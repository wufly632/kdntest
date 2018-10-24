<?php

namespace App\Criteria\ShipOrder\GoodSkuLack;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class LackStatusCriteria.
 *
 * @package namespace App\Criteria\ShipOrder\GoodSkuLack;
 */
class LackStatusCriteria implements CriteriaInterface
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
            $model = $model->where('good_sku_lacks.status', $this->status);
        }
        return $model;
    }
}
