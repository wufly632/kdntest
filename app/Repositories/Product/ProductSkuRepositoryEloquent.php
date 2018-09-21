<?php

namespace App\Repositories\Product;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Product\ProductSkuRepository;
use App\Entities\Product\ProductSku;
use App\Validators\Product\ProductSkuValidator;

/**
 * Class ProductSkuRepositoryEloquent.
 *
 * @package namespace App\Repositories\Product;
 */
class ProductSkuRepositoryEloquent extends BaseRepository implements ProductSkuRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductSku::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
