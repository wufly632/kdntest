<?php

namespace App\Criteria\Good;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class GoodCategoryIdCriteria.
 *
 * @package namespace App\Criteria\Good;
 */
class GoodCategoryIdCriteria implements CriteriaInterface
{
    protected $category_ids;

    public function __construct($category_ids)
    {
        $this->category_ids = $category_ids;
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
        if ($this->category_ids) {
            $model = $model->whereIn('audit_goods.category_id', $this->category_ids);
        }
        return $model;
    }
}
