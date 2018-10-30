<?php

namespace App\Services\Website;

use App\Repositories\Website\IconRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class IconService
{
    protected $iconRepository;

    public function __construct(IconRepository $iconRepository)
    {
        $this->iconRepository = $iconRepository;
    }

    public function getIcons($option)
    {

        if (!$option) {
            $icons = $this->iconRepository->paginate();
        } else {
            $item = $this->iconRepository->findWhere($option);
            $count = count($item);
            $icons = new LengthAwarePaginator($item, $count, $page = 20);
            $icons->withPath('icons');
            $icons->appends($option);
        }
        return $icons;
    }

    public function createIcon($data)
    {
        $time = explode('~', $data['time_duration']);
        $data['start_at'] = $time[0];
        $data['end_at'] = $time[1];
        $this->iconRepository->create($data);
    }

    public function updateIconInfo($data, $id)
    {
        $time = explode('~', $data['time_duration']);
        $data['start_at'] = $time[0];
        $data['end_at'] = $time[1];
        $this->iconRepository->update($data, $id);
    }

    public function getIconInfo($id)
    {
        return $this->iconRepository->find($id);
    }

    public function delete($id)
    {
        $this->iconRepository->delete($id);
    }
}