<?php

namespace App\Repositories\ShiperOrder;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ShiperOrder\PreShipOrderRepository;
use App\Entities\ShiperOrder\PreShipOrder;
use App\Validators\ShiperOrder\PreShipOrderValidator;

/**
 * Class PreShipOrderRepositoryEloquent.
 *
 * @package namespace App\Repositories\ShiperOrder;
 */
class PreShipOrderRepositoryEloquent extends BaseRepository implements PreShipOrderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PreShipOrder::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
