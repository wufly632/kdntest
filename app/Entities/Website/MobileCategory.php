<?php

namespace App\Entities\Website;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MobileCategory.
 *
 * @package namespace App\Entities\Website;
 */
class MobileCategory extends Model implements Transformable
{
    use TransformableTrait;


    protected $table = 'website_mobile_categorys';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'name', 'image', 'icon', 'sort', 'parent_id'];
}
