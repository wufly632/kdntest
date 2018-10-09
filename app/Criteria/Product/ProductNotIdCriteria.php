<?php

namespace App\Criteria\Product;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ProductNotIdCriteria.
 *
 * @package namespace App\Criteria\Product;
 */
class ProductNotIdCriteria implements CriteriaInterface
{
    protected $ids;
    public function __construct($ids)
    {
        $this->ids = $ids;
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
        if ($this->ids) {
            $model = $model->whereNotIn('id', $this->ids);
        }
        return $model;
    }
}
