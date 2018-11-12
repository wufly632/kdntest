<?php

namespace App\Entities\Finance;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SupplierSettleReceive.
 *
 * @package namespace App\Entities\Finance;
 */
class SupplierSettleReceive extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'supplier_settle_receive';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function receiveDaily()
    {
        return $this->hasOne(ShipOrderReceiveDaily::class, 'id', 'receive_daily_id');
    }
}
