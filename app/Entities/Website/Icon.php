<?php

namespace App\Entities\Website;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Icon.
 *
 * @package namespace App\Entities\Website;
 */
class Icon extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'website_icons';

    public function getSrcAttribute($item)
    {
        return cdnUrl($item);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'src', 'category_id', 'start_at', 'end_at', 'sort'];

}
