<?php


namespace App\Services\Website;


use App\Repositories\Website\MobileHomeCardRepository;

class MobileHomeCardService
{
    protected $mobileHomeCardRepository;

    public function __construct(MobileHomeCardRepository $mobileHomeCardRepository)
    {
        $this->mobileHomeCardRepository = $mobileHomeCardRepository;
    }

    public function get()
    {
        return $this->mobileHomeCardRepository->all();
    }

    public function update($id, $extraOption)
    {
        $this->mobileHomeCardRepository->update($extraOption, $id);

    }

    public function create($option)
    {
        $this->mobileHomeCardRepository->create($option);
    }
}