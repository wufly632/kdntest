<?php

namespace App\Repositories\CateAttr;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CateAttr\AttributeRepository;
use App\Entities\CateAttr\Attribute;
use App\Validators\CateAttr\AttributeValidator;

/**
 * Class AttributeRepositoryEloquent.
 *
 * @package namespace App\Repositories\CateAttr;
 */
class AttributeRepositoryEloquent extends BaseRepository implements AttributeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Attribute::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AttributeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
