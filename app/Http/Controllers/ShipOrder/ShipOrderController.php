<?php
// +----------------------------------------------------------------------
// | PreShipOrderController.php
// +----------------------------------------------------------------------
// | Description: 待发货商品
// +----------------------------------------------------------------------
// | Time: 2018/10/19 下午9:41
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Http\Controllers\ShipOrder;

use App\Entities\ShipOrder\GoodSkuLack;
use App\Entities\ShipOrder\ShipOrder;
use App\Http\Controllers\Controller;
use App\Services\Api\ApiResponse;
use App\Services\ShipOrderService;
use Illuminate\Http\Request;

class ShipOrderController extends Controller
{
    protected $shipOrderService;

    public function __construct(ShipOrderService $shipOrderService)
    {
        $this->shipOrderService = $shipOrderService;
    }

    /**
     * @function 待发货商品页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function preIndex(Request $request)
    {
        $pre_ship_orders = $this->shipOrderService->getPreList($request);
        return view('shipOrder.pre_list', compact('pre_ship_orders'));
    }

    /**
     * @function 发货单列表页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $ship_orders = $this->shipOrderService->getList($request);
        return view('shipOrder.list', compact('ship_orders'));
    }

    /**
     * @function 发货单明细
     * @param ShipOrder $shipOrder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shipOrderDetail(ShipOrder $shipOrder)
    {
        $shipOrderItems = $shipOrder->getItems;
        return view('shipOrder.ship_order_detail', compact('shipOrder', 'shipOrderItems'));
    }

    /**
     * @function 缺货申请记录
     * @param Request $request
     */
    public function lackList(Request $request)
    {
        $lackList = $this->shipOrderService->getLackList($request);
        return view('shipOrder.lack_list', compact('lackList'));
    }

    /**
     * @function 缺货审核页面
     * @param GoodSkuLack $lack
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lackAudit(GoodSkuLack $lack)
    {
        return view('shipOrder.lack_audit', compact('lack'));
    }

    /**
     * @function 缺货审核
     * @param Request $request
     * @return mixed
     */
    public function postLackAudit(Request $request)
    {
        return $this->shipOrderService->auditLack($request);
    }

    /**
     * @function 发货单添加备注
     * @param Request $request
     * @return mixed
     */
    public function addNote(Request $request)
    {
        if(! $ship_order_id = $request->id) {
            return ApiResponse::failure(g_API_ERROR, '操作失败');
        }
        if (! $note = $request->note) {
            return ApiResponse::failure(g_API_ERROR, '请填写备注');
        }
        $result = $this->shipOrderService->getShipOrderModel()->where(['id' => $ship_order_id])->update(['note' => $note]);
        if ($result) {
            return ApiResponse::success('添加成功');
        }
        return ApiResponse::failure(g_API_ERROR, '添加失败');
    }

}
