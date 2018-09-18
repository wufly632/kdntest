<?php

namespace App\Repositories\Good;

use App\Entities\CateAttr\CategoryAttribute;
use App\Entities\Good\GoodSkuImage;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Good\GoodRepository;
use App\Entities\Good\Good;
use App\Validators\Good\GoodValidator;

/**
 * Class GoodRepositoryEloquent.
 *
 * @package namespace App\Repositories\Good;
 */
class GoodRepositoryEloquent extends BaseRepository implements GoodRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Good::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GoodValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
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
