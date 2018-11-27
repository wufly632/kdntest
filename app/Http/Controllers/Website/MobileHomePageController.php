<?php

namespace App\Http\Controllers\Website;

use App\Services\CateAttr\CategoryService;
use App\Services\Currency\CurrencyService;
use App\Services\Website\BannerService;
use App\Services\Website\IconService;
use App\Services\Website\MobileHomeCardService;
use Illuminate\Routing\Controller;

class MobileHomePageController extends Controller
{
    protected $bannerService;
    protected $currencyService;
    protected $iconService;
    protected $categoryService;
    protected $mobileHomeCardService;

    public function __construct(BannerService $bannerService,
                                CurrencyService $currencyService,
                                IconService $iconService,
                                CategoryService $categoryService,
                                MobileHomeCardService $mobileHomeCardService)
    {
        $this->bannerService = $bannerService;
        $this->currencyService = $currencyService;
        $this->iconService = $iconService;
        $this->categoryService = $categoryService;
        $this->mobileHomeCardService = $mobileHomeCardService;
    }

    public function index()
    {
        $banners = $this->bannerService->getAllBanner(['type' => 2]);
        $icons = $this->iconService->getAll();
        $currencys = $this->currencyService->getAll();
        $categorys = $this->categoryService->getCategoryByLevel(1, ['name', 'id']);
        $mobileCards = $this->mobileHomeCardService->get();
        return view('website.mobile.homepage', compact('banners', 'currencys', 'icons', 'categorys', 'mobileCards'));
    }
}