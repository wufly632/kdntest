<?php

namespace App\Criteria\Coupon;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CouponGrantTimeCriteria.
 *
 * @package namespace App\Criteria\Coupon;
 */
class CouponGrantTimeCriteria implements CriteriaInterface
{
    protected $grant_time;

    public function __construct($grant_time)
    {
        $this->grant_time = $grant_time;
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
        if ($this->grant_time) {
            list($start_at, $end_at) = get_time_range($this->grant_time);
            $model = $model->where('coupon_grant_startdate', '>=', $start_at)
                           ->where('coupon_grant_enddate', '<=', $end_at);
        }
        return $model;
    }
}
