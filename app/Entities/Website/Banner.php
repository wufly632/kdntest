<?php

namespace App\Entities\Website;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Banner.
 *
 * @package namespace App\Entities\Website;
 */
class Banner extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'website_banners';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'describe', 'src', 'link', 'type', 'currency_code', 'start_at', 'end_at', 'sort'];

}
