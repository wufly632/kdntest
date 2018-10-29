<?php

namespace App\Entities\Website;

use App\Entities\CateAttr\Category;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class HomePageCard.
 *
 * @package namespace App\Entities\Website;
 */
class HomePageCard extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'website_homepage_card';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'link', 'left_image', 'center_image', 'product_category_id'];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'product_category_id');
    }

}
