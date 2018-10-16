<?php

namespace App\Entities\Order;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OrderTrackingmore.
 *
 * @package namespace App\Entities\Order;
 */
class OrderTrackingmore extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'customer_order_trackingmore';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['order_id', 'status', 'trackinfo', 'destination_arrived'];

}
