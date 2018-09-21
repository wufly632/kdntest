<?php

namespace App\Presenters\Good;

use App\Transformers\Good\GoodTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GoodPresenter.
 *
 * @package namespace App\Presenters\Good;
 */
class GoodPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GoodTransformer();
    }
    
}
