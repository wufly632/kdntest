<?php

namespace App\Transformers\Good;

use League\Fractal\TransformerAbstract;
use App\Entities\Good\Good;

/**
 * Class GoodTransformer.
 *
 * @package namespace App\Transformers\Good;
 */
class GoodTransformer extends TransformerAbstract
{
    /**
     * Transform the Good entity.
     *
     * @param \App\Entities\Good\Good $model
     *
     * @return array
     */
    public function transform(Good $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
