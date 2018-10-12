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
        $option = [];
        $whereoption = [];
        if ($request->hasAny('order_id', 'good_name', 'good_code', 'from_type', 'status', 'good_id', 'created_at')) {
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
            if ($request->filled('created_at')) {
                $createAt = explode('~', $request->query('created_at'));
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
        return view('orders.show', ['order' => $this->orderService->getOrderInfo($id)]);

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
}
