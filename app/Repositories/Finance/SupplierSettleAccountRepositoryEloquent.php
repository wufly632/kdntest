<?php

namespace App\Repositories\Finance;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Finance\SupplierSettleAccountRepository;
use App\Entities\Finance\SupplierSettleAccount;
use App\Validators\Finance\SupplierSettleAccountValidator;

/**
 * Class SupplierSettleAccountRepositoryEloquent.
 *
 * @package namespace App\Repositories\Finance;
 */
class SupplierSettleAccountRepositoryEloquent extends BaseRepository implements SupplierSettleAccountRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SupplierSettleAccount::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
