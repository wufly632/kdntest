<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

abstract class Request extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator,$this->response($validator));
    }

    public function response($validator)
    {
        $errors = $validator->errors()->first();
        return new Response([
            'status'  => g_API_ERROR,
            'msg'     => $errors,
            'content' => null
        ], 422);//更改格式，以及定义返回状态值
    }


}