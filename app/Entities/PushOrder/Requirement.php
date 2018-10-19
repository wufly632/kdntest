<?php

namespace App\Entities\PushOrder;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Requirement.
 *
 * @package namespace App\Entities\PushOrder;
 */
class Requirement extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'requirements';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
