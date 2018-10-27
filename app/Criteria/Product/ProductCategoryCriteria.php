<?php

namespace App\Criteria\Product;

use App\Entities\CateAttr\Category;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ProductCategoryCriteria.
 *
 * @package namespace App\Criteria\Product;
 */
class ProductCategoryCriteria implements CriteriaInterface
{
    protected $category;

    public function __construct($category)
    {
        $this->category = $category;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if ($category = $this->category) {
            if (isset($category['three']) && $category['three']) {
                $model = $model->where('category_id', $category['three']);
            } elseif (isset($category['two']) && $category['two']) {
                $category_ids = Category::where(['parent_id' => $category['two']])->pluck('id')->toArray();
                $model = $model->whereIn('category_id', $category_ids);
            } elseif (isset($category['one']) && $category['one']) {
                $model = $model->where('category_path', 'like', '0,'.$category['one'].',%');
            }
        }
        return $model;
    }
}
