<?php
// +----------------------------------------------------------------------
// | CouponController.php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Time: 2018/9/20 上午11:44
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
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
}
