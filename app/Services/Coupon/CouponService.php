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
use App\Services\Api\ApiResponse;
use App\Validators\Coupon\CouponValidator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Input;
use Prettus\Validator\Contracts\ValidatorInterface;

class CouponService
{
    /**
     * @var CouponRepository
     */
    protected $coupon;

    /**
     * CouponController constructor.
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


    /**
     * @function 创建优惠券
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        try {
            DB::beginTransaction();
            $coupon = $request->only(['coupon_name','coupon_price', 'coupon_use_price', 'coupon_number',
                                      'use_type', 'use_days', 'coupon_use_startdate', 'coupon_use_enddate',
                                      'coupon_grant_startdate', 'coupon_grant_enddate', 'coupon_purpose',
                                      'coupon_remark']);
            if ($request->count_limit == 1) {
                $coupon['coupon_number'] = 0;
            }
            if ($request->use_type == 1) {
                $coupon['use_days'] = $request->use_days;
            } else {
                $coupon['use_days'] = 0;
                $coupon_use_time = get_time_range($request->coupon_use);
                $coupon['coupon_use_startdate'] = $coupon_use_time[0];
                $coupon['coupon_use_enddate'] = $coupon_use_time[1];
            }
            $coupon_grant_time = get_time_range($request->coupon_grant);
            $coupon['coupon_grant_startdate'] = $coupon_grant_time[0];
            $coupon['coupon_grant_enddate'] = $coupon_grant_time[1];

            $coupon['user_id'] = Auth::id();
            $coupon['created_at'] = Carbon::now()->toDateTimeString();
            $this->coupon->create($coupon);
            DB::commit();
            return ApiResponse::success('创建成功');
        } catch (\Exception $e) {
            return ApiResponse::failure(g_API_ERROR, $e->getMessage());
        }
    }

    /**
     * @function 更新优惠券
     * @param $request
     * @return mixed
     */
    public function update($request)
    {
        try {
            $this->coupon->update( $request->except(['_token']), $request->id );
            return ApiResponse::success('');
        } catch (\Exception $e) {
            return ApiResponse::failure(g_API_ERROR, $e->getMessage());
        }
    }
}
