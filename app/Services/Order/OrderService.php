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
use App\Services\Api\ApiResponse;
use App\Services\TrackingMore\TrackingMoreService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Self_;

class OrderService
{
    /**
     * @var OrderRepository
     */
    protected $order;
    protected $orderGoodRepository;
    protected $goodRepository;
    protected $trackingMoreService;

    const ORDER_STATUS = [
        'waitting_pay' => 1,
        'waitting_delivery' => 3,
        'waitting_recieve' => 4,
        'trade_deal' => 5,
        'trade_cancle' => 6,
    ];

    /**
     * OrderController constructor.
     *
     * @param OrderRepository $order
     * @param OrderGoodRepository $orderGoodRepository
     */
    public function __construct(OrderRepository $order, OrderGoodRepository $orderGoodRepository, GoodRepository $goodRepository, TrackingMoreService $trackingMoreService)
    {
        $this->order = $order;
        $this->orderGoodRepository = $orderGoodRepository;
        $this->goodRepository = $goodRepository;
        $this->trackingMoreService = $trackingMoreService;
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
        $statuscode = self::ORDER_STATUS;
        return [
            0 => '全部',
            $statuscode['waitting_pay'] => '待付款',
            $statuscode['waitting_delivery'] => '待发货',
            $statuscode['waitting_recieve'] => '待收货',
            $statuscode['trade_deal'] => '交易完成',
            $statuscode['trade_cancle'] => '交易取消'
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

    public function getOrderInfo($id, $field = ['*'])
    {
        $order = $this->order->find($id);
        $order->StatusWords = $this->getStatusWords();
        return $order;
    }

    /**
     * 确认发货
     * @param $request
     * @param $id
     * @return mixed
     */
    public function confirmDelivery($request, $id)
    {
        $waybill_id = $request->post('waybill_id');
        $shipper_code = $request->post('shipper_code');
        $delivery_at = Carbon::now()->toDateTimeString();
        $status = self::ORDER_STATUS['waitting_recieve'];
        try {
            DB::beginTransaction();

            $this->trackingMoreService->createTracking($shipper_code, $waybill_id);

            $this->order->update(['status' => $status, 'waybill_id' => $waybill_id, 'shipper_code' => $shipper_code, 'delivery_at' => $delivery_at], $id);
            DB::commit();
            return ApiResponse::success();
        } catch (\Exception $e) {
            DB::rollback();
            return ApiResponse::failure(g_API_ERROR, '创建失败');
        }
    }

    public function createTrackingMore($shipper_code, $waybill_id)
    {
        $trackResponse = $this->trackingMoreService->createTracking($shipper_code, $waybill_id);
        if ($trackResponse['meta']['code'] == 200) {
            return true;
        } else {
            return false;
        }
    }

    public function orderCancel($id)
    {
        $status = self::ORDER_STATUS['trade_cancle'];
        try {
            $this->order->update(['status' => $status,], $id);
            return ApiResponse::success();
        } catch (\Exception $e) {
            return ApiResponse::failure(g_API_ERROR, '修改失败');
        }
    }

    public function test()
    {
        $this->order->firstOrCreate();
    }
}
