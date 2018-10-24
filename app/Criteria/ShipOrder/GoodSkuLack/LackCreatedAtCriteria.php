<?php

namespace App\Criteria\ShipOrder\GoodSkuLack;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class LackCreatedAtCriteria.
 *
 * @package namespace App\Criteria\ShipOrder\GoodSkuLack;
 */
class LackCreatedAtCriteria implements CriteriaInterface
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
            $model = $model->where('good_sku_lacks.created_at', '>', $start_at)->where('good_sku_lacks.created_at', '<', $end_at);
        }
        return $model;
    }
}
