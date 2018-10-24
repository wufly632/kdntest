<?php

namespace App\Criteria\ShipOrder\ShipOrder;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ShipOrderCreatedAtCriteria.
 *
 * @package namespace App\Criteria\ShipOrder\ShipOrder;
 */
class ShipOrderCreatedAtCriteria implements CriteriaInterface
{
    protected $created_at;

    public function __construct($created_at)
    {
        $this->created_at = $created_at;
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
        if ($this->created_at) {
            list($start_at,$end_at) = get_time_range($this->created_at);
            $model = $model->where('ship_orders.created_at', '>', $start_at)->where('ship_orders.created_at', '<', $end_at);
        }
        return $model;
    }
}
