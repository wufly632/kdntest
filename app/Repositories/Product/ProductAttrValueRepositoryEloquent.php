<?php

namespace App\Repositories\Product;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Product\ProductAttrValueRepository;
use App\Entities\Product\ProductAttrValue;
use App\Validators\Product\ProductAttrValueValidator;

/**
 * Class ProductAttrValueRepositoryEloquent.
 *
 * @package namespace App\Repositories\Product;
 */
class ProductAttrValueRepositoryEloquent extends BaseRepository implements ProductAttrValueRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductAttrValue::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
