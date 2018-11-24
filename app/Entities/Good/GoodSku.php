<?php

namespace App\Entities\Good;

use App\Entities\CateAttr\GoodAttrValue;
use App\Entities\Product\ProductSku;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class GoodSku.
 *
 * @package namespace App\Entities\Good;
 */
class GoodSku extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "audit_good_skus";

    /**
     * @function cdn加速
     * @param $item
     * @return \Illuminate\Contracts\Routing\UrlGenerator|mixed|string
     */
    public function getIconAttribute($item) {
        return cdnUrl($item);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    // 需同步的字段
    public static $syncField = ['id', 'good_id', 'value_ids', 'supply_price', 'price', 'good_stock', 'supplier_code',
                                'weight', 'supplier_size', 'icon'];

    public function skuAttributes()
    {
        return $this->hasMany(GoodAttrValue::class, 'sku_id', 'id');
    }

    /**
     * 获取good_sku表
     */
    public function productSku()
    {
        return $this->hasOne(ProductSku::class, 'id', 'id');
    }
}
