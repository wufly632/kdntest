<?php

namespace App\Criteria\Good;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class GoodIdCriteria.
 *
 * @package namespace App\Criteria\Good;
 */
class GoodIdCriteria implements CriteriaInterface
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
        $model = $model->selectRaw('audit_goods.*');
        if ($this->id) {
            $model = $model->where('audit_goods.id', $this->id);
        }
        return $model;
    }
}
