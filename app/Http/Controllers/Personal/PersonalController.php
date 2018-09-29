<?php

namespace App\Http\Controllers\Personal;

use App\Entities\User\AdminUser;
use App\Services\Api\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PersonalController extends Controller
{
    /**
     * @function 个人信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('personal.index');
    }

    public function update(Request $request)
    {
        if (! $request->password || !$request->repassword) {
            return ApiResponse::failure(g_API_ERROR, '密码不能为空');
        }
        if ($request->password != $request->repassword) {
            return ApiResponse::failure(g_API_ERROR, '两次密码输入不一致');
        }
        $user = AdminUser::find(Auth::id());
        $user->password = bcrypt($request->password);
        $user->updated_at = Carbon::now()->toDateTimeString();
        if (! $user->save()) {
            return ApiResponse::failure(g_API_ERROR, '修改失败');
        }
        return ApiResponse::success('修改成功');
    }
}
