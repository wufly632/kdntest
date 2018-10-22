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
use App\Services\Api\CommonService;
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

    /**
     * @function 优惠券列表页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
        return $result;
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
        //获取可添加的促销活动商品
        $promotion_goods = $this->promotionService->getAblePromotionActivityGoods($request->activity_id, $request);
        // $result = $this->promotionService->getAblePromotionActivityGoods($request->activity_id, $request);
        /*if ($request->is_ajax == 1) {
            return ApiResponse::success($result);
        }*/
        return $promotion_goods;
    }

    /**
     * 返回单品优惠html文档
     */
    public function getSingleSkuHtml(Request $request)
    {
        $result = $this->promotionService->getSingleSkuHtml($request);
        return $result;
    }

    /**
     * @function 删除促销活动
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request)
    {
        if (! $id = $request->id) {
            return ApiResponse::failure(g_API_ERROR, '请选择要删除的活动');
        }
        return $this->promotionService->deletePromotion($id);
    }

    /**
     * @function 促销活动图上传
     * @param Request $request
     * @return mixed
     */
    public function imgUpload(Request $request)
    {
        $img_name = $request->input('img_name');
        if ($request->hasFile($img_name)) {
            $file = $request->file($img_name);
            $ext = $file->getClientOriginalExtension();
            if( ! in_array(strtolower($ext), ['jpg', 'png', 'bmp', 'wbmp'])){
                return ApiResponse::failure(g_API_ERROR, '图片格式不正确，请检查!');
            }
            if(!$request->input('not_limit')){
                list($width, $height) = getimagesize($file->getRealPath());
                /*if($width > 800 || $height > 800){ //限制图片的宽高
                    return ApiResponse::failure(g_API_ERROR, '图片宽高不能大于800!');
                }*/
            }
        }
        $directory = 'promotion';
        $ali = env('APP_ENV', 'local') == 'production';
        $urlInfo = app(CommonService::class)->uploadFile($file = $img_name, $bucket = 'cucoe', $directory, $ali, false, false);
        if ($urlInfo) {
            if ($ali) {
                return ApiResponse::success($urlInfo['oss-request-url'], '图片上传成功');
            } else {
                return ApiResponse::success($urlInfo, '图片上传成功');
            }
        }else{
            return ApiResponse::failure(g_API_ERROR, '图片上传失败!');
        }
    }

}