<?php

namespace App\Transformers\User;

use League\Fractal\TransformerAbstract;
use App\Entities\User\SupplierUser;

/**
 * Class SupplierUserTransformer.
 *
 * @package namespace App\Transformers\User;
 */
class SupplierUserTransformer extends TransformerAbstract
{
    /**
     * Transform the SupplierUser entity.
     *
     * @param \App\Entities\User\SupplierUser $model
     *
     * @return array
     */
    public function transform(SupplierUser $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
