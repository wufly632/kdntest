<?php

namespace App\Entities\Product;

use App\Entities\Good\Good;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Product.
 *
 * @package namespace App\Entities\Product;
 */
class Product extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "goods";
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'category_id', 'category_path', 'supplier_id', 'good_code', 'brand_name', 'price','video', 'supply_price',
                           'good_stock', 'orders', 'good_title', 'good_en_title', 'good_summary', 'good_en_summary', 'main_pic', 'pic',
                           'content', 'status', 'rebate_level_one', 'rebate_level_two', 'rebate_level_three', 'sort', 'created_at', 'shelf_at',
                           'origin_price','deleted_at', 'updated_at'];


    const ONLINE  = 1;   //上架
    const OFFLINE = 2;   //下架

    public static $allStatus = [
        self::ONLINE => '上架',
        self::OFFLINE => '下架',
    ];

    public function productSku()
    {
        return $this->hasMany(ProductSku::class, 'good_id', 'id');
    }

    public function getGood()
    {
        return $this->hasOne(Good::class, 'id', 'id');
    }

    public function getImages()
    {
        return $this->hasMany(ProductSkuImages::class, 'good_id', 'id');
    }

    public function getAttrValue()
    {
        return $this->hasMany(ProductAttrValue::class, 'good_id', 'id');
    }
}
