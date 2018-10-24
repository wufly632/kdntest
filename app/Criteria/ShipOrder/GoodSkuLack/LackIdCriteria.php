<?php

namespace App\Criteria\ShipOrder\GoodSkuLack;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class LackIdCriteria.
 *
 * @package namespace App\Criteria\ShipOrder\GoodSkuLack;
 */
class LackIdCriteria implements CriteriaInterface
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
            $model = $model->where('good_sku_lacks.id', $this->id);
        }
        return $model;
    }
}
