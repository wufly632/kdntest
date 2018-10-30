<?php

namespace App\Criteria\Good;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class GoodStatusCriteria.
 *
 * @package namespace App\Criteria\Good;
 */
class GoodStatusCriteria implements CriteriaInterface
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
            if (in_array($this->status, ['offline', 'online'])) {
                $this->status = $this->status == 'online' ? 1 : 2;
                $model = $model->leftJoin('goods', function($join){
                    $join->on('goods.id', '=', 'audit_goods.id');
                });
                $model = $model->where(['goods.status' => $this->status, 'audit_goods.status' => 4]);
            } else {
                $model = $model->where('audit_goods.status', $this->status);
            }
        }
        return $model;
    }
}
