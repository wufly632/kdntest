<?php


namespace App\Services\Currency;


use App\Repositories\Currency\CurrencyRepository;

class CurrencyService
{
    protected $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function getAll()
    {
        return $this->currencyRepository->get();
    }
}