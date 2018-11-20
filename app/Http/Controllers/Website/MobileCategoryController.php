<?php

namespace App\Http\Controllers\Website;

use App\Services\Currency\CurrencyService;
use App\Services\Website\BannerService;

class MobileCategoryController
{
    protected $currencyService;
    protected $bannerService;

    public function __construct(BannerService $bannerService, CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
        $this->bannerService = $bannerService;
    }

    public function index()
    {
        $banners = $this->bannerService->getAllBanner(['type' => 2]);
        $currencys = $this->currencyService->getAll();
        return view('website.mobile.category', compact('banners', 'currencys'));
    }
}