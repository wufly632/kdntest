<?php

namespace App\Presenters\Good;

use App\Entities\CateAttr\AttributeValue;
use App\Transformers\Good\GoodTransformer;
use Prettus\Repository\Presenter\FractalPresenter;
use DB;

/**
 * Class GoodPresenter.
 *
 * @package namespace App\Presenters\Good;
 */
class GoodPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GoodTransformer();
    }

    /**
     * 根据产品属性显示属性为 自定义属性 ，单选， 还是多选
     *
     * @param array $category_attrributes 类目属性
     *
     * @return mixed
     */
    public function bindGoodArributesPresenter($category_attributes)
    {
        if ($category_attributes->attr_id == 1437) {
        }
        if ($category_attributes->attribute->type == 1) { //标准化属性
            if ($category_attributes->check_type == 1) { //多选
                GoodAttributesPresenterFactory::bind('Multiselect');
            } elseif ($category_attributes->check_type == 2) { //单选
                GoodAttributesPresenterFactory::bind('Singleselect');
            }
        } elseif ($category_attributes->attribute->type == 2) { //非标准属性
            GoodAttributesPresenterFactory::bind('Customtext');
        }
    }

    /**
     * 对产品属性数据进行重新组合
     *
     * @param object $good 产品信息
     *
     * @return mixed
     */
    public function displayGoodAttributes($good)
    {
        $good_attributes = [];
        foreach ($good->hasManyProductAttributes as $key => $value) {
            if (isset($good_attributes[$value->attr_id]) && in_array($value->value_ids, $good_attributes[$value->attr_id])) {
                continue;
            } else {
                $good_attributes[$value->attr_id][] = $value->value_ids;
            }
        }
        return compact('good_attributes');
    }

    /**
     * 根据页面需求组合相关数据
     *
     * @param object $skus sku信息
     *
     * @return mixed
     */
    public function displayAttr($skus)
    {
        //SKU属性表格有关属性的表头名称
        $sku_th_names             = '';
        $sku_attribute_name       = [];
        $sku_attribute_value_name = [];
        $attr_num                 = 0;
        $tmp = [];
        foreach ($skus as $key => $sku) {
            foreach ($sku->skuAttributes as $v) {
                $tmp[$v->attr_id]['value_name'][$v->value_ids] = $v->getAttrValue->name;
                $tmp[$v->attr_id]['value_id'][$v->value_ids]   = $v->value_ids;
                $tmp[$v->attr_id]['name']                      = $v->getAttibute->name ?? $v->getAttibute->alias_name;
                $tmp[$v->attr_id]['is_image']                  = 1;
            }
        }
        // dd($tmp);

        foreach ($tmp as $key => $sku_attribute) {
            $attr_num++;
            $sku_th_names .= "<th>" . $sku_attribute['name'] . "</th>";
            //显示图片属性
            if ($sku_attribute['is_image']) {
                foreach ($sku_attribute['value_name'] as $value_id => $value_name) {
                    $sku_attribute_name[$value_id] = $value_name;
                }
            }
            //显示关键属性
            foreach ($sku_attribute['value_name'] as $value_id => $value_name) {
                if (isset($sku_attribute_value_name[$key])) {
                    $sku_attribute_value_name[$key] .= "<div class='key-attribute'>" . $value_name . "</div>";
                } else {
                    $sku_attribute_value_name[$key] = "<div class='key-attribute'>" . $value_name . "</div>";
                }
            }
        }
        return compact('sku_attribute_name', 'sku_th_names', 'sku_attribute_value_name', 'attr_num');
    }

    /**
     * @function sku属性及属性值显示
     * @param $sku_value_ids
     * @return string
     */
    public function displaySkuAttr($sku_value_ids)
    {
        $attr_value_str = '';
        $attr_value_ids = explode(',', $sku_value_ids);
        $attr_values = DB::table('admin_attribute_value as av')->leftJoin('admin_attribute as a', 'a.id', '=', 'av.attribute_id')
            ->whereIn('av.id', $attr_value_ids)
            ->selectRaw('av.id,av.attribute_id,av.name,a.name as attr_name')
            ->get();
        foreach ($attr_values as $attr_value) {
            $attr_value_str .= $attr_value->attr_name.':'.$attr_value->name.',';
        }
        return rtrim($attr_value_str, ',');
    }

}
