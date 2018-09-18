<?php

namespace App\Entities\CateAttr;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CategoryAttribute.
 *
 * @package namespace App\Entities\CateAttr;
 */
class CategoryAttribute extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "admin_goods_category_attribute";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * @function 获取属性值
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function attribute()
    {
        return $this->hasOne(Attribute::class, "id", "attr_id")->orderBy('sort','asc');
    }

}
