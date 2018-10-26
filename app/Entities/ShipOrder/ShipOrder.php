<?php

namespace App\Entities\ShipOrder;

use App\Entities\Supplier\SupplierUser;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ShipOrder.
 *
 * @package namespace App\Entities\ShipOrder;
 */
class ShipOrder extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'ship_orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['supplier_id','num','status','released','received','accepted','rejected','note','created_at',
        'confirmed_at','shipped_at','partlyinhouse_at','acceptance_at','closed_at','updated_at'];

    const CONFIRMED = 'confirmed';
    const SHIPPED = 'shipped';
    const PARTLYINHOUSED = 'partlyinhoused';
    const ACCEPTANCE = 'acceptance';
    const CLOSED = 'closed';

    public static $allStatus = [
        self::CONFIRMED => '已组单',
        self::SHIPPED  => '已发货',
        self::PARTLYINHOUSED => '部分到货',
        self::ACCEPTANCE => '全部到货',
        self::CLOSED    => '已完成'
    ];

    /**
     * @function 获取供应商信息
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getSupplier()
    {
        return $this->hasOne(SupplierUser::class, 'id', 'supplier_id');
    }

    /**
     * @function 获取发货单快递信息
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    /*public function getExpress()
    {
        return $this->hasMany(ShipOrderExpress::class, 'ship_order_id', 'id');
    }*/

    /**
     * @function 获取明细
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getItems()
    {
        return $this->hasMany(ShipOrderItem::class, 'ship_order_id', 'id');
    }
}
