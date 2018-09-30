<?php

namespace App\Criteria\Coupon;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CouponNameCriteria.
 *
 * @package namespace App\Criteria\Coupon;
 */
class CouponNameCriteria implements CriteriaInterface
{
    protected $coupon_name;
    public function __construct($coupon_name)
    {
        $this->coupon_name = $coupon_name;
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
        if ($this->coupon_name) {
            $model = $model->where('coupon_name', $this->coupon_name);
        }
        return $model;
    }
}
