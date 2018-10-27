<?php

namespace App\Entities\Website;

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
    protected $fillable = [];

}
