<?php

namespace App\Repositories\Website;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Website\MobileCategoryRepository;
use App\Entities\Website\MobileCategory;
use App\Validators\Website\MobileCategoryValidator;

/**
 * Class MobileCategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories\Website;
 */
class MobileCategoryRepositoryEloquent extends BaseRepository implements MobileCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MobileCategory::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
