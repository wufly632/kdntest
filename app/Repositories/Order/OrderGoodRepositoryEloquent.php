<?php

namespace App\Repositories\Order;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Order\OrderGoodRepository;
use App\Entities\Order\OrderGood;
use App\Validators\Order\OrderGoodValidator;

/**
 * Class OrderGoodRepositoryEloquent.
 *
 * @package namespace App\Repositories\Order;
 */
class OrderGoodRepositoryEloquent extends BaseRepository implements OrderGoodRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderGood::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
