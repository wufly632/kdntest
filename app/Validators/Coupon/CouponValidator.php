<?php

namespace App\Validators\Coupon;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class CouponValidator.
 *
 * @package namespace App\Validators\Coupon;
 */
class CouponValidator extends LaravelValidator
{

    protected $attributes = [
        'coupon_name'      => '优惠券名称',
        'coupon_price'     => '优惠券面额',
        'coupon_use_price' => '优惠券使用条件',
        'coupon_purpose'   => '优惠券用途',
    ];

    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'coupon_name'    => 'required',
            'coupon_price'   => 'required',
            'use_type'       => 'required',
            'coupon_purpose' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'id'             => 'required',
            'coupon_name'    => 'required',
            'coupon_price'   => 'required|int',
            'use_type'       => 'required',
            'coupon_purpose' => 'required',
        ],
    ];

    protected $messages = [
        'required' => ':attribute 必填',
    ];


}
