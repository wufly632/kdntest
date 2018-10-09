<?php

namespace App\Criteria\Product;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ProductTitleCriteria.
 *
 * @package namespace App\Criteria\Product;
 */
class ProductTitleCriteria implements CriteriaInterface
{
    protected $good_title = '';

    public function __construct($good_title)
    {
        $this->good_title = $good_title;
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
        if ($this->good_title) {
            $model = $model->where('good_title', 'like', $this->good_title);
        }
        return $model;
    }
}
