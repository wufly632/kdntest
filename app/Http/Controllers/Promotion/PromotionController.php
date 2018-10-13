<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/20 上午11:21
 */
namespace App\Http\Controllers\Promotion;

use App\Entities\Promotion\Promotion;
use App\Http\Controllers\Controller;
use App\Http\Requests\Promotion\PromotionAddGoodRequest;
use App\Services\Api\ApiResponse;
use App\Services\Coupon\CouponService;
use App\Services\Product\ProductService;
use App\Services\Promotion\PromotionService;
use Carbon\Carbon;
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
    public function edit(Promotion $promotion, Request $request)
    {
        if (! $promotion) {
            redirect(secure_route('promotion.index'));
        }
        //获取可添加的促销活动商品
        $promotion_goods = $this->promotionService->getAblePromotionActivityGoods($promotion->id, $request);
        //获取优惠券
        $coupon_list = app(CouponService::class)->getPromotionCoupons();
        return view('promotion.edit', compact('promotion','promotion_goods', 'coupon_list'));
    }

    /**
     * @function 保存促销活动
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function editPost(Request $request)
    {
        $result = $this->promotionService->create($request);
        if ($result['status'] == 200) {
            return ApiResponse::success($result['content']);
        }
        return ApiResponse::failure(g_API_ERROR, $result['msg']);
    }

    public function addGood(Promotion $promotion)
    {
        //获取所有可添加的商品(已上线)
        $promotion_products = $this->productService->getList();
        return view('promotion.addGoods', compact('promotion','promotion_products'));
    }

    /**
     * @function 添加活动商品
     * @param PromotionAddGoodRequest $request
     * @return mixed
     */
    public function addGoodPost(PromotionAddGoodRequest $request)
    {
        if (! $request->good_id) {
            return ApiResponse::failure(g_API_ERROR, '请选择要添加的商品');
        }
        if (! $request->type) {
            return ApiResponse::failure(g_API_ERROR, '请先选择活动的类型');
        }
        $result = $this->promotionService->addGoods($request);
        if ($result['status'] == 200) {
            return ApiResponse::success($result['content']);
        }
        return ApiResponse::failure(g_API_ERROR, $result['msg']);
    }

    /**
     * @function 删除活动商品
     * @param Request $request
     * @return mixed
     */
    public function delGoodPost(Request $request)
    {
        if (! $request->good_id || ! $request->activity_id) {
            return ApiResponse::failure(g_API_ERROR, '缺少参数');
        }
        $result = $this->promotionService->delGoods($request);
        if ($result['status'] == 200) {
            return ApiResponse::success($result['msg']);
        }
        return ApiResponse::failure(g_API_ERROR, $result['msg']);
    }

    /**
     * @function 获取促销活动可添加的商品
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getGoods(Request $request)
    {
        $result = $this->promotionService->getAblePromotionActivityGoods($request->activity_id, $request);
        /*if ($request->is_ajax == 1) {
            return ApiResponse::success($result);
        }*/
        return $result;
    }
}