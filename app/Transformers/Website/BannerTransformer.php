<?php

namespace App\Transformers\Website;

use League\Fractal\TransformerAbstract;
use App\Entities\Website\Banner;

/**
 * Class BannerTransformer.
 *
 * @package namespace App\Transformers\Website;
 */
class BannerTransformer extends TransformerAbstract
{
    /**
     * Transform the Banner entity.
     *
     * @param \App\Entities\Website\Banner $model
     *
     * @return array
     */
    public function transform(Banner $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
