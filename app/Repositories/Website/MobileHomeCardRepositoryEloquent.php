<?php

namespace App\Repositories\Website;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Website\MobileHomeCardRepository;
use App\Entities\Website\MobileHomeCard;
use App\Validators\Website\MobileHomeCardValidator;

/**
 * Class MobileHomeCardRepositoryEloquent.
 *
 * @package namespace App\Repositories\Website;
 */
class MobileHomeCardRepositoryEloquent extends BaseRepository implements MobileHomeCardRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MobileHomeCard::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
