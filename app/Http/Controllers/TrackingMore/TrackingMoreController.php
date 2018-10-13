<?php

namespace App\Http\Controllers\TrackingMore;

use App\Services\Api\ApiResponse;
use App\Services\TrackingMore\TrackingMoreService;
use App\Http\Controllers\Controller;

class TrackingMoreController extends Controller
{
    //
    protected $trackingMoreService;

    public function __construct(TrackingMoreService $trackingMoreService)
    {
        $this->trackingMoreService = $trackingMoreService;
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

    public function getStream()//$shipperCode, $waybillId
    {
        return '{"id":"75ff84d5e3abd7bfa9d5b9aed375a161","tracking_number":"JNTCU2200005070YQ","carrier_code":"j-net","status":"transit","created_at":"2018-10-13T16:04:05+08:00","updated_at":"2018-10-13T16:04:23+08:00","order_create_time":null,"customer_email":"","title":"","order_id":null,"comment":null,"customer_name":null,"archived":false,"original_country":"","destination_country":"United States","itemTimeLength":3,"stayTimeLength":3,"origin_info":{"ItemReceived":"2018-10-11 15:59","ItemDispatched":null,"DepartfromAirport":null,"ArrivalfromAbroad":null,"CustomsClearance":null,"DestinationArrived":null,"weblink":"http:\/\/www.j-net.cn\/","phone":"400-728-7156","carrier_code":"j-net","trackinfo":[{"Date":"2018-10-11 15:59","StatusDescription":"\u4e8e 2018-10-11 15:59:36 \u6536\u5230\u9884\u5f55\u5355\u7535\u5b50\u4fe1\u606f\u3002","Details":"","checkpoint_status":"transit","ItemNode":"ItemReceived"}]},"service_code":"","substatus":null,"lastEvent":"\u4e8e 2018-10-11 15:59:36 \u6536\u5230\u9884\u5f55\u5355\u7535\u5b50\u4fe1\u606f\u3002,2018-10-11 15:59","lastUpdateTime":"2018-10-11 15:59"}';
//        return $this->trackingMoreService->getSingleTrackingResult('j-net','JNTCU2200005070YQ');
    }

    public function createTracking($shipperCode,$waybillId)
    {
        return $this->trackingMoreService->createTracking($shipperCode,$waybillId);
    }

    public function detectCarrier($waybill_id)
    {
        //JNTCU2200005070YQ
        return $this->trackingMoreService->detectCarrier($waybill_id);
    }
}
