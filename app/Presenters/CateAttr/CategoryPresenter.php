<?php

namespace App\Presenters\CateAttr;

use App\Entities\CateAttr\Category;
use App\Transformers\CateAttr\CategoryTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CategoryPresenter.
 *
 * @package namespace App\Presenters\CateAttr;
 */
class CategoryPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CategoryTransformer();
    }

    /**
     * @function 拼接类目路径
     * @param $path
     * @return string
     */
    public function getCatePathName($path)
    {
        $cate_ids = explode(',', $path);
        $categories = Category::whereIn('id', $cate_ids)->orderBy('id', 'asc')->pluck('name','id')->toArray();
        $category_str = '';
        foreach ($cate_ids as $cate_id) {
            if (isset($categories[$cate_id])) {
                $category_str .= $categories[$cate_id].' > ';
            }
        }
        return rtrim($category_str, ' > ');
    }

    /**
     * @function 获取类目路径(数组)）
     * @param $path
     * @return array
     */
    public function getCatePathArr($path, $field='name')
    {
        $cate_ids = explode(',', $path);
        $categories = Category::whereIn('id', $cate_ids)->orderBy('id', 'asc')->pluck($field,'id')->toArray();
        $category_arr = [];
        foreach ($cate_ids as $cate_id) {
            if (isset($categories[$cate_id])) {
                $category_arr[] = $categories[$cate_id];
            }
        }
        return $category_arr;
    }
}
