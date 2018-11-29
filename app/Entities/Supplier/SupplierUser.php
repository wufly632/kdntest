<?php

namespace App\Entities\Supplier;

use App\Entities\CommonTrait\DateToLocalShowTrait;
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
    use DateToLocalShowTrait;

    protected $table = 'supplier_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'mobile', 'email', 'password', 'status', 'created_at', 'updated_at', 'company_name'];

    public function supplierAccount()
    {
        return $this->hasOne(SupplierAccount::class, 'supplier_id', 'id');
    }
}
