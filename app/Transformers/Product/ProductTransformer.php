<?php

namespace App\Transformers\Product;

use League\Fractal\TransformerAbstract;
use App\Entities\Product\Product;

/**
 * Class ProductTransformer.
 *
 * @package namespace App\Transformers\Product;
 */
class ProductTransformer extends TransformerAbstract
{
    /**
     * Transform the Product entity.
     *
     * @param \App\Entities\Product\Product $model
     *
     * @return array
     */
    public function transform(Product $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
