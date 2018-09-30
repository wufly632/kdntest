<?php

namespace App\Entities\Coupon;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Coupon.
 *
 * @package namespace App\Entities\Coupon;
 */
class Coupon extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'coupon';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','coupon_name','coupon_price','coupon_use_price','coupon_number','use_type','use_days','coupon_use_startdate',
        'coupon_use_enddate','coupon_grant_startdate','coupon_grant_enddate','coupon_purpose','coupon_remark','created_at','updated_at'];

    //用途
    const PAGE_GET       = 1;   //页面领取
    const RETURN_COUPON  = 2;   //满返优惠券
    const NEW_USER       = 3;   //新人礼包

    public static $allPurpose = [
        self::PAGE_GET        => '页面领取',
        self::RETURN_COUPON   => '满返优惠券',
        self::NEW_USER        => '新人礼包',
    ];

    //状态
    const BEFORE    = 1; // 未开始
    const STARTING  = 2; //进行中
    const AFTER     = 3; //已结束

    public static $allStatus = [
       self::BEFORE    => '未开始',
       self::STARTING  => '进行中',
       self::AFTER     => '已结束'
    ];

}
