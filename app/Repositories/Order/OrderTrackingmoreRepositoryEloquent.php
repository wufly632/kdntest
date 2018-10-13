<?php

namespace App\Repositories\Order;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Order\OrderTrackingmoreRepository;
use App\Entities\Order\OrderTrackingmore;
use App\Validators\Order\OrderTrackingmoreValidator;

/**
 * Class OrderTrackingmoreRepositoryEloquent.
 *
 * @package namespace App\Repositories\Order;
 */
class OrderTrackingmoreRepositoryEloquent extends BaseRepository implements OrderTrackingmoreRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderTrackingmore::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
