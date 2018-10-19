<?php

namespace App\Entities\ShiperOrder;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PreShipOrder.
 *
 * @package namespace App\Entities\ShiperOrder;
 */
class PreShipOrder extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'pre_ship_orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['supplier_id','sku_id','num','confirmed_num','accepted_num','supply_price','status','created_at','updated_at'];

}
