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
        if (! $request->start_at | ! $request->end_at) {
            return ApiResponse::failure(g_API_ERROR, '请完善活动时间');
        }
        $result = $this->promotionService->preCreate($request);
        if ($result['status'] == 200) {
            return ApiResponse::success($result['content']);
        }
        return ApiResponse::failure(g_API_ERROR, $result['msg']);
    }

    /**
     * @function 促销活动添加商品页面
     * @param Promotion $promotion
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Promotion $promotion)
    {
        if (! $promotion) {
            redirect(secure_route('promotion.index'));
        }
        return view('promotion.add', compact('promotion'));
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