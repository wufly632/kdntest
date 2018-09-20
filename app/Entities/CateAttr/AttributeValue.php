<?php

namespace App\Entities\CateAttr;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class AttributeValue.
 *
 * @package namespace App\Entities\CateAttr;
 */
class AttributeValue extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'admin_attribute_value';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
