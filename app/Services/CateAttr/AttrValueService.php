<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/19 上午11:47
 */
namespace App\Services\CateAttr;

use App\Repositories\CateAttr\AttributeRepository;
use App\Repositories\CateAttr\AttributeValueRepository;

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
}