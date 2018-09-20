<?php

namespace App\Repositories\Promotion;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Promotion\PromotionRepository;
use App\Entities\Promotion\Promotion;
use App\Validators\Promotion\PromotionValidator;

/**
 * Class PromotionRepositoryEloquent.
 *
 * @package namespace App\Repositories\Promotion;
 */
class PromotionRepositoryEloquent extends BaseRepository implements PromotionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Promotion::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PromotionValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
