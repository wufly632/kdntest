<?php

namespace App\Criteria\ShopOrder\PreShipOrder;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PreShipOrderIdCriteria.
 *
 * @package namespace App\Criteria\ShopOrder\PreShipOrder;
 */
class PreShipOrderIdCriteria implements CriteriaInterface
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
            $model = $model->where('id', $this->id);
        }
        return $model;
    }
}
