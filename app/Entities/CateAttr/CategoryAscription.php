<?php

namespace App\Entities\CateAttr;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CategoryAscription.
 *
 * @package namespace App\Entities\CateAttr;
 */
class CategoryAscription extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'category_ascription';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
