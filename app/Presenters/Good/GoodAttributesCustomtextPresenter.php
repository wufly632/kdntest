<?php
// +----------------------------------------------------------------------
// | GoodAttributesCustomtextPresenter.php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Time: 2018/9/23 上午10:36
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Presenters\Good;

class GoodAttributesCustomtextPresenter implements GoodAttributesPresenterInterface
{
    public function showGoodAttributes($key, $category_attributes, $good_attributes)
    {
        if(! $category_attributes) return '';
        $showStr = '<input type="text" class="form-control" placeholder="" readonly value="'.($good_attributes[$key][0] ?? '').'">';
        return $showStr;
    }
}
