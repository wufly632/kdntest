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
use App\Services\Api\ApiResponse;
use App\Services\Order\OrderService;
use App\Services\TrackingMore\TrackingMoreService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;
    protected $trackingMoreService;

    public function __construct(OrderService $orderService, TrackingMoreService $trackingMoreService)
    {
        $this->orderService = $orderService;
        $this->trackingMoreService = $trackingMoreService;
    }

    public function index(Request $request)
    {
        $option = [];
        $whereoption = [];
        if ($request->hasAny('order_id', 'good_name', 'good_code', 'from_type', 'status', 'good_id', 'daterange')) {
            if ($request->filled('order_id')) {
                $option = array_merge($option, ['order_id' => $request->input('order_id')]);
            }
            if ($request->filled('good_name')) {
                $whereoption = array_merge($whereoption, [['good_title', 'like', '%' . $request->input('good_name') . '%']]);
            }
            if ($request->filled('good_code')) {
                $whereoption = array_merge($whereoption, ['good_code' => $request->input('good_code')]);
            }
            if ($request->filled('from_type') && !empty($request->get('from_type'))) {
                $option = array_merge($option, ['from_type' => $request->input('from_type')]);
            }
            if ($request->filled('status') && !empty($request->get('status'))) {
                $option = array_merge($option, ['status' => $request->input('status')]);
            }
            if ($request->filled('good_id')) {
                $whereoption = array_merge($whereoption, ['id' => $request->input('good_id')]);
            }
            if ($request->filled('daterange')) {
                $createAt = explode('~', $request->query('daterange'));
                $option = array_merge($option, [
                    ['created_at', '>=', $createAt[0]],
                    ['created_at', '<=', $createAt[1]]
                ]);
            }
        }
        $request->flash();
        $orders = $this->orderService->getList($option, $whereoption, $request);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $order = $this->orderService->getOrderInfo($id);
        return view('orders.show', ['order' => $order]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * 发货页面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function send($id)
    {
        return view('orders.send', ['order' => $this->orderService->getOrderInfo($id)]);
    }

    /**
     * 确认发货
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function sendConfirm(Request $request, $id)
    {
        if (!$request->filled('shipper_code') || !$request->filled('waybill_id')) {
            return ApiResponse::failure(g_API_ERROR, '参数不全');
        }
        // TODO:状态码可能修改

        if (!$this->checkOrderStatus($id, $this->orderService::ORDER_STATUS['waitting_delivery'])) {
            return ApiResponse::failure(g_API_ERROR, '订单状态有误');
        }
        if ($this->orderService->confirmDelivery($request, $id)['status'] == 200) {
            return ApiResponse::success();
        } else {
            return ApiResponse::failure(g_API_ERROR, '修改失败');
        }

    }

    /**
     * 查询订单状态
     * @param $id
     * @param $status
     * @return bool
     */
    public function checkOrderStatus($id, $status)
    {
        $orderInfo = $this->orderService->getOrderInfo($id, ['status']);
        if ($orderInfo['status'] != $status) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 取消订单
     * @param $id
     * @return mixed
     */
    public function orderCancel($id)
    {
        if ($this->orderService->orderCancel($id)['status'] == 200) {
            return ApiResponse::success();
        } else {
            return ApiResponse::failure(g_API_ERROR, '取消失败');
        }
    }
}
