<?php

namespace App\Entities\Order;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OrderGood.
 *
 * @package namespace App\Entities\Order;
 */
class OrderGood extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'customer_order_goods';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function good()
    {
        return $this->hasOne('App\Entities\Good\Good', 'id', 'good_id');
    }
}
