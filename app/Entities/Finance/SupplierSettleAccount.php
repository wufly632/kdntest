<?php

namespace App\Entities\Finance;

use App\Entities\Supplier\SupplierUser;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SupplierSettleAccount.
 *
 * @package namespace App\Entities\Finance;
 */
class SupplierSettleAccount extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'supplier_settle_accounts';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function supplier()
    {
        return $this->hasOne(SupplierUser::class, 'id', 'supplier_id');
    }

    public function settleReceiveRelate()
    {
        return $this->hasMany(SupplierSettleReceive::class, 'settle_id', 'id');
    }
}
