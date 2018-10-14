<?php

namespace App\Criteria\Promotion;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PromotionNameCriteria.
 *
 * @package namespace App\Criteria\Promotion;
 */
class PromotionNameCriteria implements CriteriaInterface
{
    protected $title;

    public function __construct($title)
    {
        $this->title = $title;
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
        if ($this->title) {
            $model = $model->where('title', 'like', $this->title);
        }
        return $model;
    }
}
