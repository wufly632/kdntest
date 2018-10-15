<?php
// +----------------------------------------------------------------------
// | ProductController.php
// +----------------------------------------------------------------------
// | Description: 商品管理
// +----------------------------------------------------------------------
// | Time: 2018/10/15 上午11:16
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Services\Api\ApiResponse;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @function 商品上架
     * @param Request $request
     * @return mixed
     */
    public function onshelf(Request $request)
    {
        if (! $request->id) {
            return ApiResponse::failure(g_API_ERROR, '请选择要上架的商品');
        }
        return $this->productService->onshelf($request->id);
    }

    /**
     * @function 商品下架
     * @param Request $request
     * @return mixed
     */
    public function offshelf(Request $request)
    {
        if (! $request->id) {
            return ApiResponse::failure(g_API_ERROR, '请选择要下架的商品');
        }
        return $this->productService->offshelf($request->id);
    }
}
