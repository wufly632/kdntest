<?php

namespace App\Criteria\ShipOrder\PreShipOrder;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ProductIdCriteria.
 *
 * @package namespace App\Criteria\ShipOrder\PreShipOrder;
 */
class ProductIdCriteria implements CriteriaInterface
{
    protected $product_id;

    public function __construct($product_id)
    {
        $this->product_id = $product_id;
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
        if ($this->product_id) {
            $model = $model->where('pre_ship_orders.good_id', $this->product_id);
        }
        return $model;
    }
}
