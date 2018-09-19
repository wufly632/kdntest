<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/19 上午11:47
 */
namespace App\Services\CateAttr;

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
    public function getPicAttributeId($category_id) {
        return $this->repository->findWhere(['category_id' => $category_id, 'status' => 1, 'is_image' => 1])->attr_id;
    }
}