<?php

namespace App\Criteria\Product;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ProductCodeCriteria.
 *
 * @package namespace App\Criteria\Product;
 */
class ProductCodeCriteria implements CriteriaInterface
{
    protected $good_code;

    public function __construct($good_code)
    {
        $this->good_code = $good_code;
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
        if ($this->good_code) {
            $model = $model->where('good_code', $this->good_code);
        }
        return $model;
    }
}
