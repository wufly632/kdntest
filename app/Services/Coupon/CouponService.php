<?php
// +----------------------------------------------------------------------
// | CouponService.php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Time: 2018/9/20 上午11:40
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Services\Coupon;

use App\Repositories\Coupon\CouponRepository;

class CouponService
{
    /**
     * @var CouponRepository
     */
    protected $coupon;

    /**
     * PromotionController constructor.
     *
     * @param CouponRepository $coupon
     */
    public function __construct(CouponRepository $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * @function 获取优惠券列表
     * @return mixed
     */
    public function getList()
    {
        $this->coupon->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $orderBy = $request->orderBy ?? 'id';
        $sort = $request->sort ?? 'desc';
        $length = $request->length ?? 20;
        return $this->coupon->orderBy($orderBy, $sort)->paginate($length);
    }
}
