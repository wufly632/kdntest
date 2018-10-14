<?php

namespace App\Criteria\Promotion;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PromotionCreateTimeCriteria.
 *
 * @package namespace App\Criteria\Promotion;
 */
class PromotionCreateTimeCriteria implements CriteriaInterface
{
    protected $create_time;

    public function __construct($create_time)
    {
        $this->create_time = $create_time;
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
        if ($this->create_time) {
            list($start_at, $end_at) = get_time_range($this->create_time);
            $model = $model->where('created_at', '>=', $start_at)
                ->where('created_at', '<=', $end_at);
        }
        return $model;
    }
}
