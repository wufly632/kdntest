<?php

namespace App\Repositories\CateAttr;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CateAttr\CategoryAttributeRepository;
use App\Entities\CateAttr\CategoryAttribute;
use App\Validators\CateAttr\CategoryAttributeValidator;

/**
 * Class CategoryAttributeRepositoryEloquent.
 *
 * @package namespace App\Repositories\CateAttr;
 */
class CategoryAttributeRepositoryEloquent extends BaseRepository implements CategoryAttributeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CategoryAttribute::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CategoryAttributeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 获取分类属性
     *
     * @param int $categoryId
     * @return array
     */
    public function getCategoryAttribute($category_id)
    {
        $categoryAttributes = CategoryAttribute::with('attribute')
            ->where(['category_id' => $category_id, 'status' => 1])
            ->get()
            ->groupBy('attr_type');
        if (! $categoryAttributes) {
            return [];
        }
        return $categoryAttributes;
    }

    /**
     * 获取该分类下面的图片属性ID
     *
     * @param int $category_id 类目id
     * @return int 属性id
     */
    public static function getPicAttributeId($category_id)
    {
        return CategoryAttribute::where(['category_id' => $category_id, 'status' => 1, 'is_image' => 1])->first()->attr_id;
    }
    
}
