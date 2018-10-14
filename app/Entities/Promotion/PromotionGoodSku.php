<?php

namespace App\Entities\Promotion;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PromotionGoodSku.
 *
 * @package namespace App\Entities\Promotion;
 */
class PromotionGoodSku extends Model implements Transformable
{
    use TransformableTrait;

    const UPDATED_AT = null;

    protected $table = 'promotions_activity_goods_sku';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['activity_id', 'goods_id', 'sku_id', 'price', 'created_at'];

}
