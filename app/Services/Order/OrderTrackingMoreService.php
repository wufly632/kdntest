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

    public function updateTable($order_id, $info)
    {
        $this->orderTrackingmoreRepository->update($info, $order_id);
    }

    public function createTable($info)
    {
        $this->orderTrackingmoreRepository->create($info);
    }

}