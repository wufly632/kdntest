<?php

namespace App\Criteria\ShipOrder\GoodSkuLack;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class LackGoodIdCriteria.
 *
 * @package namespace App\Criteria\ShipOrder\GoodSkuLack;
 */
class LackGoodIdCriteria implements CriteriaInterface
{
    protected $good_id;

    public function __construct($good_id)
    {
        $this->good_id = $good_id;
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
        if ($this->good_id) {
            $model = $model->where('good_sku_lacks.good_id', $this->good_id);
        }
        return $model;
    }
}
