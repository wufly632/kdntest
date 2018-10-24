<?php

namespace App\Criteria\ShipOrder\GoodSkuLack;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class LackSkuIdCriteria.
 *
 * @package namespace App\Criteria\ShipOrder\GoodSkuLack;
 */
class LackSkuIdCriteria implements CriteriaInterface
{
    protected $sku_id;

    public function __construct($sku_id)
    {
        $this->sku_id = $sku_id;
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
        if ($this->sku_id) {
            $model = $model->where('good_sku_lacks.sku_id', $this->sku_id);
        }
        return $model;
    }
}
