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
    protected $fillable = [];

}
