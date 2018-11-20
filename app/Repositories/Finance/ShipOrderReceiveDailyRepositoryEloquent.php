<?php

namespace App\Repositories\Finance;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Finance\ShipOrderReceiveDailyRepository;
use App\Entities\Finance\ShipOrderReceiveDaily;
use App\Validators\Finance\ShipOrderReceiveDailyValidator;

/**
 * Class ShipOrderReceiveDailyRepositoryEloquent.
 *
 * @package namespace App\Repositories\Finance;
 */
class ShipOrderReceiveDailyRepositoryEloquent extends BaseRepository implements ShipOrderReceiveDailyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ShipOrderReceiveDaily::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
