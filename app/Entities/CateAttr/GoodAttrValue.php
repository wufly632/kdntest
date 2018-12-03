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
    protected $guarded = ['id'];

    // 需同步的字段
    public static $syncField = ['id', 'good_id', 'sku_id', 'attr_id', 'value_ids', 'value_name'];

    public function categoryAttribute()
    {
        return app('App\Services\CateAttr\CategoryAttributeService')->getCategoryAttributeById($this->value_ids);
    }

    public function getAttibute()
    {
        return $this->hasOne(Attribute::class, 'id', 'attr_id');
    }

    public function getAttrValue()
    {
        return $this->hasOne(AttributeValue::class, 'id', 'value_ids');
    }


}
