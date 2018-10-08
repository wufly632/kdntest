@section('css')
    <style>
        .text-padding-left {
            padding-left: 1em;
        }

        .panel-bordered {
            border: 1px solid #e4eaec;
        }

        .block-padding-top {
            padding-top: 40px;
        }
    </style>
@endsection
@extends('layouts.default')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                用户详情
                <small>查看</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> 主页</a></li>
                <li><a href="#">用户</a></li>
                <li class="active">查看</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div>
                        <h1 class="h2 text-padding-left">
                            <i class="fa fa-user"></i>
                            <span class="h3 text-padding-left">查看用户</span>
                            <a href="{{ secure_route('users.edit',['id'=>$user->id]) }}" type="text"
                               class="btn btn-primary">编辑</a>
                            <a href="" data-user-id="{{ $user->id }}" type="text"
                               class="btn btn-danger">删除</a>
                            <a href="{{ secure_route('users.index',['id'=>$user->id]) }}" type="text"
                               class="btn btn-warning">返回列表</a>

                        </h1>
                    </div>
                    <div class="block-padding-top">
                        <ol class="list-group">
                            <li class="list-group-item"><h2 class="h4">用户ID</h2>
                                <p class="text-padding-left">{{ $user->id }}</p></li>
                            <li class="list-group-item"><h2 class="h4">用户头像</h2>
                                <p class="text-padding-left">
                                    <img
                                            src="{{ $user->logo }}"
                                            alt="" class="header-image">
                                </p>
                            </li>
                            <li class="list-group-item"><h2 class="h4">系统ID</h2>
                                <p class="text-padding-left">{{ $user->cucoe_id }}</p></li>
                            <li class="list-group-item"><h2 class="h4">昵称</h2>
                                <p class="text-padding-left">{{ $user->user_alias }}</p></li>
                            <li class="list-group-item"><h2 class="h4">邮箱</h2>
                                <p class="text-padding-left">{{ $user->email }}</p></li>
                            <li class="list-group-item"><h2 class="h4">账户余额</h2>
                                <p class="text-padding-left">{{ $user->amount_money }}</p></li>
                            <li class="list-group-item"><h2 class="h4">状态</h2>
                                <p class="text-padding-left">{{ $user->status }}</p></li>
                            <li class="list-group-item"><h2 class="h4">创建时间</h2>
                                <p class="text-padding-left">{{ $user->create_at }}</p></li>
                            <li class="list-group-item"><h2 class="h4">最后登陆时间</h2>
                                <p class="text-padding-left">{{ $user->last_login_datetime }}</p></li>
                        </ol>
                    </div>

                </div>
            </div>
        </section>
    </div>
@stop