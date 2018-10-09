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
    protected $fillable = [];

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

}
