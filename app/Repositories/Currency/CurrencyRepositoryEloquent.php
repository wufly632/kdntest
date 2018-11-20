<?php

namespace App\Repositories\Currency;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Currency\CurrencyRepository;
use App\Entities\Currency\Currency;
use App\Validators\Currency\CurrencyValidator;

/**
 * Class CurrencyRepositoryEloquent.
 *
 * @package namespace App\Repositories\Currency;
 */
class CurrencyRepositoryEloquent extends BaseRepository implements CurrencyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Currency::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
