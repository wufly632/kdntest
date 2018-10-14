<?php

namespace App\Criteria\Promotion;

use App\Entities\Promotion\Promotion;
use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PromotionStatusCriteria.
 *
 * @package namespace App\Criteria\Promotion;
 */
class PromotionStatusCriteria implements CriteriaInterface
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
            $now = Carbon::now()->toDateTimeString();
            if ($this->status == Promotion::BEFORE) { //未开始
                $model = $model->where('start_at', '>', $now);
            } elseif ($this->status == Promotion::STARTING) { //进行中
                $model = $model->where('start_at', '<=', $now)->where('end_at', '>=', $now);
            } elseif ($this->status == Promotion::AFTER) { //已结束
                $model = $model->where('end_at', '<', $now);
            }
        }
        return $model;
    }
}
