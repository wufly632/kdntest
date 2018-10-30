<?php

namespace App\Criteria\Good;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class GoodSupplierIdCriteria.
 *
 * @package namespace App\Criteria\Good;
 */
class GoodSupplierIdCriteria implements CriteriaInterface
{
    protected $supplier_id;

    public function __construct($supplier_id)
    {
        $this->supplier_id = $supplier_id;
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
        if ($this->supplier_id) {
            $model = $model->where('audit_goods.supplier_id', $this->supplier_id);
        }
        return $model;
    }
}
