<?php

namespace App\Repositories\ShipOrder;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ShipOrder\GoodSkuLackRepository;
use App\Entities\ShipOrder\GoodSkuLack;
use App\Validators\ShipOrder\GoodSkuLackValidator;

/**
 * Class GoodSkuLackRepositoryEloquent.
 *
 * @package namespace App\Repositories\ShipOrder;
 */
class GoodSkuLackRepositoryEloquent extends BaseRepository implements GoodSkuLackRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GoodSkuLack::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
