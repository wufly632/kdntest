<?php

namespace App\Http\Requests\Coupon;

use App\Http\Requests\Request;

class CouponRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'coupon_name'      => 'required',
            'coupon_price'     => 'required|numeric',
            'coupon_purpose'   => 'required|in:1,2,3',
            'use_type'         => 'required|in:1,2',
            'coupon_grant'     => 'required',
            'use_days'         => 'required_if:use_type,1',
            'coupon_use'       => 'required_if:use_type,2',
            'count_limit'      => 'required|in:1,2',
            'coupon_number'    => 'required_if:count_limit,2|numeric',
            'coupon_use_price' => 'required|numeric'
        ];
    }

    /**
     * 自定义验证信息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => ':attribute 必须',
            'numeric'  => ':attribute 必须为数字',
            'in'       => ':attribute 不正确',
            'required_if' => '缺少 :attribute',
        ];
    }
}
