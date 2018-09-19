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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
