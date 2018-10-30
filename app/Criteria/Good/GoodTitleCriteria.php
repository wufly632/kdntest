<?php

namespace App\Criteria\Good;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class GoodTitleCriteria.
 *
 * @package namespace App\Criteria\Good;
 */
class GoodTitleCriteria implements CriteriaInterface
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
            $model = $model->where('audit_goods.good_title', 'like', $this->good_title);
        }
        return $model;
    }
}
