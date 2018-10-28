<?php

namespace App\Http\Controllers\Website;

use App\Entities\Product\Product;
use App\Entities\Website\HomePageCard;
use App\Services\Api\ApiResponse;
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

    public function __construct(BannerService $bannerService, HomePageCardService $homePageCardService, ProductService $productService)
    {
        $this->bannerService = $bannerService;
        $this->homePageCardService = $homePageCardService;
        $this->productService = $productService;
    }

    public function index()
    {
        \request()->flash();
        $banners = $this->bannerService->getAllBanner(['type' => 1]);
        $dailySelect = HomePageCard::find(5);
        $good_ids = json_decode($dailySelect->left_image, true);
        $goods = $this->productService->getByIds($good_ids);
        return view('website.homepage.index', ['cards' => HomePageCard::limit(4)->get(), 'banners' => $banners, 'goods' => $goods, 'good_ids' => $good_ids]);
    }

    public function update($id)
    {
        $option = \request()->only(['link', 'title']);
        try {
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
        $index = $option['index'];
        try {
            $this->homePageCardService->update(['left_image' => json_encode($option['left'])], $id);
            return ApiResponse::success();
        } catch (\Exception $e) {
            dd($e);
            return ApiResponse::failure(g_API_STATUS, 'modify failed');
        }
    }
}
