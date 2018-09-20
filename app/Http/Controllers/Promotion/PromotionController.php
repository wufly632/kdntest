<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/20 上午11:21
 */
namespace App\Http\Controllers\Promotion;

use App\Http\Controllers\Controller;
use App\Services\Promotion\PromotionService;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    protected $promotionService;

    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }

    public function index(Request $request)
    {
        $request->flash();
        $promotions = $this->promotionService->getList();
        return view('promotion.index', compact('promotions'));
    }
}