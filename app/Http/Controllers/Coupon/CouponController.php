<?php
// +----------------------------------------------------------------------
// | CouponController.php
// +----------------------------------------------------------------------
// | Description: 优惠券
// +----------------------------------------------------------------------
// | Time: 2018/9/20 上午11:44
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Http\Controllers\Coupon;

use App\Entities\Coupon\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\CouponRequest;
use App\Services\Api\ApiResponse;
use App\Services\Coupon\CouponService;
use App\Services\Currency\CurrencyService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected $couponService;
    protected $currencyService;

    public function __construct(CouponService $couponService, CurrencyService $currencyService)
    {
        $this->couponService = $couponService;
        $this->currencyService = $currencyService;
    }

    /**
     * @function 优惠券列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $request->flash();
        $currencys = $this->getCurrencyList();
        $coupons = $this->couponService->getList();
        return view('coupon.index', compact('coupons','currencys'));
    }

    /**
     * 创建优惠券
     */
    public function create(CouponRequest $request)
    {
        $result = $this->couponService->store($request);
        if ($result['status'] != 200) {
            return ApiResponse::failure(g_API_ERROR, $result['msg']);
        }
        return ApiResponse::success('创建成功');
    }

    /**
     * 更新优惠券
     */
    public function update(CouponRequest $request)
    {
        if (!$request->id) {
            return ApiResponse::failure(g_API_ERROR, '请选择要修改的优惠券');
        }
        $result = $this->couponService->update($request);
        if ($result['status'] != 200) {
            return ApiResponse::failure(g_API_ERROR, $result['msg']);
        }
        return ApiResponse::success('更新成功');
    }

    /**
     * 获取币种列表
     * @return mixed
     */
    public function getCurrencyList()
    {
        return $this->currencyService->getAll();
    }

    /**
     * 编辑优惠券
     */
    public function edit(Coupon $coupon)
    {
        $currencys = $this->getCurrencyList();
        return view('coupon.edit', compact('coupon', 'currencys'));
    }
}
