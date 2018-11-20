<?php

namespace App\Repositories\Finance;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Finance\SupplierSettleReceiveRepository;
use App\Entities\Finance\SupplierSettleReceive;
use App\Validators\Finance\SupplierSettleReceiveValidator;

/**
 * Class SupplierSettleReceiveRepositoryEloquent.
 *
 * @package namespace App\Repositories\Finance;
 */
class SupplierSettleReceiveRepositoryEloquent extends BaseRepository implements SupplierSettleReceiveRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SupplierSettleReceive::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
