<?php

namespace App\Entities\Product;

use App\Entities\CateAttr\Category;
use App\Entities\Good\Good;
use App\Observers\ProductObserver;
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

    public function getMainPicAttribute($item)
    {
        return cdnUrl($item);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'category_id', 'category_path', 'supplier_id', 'good_code', 'brand_name', 'price','video', 'supply_price',
                           'good_stock', 'orders', 'good_title', 'good_en_title', 'good_summary', 'good_en_summary', 'main_pic', 'pic',
                           'content', 'status', 'rebate_level_one', 'rebate_level_two', 'rebate_level_three', 'sort', 'created_at', 'shelf_at',
                           'origin_price','deleted_at', 'updated_at'];


    protected static function boot()
    {
        parent::boot();
        // 模型监听
        self::observe(ProductObserver::class);
    }

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

    /**
     * @function 获取商品的非销售属性
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prop()
    {
        return $this->hasMany(ProductAttrValue::class, 'good_id', 'id')->whereNull('sku_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 转换ES数组
    public function toESArray()
    {
        // 只取出需要的字段
        $arr = array_only($this->toArray(), [
            'id',
            'good_en_title',
            'category_id',
            'status',
            'price',
            'orders',
            'good_en_summary',
            'main_pic',
            'good_stock',
            'rebate_level_one',
            'rebate_level_two'
        ]);
        // 类目的 path 字段
        $arr['category_ids'] = $this->category ? $this->category->category_ids : '';
        $arr['category_path'] = $this->category ? implode(' ', $this->category->getPathArr()) : '';
        // strip_tags 函数可以将 html 标签去除
        $arr['good_en_summary'] = strip_tags($this->good_en_summary);
        // 只取出需要的 SKU 字段
        $arr['skus'] = $this->productSku->map(function (ProductSku $sku) {
            $item = array_only($sku->toArray(), ['price', 'good_stock']);
            $item['desciption'] = $sku->getSkuDescription();
            return $item;
        })->toArray();
        // 只取出需要的商品属性字段
        $arr['prop'] = $this->prop->map(function (ProductAttrValue $property) {
            $item = [];
            $item['name'] = $property->getAttibute->en_name;
            $item['value'] = $property->value_name ?: ($property->getAttrValue->en_name ?? '');
            $item['search_value'] = $item['name'].':'.$item['value'];
            return $item;
        })->toArray();
        return $arr;
    }
}
