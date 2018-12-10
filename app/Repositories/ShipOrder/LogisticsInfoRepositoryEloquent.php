<?php

namespace App\Repositories\ShipOrder;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ShipOrder\LogisticsInfoRepository;
use App\Entities\ShipOrder\LogisticsInfo;
use App\Validators\ShipOrder\LogisticsInfoValidator;

/**
 * Class LogisticsInfoRepositoryEloquent.
 *
 * @package namespace App\Repositories\ShipOrder;
 */
class LogisticsInfoRepositoryEloquent extends BaseRepository implements LogisticsInfoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LogisticsInfo::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
