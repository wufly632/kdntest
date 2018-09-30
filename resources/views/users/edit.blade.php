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
                编辑用户
                <small>编辑</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> 主页</a></li>
                <li><a href="#">用户</a></li>
                <li class="active">编辑</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div>
                        <h1 class="h2 text-padding-left">
                            <i class="fa fa-user"></i>
                            <span class="h3 text-padding-left">编辑用户</span>
                        </h1>
                    </div>
                    <div>
                        <form action="{{ secure_route('users.update',['id'=>$user->id]) }}" class="" method="post">
                            {{ method_field('put') }}
                            {{ csrf_field() }}
                            <div class="row block-padding-top">
                                <div class="col-md-8">
                                    <div class="panel panel-bordered">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="user_alias" class="control-label">用户昵称:</label>
                                                <input type="text" id="user_alias" name="user_alias"
                                                       class="form-control" value="{{ $user->user_alias }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="control-label">邮箱:</label>
                                                <input type="text" id="email" name="email" class="form-control"
                                                       value="{{ $user->email }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="firstname" class="control-label">姓:</label>
                                                <input type="text" id="firstname" name="firstname" class="form-control"
                                                       value="{{ $user->firstname }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="lastname" class="control-label">名:</label>
                                                <input type="text" id="lastname" name="lastname" class="form-control"
                                                       value="{{ $user->lastname }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="control-label">密码:</label>
                                                <input type="password" id="password" name="password"
                                                       class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="user_status" class="control-label">状态</label>
                                                <select name="status" id="user_status" class="form-control">
                                                    <option value="1">正常</option>
                                                    <option value="2">冻结</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-bordered">
                                        <div class="panel-body">
                                            <div class="">

                                            </div>
                                            <div class="form-group">
                                                <label for="logo"><img width="200px" src="{{ $user->logo }}"
                                                                       alt=""></label>
                                                <input type="file" id="logo" name="logo" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="block-padding-top">
                                <input type="submit" class="btn btn-success col-md-offset-11" value="保存">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop