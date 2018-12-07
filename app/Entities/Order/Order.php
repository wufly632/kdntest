<?php

namespace App\Entities\Order;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Order.
 *
 * @package namespace App\Entities\Order;
 */
class Order extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'customer_order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['status','shipper_code', 'waybill_id','delivery_at'];

    const WAIT_PAY = 1;
    const PYID = 3;
    const CANCEL = 6;
    public function customerOrderGood()
    {
        return $this->hasMany('App\Entities\Order\OrderGood', 'order_id', 'order_id');
    }

    public function orderAddress()
    {
        return $this->hasOne('App\Entities\Order\OrderAddress', 'order_id', 'order_id');
    }

    public function customerOrderPayment()
    {
        return $this->hasOne('App\Entities\Order\OrderPayment', 'order_id', 'order_id');
    }

    public function customer()
    {
        return $this->hasOne('App\Entities\User\User', 'id', 'customer_id');
    }
    public function orderTrackingmore()
    {
        return $this->hasOne('App\Entities\Order\OrderTrackingmore', 'order_id', 'order_id');
    }
}
