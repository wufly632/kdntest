<?php
// +----------------------------------------------------------------------
// | ProductService.php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Time: 2018/9/29 下午2:41
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Services\Product;

use App\Criteria\Product\ProductCategoryCriteria;
use App\Criteria\Product\ProductCodeCriteria;
use App\Criteria\Product\ProductIdCriteria;
use App\Criteria\Product\ProductStatusCriteria;
use App\Criteria\Product\ProductTitleCriteria;
use App\Entities\Product\Product;
use App\Repositories\Product\ProductRepository;
use App\Services\Api\ApiResponse;
use Request, DB, Log;

class ProductService
{
    /**
     * @var ProductRepository
     */
    protected $product;

    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }

    /**
     * @function 获取商品的列表
     * @return mixed
     */
    public function getList()
    {
        $orderBy = Request::input('orderBy', 'id');
        $sort = Request::input('sort', 'desc');
        $length = Request::input('length', 10);
        return $this->product->orderBy($orderBy, $sort)->paginate($length);
    }

    /**
     * @function 商品上架
     * @param $product_id
     * @return mixed
     */
    public function onshelf($product_id, $request)
    {
        try {
            DB::beginTransaction();
            $product = $this->product->find($product_id);
            if (!$product) {
                return ApiResponse::failure(g_API_ERROR, '商品不存在');
            }
            $product->status = Product::ONLINE;
            $product->rebate_level_one = $request->rebate_level_one;
            $product->rebate_level_two = $request->rebate_level_two;
            $product->save();
            DB::commit();
            return ApiResponse::success('上架成功');
        } catch (\Exception $e) {
            Log::info('商品上架失败：' . $e->getMessage());
            DB::rollBack();
            return ApiResponse::failure(g_API_ERROR, '商品上架失败');
        }
    }

    /**
     * @function 商品下架
     * @param $product_id
     * @return mixed
     */
    public function offshelf($product_id)
    {
        try {
            DB::beginTransaction();
            $product = $this->product->find($product_id);
            if (!$product) {
                return ApiResponse::failure(g_API_ERROR, '商品不存在');
            }
            $product->status = Product::OFFLINE;
            $product->save();
            DB::commit();
            return ApiResponse::success('下架成功');
        } catch (\Exception $e) {
            Log::info('商品下架失败：' . $e->getMessage());
            DB::rollBack();
            return ApiResponse::failure(g_API_ERROR, '商品下架失败');
        }
    }

    /**
     * 获取所有商品
     * @param $request
     * @return string
     */
    public function getAllProduct($request)
    {
        $category = [
            'one' => $request->category_one,
            'two' => $request->category_two,
            'three' => $request->category_three,
        ];

        //获取所有商品列表
        $this->product->pushCriteria(new ProductTitleCriteria($request->good_title));
        $this->product->pushCriteria(new ProductIdCriteria($request->good_id));
        $this->product->pushCriteria(new ProductCodeCriteria($request->good_code));

        $this->product->pushCriteria(new ProductStatusCriteria(Product::ONLINE));
        $this->product->pushCriteria(new ProductCategoryCriteria($category));
        $goods = $this->product->orderBy('id', 'desc')->paginate(10);

        return $goods;
    }
}
