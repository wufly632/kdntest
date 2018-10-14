<?php

namespace App\Entities\Promotion;

use App\Entities\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PromotionGood.
 *
 * @package namespace App\Entities\Promotion;
 */
class PromotionGood extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'promotions_activity_goods';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['activity_id','goods_id','num','buy_num','per_num','status','created_at','updated_at'];

    public function getProduct()
    {
        return $this->hasOne(Product::class, 'id', 'goods_id');
    }
}
