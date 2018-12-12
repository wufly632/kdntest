<?php

namespace App\Entities\Finance;

use App\Entities\Supplier\SupplierUser;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SupplierWithdraw.
 *
 * @package namespace App\Entities\Finance;
 */
class SupplierWithdraw extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'supplier_withdraw';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'supplier_id',
        'withdraw_code',
        'amout',
        'status',
        'note',
        'charge',
        'swift_number',
        'audited_at',
        'finished_at',
        'rejected_at'
    ];

    public function supplier()
    {
        return $this->hasOne(SupplierUser::class, 'id', 'supplier_id');
    }
}
