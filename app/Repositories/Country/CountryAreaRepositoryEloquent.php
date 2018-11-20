<?php

namespace App\Repositories\Country;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Country\CountryAreaRepository;
use App\Entities\Country\CountryArea;
use App\Validators\Country\CountryAreaValidator;

/**
 * Class CountryAreaRepositoryEloquent.
 *
 * @package namespace App\Repositories\Country;
 */
class CountryAreaRepositoryEloquent extends BaseRepository implements CountryAreaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CountryArea::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
