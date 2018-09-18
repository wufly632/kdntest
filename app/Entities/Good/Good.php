<?php

namespace App\Entities\Good;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Good.
 *
 * @package namespace App\Entities\Good;
 */
class Good extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'audit_goods';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
