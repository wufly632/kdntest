<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <title>WaiWaiMall</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link type="image/x-icon" rel="shortcut icon" href="common/images/icon.png">
    <link rel="stylesheet" href="{{asset('/assets/admin/css/plugins.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/admin/css/style.css')}}">
    <script src="{{asset('assets/admin/js/plugins.js')}}"></script>
    <script src="{{asset('assets/admin/js/index.js')}}"></script>
</head>
<body class="back">
<div class="logon-admin">
    <div class="message">waiwaimall - 用户登录</div>
    <form class="logon-form" method="post">
        <div class="logon-input">
            {!! csrf_field() !!}
            <input type="text" name="username" class="required" placeholder="用户名">
        </div>
        <div class="logon-input">
            <input type="password" name="password" class="required" placeholder="密码">
        </div>
        <div class="logon-input clearfix">
            <div class="proving">
                <input type="text" name="captcha" class="required" placeholder="验证码">
            </div>
            <a href="javascript:;" class="proving-png" >
                <img src="{{route('captcha')}}" alt="" onclick="javascript:this.src=this.src+'?time='+Math.random()">
            </a>
        </div>
        <div class="forget clearfix">
            <label class="clearfix">
                <input type="checkbox" name="remember" value="1" checked="checked"/>
                <div class="logon-icon">
                    <i class="iconfont yes">&#xe6d3;</i>
                    <i class="iconfont no">&#xe6e4;</i>
                </div>
                <p>记住密码</p>
            </label>
            <a href="javascript:;">忘记密码？</a>
        </div>
        <button type="submit" class="login-submit">登 录</button>
    </form>
    <p class="account">还没有账号？请联系<a href="javascript:;">龙渊</a></p>
</div>
</body>
</html>
<script type="text/javascript">
    $(function(){

        $('.logon-form').submit(function(e) {
            e.preventDefault();
        }).validate({
            messages: {
                captcha: {
                    required: '请输入验证码'
                }
            },
            submitHandler: function(f) {
                $.ajax({
                    type: 'post',
                    async: false,
                    dataType : 'json',
                    url:'/loginPost',
                    data: $('.logon-form').serialize(),
                    beforeSend: function() {
                        $('button.login-submit').text('登录中...').attr('disabled', true);
                    },
                    success: function(json) {
                        if (json.status) {
                            window.location.href = json.messages;
                        } else {
                            alert(json.messages);
                            $('button.login-submit').text('登　录').removeAttr('disabled');
                        }
                    }
                });
                return false;
            }
        });

    });
</script>