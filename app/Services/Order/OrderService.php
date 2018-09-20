<?php
// +----------------------------------------------------------------------
// | OrderService.php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Time: 2018/9/20 上午11:50
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Services\Order;

use App\Repositories\Order\OrderRepository;

class OrderService
{
    /**
     * @var OrderRepository
     */
    protected $order;

    /**
     * OrderController constructor.
     *
     * @param OrderRepository $order
     */

    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }

    /**
     * @function 获取用户订单列表
     * @return mixed
     */
    public function getList()
    {
        $this->order->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $orderBy = $request->orderBy ?? 'id';
        $sort = $request->sort ?? 'desc';
        $length = $request->length ?? 20;
        return $this->order->orderBy($orderBy, $sort)->paginate($length);
    }

}
