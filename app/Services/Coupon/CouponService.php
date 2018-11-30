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

use App\Criteria\Coupon\CouponGrantTimeCriteria;
use App\Criteria\Coupon\CouponIdCriteria;
use App\Criteria\Coupon\CouponNameCriteria;
use App\Criteria\Coupon\CouponPurposeCriteria;
use App\Criteria\Coupon\CouponStatusCriteria;
use App\Criteria\Coupon\CouponUseTimeCriteria;
use App\Entities\Coupon\Coupon;
use App\Repositories\Coupon\CouponRepository;
use App\Services\Api\ApiResponse;
use App\Validators\Coupon\CouponValidator;
use Carbon\Carbon;
use function Composer\Autoload\includeFile;
use Illuminate\Support\Facades\Auth;
use DB, Request;
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
        // $this->coupon->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $orderBy = $request->orderBy ?? 'id';
        $sort = $request->sort ?? 'desc';
        $length = $request->length ?? 20;
        $this->coupon->pushCriteria(new CouponIdCriteria(Request::input('id')));
        $this->coupon->pushCriteria(new CouponNameCriteria(Request::input('coupon_title')));
        $this->coupon->pushCriteria(new CouponPurposeCriteria(Request::input('coupon_purpost')));
        $this->coupon->pushCriteria(new CouponStatusCriteria(Request::input('status')));
        $this->coupon->pushCriteria(new CouponGrantTimeCriteria(Request::input('daterange2')));
        $this->coupon->pushCriteria(new CouponUseTimeCriteria(Request::input('daterange')));
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
            $coupon = $request->only(['coupon_name', 'coupon_price', 'currency_code', 'coupon_use_price', 'coupon_number',
                'use_type', 'use_days', 'coupon_use_startdate', 'coupon_use_enddate',
                'coupon_grant_startdate', 'coupon_grant_enddate', 'coupon_purpose',
                'coupon_remark', 'coupon_key', 'rebate_type']);
            if ($request->coupon_purpose == 4) {
                if (!$request->coupon_key) {
                    return ApiResponse::failure(g_API_ERROR, '请填写券口令');
                }
                if ($this->coupon->findWhere(['coupon_key' => $request->coupon_key])->count() > 0) {
                    return ApiResponse::failure(g_API_ERROR, '券口令重复');
                }
            }
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
            DB::beginTransaction();
            $coupon = $request->only(['id', 'coupon_name', 'coupon_price', 'currency_code', 'coupon_key', 'coupon_use_price', 'coupon_number',
                'use_type', 'use_days', 'coupon_use_startdate', 'coupon_use_enddate',
                'coupon_grant_startdate', 'coupon_grant_enddate', 'coupon_purpose',
                'coupon_remark', 'rebate_type']);
            if ($request->coupon_purpose == 4) {
                if (!$request->coupon_key) {
                    return ApiResponse::failure(g_API_ERROR, '请填写券口令');
                }
                if ($this->coupon->findWhere([['coupon_key', '=', $request->coupon_key], ['id', '<>', $request->id]])->count() > 0) {
                    return ApiResponse::failure(g_API_ERROR, '券口令重复');
                }
            }
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
            $coupon['updated_at'] = Carbon::now()->toDateTimeString();
            $this->coupon->update($coupon, $request->id);
            DB::commit();
            return ApiResponse::success('修改成功');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::failure(g_API_ERROR, $e->getMessage());
        }
    }

    public function getPromotionCoupons()
    {
        $orderBy = $request->orderBy ?? 'id';
        $sort = $request->sort ?? 'desc';
        $length = $request->length ?? 20;

        $this->coupon->pushCriteria(new CouponPurposeCriteria(Coupon::RETURN_COUPON));

        $coupons = $this->coupon->orderBy($orderBy, $sort)->paginate($length);
        $couponStr = view('promotion.addCoupons', compact('coupons'));
        return $couponStr;
    }
}
