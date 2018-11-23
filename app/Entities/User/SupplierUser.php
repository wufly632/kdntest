<?php

namespace App\Entities\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SupplierUser.
 *
 * @package namespace App\Entities\User;
 */
class SupplierUser extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'mobile', 'email', 'password', 'status', 'company_name'];

    protected $visible = ['id', 'name', 'mobile', 'email', 'password', 'amount_money', 'status', 'create_at', 'company_name'];
}
