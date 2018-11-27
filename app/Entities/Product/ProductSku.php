<?php

namespace App\Entities\Product;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ProductSku.
 *
 * @package namespace App\Entities\Product;
 */
class ProductSku extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'good_skus';

    public function getIcon($item)
    {
        return cdnUrl($item);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function skuAttributes()
    {
        return $this->hasMany(ProductAttrValue::class,'sku_id', 'id');
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, 'id', 'good_id');
    }
}
