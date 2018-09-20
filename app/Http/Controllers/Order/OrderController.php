<?php
// +----------------------------------------------------------------------
// | OrderController.php
// +----------------------------------------------------------------------
// | Description: 用户订单管理
// +----------------------------------------------------------------------
// | Time: 2018/9/20 上午11:52
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $request->flash();
        $orders = $this->orderService->getList();
        return view('order.index', compact('orders'));
    }
}
