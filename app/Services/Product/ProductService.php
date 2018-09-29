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

use App\Repositories\Product\ProductRepository;
use Request;

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
}
