<?php
// +----------------------------------------------------------------------
// | KDNiaoService.php
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------
// | Time: 2018/12/10 下午8:16
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Services\Common;

use App\Entities\ShipOrder\LogisticsInfo;
use App\Services\Api\ApiResponse;
use Carbon\Carbon;
use Wufly\Kuaidiniao\KuaidiniaoService;
class KDNiaoService
{
    protected $kdniao;
    public function __construct(KuaidiniaoService $service)
    {
        $this->kdniao = $service;
    }

    /**
     * @function 查询物流信息
     * @param $logisticCode
     * @param $shipperCode
     * @return mixed
     */
    public function getLogisticsTrace($logisticCode, $shipperCode)
    {
        // 先判断数据库是否存在数据
        $logisticsInfo = LogisticsInfo::where(['logistic_code' => $logisticCode, 'shipper_code' => $shipperCode])->first();
        if ($logisticsInfo && ($logisticsInfo->is_dubscribed == 1 || $logisticsInfo->is_signed == 1)) {
            // 取数据库存储数据
            return ApiResponse::success(json_decode($logisticsInfo->logistic_info));
        }
        // 加入物流跟踪
        $this->kdniao->orderTracesSubByJson($shipperCode, $logisticCode);
        // 物流及时查询
        $result = $this->kdniao->getOrderTracesByJson($shipperCode, $logisticCode);
        $result = json_decode($result);
        if ($result->Success === true) {
            return ApiResponse::success($result->Traces);
        } else {
            return ApiResponse::failure(g_API_STATUS, '获取物流信息失败');
        }
    }

    /**
     * @function 回调地址接收数据
     * @return \Illuminate\Http\JsonResponse
     */
    public function receiveLogistics()
    {
        // 获取快递鸟传过来的数据
        $kdnInfo = file_get_contents("php://input");
        ding($kdnInfo);
        // 解密
        $kdnInfo = urldecode($kdnInfo);
        parse_str($kdnInfo, $kdn_arr);
        $request_info = json_decode($kdn_arr['RequestData']);
        try {
            // 验证传过来的数据
            if ($request_info && $request_info->EBusinessID === env('EBUSINESS_ID')) {
                // 判断状态
                $status = $request_info->Data[0]->State ?? '';
                // 是否签收
                $is_signed = $status == 3 ? 1 : 2;
                $logistic_code = $request_info->Data[0]->LogisticCode;
                $shipper_code = $request_info->Data[0]->ShipperCode;
                $logistic_info = collect($request_info->Data[0]->Traces)->map(function ($item) {
                    return collect($item)->toArray();
                })->toJson();
                // 插入或更新物流表
                if (LogisticsInfo::updateOrInsert(compact('logistic_code', 'shipper_code'), [
                    'is_dubscribed' => 1,
                    'logistic_info' => $logistic_info,
                    'is_signed' => $is_signed
                ])) {
                    ding('返回成功');
                    return response()->json([
                        'EBusinessID' => $request_info->EBusinessID,
                        'UpdateTime' => Carbon::now()->toDateTimeString(),
                        'Success' => 'True',
                        'Reason' => ''
                    ]);
                }
            }
        } catch (\Exception $e) {
            ding('接收物流信息失败:'.$e->getMessage());
        }
        ding('返回失败');
        return response()->json([
            'EBusinessID' => $request_info->EBusinessID,
            'UpdateTime' => Carbon::now()->toDateTimeString(),
            'Success' => 'False',
            'Reason' => '数据接收失败'
        ]);
    }
}