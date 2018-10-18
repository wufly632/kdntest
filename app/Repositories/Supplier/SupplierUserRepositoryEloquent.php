<?php

namespace App\Repositories\Supplier;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Supplier\SupplierUserRepository;
use App\Entities\Supplier\SupplierUser;
use App\Validators\Supplier\SupplierUserValidator;

/**
 * Class SupplierUserRepositoryEloquent.
 *
 * @package namespace App\Repositories\Supplier;
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
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
