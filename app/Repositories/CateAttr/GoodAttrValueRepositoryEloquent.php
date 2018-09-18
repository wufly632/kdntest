<?php

namespace App\Repositories\CateAttr;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CateAttr\GoodAttrValueRepository;
use App\Entities\CateAttr\GoodAttrValue;
use App\Validators\CateAttr\GoodAttrValueValidator;

/**
 * Class GoodAttrValueRepositoryEloquent.
 *
 * @package namespace App\Repositories\CateAttr;
 */
class GoodAttrValueRepositoryEloquent extends BaseRepository implements GoodAttrValueRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GoodAttrValue::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
