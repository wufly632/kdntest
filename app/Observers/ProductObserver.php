<?php
// +----------------------------------------------------------------------
// | ProductObserver.php
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------
// | Time: 2018/11/22 下午9:42
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Observers;

use App\Entities\Product\Product;
use App\Services\Product\ProductLogService;

class ProductObserver
{
    /**
     * Handle to the Product "created" event.
     *
     * @param  \App\Entities\Product\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        //
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Entities\Product\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        if ($product->isDirty('status')) {
            // 加入日志
            app(ProductLogService::class)->addOnOfflineLog($product->id, $product->status);
        }
    }

    /**resources/views/goods/index.blade.php
     * Handle the Product "deleted" event.
     *
     * @param  \App\Entities\Product\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }
}
