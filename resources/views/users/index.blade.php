@section('css')
    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <style>
        .header-image-block {
            width: 120px;
        }

        .header-image {
            width: 100px;
            height: 100px;
        }

        .text-vertical td {
            vertical-align: middle !important;
        }

        .fa-gray {
            color: gray;
        }
    </style>
@stop
@extends('layouts.default')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                用户列表
                <small>用户</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Layout</a></li>
                <li class="active">Fixed</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <form action="" class="form-inline" method="get">
                                <div class="col-xs-3 col-xs-offset-1">
                                    <div class="form-group">
                                        <label for="name" class="control-label">用户名:</label>
                                        <div class="form-group"><input type="text" class="form-control" id="name"></div>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label for="email" class="control-label">用户邮箱:</label></div>
                                    <div class="form-group"><input type="text" class="form-control" id="email"></div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label for="user_id" class="control-label">用户ID:</label>
                                        <div class="form-group"><input type="text" class="form-control" id="user_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-1"><input type="button" id="user_search" value="查找"
                                                             class="btn btn-success"></div>
                                <div class="col-xs-1"><a href="{{ secure_route('users.create') }}"><input type="button" id="create_user" value="创建新用户"
                                                                        class="btn btn-success"></a></div>
                            </form>
                        </div>
                        <hr>
                        <div class="box-body">
                            <table class="table table-hover table-striped table-bordered text-center text-vertical"
                                   id="user_table">
                                <thead>
                                <tr>
                                    <th>用户ID <span class="fa fa-gray fa-sort-numeric-desc pull-right"></span></th>
                                    <th>用户头像<span class="fa fa-gray fa-unsorted pull-right"></span></th>
                                    <th>用户系统ID<span class="fa fa-gray fa-unsorted pull-right"></span></th>
                                    <th>用户昵称<span class="fa fa-gray fa-unsorted pull-right"></span></th>
                                    <th>用户邮箱<span class="fa fa-gray fa-unsorted pull-right"></span></th>
                                    <th>账户余额<span class="fa fa-gray fa-unsorted pull-right"></span></th>
                                    <th>用户状态<span class="fa fa-gray fa-unsorted pull-right"></span></th>
                                    <th>创建时间<span class="fa fa-gray fa-unsorted pull-right"></span></th>
                                    <th>登陆时间<span class="fa fa-gray fa-unsorted pull-right"></span></th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td class="header-image-block"><img
                                                    src="{{ $user->cucoe_id }}"
                                                    alt="" class="header-image">
                                        </td>
                                        <td>{{ $user->cucoe_id }}</td>
                                        <td>{{ $user->user_alias }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->amount_money }}</td>
                                        <td>{{ $user->status }}</td>
                                        <td>{{ $user->create_at }}</td>
                                        <td>{{ $user->last_login_datetime }}</td>
                                        <td id="bread-actions" class="no-sort no-click">
                                            <div class="btn-group">
                                                <a href="{{ secure_route('users.show',['id'=>$user->id]) }}" type="text"
                                                   class="btn btn-sm btn-warning"><span class="fa fa-eye"></span> 查看</a>
                                                <a href="{{ secure_route('users.edit',['id'=>$user->id]) }}" type="text"
                                                   class="btn btn-sm btn-primary"><span class="fa fa-edit"></span> 编辑</a>
                                                <a href="" data-user-id="{{ $user->id }}" type="text"
                                                   class="btn btn-sm btn-danger"><span class="fa fa-trash"></span> 删除</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pull-right">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')

@endsection