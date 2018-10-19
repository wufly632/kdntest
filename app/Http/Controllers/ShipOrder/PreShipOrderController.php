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

use App\Services\ShipOrderService;
use Illuminate\Http\Request;

class PreShipOrderController
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
    public function index(Request $request)
    {
        $pre_ship_orders = $this->shipOrderService->getPreList($request);
        return view('shipOrder.pre_list', compact('pre_ship_orders'));
    }
}
