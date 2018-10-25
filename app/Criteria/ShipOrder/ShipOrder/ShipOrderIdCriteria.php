<?php

namespace App\Criteria\ShipOrder\ShipOrder;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ShipOrderIdCriteria.
 *
 * @package namespace App\Criteria\ShipOrder\ShipOrder;
 */
class ShipOrderIdCriteria implements CriteriaInterface
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
        if ($this->id) {
            $model = $model->where('ship_orders.id', $this->id);
        }
        return $model;
    }
}
