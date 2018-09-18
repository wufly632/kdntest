<?php

namespace App\Entities\CateAttr;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Category.
 *
 * @package namespace App\Entities\CateAttr;
 */
class Category extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'admin_goods_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
