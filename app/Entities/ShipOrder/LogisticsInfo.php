<?php

namespace App\Entities\ShipOrder;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class LogisticsInfo.
 *
 * @package namespace App\Entities\ShipOrder;
 */
class LogisticsInfo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'logistic_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
