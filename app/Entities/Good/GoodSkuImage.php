<?php

namespace App\Entities\Good;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class GoodSkuImage.
 *
 * @package namespace App\Entities\Good;
 */
class GoodSkuImage extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "audit_good_sku_images";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['good_id', 'sku_id', 'src', 'sort', 'is_deleted', 'created_at', 'updated_at'];

    // 需同步的字段
    public static $syncField = ['id','good_id', 'sku_id', 'src', 'sort', 'is_deleted'];

}
