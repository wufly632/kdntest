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

use App\Repositories\Order\OrderGoodRepository;
use App\Repositories\Order\OrderRepository;

class OrderService
{
    /**
     * @var OrderRepository
     */
    protected $order;
    protected $orderGoodRepository;

    /**
     * OrderController constructor.
     *
     * @param OrderRepository $order
     * @param OrderGoodRepository $orderGoodRepository
     */
    public function __construct(OrderRepository $order, OrderGoodRepository $orderGoodRepository)
    {
        $this->order = $order;
        $this->orderGoodRepository = $orderGoodRepository;
    }

    /**
     * @function 获取用户订单列表
     * @return mixed
     */
    public function getList()
    {
//        $this->order->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $orderBy = $request->orderBy ?? 'id';
        $sort = $request->sort ?? 'desc';
        $length = $request->length ?? 20;
        $orders = $this->order->model()::with('customerOrderGood')->orderBy($orderBy, $sort)->paginate($length);
        $orders->StatusWords = $this->getStatusWords();
        $orders->OriginWords = $this->getOriginWords();
        return $orders;
    }

    public function getStatusWords()
    {
        return [
            '全部',
            '待付款',
            '',
            '待发货',
            '待收货',
            '交易完成',
            '交易取消'
        ];

    }

    public function getOriginWords()
    {
        return [
            '未选择',
            'PC',
            'H5',
            '小程序',
            'APP',
            '门店'
        ];
    }

    public function getOrderInfo($id)
    {
        return $this->order->findByField('order_id', $id)->first();
    }
}
