<?php

namespace App\Repositories\User;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\User\SupplierUserRepository;
use App\Entities\User\SupplierUser;
use App\Validators\User\SupplierUserValidator;

/**
 * Class SupplierUserRepositoryEloquent.
 *
 * @package namespace App\Repositories\User;
 */
class SupplierUserRepositoryEloquent extends BaseRepository implements SupplierUserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SupplierUser::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return SupplierUserValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
