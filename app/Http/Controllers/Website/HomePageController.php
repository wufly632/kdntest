<?php

namespace App\Http\Controllers\Website;

use App\Entities\Product\Product;
use App\Entities\Website\HomePageCard;
use App\Services\Api\ApiResponse;
use App\Services\CateAttr\CategoryService;
use App\Services\Currency\CurrencyService;
use App\Services\Product\ProductService;
use App\Services\Website\BannerService;
use App\Services\Website\HomePageCardService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    //
    protected $bannerService;
    protected $homePageCardService;
    protected $productService;
    protected $currencyService;
    protected $categoryService;

    public function __construct(BannerService $bannerService, HomePageCardService $homePageCardService, ProductService $productService, CurrencyService $currencyService, CategoryService $categoryService)
    {
        $this->bannerService = $bannerService;
        $this->homePageCardService = $homePageCardService;
        $this->productService = $productService;
        $this->currencyService = $currencyService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        \request()->flash();
        $banners = $this->bannerService->getAllBanner(['type' => 1]);
        $dailySelect = HomePageCard::find(5);
        $good_ids = json_decode($dailySelect->left_image, true);
        $currencys = $this->currencyService->getAll();
        $goods = $this->productService->getByIds($good_ids);
        return view('website.homepage.index', ['cards' => HomePageCard::limit(4)->get(), 'banners' => $banners, 'goods' => $goods, 'good_ids' => $good_ids, 'currencys' => $currencys]);
    }

    public function update($id)
    {
        $option = \request()->only(['link', 'title', 'product_category_id']);
        try {
            if (\request()->filled('product_category_id')) {
                if ($this->categoryService->getCategoryProductSum($option['product_category_id']) < 5) {
                    return ApiResponse::failure(g_API_ERROR, '此分类商品数量不足');
                }
            }
            $this->homePageCardService->update($option, $id);
            return ApiResponse::success();
        } catch (\Exception $e) {
            return ApiResponse::failure(g_API_STATUS, 'modify failed');
        }
    }

    public function updateJsonFields($id)
    {
        $option = \request()->only(['center_image', 'index']);
        $index = $option['index'];
        try {
            $this->homePageCardService->update(['center_image' => json_encode($option['center_image'])], $id);
            return ApiResponse::success();
        } catch (\Exception $e) {
            return ApiResponse::failure(g_API_STATUS, 'modify failed');
        }

    }

    public function updateLeft($id)
    {
        $option = \request()->only(['left', 'index']);
        try {
            $this->homePageCardService->update(['left_image' => json_encode($option['left'])], $id);
            return ApiResponse::success();
        } catch (\Exception $e) {
            return ApiResponse::failure(g_API_STATUS, 'modify failed');
        }
    }
}
