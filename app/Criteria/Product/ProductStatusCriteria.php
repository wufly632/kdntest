<?php

namespace App\Criteria\Product;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ProductStatusCriteria.
 *
 * @package namespace App\Criteria\Product;
 */
class ProductStatusCriteria implements CriteriaInterface
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
            $model = $model->where('status', $this->status);
        }
        return $model;
    }
}
