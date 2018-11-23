<?php

namespace App\Entities\Website;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PcCategory.
 *
 * @package namespace App\Entities\Website;
 */
class PcCategory extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'website_pc_categorys';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'name', 'sort', 'parent_id'];

}
