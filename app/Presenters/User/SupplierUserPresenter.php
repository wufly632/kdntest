<?php

namespace App\Presenters\User;

use App\Transformers\User\SupplierUserTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SupplierUserPresenter.
 *
 * @package namespace App\Presenters\User;
 */
class SupplierUserPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SupplierUserTransformer();
    }
}
