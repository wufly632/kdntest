<?php

namespace App\Transformers\CateAttr;

use League\Fractal\TransformerAbstract;
use App\Entities\CateAttr\Category;

/**
 * Class CategoryTransformer.
 *
 * @package namespace App\Transformers\CateAttr;
 */
class CategoryTransformer extends TransformerAbstract
{
    /**
     * Transform the Category entity.
     *
     * @param \App\Entities\CateAttr\Category $model
     *
     * @return array
     */
    public function transform(Category $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
