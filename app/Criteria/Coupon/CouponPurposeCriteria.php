<?php

namespace App\Criteria\Coupon;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CouponPurposeCriteria.
 *
 * @package namespace App\Criteria\Coupon;
 */
class CouponPurposeCriteria implements CriteriaInterface
{
    protected $coupon_purpose;

    public function __construct($coupon_purpose)
    {
        $this->coupon_purpose = $coupon_purpose;
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
        if ($this->coupon_purpose) {
            $model = $model->where('coupon_purpose', $this->coupon_purpose);
        }
        return $model;
    }
}
