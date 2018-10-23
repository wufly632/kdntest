<?php

namespace App\Criteria\ShopOrder\PreShipOrder;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PreShipOrderStatusCriteria.
 *
 * @package namespace App\Criteria\ShopOrder\PreShipOrder;
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
        if ($this->status) {
            $model = $model->where('status', $this->status);
        }
        return $model;
    }
}
