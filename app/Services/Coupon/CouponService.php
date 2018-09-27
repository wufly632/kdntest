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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\Exceptions\ValidatorException;

class CouponService
{
    /**
     * @var CouponRepository
     */
    protected $coupon;

    /**
     * @var CouponValidator
     */
    protected $couponValidator;

    /**
     * CouponController constructor.
     *
     * @param CouponRepository $coupon
     */
    public function __construct(CouponRepository $coupon, CouponValidator $couponValidator)
    {
        $this->coupon = $coupon;
        $this->couponValidator = $couponValidator;
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
            dd($request->all());
            // $this->couponValidator->with( $request->all() )->passesOrFail();
            DB::beginTransaction();
            $coupon = $request->only(['coupon_name','coupon_price', 'coupon_use_price', 'coupon_number',
                                      'use_type', 'use_days', 'coupon_use_startdate', 'coupon_use_enddate',
                                      'coupon_grant_startdate', 'coupon_grant_enddate', 'coupon_purpose',
                                      'coupon_remark']);
            if ($request->count_limit) {
                $coupon['coupon_number'] = null;
            }
            if ($request->use_type == 1) {
                $coupon['use_days'] = $request->use_days_value;
            } else {
                $coupon['coupon_use_startdate'] = $request->use_days_value;
                $coupon['coupon_use_startdate'] = $request->use_days_value;
            }
            $coupon['coupon_grant_startdate'] = $request->coupon_grant;
            $coupon['coupon_grant_enddate'] = $request->coupon_grant;

            $coupon['user_id'] = Auth::id();
            $coupon['created_at'] = Carbon::now()->toDateTimeString();
            $this->coupon->create($coupon);
            DB::commit();
            return ApiResponse::success('创建成功');
        } catch (ValidatorException $e) {
            DB::rollback();
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
            $this->couponValidator->with( Input::all() )->passesOrFail( ValidatorInterface::RULE_UPDATE );
            $this->coupon->update( $request->except(['_token']), $request->id );
            return ApiResponse::success('');
        } catch (\Exception $e) {
            return ApiResponse::failure(g_API_ERROR, $e->getMessage());
        }
    }
}
