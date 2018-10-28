<?php

namespace App\Http\Controllers\Website;

use App\Entities\Website\HomePageCard;
use App\Services\Website\BannerService;
use App\Services\Website\HomePageCardService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    //
    protected $bannerService;
    protected $homePageCardService;

    public function __construct(BannerService $bannerService, HomePageCardService $homePageCardService)
    {
        $this->bannerService = $bannerService;
        $this->homePageCardService = $homePageCardService;
    }

    public function index()
    {
        \request()->flash();
        $banners = $this->bannerService->getAllBanner(['type' => 1]);
        return view('website.homepage.index', ['cards' => HomePageCard::get(), 'banners' => $banners]);
    }

    public function update($id)
    {
        $option = \request()->only(['link', 'title']);
        $this->homePageCardService->update($option, $id);
    }

    public function updateJsonFields($id)
    {
        dd(\request());
        $option = \request()->only(['center_image', 'index']);
        $index = $option->post('index');
        $this->homePageCardService->update(['center_image->' . $index => $option['center_image']], $id);

    }
}
