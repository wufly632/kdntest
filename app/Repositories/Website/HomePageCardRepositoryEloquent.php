<?php

namespace App\Repositories\Website;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Website\HomePageCardRepository;
use App\Entities\Website\HomePageCard;
use App\Validators\Website\HomePageCardValidator;

/**
 * Class HomePageCardRepositoryEloquent.
 *
 * @package namespace App\Repositories\Website;
 */
class HomePageCardRepositoryEloquent extends BaseRepository implements HomePageCardRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return HomePageCard::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
