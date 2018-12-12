<?php

namespace App\Entities\CateAttr;

use App\Presenters\CateAttr\CategoryPresenter;
use App\Services\CateAttr\CategoryService;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Category.
 *
 * @package namespace App\Entities\CateAttr;
 */
class Category extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'admin_goods_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','en_name','level','parent_id','category_path','category_ids','is_final', 'describe','status','sort','created_at','updated_at'];

    /**
     * 子类目
     *
     * @param void
     * @var mix
     */
    public function subCategories()
    {
        return $this->hasMany(Category::class, "parent_id","id");
    }

    /**
     * 父类目
     *
     * @param void
     * @var mix
     */
    public function parentCategory()
    {
        return $this->hasOne(Category::class,"id","parent_id");
    }

    /**
     * @function 获取类目路径
     * @return mixed
     */
    public function getPathArr()
    {
        return app(CategoryPresenter::class)->getCatePathArr($this->category_ids.','.$this->id, 'en_name');
    }
}
