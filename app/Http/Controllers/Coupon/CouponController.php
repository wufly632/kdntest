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
use App\Services\Api\ApiResponse;
use App\Services\Coupon\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function index(Request $request)
    {
        $request->flash();
        $coupons = $this->couponService->getList();
        return view('coupon.index', compact('coupons'));
    }

    /**
     * 创建优惠券
     */
    public function create(Request $request)
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
    public function update(Request $request)
    {
        $result = $this->couponService->update($request);
        if ($result['status'] != 200) {
            return ApiResponse::failure(g_API_ERROR, $result['msg']);
        }
        return ApiResponse::success('更新成功');
    }

    /**
     * 编辑优惠券
     */
    public function edit(Coupon $coupon)
    {
        return view('coupon.edit', compact('coupon'));
    }
}
