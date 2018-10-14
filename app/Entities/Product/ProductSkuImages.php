<?php

namespace App\Entities\Product;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ProductSkuImages.
 *
 * @package namespace App\Entities\Product;
 */
class ProductSkuImages extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'good_sku_images';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['good_id', 'sku_id', 'src', 'updated_at', 'sort', 'created_at', 'is_deleted'];

}
