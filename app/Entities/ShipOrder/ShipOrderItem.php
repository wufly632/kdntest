<?php

namespace App\Entities\ShipOrder;

use App\Entities\Product\Product;
use App\Entities\Product\ProductSku;
use Illuminate\Database\Eloquent\Model;

class ShipOrderItem extends Model
{
    protected $table = 'ship_order_items';

    protected $fillable = ['ship_order_id', 'good_id', 'sku_id', 'num', 'released', 'received', 'accepted',
        'rejected','supply_price','created_at','updated_at'];

    /**
     * @function 获取sku
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
}
