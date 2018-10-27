<?php

namespace App\Entities\Promotion;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Promotion.
 *
 * @package namespace App\Entities\Promotion;
 */
class Promotion extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "promotions_activity";

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */

    protected $guarded = ['id'];

    //状态
    const BEFORE    = 1; // 未开始
    const STARTING  = 2; //进行中
    const AFTER     = 3; //已结束

    public static $allStatus = [
        self::BEFORE    => '未开始',
        self::STARTING  => '进行中',
        self::AFTER     => '已结束'
    ];

    const REDUCE = 'reduce';
    const RETURN = 'return';
    const DISCOUNT = 'discount';
    const WHOLESALE = 'wholesale';
    const GIVE = 'give';
    const LIMIT = 'limit';
    const QUANTITY = 'quantity';
    public static $allType = [
        self::REDUCE => '满减',
        self::RETURN => '满返',
        self::DISCOUNT => '多件多折',
        self::WHOLESALE => 'X元n件',
        self::GIVE      => '买n免一',
        self::LIMIT => '限时特价',
        self::QUANTITY => '限量秒杀',
    ];

    public function getPromotionGoods()
    {
        return $this->hasMany(PromotionGood::class, 'activity_id', 'id');
    }

    /**
     * @function 获取促销活动的sku信息
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getPromotionSkus()
    {
        return $this->hasMany(PromotionGoodSku::class, 'activity_id', 'id');
    }
}
