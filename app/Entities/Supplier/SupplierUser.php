<?php

namespace App\Entities\Supplier;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SupplierUser.
 *
 * @package namespace App\Entities\Supplier;
 */
class SupplierUser extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'supplier_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'mobile', 'email', 'password', 'status','created_at','updated_at'];

}
