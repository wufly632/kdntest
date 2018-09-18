<?php

namespace App\Repositories\Good;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Good\GoodSkuImageRepository;
use App\Entities\Good\GoodSkuImage;
use App\Validators\Good\GoodSkuImageValidator;

/**
 * Class GoodSkuImageRepositoryEloquent.
 *
 * @package namespace App\Repositories\Good;
 */
class GoodSkuImageRepositoryEloquent extends BaseRepository implements GoodSkuImageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GoodSkuImage::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GoodSkuImageValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
