<?php

namespace App\Entities\Order;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OrderPayment.
 *
 * @package namespace App\Entities\Order;
 */
class OrderPayment extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'customer_order_payment_amount';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
