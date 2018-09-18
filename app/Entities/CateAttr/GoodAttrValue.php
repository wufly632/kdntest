<?php

namespace App\Entities\CateAttr;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class GoodAttrValue.
 *
 * @package namespace App\Entities\CateAttr;
 */
class GoodAttrValue extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "audit_goods_attr_value";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
