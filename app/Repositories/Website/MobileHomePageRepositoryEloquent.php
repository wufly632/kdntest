<?php

namespace App\Repositories\Website;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Website\MobileHomePageRepository;
use App\Entities\Website\MobileHomePage;
use App\Validators\Website\MobileHomePageValidator;

/**
 * Class MobileHomePageRepositoryEloquent.
 *
 * @package namespace App\Repositories\Website;
 */
class MobileHomePageRepositoryEloquent extends BaseRepository implements MobileHomePageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MobileHomePage::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
