<?php

namespace App\Entities\Product;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ProductOnOffline.
 *
 * @package namespace App\Entities\Product;
 */
class ProductOnOffline extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'good_onoffline_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
