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

use App\Repositories\Good\GoodRepository;
use App\Repositories\Order\OrderGoodRepository;
use App\Repositories\Order\OrderRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderService
{
    /**
     * @var OrderRepository
     */
    protected $order;
    protected $orderGoodRepository;
    protected $goodRepository;

    /**
     * OrderController constructor.
     *
     * @param OrderRepository $order
     * @param OrderGoodRepository $orderGoodRepository
     */
    public function __construct(OrderRepository $order, OrderGoodRepository $orderGoodRepository, GoodRepository $goodRepository)
    {
        $this->order = $order;
        $this->orderGoodRepository = $orderGoodRepository;
        $this->goodRepository = $goodRepository;
    }

    /**
     * @function 获取用户订单列表
     * @return mixed
     */
    public function getList($option, $whereoption, $request)
    {
        $orderBy = $request->orderBy ?? 'id';
        $sort = $request->sort ?? 'desc';
        $length = $request->length ?? 20;
        $searchOrderIds = [];
        if ($whereoption) {
            $searchGoods = $this->goodRepository->findWhere($whereoption, ['id']);
            if ($request->filled('good_name')) {
                $searchGoodsId = [];
                foreach ($searchGoods as $searchGood) {
                    array_push($searchGoodsId, $searchGood->id);
                }
                $searchOrderGoods = $this->orderGoodRepository->findWhereIn('good_id', $searchGoodsId, ['order_id']);
            } else {
                $searchGoods = $searchGoods->first()->toArray();
                $searchGoodsId = $searchGoods['id'];
                $searchOrderGoods = $this->orderGoodRepository->findByField('good_id', $searchGoodsId, ['order_id']);
            }

            foreach ($searchOrderGoods as $searchOrderGood) {
                array_push($searchOrderIds, $searchOrderGood['order_id']);
            }
            if (count($searchOrderIds) == 1) {
                $option = array_merge($option, ['order_id' => $searchOrderIds[0]]);
            } else {
                $option = array_merge($option, [['order_id', 'in', $searchOrderIds]]);
            }
        }
        if ($option) {
            if (count($searchOrderIds) == 1) {
                $option = array_merge($option, ['order_id' => $searchOrderIds[0]]);
                $orders = $this->order->orderBy($orderBy, $sort)->findWhere($option);
            } elseif (count($searchOrderIds) == 0) {
                $orders = $this->order->orderBy($orderBy, $sort)->findWhere($option);
            } else {
                $orders = $this->order->orderBy($orderBy, $sort)->findWhereIn('order_id', $searchOrderIds);
            }
            $orderCount = count($orders);
            $orders = new LengthAwarePaginator($orders, $orderCount, $length);
            $orders->withPath('orders');
            $orders->appends($request->all());

        } else {
            $orders = $this->order->orderBy($orderBy, $sort)->paginate($length);
        }
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
