<?php

namespace App\Transformers\User;

use League\Fractal\TransformerAbstract;
use App\Entities\User\User;

/**
 * Class UserTransformer.
 *
 * @package namespace App\Transformers\User;
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Transform the User entity.
     *
     * @param \App\Entities\User\User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
