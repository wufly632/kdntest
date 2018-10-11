<?php

namespace App\Repositories\Order;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Order\OrderPaymentRepository;
use App\Entities\Order\OrderPayment;
use App\Validators\Order\OrderPaymentValidator;

/**
 * Class OrderPaymentRepositoryEloquent.
 *
 * @package namespace App\Repositories\Order;
 */
class OrderPaymentRepositoryEloquent extends BaseRepository implements OrderPaymentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderPayment::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
