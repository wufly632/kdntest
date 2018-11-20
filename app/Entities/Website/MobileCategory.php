<?php

namespace App\Entities\Website;

use Illuminate\Database\Eloquent\Model;

class MobileCategory extends Model
{

    protected $table = 'website_mobile_categorys';

    public function childrens()
    {
        return $this->hasMany(MobileCategory::class, 'parent_id', 'id')->select(['category_id', 'name', 'image'])->orderByDesc('sort');
    }
}