<?php

namespace App\Repositories\Good;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Good\GoodRepository;
use App\Entities\Good\Good;
use App\Validators\Good\GoodValidator;

/**
 * Class GoodRepositoryEloquent.
 *
 * @package namespace App\Repositories\Good;
 */
class GoodRepositoryEloquent extends BaseRepository implements GoodRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Good::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GoodValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
