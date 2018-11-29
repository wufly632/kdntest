<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/19 上午11:47
 */
namespace App\Services\CateAttr;

use App\Entities\CateAttr\AttributeValue;
use App\Entities\CateAttr\CategoryAttribute;
use App\Entities\CateAttr\GoodAttrValue;
use App\Entities\Product\ProductAttrValue;
use App\Repositories\CateAttr\AttributeRepository;
use App\Repositories\CateAttr\AttributeValueRepository;
use App\Services\Api\ApiResponse;
use Illuminate\Support\Facades\DB;

class AttrValueService{

    /**
     * @var AttributeValueRepository
     */
    protected $attrvalue;

    /**
     * @var AttributeRepository
     */
    protected $attribute;


    /**
     * GoodsController constructor.
     *
     * @param AttributeValueRepository $attrvalue
     */
    public function __construct(AttributeValueRepository $attrvalue,AttributeRepository $attribute)
    {
        $this->attrvalue = $attrvalue;
        $this->attribute = $attribute;
    }


    public function getAttributeValueRepository()
    {
        return $this->attrvalue;
    }

    public function getAttributeRepository()
    {
        return $this->attribute;
    }

    /**
     * 根据属性id获取该属性对应的所有属性值
     *
     * @param int $attribute_id 属性id
     * @return object
     */
    public function getAttributeValuesByAttributeId(int $attribute_id, $sortBy = '', $sort = '', $toArray = true)
    {
        if($sortBy && in_array($sort, ['asc', 'desc'])){
            $this->attrvalue = $this->attrvalue->scopeQuery(function($query)use($sortBy, $sort){
                return $query->orderBy($sortBy, $sort);
            });
        }
        $attribute_values = $this->attrvalue->findWhere(['attribute_id' => $attribute_id]);
        return $this->transfer($attribute_values, $toArray);
    }

    /**
     * 返回属性对应的相关信息
     *
     * @param array $category_attributes 类目属性
     * @return mix
     */
    public function attribute_value_names($category_attributes)
    {
        if(!$category_attributes){
            return [];
        }
        $attribute_value_ids = explode(',', $category_attributes->attr_values);
        $attribute_values = $this->attrvalue->findWhereIn('id', $attribute_value_ids);
        $arr = [];
        foreach ($attribute_values as $key => $value) {
            $data = [];
            $data['name'] = $value->name;
            $data['id'] = $value->id;
            $data['is_image'] = $category_attributes->is_image;
            $data['is_diy'] = $category_attributes->is_diy;
            $data['check_type'] = $category_attributes->check_type;
            $data['is_detail'] = $category_attributes->is_detail;
            $data['is_required'] = $category_attributes->is_required;
            $arr[] = $data;
        }

        return $arr;
    }

    /**
     * 转换数据格式
     *
     * @param object $object
     * @return object|array
     */
    public function transfer($object, $toArray = true)
    {
        if(($toArray === true) && $object){
            return $object->toArray();
        }
        return $object;
    }

    /**
     * 根据商品ids获取属性
     * @param $ids
     * @return string
     */
    public function getAttriButeByIds($ids)
    {
        if (!is_array($ids)) {
            $ids = explode(',', $ids);
        }
        $attributeStr = '';
        foreach ($ids as $key => $id) {
            $attrValue = $this->attrvalue->model()::find($id);
            $attributeStr .= $attrValue->getAttr->name . ':' . $attrValue->name . ',';
        }
        return rtrim($attributeStr, ',');
    }

    /**
     * @function 删除属性值
     * @param $attr_value_id
     * @return mixed
     */
    public function deleteAttrValue($attr_value_id)
    {
        try {
            DB::beginTransaction();
            // 删除属性值
            $attributeValue = AttributeValue::find($attr_value_id);
            if (! $attributeValue) {
                return ApiResponse::failure(g_API_ERROR, '该属性值不存在');
            }
            $attr_id = $attributeValue->attribute_id;
            $attributeValue->delete();
            // 判断该属性和属性值是否存在销售属性中
            $category_sale_attributes = CategoryAttribute::where([['attr_id','=', $attr_id], ['attr_type', '=', 3]])->pluck('attr_values')->toArray();
            $sale_attr_values_arr = array_unique(explode(',', implode(',', $category_sale_attributes)));
            if (in_array($attr_value_id, $sale_attr_values_arr)) {
                return ApiResponse::failure(g_API_ERROR, '该属性值在销售属性值中，不能删除');
            }
            // 删除类目属性表相关值
            $category_attributes = CategoryAttribute::where([['attr_id', '=', $attr_id], ['attr_values', 'like', '%'.$attr_value_id]])
                ->get();
            foreach ($category_attributes as $category_attribute)
            {
                $attr_values_arr = explode(',', $category_attribute->attr_value);
                if (in_array($attr_value_id, $attr_values_arr)) {
                    $arr = array_merge(array_diff($attr_values_arr, [$attr_value_id]));
                    $category_attribute->attr_values = implode(',', $arr);
                    $category_attribute->save();
                }
            }
            // 删除商品的该属性值
            $good_attr_values = GoodAttrValue::where([['attr_id', '=', $attr_id], ['value_ids', 'like', '%'.$attr_value_id.'%']])->get();
            foreach ($good_attr_values as $good_attr_value)
            {
                $attr_value_ids = explode(',', $good_attr_value);
                if (in_array($attr_value_id, $attr_value_ids)) {
                    $arr = array_merge(array_diff($attr_value_ids, [$attr_value_id]));
                    $good_attr_value->attr_values = implode(',', $arr);
                    $good_attr_value->save();
                }
            }

            $product_attr_values = ProductAttrValue::where([['attr_id', '=', $attr_id], ['value_ids', 'like', '%'.$attr_value_id.'%']])->get();
            foreach ($product_attr_values as $product_attr_value)
            {
                $attr_value_ids = explode(',', $product_attr_value);
                if (in_array($attr_value_id, $attr_value_ids)) {
                    $arr = array_merge(array_diff($attr_value_ids, [$attr_value_id]));
                    $product_attr_value->attr_values = implode(',', $arr);
                    $product_attr_value->save();
                }
            }
            DB::commit();
            return ApiResponse::success('删除成功');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::info(\Auth::id().'删除属性值'.$attr_value_id.'失败-'.$e->getMessage());
            ding(\Auth::id().'删除属性值'.$attr_value_id.'失败-'.$e->getMessage());
            return ApiResponse::failure(g_API_ERROR, '删除失败');
        }

    }
}