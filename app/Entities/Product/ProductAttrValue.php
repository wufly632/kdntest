<?php

namespace App\Entities\Product;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ProductAttrValue.
 *
 * @package namespace App\Entities\Product;
 */
class ProductAttrValue extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'goods_attr_value';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['good_id', 'sku_id', 'attr_id', 'value_ids', 'value_name', 'created_at', 'updated_at'];

}
