<?php

namespace App\Criteria\Coupon;

use App\Entities\Coupon\Coupon;
use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CouponStatusCriteria.
 *
 * @package namespace App\Criteria\Coupon;
 */
class CouponStatusCriteria implements CriteriaInterface
{
    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if ($this->status) {
            $model = $model->where('use_type', 1); //固定日期
            $now = Carbon::now()->toDateTimeString();
            if ($this->status == Coupon::BEFORE) { //未开始
                $model = $model->where('coupon_use_startdate', '>', $now);
            } elseif ($this->status == Coupon::STARTING) { //进行中
                $model = $model->where('coupon_use_startdate', '<=', $now)->where('coupon_use_enddate', '>=', $now);
            } elseif ($this->status == Coupon::AFTER) { //已结束
                $model = $model->where('coupon_use_enddate', '<', $now);
            }
        }
        return $model;
    }
}
