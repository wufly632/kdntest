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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
