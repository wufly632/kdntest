<?php

namespace App\Repositories\Product;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Product\ProductSkuImagesRepository;
use App\Entities\Product\ProductSkuImages;
use App\Validators\Product\ProductSkuImagesValidator;

/**
 * Class ProductSkuImagesRepositoryEloquent.
 *
 * @package namespace App\Repositories\Product;
 */
class ProductSkuImagesRepositoryEloquent extends BaseRepository implements ProductSkuImagesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductSkuImages::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
