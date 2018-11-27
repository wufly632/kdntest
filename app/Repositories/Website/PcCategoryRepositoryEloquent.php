<?php

namespace App\Repositories\Website;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Website\PcCategoryRepository;
use App\Entities\Website\PcCategory;
use App\Validators\Website\PcCategoryValidator;

/**
 * Class PcCategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories\Website;
 */
class PcCategoryRepositoryEloquent extends BaseRepository implements PcCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PcCategory::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
