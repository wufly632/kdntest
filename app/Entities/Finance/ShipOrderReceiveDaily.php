<?php

namespace App\Entities\Finance;

use App\Entities\Product\Product;
use App\Entities\Product\ProductSku;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ShipOrderReceiveDaily.
 *
 * @package namespace App\Entities\Finance;
 */
class ShipOrderReceiveDaily extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'ship_order_receive_daily';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function good()
    {
        return $this->hasOne(Product::class, 'id', 'good_id');
    }

    public function sku()
    {
        return $this->hasOne(ProductSku::class, 'id', 'sku_id');
    }
}
