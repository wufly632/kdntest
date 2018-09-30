<?php

namespace App\Criteria\Coupon;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CouponUseTimeCriteria.
 *
 * @package namespace App\Criteria\Coupon;
 */
class CouponUseTimeCriteria implements CriteriaInterface
{
    protected $use_time;

    public function __construct($use_time)
    {
        $this->use_time = $use_time;
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
        if ($this->use_time) {
            //固定时长
            /*$now = Carbon::now()->toDateTimeString();
            $model = $model->where('coupon_use_startdate','<=', $now)
                           ->where('coupon_use_enddate', '>=', $now);*/

            //固定日期
            list($start_at, $end_at) = get_time_range($this->use_time);
            $model = $model->where('coupon_use_startdate','<=', $start_at)
                           ->where('coupon_use_enddate', '>=', $end_at);
        }
        return $model;
    }
}
