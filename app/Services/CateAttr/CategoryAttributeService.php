<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/19 上午11:47
 */
namespace App\Services\CateAttr;

use App\Entities\CateAttr\CategoryAttribute;
use App\Repositories\CateAttr\CategoryAttributeRepository;
use App\Validators\CateAttr\CategoryAttributeValidator;

class CategoryAttributeService{

    /**
     * @var CategoryAttributeRepository
     */
    protected $repository;

    /**
     * @var CategoryAttributeValidator
     */
    protected $validator;

    /**
     * GoodsController constructor.
     *
     * @param CategoryAttributeRepository $repository
     * @param CategoryAttributeValidator $validator
     */
    public function __construct(CategoryAttributeRepository $repository, CategoryAttributeValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * 获取分类属性
     *
     * @param int $categoryId
     * @return array
     */
    public function getCategoryAttribute($category_id)
    {
        $categoryAttributes = $this->repository->with('attribute')
            ->findWhere(['category_id' => $category_id, 'status' => 1])
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
    public function getPicAttributeId($category_id) {
        return $this->repository->findWhere(['category_id' => $category_id, 'status' => 1, 'is_image' => 1])->first()->attr_id;
    }

    /**
     * 根据分类ID获取自定义属性
     *
     * @param int $id 类目属性id
     * @return object
     */
    public function getCategoryAttributeById(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * 获取分类属性
     *
     * @param int $categoryId
     * @return array
     */
    public function getNotStandardAttr($category_id, $good_category_attrs)
    {
        $categoryAttributes = CategoryAttribute::join('admin_attribute', 'admin_attribute.id', '=', 'admin_goods_category_attribute.attr_id')
            ->where([
                'admin_goods_category_attribute.category_id' => $category_id,
                'admin_goods_category_attribute.status' => 1,
                'admin_attribute.type' => 2
            ])->get(['admin_attribute.name', 'admin_goods_category_attribute.attr_id', 'admin_attribute.en_name', 'admin_goods_category_attribute.id']);
        if (! $categoryAttributes) {
            return [];
        }
        $good_category_attrs = $good_category_attrs->pluck(null,'attr_id');
        foreach ($categoryAttributes as &$categoryAttribute)
        {
            $categoryAttribute->ch_attr_value = isset($good_category_attrs[$categoryAttribute->attr_id]) ? $good_category_attrs[$categoryAttribute->attr_id]->value_ids : '';
            $categoryAttribute->en_attr_value = isset($good_category_attrs[$categoryAttribute->attr_id]) ? $good_category_attrs[$categoryAttribute->attr_id]->value_name : '';
        }
        return $categoryAttributes;
    }

}