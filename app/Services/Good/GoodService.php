<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/19 上午11:47
 */
namespace App\Services\Good;

use App\Repositories\Good\GoodRepository;
use App\Validators\Good\GoodValidator;

class GoodService{

    /**
     * @var GoodRepository
     */
    protected $repository;

    /**
     * @var GoodValidator
     */
    protected $validator;

    /**
     * GoodsController constructor.
     *
     * @param GoodRepository $repository
     * @param GoodValidator $validator
     */
    public function __construct(GoodRepository $repository, GoodValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    public function getList($request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $orderBy = $request->orderBy ?? 'id';
        $sort = $request->sort ?? 'desc';
        $length = $request->length ?? 20;
        return $this->repository->orderBy($orderBy, $sort)->paginate($length);
    }

    /**
     * 获取产品sku图片
     * 并组装相关信息
     * 图片属性值id对应相关产品sku图片
     *
     * @param array $good_skus
     * @param int $category_id
     * @return mixed
     */
    public function getProductSkuImage($good_skus, int $category_id)
    {
        $image_arr = [];
        if(!$good_skus){
            return [];
        }
        $pic_attribute_value_ids_arr = $this->getPicAttributeValueIdsArr($category_id);
        foreach ($good_skus as $key => $value) {
            foreach ($value->skuAttributes as $k => $v) {
                $attributeValueIds = explode(',', $v->value_ids);
                foreach ($attributeValueIds as $attributeValueId) {
                    if(in_array($attributeValueId, $pic_attribute_value_ids_arr)){
                        $image_arr[$attributeValueId][] = GoodSkuImage::where(['sku_id' => $value->id])->get()->toArray();
                    }
                }
            }
        }
        foreach($image_arr as $key => $value){
            $image_arr[$key] = collect($value)->collapse()->unique();
        }
        return $image_arr;
    }

    /**
     * 获取该分类对应的图片分类属性
     *
     * @param int $category_id 分类id
     * @return mixed
     */
    public function getPicAttributeValueIdsArr(int $category_id)
    {
        $category_attributes = CategoryAttribute::where(['category_id' => $category_id, 'is_image' => 1, 'status' => 1])->get();
        $attr_value_ids = array_unique(explode(',', implode(',', array_pluck($category_attributes, 'attr_values'))));
        return $attr_value_ids;
    }

}