<?php

namespace App\Entities\User;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class User.
 *
 * @package namespace App\Entities\User;
 */
class User extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_alias', 'firstname', 'lastname', 'email', 'password', 'status', 'logo'];

    protected $hidden = ['password', 'update_at'];

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case 1:
                return '正常';
                break;
            case 2:
                return '冻结';
                break;
            default:
                return '冻结';
                break;
        }
    }
}
