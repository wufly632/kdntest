<?php

namespace App\Http\Controllers\Website;

use App\Entities\Website\HomePageCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    //
    public function index()
    {
        \request()->flash();

        return view('website.homepage.index', ['cards' => HomePageCard::get()]);
    }
}
