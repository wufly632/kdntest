<?php

namespace App\Repositories\Promotion;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Promotion\PromotionGoodSkuRepository;
use App\Entities\Promotion\PromotionGoodSku;
use App\Validators\Promotion\PromotionGoodSkuValidator;

/**
 * Class PromotionGoodSkuRepositoryEloquent.
 *
 * @package namespace App\Repositories\Promotion;
 */
class PromotionGoodSkuRepositoryEloquent extends BaseRepository implements PromotionGoodSkuRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PromotionGoodSku::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
