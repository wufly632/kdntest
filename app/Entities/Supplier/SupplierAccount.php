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
class SupplierAccount extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'supplier_account';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
