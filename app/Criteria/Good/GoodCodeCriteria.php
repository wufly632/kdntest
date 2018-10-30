<?php

namespace App\Criteria\Good;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class GoodCodeCriteria.
 *
 * @package namespace App\Criteria\Good;
 */
class GoodCodeCriteria implements CriteriaInterface
{

    protected $good_code;

    public function __construct($good_code)
    {
        $this->good_code = $good_code;
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
        if ($this->good_code) {
            $model = $model->where('audit_goods.good_code', $this->good_code);
        }
        return $model;
    }
}
