<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/20 上午11:21
 */
namespace App\Http\Controllers\Promotion;

use App\Entities\Promotion\Promotion;
use App\Http\Controllers\Controller;
use App\Services\Api\ApiResponse;
use App\Services\Product\ProductService;
use App\Services\Promotion\PromotionService;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    protected $promotionService;

    protected $productService;

    public function __construct(PromotionService $promotionService, ProductService $productService)
    {
        $this->promotionService = $promotionService;
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $request->flash();
        $promotions = $this->promotionService->getList();
        debug($promotions);
        return view('promotion.index', compact('promotions'));
    }

    /**
     * @function 预添加活动
     * @param Request $request
     * @return mixed
     */
    public function addPost(Request $request)
    {
        if (! $request->title) {
            return ApiResponse::failure(g_API_ERROR, '请填写活动名称');
        }
        if (! $request->promotion_time) {
            return ApiResponse::failure(g_API_ERROR, '请完善活动时间');
        }
        $result = $this->promotionService->preCreate($request);
        if ($result['status'] == 200) {
            return ApiResponse::success($result['content']);
        }
        return ApiResponse::failure(g_API_ERROR, $result['msg']);
    }

    /**
     * @function 促销活动添加/修改商品页面
     * @param Promotion $promotion
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Promotion $promotion)
    {
        if (! $promotion) {
            redirect(secure_route('promotion.index'));
        }
        // 获取所有的商品(已上线)
        $promotion_products = $this->productService->getList();
        return view('promotion.edit', compact('promotion', 'promotion_products'));
    }

    /**
     * @function 促销活动创建商品
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(Request $request)
    {
        $result = $this->promotionService->create($request);
        if ($result['status'] == 200) {
            return ApiResponse::success($result['content']);
        }
        return ApiResponse::failure(g_API_ERROR, $result['msg']);
    }
}