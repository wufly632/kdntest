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

use App\Entities\ShipOrder\GoodSkuLack;
use App\Repositories\ShipOrder\PreShipOrderRepository;
use App\Repositories\ShipOrder\ShipOrderRepository;
use Request;

class ShipOrderService
{
    protected $preShipOrder;

    protected $shipOrder;

    protected $goodSkuLack;

    public function __construct(PreShipOrderRepository $preShipOrder,
                                ShipOrderRepository $shipOrder,
                                GoodSkuLack $goodSkuLack)
    {
        $this->preShipOrder = $preShipOrder;
        $this->shipOrder = $shipOrder;
        $this->goodSkuLack = $goodSkuLack;
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

    /**
     * @function 发货单列表
     * @param Request $request
     * @return mixed
     */
    public function getList($request)
    {
        Request::flash();
        $orderBy = $request->orderBy ?: 'id';
        $sort = $request->sort ?: 'desc';
        $length = $request->length ?: 5;
        return $this->shipOrder->orderBy($orderBy, $sort)->paginate($length);
    }

    /**
     * @function 缺货申请记录
     * @param $request
     * @return mixed
     */
    public function getLackList($request)
    {
        Request::flash();
        $orderBy = $request->orderBy ?: 'id';
        $sort = $request->sort ?: 'desc';
        $length = $request->length ?: 20;
        return $this->goodSkuLack->orderBy($orderBy, $sort)->paginate($length);
    }
}
