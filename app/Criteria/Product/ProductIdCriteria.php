<?php

namespace App\Criteria\Product;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ProductIdCriteria.
 *
 * @package namespace App\Criteria\Product;
 */
class ProductIdCriteria implements CriteriaInterface
{
    protected $good_id;

    public function __construct($good_id)
    {
        $this->good_id = $good_id;
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
        if ($this->good_id) {
            $good_id = explode(',', $this->good_id);
            $model = $model->whereIn('id', $good_id);
        }
        return $model;
    }
}
