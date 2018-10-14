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

    public function getPromotionGoods()
    {
        return $this->hasMany(PromotionGood::class, 'activity_id', 'id');
    }
}
