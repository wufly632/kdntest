<?php

namespace App\Http\Controllers\TrackingMore;

use App\Services\Order\OrderService;
use App\Services\Order\OrderTrackingMoreService;
use App\Http\Controllers\Controller;
use App\Services\TrackingMore\TrackingMoreService;

class OrderTrackingMoreController extends Controller
{
    //
    protected $trackingMoreService;
    protected $orderService;
    protected $orderTrackingmoreRepository;

    /**
     * OrderTrackingMoreController constructor.
     * @param TrackingMoreService $trackingMoreService
     * @param OrderService $orderService
     * @param OrderTrackingMoreService $orderTrackingMoreService
     */
    public function __construct(TrackingMoreService $trackingMoreService, OrderService $orderService, OrderTrackingMoreService $orderTrackingMoreService)
    {
        $this->trackingMoreService = $trackingMoreService;
        $this->orderService = $orderService;
        $this->orderTrackingMoreService = $orderTrackingMoreService;
    }

    public function getCarriers()
    {
        return [
            [
                "name" => "DHL",
                "code" => "dhl",
                "phone" => "1 800 225 5345",
                "homepage" => "http://www.dhl.com/",
                "type" => "express",
                "picture" => "//cdn.trackingmore.com/images/icons/express/dhl.png",
                "name_cn" => "DHL",
            ],
            [
                "name" => "UPS",
                "code" => "ups",
                "phone" => "1 800 742 5877",
                "homepage" => "http://www.ups.com/",
                "type" => "express",
                "picture" => "//cdn.trackingmore.com/images/icons/express/ups.png",
                "name_cn" => "UPS",
            ],
            [
                "name" => "Fedex",
                "code" => "fedex",
                "phone" => "1 800 247 4747",
                "homepage" => "http://www.fedex.com/",
                "type" => "express",
                "picture" => "//cdn.trackingmore.com/images/icons/express/fedex.png",
                "name_cn" => "Fedex-联邦快递",
            ]
        ];
    }

    public function getStream($id, $shipperCode, $waybillId)//$shipperCode, $waybillId delivered
    {
        $order = $this->orderService->getOrderInfo($id, ['order_id', 'status']);
        if ($order['status'] != 4) {
            if ($order->orderTrackingmore) {
                return $order->orderTrackingmore->trackinfo;
            } else {
                return false;
            }

        }
        if ($order->orderTrackingmore && $order->orderTrackingmore->trackinfo->status == 'delivered') {
            return $order->orderTrackingmore->trackinfo;
        };
        $orderTrackInfo = $this->trackingMoreService->getSingleTrackingResult($shipperCode, $waybillId);
        if ($orderTrackInfo['meta']['code'] == 200) {
            return $orderTrackInfo['data']['origin_info']['trackinfo'];
        }else{
            return false;
        }

    }

    public function createTracking($shipperCode, $waybillId)
    {
        return $this->trackingMoreService->createTracking($shipperCode, $waybillId);
    }

    public function detectCarrier($waybill_id)
    {
        //JNTCU2200005070YQ
        return $this->trackingMoreService->detectCarrier($waybill_id);
    }
}
