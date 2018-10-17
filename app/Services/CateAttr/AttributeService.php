<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/19 上午11:47
 */
namespace App\Services\CateAttr;

use App\Entities\CateAttr\CategoryAttribute;
use App\Presenters\CateAttr\CategoryPresenter;
use App\Repositories\CateAttr\AttributeRepository;
use App\Repositories\CateAttr\CategoryAttributeRepository;
use App\Validators\CateAttr\CategoryAttributeValidator;

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

}