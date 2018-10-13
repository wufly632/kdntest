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

    public function customerOrderGood()
    {
        return $this->hasMany('App\Entities\Order\OrderGood', 'order_id', 'order_id');
    }

    public function customerAddress()
    {
        return $this->hasOne('App\Entities\Customer\CustomerAddress', 'id', 'address_id');
    }

    public function customerOrderPayment()
    {
        return $this->hasOne('App\Entities\Order\OrderPayment', 'order_id', 'order_id');
    }

    public function customer()
    {
        return $this->hasOne('App\Entities\User\User', 'id', 'customer_id');
    }
}
