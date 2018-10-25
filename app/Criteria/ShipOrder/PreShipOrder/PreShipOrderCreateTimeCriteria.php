<?php

namespace App\Criteria\ShipOrder\PreShipOrder;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PreShipOrderCreateTimeCriteria.
 *
 * @package namespace App\Criteria\ShipOrder\PreShipOrder;
 */
class PreShipOrderCreateTimeCriteria implements CriteriaInterface
{
    protected $range_time;

    public function __construct($range_time)
    {
        $this->range_time = $range_time;
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
        if ($this->range_time) {
            list($start_at,$end_at) = get_time_range($this->range_time);
            $model = $model->where('pre_ship_orders.created_at', '>', $start_at)->where('pre_ship_orders.created_at', '<', $end_at);
        }
        return $model;
    }
}
