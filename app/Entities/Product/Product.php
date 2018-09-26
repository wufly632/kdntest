<?php

namespace App\Entities\Product;

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
    protected $fillable = ['id', 'category_id', 'category_path', 'supplier_id', 'good_code', 'brand_name', 'stock_price', 'supply_price',
                           'good_stock', 'orders', 'good_title', 'good_en_title', 'good_summary', 'good_en_summary', 'main_pic', 'pic',
                           'content', 'status', 'created_at', 'shelf_at', 'deleted_at', 'updated_at'];


    const ONLINE  = 1;   //上架
    const OFFLINE = 2;   //下架

    public static $allStatus = [
        self::ONLINE => '上架',
        self::OFFLINE => '上架',
    ];
}
