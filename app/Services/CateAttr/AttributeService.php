<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/19 上午11:47
 */
namespace App\Services\CateAttr;

use App\Entities\CateAttr\Attribute;
use App\Entities\CateAttr\AttributeValue;
use App\Entities\CateAttr\CategoryAttribute;
use App\Presenters\CateAttr\CategoryPresenter;
use App\Repositories\CateAttr\AttributeRepository;
use App\Repositories\CateAttr\CategoryAttributeRepository;
use App\Services\Api\ApiResponse;
use App\Validators\CateAttr\CategoryAttributeValidator;
use Illuminate\Support\Facades\DB;

class AttributeService{

    /**
     * @var AttributeRepository
     */
    protected $attribute;


    /**
     * GoodsController constructor.
     *
     * @param AttributeRepository $attribute
     */
    public function __construct(AttributeRepository $attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * 获取AttributeRepository
     *
     * @param void
     * @return object
     */
    public function getAttributeRepository()
    {
        return $this->attribute;
    }

    /**
     * 根据属性对应的分类数组，重新组合
     *
     * @param array $attribute_categories_array
     * @return array
     */
    public function getAttributeCategories($attribute_categories_array)
    {
        $categories = [];
        foreach ($attribute_categories_array as $key => $attribute_categories){
            if ($key <= 100) {
                $category = $attribute_categories->category;
                $category->name = app(CategoryPresenter::class)->getCatePathName($category->category_ids);
                array_push($categories, $category);
            }
        }
        return $categories;
    }

    /**
     * 搜索属性
     *
     * @param void
     * @return mixed
     */
    public function getAttributesByLikeName($name)
    {
        $name = strtolower($name);
        $attributes = $this->attribute->all();
        $attributesLikeName = [];
        foreach ($attributes as $attribute) {
            if(str_contains(strtolower($attribute->name), $name)){
                $attributesLikeName[$attribute->id] = $attribute->name;
            }
        }
        return $attributesLikeName;
    }

    /**
     * 根据主键获取属性
     *
     * @param int $attribute_id 属性id
     * @return object
     */
    public function getAttributeByPk(int $attribute_id)
    {
        return $this->getAttributeRepository()->makeModel()->find($attribute_id);
    }

    /**
     * @function 删除属性
     * @param $attribute_id
     * @return mixed
     */
    public function deleteAttribute($attribute_id)
    {
        if (CategoryAttribute::where('attr_id', $attribute_id)->first()) {
            return ApiResponse::failure(g_API_ERROR, '该属性已有商品，不允许删除');
        }
        try {
            DB::beginTransaction();
            //删除属性值
            AttributeValue::where('attribute_id', $attribute_id)->delete();
            Attribute::where('id', $attribute_id)->delete();
            DB::commit();
            return ApiResponse::success('操作成功');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::info('属性'.$attribute_id.'删除失败-'.$e->getMessage());
            ding('属性'.$attribute_id.'删除失败-'.$e->getMessage());
            return ApiResponse::failure(g_API_ERROR, '操作失败');
        }
    }

}