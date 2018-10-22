<?php

namespace App\Repositories\ShipOrder;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ShipOrder\ShipOrderRepository;
use App\Entities\ShipOrder\ShipOrder;
use App\Validators\ShipOrder\ShipOrderValidator;

/**
 * Class ShipOrderRepositoryEloquent.
 *
 * @package namespace App\Repositories\ShipOrder;
 */
class ShipOrderRepositoryEloquent extends BaseRepository implements ShipOrderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ShipOrder::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
