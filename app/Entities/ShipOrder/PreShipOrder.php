<?php

namespace App\Entities\ShipOrder;

use App\Entities\Product\Product;
use App\Entities\Product\ProductSku;
use App\Entities\Supplier\SupplierUser;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PreShipOrder.
 *
 * @package namespace App\Entities\ShipOrder;
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
    protected $fillable = ['supplier_id','good_id','sku_id','num','confirmed_num','accepted_num','supply_price','status','created_at','updated_at'];

    const WAIT_CREATE = 1;
    const PARTY_CREATED  =  2;
    const CREATED = 3;
    const DONE = 4;

    public static $allStatus = [
        self::WAIT_CREATE => '待组单',
        self::PARTY_CREATED => '部分组单',
        self::CREATED => '组单完成',
        self::DONE => '收货完成',
    ];


    /**
     * @function 获取sku信息
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getSku()
    {
        return $this->hasOne(ProductSku::class, 'id', 'sku_id');
    }

    /**
     * @function 获取商品信息
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, 'id', 'good_id');
    }

    /**
     * @function 获取供应商信息
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getSupplier()
    {
        return $this->hasOne(SupplierUser::class, 'id', 'supplier_id');
    }

}
