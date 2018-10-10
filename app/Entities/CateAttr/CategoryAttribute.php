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
    protected $fillable = ['category_id','attr_type','attr_id','attr_values','is_required','check_type','is_image','is_diy','is_detail','status','created_at'];

    /**
     * @function 获取属性值
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function attribute()
    {
        return $this->hasOne(Attribute::class, "id", "attr_id")->orderBy('sort','asc');
    }

    /**
     * @function 获取分类
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

}
