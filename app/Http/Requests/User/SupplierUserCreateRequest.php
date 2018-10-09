<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUserCreateRequest extends FormRequest
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
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|min:6'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute 必须',
            'numeric' => ':attribute 必须为数字',
            'email' => ':attribute 必须为邮箱',
            'in' => ':attribute 不正确',
            'required_if' => '缺少 :attribute',
        ];
    }
}
