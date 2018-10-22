<?php

namespace App\Entities\ShipOrder;

use App\Entities\CommonTrait\DateToLocalShowTrait;
use App\Entities\Supplier\SupplierUser;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class GoodSkuLack.
 *
 * @package namespace App\Entities\ShipOrder;
 */
class GoodSkuLack extends Model implements Transformable
{
    use TransformableTrait;
    use DateToLocalShowTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['pre_ship_order_id','supplier_id','sku_id','num','apply_note','reject_note','status','created_at','audited_at','rejected_at','updated_at'];

    const WAIT_AUDIT     = 1;   //等待审核
    const PASS_AUDIT     = 2;   //审核通过
    const REJECT         = 3;   //审核拒绝

    public static $allStatus = [
        self::WAIT_AUDIT      => '等待审核',
        self::PASS_AUDIT      => '审核通过',
        self::REJECT          => '审核拒绝',
    ];

    /**
     * @function 获取供应商信息
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getSupplier()
    {
        return $this->hasOne(SupplierUser::class, 'id', 'supplier_id');
    }

}
