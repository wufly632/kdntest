<?php

namespace App\Criteria\ShipOrder\PreShipOrder;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ProductTitleCriteria.
 *
 * @package namespace App\Criteria\ShipOrder\PreShipOrder;
 */
class ProductTitleCriteria implements CriteriaInterface
{
    protected $good_title;

    public function __construct($good_title)
    {
        $this->good_title = $good_title;
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
        if ($this->good_title) {
            $model = $model->leftJoin('goods', function($join){
                $join->on('goods.id', '=', 'pre_ship_orders.good_id');
            });
            $model = $model->where('goods.good_title', $this->good_title);
        }
        return $model;
    }
}
