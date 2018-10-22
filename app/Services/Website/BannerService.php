<?php

namespace App\Services\Website;

use App\Repositories\Website\BannerRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class BannerService
{
    protected $bannerRepository;

    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function getAllBanner($option)
    {
        if (!$option) {
            $banners = $this->bannerRepository->paginate();
        } else {
            $item = $this->bannerRepository->findWhere($option);
            $count = count($item);
            $banners = new LengthAwarePaginator($item, $count, $page = 20);
            $banners->withPath('banners');
            $banners->appends($option);
        }

        return $banners;
    }

    public function getBannerInfo($id)
    {
        return $this->bannerRepository->find($id);
    }

    public function updateBannerInfo($data, $id)
    {
        $time = explode('~', $data['time_duration']);
        $data['start_at'] = $time[0];
        $data['end_at'] = $time[1];
        $this->bannerRepository->update($data, $id);
    }

    public function createBannerInfo($data)
    {
        $time = explode('~', $data['time_duration']);
        $data['start_at'] = $time[0];
        $data['end_at'] = $time[1];
        $this->bannerRepository->create($data);
    }

    public function deleteBannerInfo($id)
    {
        $this->bannerRepository->delete($id);
    }

}