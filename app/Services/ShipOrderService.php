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

use App\Criteria\ShipOrder\GoodSkuLack\LackCreatedAtCriteria;
use App\Criteria\ShipOrder\GoodSkuLack\LackGoodIdCriteria;
use App\Criteria\ShipOrder\GoodSkuLack\LackIdCriteria;
use App\Criteria\ShipOrder\GoodSkuLack\LackSkuIdCriteria;
use App\Criteria\ShipOrder\GoodSkuLack\LackStatusCriteria;
use App\Criteria\ShipOrder\PreShipOrder\PreShipOrderCreateTimeCriteria;
use App\Criteria\ShipOrder\PreShipOrder\PreShipOrderIdCriteria;
use App\Criteria\ShipOrder\PreShipOrder\PreShipOrderStatusCriteria;
use App\Criteria\ShipOrder\PreShipOrder\ProductIdCriteria;
use App\Criteria\ShipOrder\PreShipOrder\ProductTitleCriteria;
use App\Criteria\ShipOrder\ShipOrder\ShipOrderCreatedAtCriteria;
use App\Criteria\ShipOrder\ShipOrder\ShipOrderIdCriteria;
use App\Criteria\ShipOrder\ShipOrder\ShipOrderStatusCriteria;
use App\Entities\ShipOrder\GoodSkuLack;
use App\Entities\ShipOrder\ShipOrder;
use App\Entities\ShipOrder\ShipOrderItem;
use App\Repositories\ShipOrder\GoodSkuLackRepository;
use App\Repositories\ShipOrder\PreShipOrderRepository;
use App\Repositories\ShipOrder\ShipOrderRepository;
use App\Services\Api\ApiResponse;
use Illuminate\Support\Facades\DB;
use Request;

class ShipOrderService
{
    protected $preShipOrder;

    protected $shipOrder;

    protected $goodSkuLack;

    public function __construct(PreShipOrderRepository $preShipOrder,
                                ShipOrderRepository $shipOrder,
                                GoodSkuLackRepository $goodSkuLack)
    {
        $this->preShipOrder = $preShipOrder;
        $this->shipOrder = $shipOrder;
        $this->goodSkuLack = $goodSkuLack;
    }

    public function getShipOrderModel()
    {
        return $this->shipOrder->makeModel();
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
        $this->preShipOrder->pushCriteria(new PreShipOrderCreateTimeCriteria($request->daterange));
        $this->preShipOrder->pushCriteria(new PreShipOrderIdCriteria($request->id));
        $this->preShipOrder->pushCriteria(new PreShipOrderStatusCriteria($request->status));
        $this->preShipOrder->pushCriteria(new ProductIdCriteria($request->good_id));
        $this->preShipOrder->pushCriteria(new ProductTitleCriteria($request->good_title));
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
        $this->shipOrder->pushCriteria(new ShipOrderCreatedAtCriteria($request->daterange));
        $this->shipOrder->pushCriteria(new ShipOrderIdCriteria($request->id));
        $this->shipOrder->pushCriteria(new ShipOrderStatusCriteria($request->status));
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
        $this->goodSkuLack->pushCriteria(new LackCreatedAtCriteria($request->daterange));
        $this->goodSkuLack->pushCriteria(new LackGoodIdCriteria($request->good_id));
        $this->goodSkuLack->pushCriteria(new LackSkuIdCriteria($request->sku_id));
        $this->goodSkuLack->pushCriteria(new LackIdCriteria($request->id));
        $this->goodSkuLack->pushCriteria(new LackStatusCriteria($request->status));
        return $this->goodSkuLack->orderBy($orderBy, $sort)->paginate($length);
    }

    /**
     * @function 缺货申请审核
     * @param $request
     * @return mixed
     */
    public function auditLack($request)
    {
        if (! $request->id) {
            return ApiResponse::failure(g_API_ERROR, '请选择要审核的记录');
        }
        if (! in_array($request->type, ['pass', 'reject'])) {
            return ApiResponse::failure(g_API_ERROR, '请通过或拒绝');
        }
        try {
            if ($request->type == 'pass') {
                $this->goodSkuLack->update(['status' => GoodSkuLack::PASS_AUDIT],$request->id);
            } else {
                $this->goodSkuLack->update(['status' => GoodSkuLack::REJECT, 'reject_note' => $request->reject_note],$request->id);
            }
            return ApiResponse::success('操作成功');
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            ding('缺货审核失败-'.$e->getMessage());
            return ApiResponse::failure(g_API_ERROR, '操作失败');
        }
    }

    /**
     * @function 发货单签收
     * @param $request
     * @return mixed
     */
    public function sign($request)
    {
        try {
            DB::beginTransaction();
            $ship_order_id = $request->ship_order_id;
            $ship_order = ShipOrder::find($ship_order_id);
            if (! $sku_num = $request->sku_num) {
                return ApiResponse::failure(g_API_ERROR, '参数错误');
            }
            foreach ($sku_num as $sku_id => $accepted) {
                ShipOrderItem::where(['ship_order_id' => $ship_order_id, 'sku_id' => $sku_id])->update(['accepted' => $accepted]);
            }
            $accepted_total = $ship_order->getItems->count('accepted');
            $ship_order->accepted = $accepted_total;
            if ($accepted_total >= $ship_order->num) {
                $ship_order->status = ShipOrder::ACCEPTANCE;
            } else {
                $ship_order->status = ShipOrder::PARTLYINHOUSED;
            }
            $ship_order->save();
            DB::commit();
            return ApiResponse::success('签收成功');
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            ding('发货单'.$ship_order_id.'签收失败');
            DB::rollBack();
            return ApiResponse::failure(g_API_ERROR,'签收失败');
        }
    }
}
