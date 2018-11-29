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
    protected $fillable = ['attribute_id', 'name', 'en_name', 'value', 'sort', 'created_at', 'updated_at'];

    /**
     * @function 获取属性
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getAttr()
    {
        return $this->hasOne(Attribute::class, 'id', 'attribute_id');
    }
}
