<?php

namespace App\Repositories\PushOrder;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PushOrder\RequirementRepository;
use App\Entities\PushOrder\Requirement;
use App\Validators\PushOrder\RequirementValidator;

/**
 * Class RequirementRepositoryEloquent.
 *
 * @package namespace App\Repositories\PushOrder;
 */
class RequirementRepositoryEloquent extends BaseRepository implements RequirementRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Requirement::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
