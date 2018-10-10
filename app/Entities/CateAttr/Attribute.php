<?php

namespace App\Entities\CateAttr;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Attribute.
 *
 * @package namespace App\Entities\CateAttr;
 */
class Attribute extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "admin_attribute";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','alias_name','en_name','type','sort','status','created_at','updated_at'];

    /**标准类型*/
    const TYPE_STANDARD = "0";

    /**自定义文本*/
    const TYPE_CUSTOM = "1";


    /**
     * 所有属性值类型数组
     */
    public static $alltypes = array(
        self::TYPE_STANDARD => '标准化文本',
        self::TYPE_CUSTOM   => '自定义文本',
    );

    /**
     * @function 属性值
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attribute_values()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id', 'id')->orderBy('sort', 'desc');
    }

    /**
     * @function 获取属性对应的类目属性
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attribute_categories()
    {
        return $this->hasMany(CategoryAttribute::class, 'attr_id', 'id')->where('status', 1)->groupBy('category_id');
    }
}
