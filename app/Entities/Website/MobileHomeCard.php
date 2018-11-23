<?php

namespace App\Entities\Website;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MobileHomeCard.
 *
 * @package namespace App\Entities\Website;
 */
class MobileHomeCard extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'website_mobile_homepage_cards';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'content', 'type'];

    protected $visible = ['id', 'title', 'content', 'type'];

    protected $casts = [
        'content' => 'array'
    ];

}
