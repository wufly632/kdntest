<?php

namespace App\Entities\Currency;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Currency.
 *
 * @package namespace App\Entities\Currency;
 */
class Currency extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'currency';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
