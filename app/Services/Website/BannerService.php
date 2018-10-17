<?php

namespace App\Services\Website;

use App\Repositories\Website\BannerRepository;

class BannerService
{
    protected $bannerRepository;

    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function getAllBanner()
    {
        return $this->bannerRepository->all();
    }

    public function getBannerInfo($id)
    {
        return $this->bannerRepository->find($id);
    }

}