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
}
