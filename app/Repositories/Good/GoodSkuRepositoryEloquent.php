<?php

namespace App\Repositories\Good;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Good\GoodSkuRepository;
use App\Entities\Good\GoodSku;
use App\Validators\Good\GoodSkuValidator;

/**
 * Class GoodSkuRepositoryEloquent.
 *
 * @package namespace App\Repositories\Good;
 */
class GoodSkuRepositoryEloquent extends BaseRepository implements GoodSkuRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GoodSku::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GoodSkuValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
