<?php

namespace App\Repositories\ShipOrder;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ShipOrder\PreShipOrderRepository;
use App\Entities\ShipOrder\PreShipOrder;
use App\Validators\ShipOrder\PreShipOrderValidator;

/**
 * Class PreShipOrderRepositoryEloquent.
 *
 * @package namespace App\Repositories\ShipOrder;
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
