<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginController extends Controller
{
    public function login()
    {
        if (\Auth::check()) {
            return redirect(route('home.dashboard'));
        }
        return view('admin.login');
    }

    public function postLogin(Request $request)
    {
        if (!$username = $request->post('username')) {
            return jsonMessage('用户名不能为空。');
        }
        if (strlen($request->post('password')) < 6) {
            return jsonMessage('密码长度必须大于等于6个字符。');
        }
        if (! $this->verifyCaptcha()) {
            return jsonMessage('验证码输入有误');
        }
        $result = Auth::attempt(['name' => $username, 'password' => $request->password],$request->remember);
        if (! $result) {
            return jsonMessage('用户名或密码错误');
        }
        if (Auth::user()->flag != 1) {
            return jsonMessage('此帐号已被冻结，请与管理员联系');
        }
        if ($request->post('backurl')) {
            $directUrl = $request->post('backurl');
        } else {
            $directUrl = route('home.dashboard');
        }
        return jsonMessage('', $directUrl);
    }

    //生成验证码
    public function captcha() {
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 250, $height = 70, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();
        //把内容存入session
        Session::flash('captcha', $phrase);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }

    //验证注册码的正确与否
    public function verifyCaptcha() {
        $userInput = request('captcha');
        if (Session::get('captcha') == $userInput) {
            //用户输入验证码正确
            return true;
        } else {
            //用户输入验证码错误
            return false;
        }
    }

    /**
     * @function
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }

    //首页
    public function dashboard()
    {
        return view('welcome');
    }
}
