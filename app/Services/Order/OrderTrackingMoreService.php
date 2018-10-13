<?php

namespace App\Services\Order;

use App\Repositories\Order\OrderTrackingmoreRepository;

class OrderTrackingMoreService
{

    private $orderTrackingmoreRepository;

    /**
     * UserService constructor.
     * @param OrderTrackingmoreRepository $orderTrackingmoreRepository
     */
    public function __construct(OrderTrackingmoreRepository $orderTrackingmoreRepository)
    {
        $this->orderTrackingmoreRepository = $orderTrackingmoreRepository;
    }

    public function checkOrCreate($order_id, $info)
    {
        $this->orderTrackingmoreRepository->update(['order_id' => $order_id], $info);
    }

}