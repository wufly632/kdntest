<?php

namespace App\Presenters\Website;

use App\Transformers\Website\BannerTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BannerPresenter.
 *
 * @package namespace App\Presenters\Website;
 */
class BannerPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BannerTransformer();
    }
}
