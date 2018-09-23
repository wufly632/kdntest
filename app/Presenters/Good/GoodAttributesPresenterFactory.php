<?php
// +----------------------------------------------------------------------
// | GoodAttributesPresenterFactory.php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Time: 2018/9/22 上午11:31
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Presenters\Good;

class GoodAttributesPresenterFactory
{
    /**
     * @function
     * @param string $type
     */
    public static function bind(string $type)
    {
        $class = "App\Presenters\Good\GoodAttributes".$type."Presenter";
        $mark = new $class();

        app()->singleton(GoodAttributesPresenterInterface::class, function () use ($mark) {
            return $mark;
        });
    }
}
