<?php
// +----------------------------------------------------------------------
// | ShipOrderService.php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Time: 2018/10/19 下午9:42
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Services;

use App\Repositories\ShiperOrder\PreShipOrderRepository;
use Request;

class ShipOrderService
{
    protected $preShipOrder;

    public function __construct(PreShipOrderRepository $preShipOrder)
    {
        $this->preShipOrder = $preShipOrder;
    }

    /**
     * @function 待发货商品列表
     * @param Request $request
     * @return mixed
     */
    public function getPreList($request)
    {
        Request::flash();
        $orderBy = $request->orderBy ?: 'id';
        $sort = $request->sort ?: 'desc';
        $length = $request->length ?: 20;
        return $this->preShipOrder->orderBy($orderBy, $sort)->paginate($length);
    }
}
