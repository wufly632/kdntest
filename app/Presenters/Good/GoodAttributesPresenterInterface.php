<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/22 上午11:40
 */

namespace App\Presenters\Good;


interface GoodAttributesPresenterInterface
{
    /**
     * 顯示不同商品属性显示格式
     * @param vodi
     * @return string
     */
    public function showGoodAttributes($key, $category_attributes, $product_attributes);
}