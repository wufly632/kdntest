<?php

namespace App\Http\Requests\CateAttr;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class CategoryRequest extends Request
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
        $id = Request::input('id');
        $name_unique = $id ? ','.$id : '';
        return [
            'name'                => 'required|unique:admin_goods_category,name'.$name_unique,
            'sort'                => 'numeric',
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
            'name.required'     => '请填写分类名称',
            'name.unique'       => '该分类名称已存在',
            'sort.numeric'      => '排序值只能为数字',
        ];
    }

    /**
     * 自定义错误数组
     *
     * @return array
     */
    public function formatErrors(Validator $validator)
    {
        $errors = ['errors' => $validator->errors()->all()];
        return $errors;
    }
}
