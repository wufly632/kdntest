<?php

namespace App\Services\Website;


use App\Repositories\Website\HomePageCardRepository;

class HomePageCardService
{
    protected $homePageCardRepository;

    public function __construct(HomePageCardRepository $homePageCardRepository)
    {
        $this->homePageCardRepository = $homePageCardRepository;
    }

    public function update($option, $id)
    {
        $this->homePageCardRepository->update($option, $id);
    }
}