<?php

namespace App\Criteria\Good;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class GoodStatusCriteria.
 *
 * @package namespace App\Criteria\Good;
 */
class GoodStatusCriteria implements CriteriaInterface
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
