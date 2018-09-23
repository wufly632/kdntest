<?php
// +----------------------------------------------------------------------
// | GoodAttributesSingleselectPresenter.php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Time: 2018/9/22 上午11:47
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Presenters\Good;

use App\Entities\CateAttr\AttributeValue;

class GoodAttributesSingleselectPresenter implements GoodAttributesPresenterInterface
{
    public function showGoodAttributes($key, $category_attributes, $good_attributes)
    {
        // $attribute_id_arr = Attribute::whereIn('alias', ['Washing Mode', 'Bleach', 'Dry', 'Iron', 'Dry Clean'])->get()->pluck('id')->toArray();

        if(! $category_attributes) return '';
        $showStr = '';

        $attribute_values = AttributeValue::whereIn('id', explode(',', $category_attributes))->get();
        foreach ($attribute_values as $attribute_value) {
            $showStr .= '<div style="margin-right: 20px;float: left;"><input type="checkbox" readonly style="margin-right: 5px;"';
            if (isset($good_attributes[$key]) && in_array($attribute_value->id, $good_attributes[$key])) {
                $showStr .= 'checked';
            }
            $showStr .= '>'.$attribute_value->name.'</div>';
        }
        return $showStr;
    }
}
