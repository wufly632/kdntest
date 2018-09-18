<?php

namespace App\Repositories\CateAttr;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CateAttr\CategoryAttributeRepository;
use App\Entities\CateAttr\CategoryAttribute;
use App\Validators\CateAttr\CategoryAttributeValidator;

/**
 * Class CategoryAttributeRepositoryEloquent.
 *
 * @package namespace App\Repositories\CateAttr;
 */
class CategoryAttributeRepositoryEloquent extends BaseRepository implements CategoryAttributeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CategoryAttribute::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CategoryAttributeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
