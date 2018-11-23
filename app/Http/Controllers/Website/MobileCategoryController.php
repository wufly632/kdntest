<?php

namespace App\Http\Controllers\Website;

use App\Services\Website\MobileCategoryService;

class MobileCategoryController
{
    protected $mobileCategoryService;

    public function __construct(MobileCategoryService $mobileCategoryService)
    {
        $this->mobileCategoryService = $mobileCategoryService;
    }

    public function index()
    {
        $categorys = $this->mobileCategoryService->get();
        return view('website.mobile.category', compact('categorys'));
    }
}