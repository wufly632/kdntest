<?php

namespace App\Repositories\Website;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Website\IconRepository;
use App\Entities\Website\Icon;
use App\Validators\Website\IconValidator;

/**
 * Class IconRepositoryEloquent.
 *
 * @package namespace App\Repositories\Website;
 */
class IconRepositoryEloquent extends BaseRepository implements IconRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Icon::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
