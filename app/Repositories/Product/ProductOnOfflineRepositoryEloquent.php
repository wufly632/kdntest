<?php

namespace App\Repositories\Product;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Product\ProductOnOfflineRepository;
use App\Entities\Product\ProductOnOffline;
use App\Validators\Product\ProductOnOfflineValidator;

/**
 * Class ProductOnOfflineRepositoryEloquent.
 *
 * @package namespace App\Repositories\Product;
 */
class ProductOnOfflineRepositoryEloquent extends BaseRepository implements ProductOnOfflineRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductOnOffline::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
