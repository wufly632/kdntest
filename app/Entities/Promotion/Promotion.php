<?php

namespace App\Entities\Promotion;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Promotion.
 *
 * @package namespace App\Entities\Promotion;
 */
class Promotion extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "promotions_activity";

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */

    protected $guarded = ['id'];

}
