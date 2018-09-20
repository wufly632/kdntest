<?php

namespace App\Http\Requests\CateAttr;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class AttributeRequest extends Request
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
            'name'                => 'required|unique:admin_attribute,name'.$name_unique.'|regex:/^[\x7f-\xff\w]+$/',
            'alias_name'          => 'regex:/^[\x7f-\xff\w]+$/',
            'type'                => 'required|numeric',
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
            'name.required'     => '请填写属性名称',
            'name.unique'       => '属性名称已存在',
            'name.regex'        => '请填写正确的属性名称',
            'alias_name.regex'  => '请填写正确的属性别名',
            'type.required'     => '请选择属性类型',
            'type.numeric'      => '请选择正确的属性类型',
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
