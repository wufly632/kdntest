<?php

namespace App\Criteria\ShipOrder\ShipOrder;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ShipOrderStatusCriteria.
 *
 * @package namespace App\Criteria\ShipOrder\ShipOrder;
 */
class ShipOrderStatusCriteria implements CriteriaInterface
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
            $model = $model->where('ship_orders.status', $this->status);
        }
        return $model;
    }
}
