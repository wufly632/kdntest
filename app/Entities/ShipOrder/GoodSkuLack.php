<?php

namespace App\Entities\ShipOrder;

use App\Entities\CommonTrait\DateToLocalShowTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class GoodSkuLack.
 *
 * @package namespace App\Entities\ShipOrder;
 */
class GoodSkuLack extends Model implements Transformable
{
    use TransformableTrait;
    use DateToLocalShowTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['pre_ship_order_id','supplier_id','sku_id','num','apply_note','reject_note','status','created_at','audited_at','rejected_at','updated_at'];

    public function getSupplier()
    {

    }

}
