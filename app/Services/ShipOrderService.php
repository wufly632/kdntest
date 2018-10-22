<?php
// +----------------------------------------------------------------------
// | ShipOrderService.php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Time: 2018/10/19 下午9:42
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Services;

use App\Entities\ShipOrder\GoodSkuLack;
use App\Repositories\ShipOrder\GoodSkuLackRepository;
use App\Repositories\ShipOrder\PreShipOrderRepository;
use App\Repositories\ShipOrder\ShipOrderRepository;
use App\Services\Api\ApiResponse;
use Request;

class ShipOrderService
{
    protected $preShipOrder;

    protected $shipOrder;

    protected $goodSkuLack;

    public function __construct(PreShipOrderRepository $preShipOrder,
                                ShipOrderRepository $shipOrder,
                                GoodSkuLackRepository $goodSkuLack)
    {
        $this->preShipOrder = $preShipOrder;
        $this->shipOrder = $shipOrder;
        $this->goodSkuLack = $goodSkuLack;
    }

    /**
     * @function 待发货商品列表
     * @param Request $request
     * @return mixed
     */
    public function getPreList($request)
    {
        Request::flash();
        $orderBy = $request->orderBy ?: 'id';
        $sort = $request->sort ?: 'desc';
        $length = $request->length ?: 20;
        return $this->preShipOrder->orderBy($orderBy, $sort)->paginate($length);
    }

    /**
     * @function 发货单列表
     * @param Request $request
     * @return mixed
     */
    public function getList($request)
    {
        Request::flash();
        $orderBy = $request->orderBy ?: 'id';
        $sort = $request->sort ?: 'desc';
        $length = $request->length ?: 5;
        return $this->shipOrder->orderBy($orderBy, $sort)->paginate($length);
    }

    /**
     * @function 缺货申请记录
     * @param $request
     * @return mixed
     */
    public function getLackList($request)
    {
        Request::flash();
        $orderBy = $request->orderBy ?: 'id';
        $sort = $request->sort ?: 'desc';
        $length = $request->length ?: 20;
        return $this->goodSkuLack->orderBy($orderBy, $sort)->paginate($length);
    }

    public function auditLack($request)
    {
        if (! $request->id) {
            return ApiResponse::failure(g_API_ERROR, '请选择要审核的记录');
        }
        if (! in_array($request->type, ['pass', 'reject'])) {
            return ApiResponse::failure(g_API_ERROR, '请通过或拒绝');
        }
        try {
            if ($request->type == 'pass') {
                $this->goodSkuLack->update(['status' => GoodSkuLack::PASS_AUDIT],$request->id);
            } else {
                $this->goodSkuLack->update(['status' => GoodSkuLack::REJECT, 'reject_note' => $request->reject_note],$request->id);
            }
            return ApiResponse::success('操作成功');
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            ding('缺货审核失败-'.$e->getMessage());
            return ApiResponse::failure(g_API_ERROR, '操作失败');
        }
    }
}
