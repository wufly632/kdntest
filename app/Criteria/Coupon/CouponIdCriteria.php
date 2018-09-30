<?php

namespace App\Criteria\Coupon;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CouponIdCriteria.
 *
 * @package namespace App\Criteria\Coupon;
 */
class CouponIdCriteria implements CriteriaInterface
{
    protected $id;
    public function __construct($id)
    {
        $this->id = $id;
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
        if ($this->id) {
            $model = $model->where('id', $this->id);
        }
        return $model;
    }
}
