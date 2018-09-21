<?php

namespace App\Repositories\Promotion;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Promotion\PromotionGoodRepository;
use App\Entities\Promotion\PromotionGood;
use App\Validators\Promotion\PromotionGoodValidator;

/**
 * Class PromotionGoodRepositoryEloquent.
 *
 * @package namespace App\Repositories\Promotion;
 */
class PromotionGoodRepositoryEloquent extends BaseRepository implements PromotionGoodRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PromotionGood::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PromotionGoodValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
