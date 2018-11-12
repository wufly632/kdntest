<?php

namespace App\Repositories\Finance;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Finance\SupplierWithdrawRepository;
use App\Entities\Finance\SupplierWithdraw;
use App\Validators\Finance\SupplierWithdrawValidator;

/**
 * Class SupplierWithdrawRepositoryEloquent.
 *
 * @package namespace App\Repositories\Finance;
 */
class SupplierWithdrawRepositoryEloquent extends BaseRepository implements SupplierWithdrawRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SupplierWithdraw::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
