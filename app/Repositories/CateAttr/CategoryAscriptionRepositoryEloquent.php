<?php

namespace App\Repositories\CateAttr;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CateAttr\CategoryAscriptionRepository;
use App\Entities\CateAttr\CategoryAscription;
use App\Validators\CateAttr\CategoryAscriptionValidator;

/**
 * Class CategoryAscriptionRepositoryEloquent.
 *
 * @package namespace App\Repositories\CateAttr;
 */
class CategoryAscriptionRepositoryEloquent extends BaseRepository implements CategoryAscriptionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CategoryAscription::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
