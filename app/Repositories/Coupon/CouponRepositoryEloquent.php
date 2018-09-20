<?php

namespace App\Repositories\Coupon;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Coupon\CouponRepository;
use App\Entities\Coupon\Coupon;
use App\Validators\Coupon\CouponValidator;

/**
 * Class CouponRepositoryEloquent.
 *
 * @package namespace App\Repositories\Coupon;
 */
class CouponRepositoryEloquent extends BaseRepository implements CouponRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Coupon::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CouponValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
