<?php

namespace App\Http\Requests\Promotion;

use App\Http\Requests\Request;

class PromotionAddGoodRequest extends Request
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
            'activity_id'      => 'required',
            'good_id'          => 'required',
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
            'activity_id.required' => '请选择活动类型',
            'good_id.required'     => '请重新选择要添加的商品',
        ];
    }
}
