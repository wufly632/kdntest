<?php

namespace App\Criteria\ShipOrder\PreShipOrder;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PreShipOrderStatusCriteria.
 *
 * @package namespace App\Criteria\ShipOrder\PreShipOrder;
 */
class PreShipOrderStatusCriteria implements CriteriaInterface
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
        $model = $model->where('pre_ship_orders.status', '<>', 3);
        if ($this->status) {
            $model = $model->where('pre_ship_orders.status', $this->status);
        }
        return $model;
    }
}
