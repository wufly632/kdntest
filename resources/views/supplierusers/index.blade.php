@section('css')
    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <style>
        .header-image-block {
            width: 80px;
        }

        .header-image {
            width: 60px;
            height: 60px;
        }

        .text-vertical td {
            vertical-align: middle !important;
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
                                <div class="col-xs-2"><input type="button" value="查找" class="btn btn-success"></div>
                            </form>
                        </div>
                        <hr>
                        <div class="box-body">
                            <table class="table table-hover table-striped table-bordered text-center text-vertical"
                                   id="user_table">
                                <thead>
                                <tr>
                                    <th>用户ID</th>
                                    <th>用户头像</th>
                                    <th>用户系统ID</th>
                                    <th>用户昵称</th>
                                    <th>用户邮箱</th>
                                    <th>账户余额</th>
                                    <th>用户状态</th>
                                    <th>创建时间</th>
                                    <th>登陆时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(userInfo, index) in userList">
                                    <td>@{{ userInfo.userId }}</td>
                                    <td class="header-image-block"><img
                                                :src="userInfo.headImage"
                                                alt="" class="header-image">
                                    </td>
                                    <td>@{{ userInfo.systemId }}</td>
                                    <td>@{{ userInfo.alias }}</td>
                                    <td>@{{ userInfo.email }}</td>
                                    <td>@{{ userInfo.money }}</td>
                                    <td>@{{ userInfo.status }}</td>
                                    <td>@{{ userInfo.loginTime }}</td>
                                    <td>@{{ userInfo.createTime }}</td>
                                    <td id="bread-actions" class="no-sort no-click">
                                        <div class="btn-group">
                                            <a type="text" class="btn btn-sm btn-warning">查看</a>
                                            <a type="text" class="btn btn-sm btn-primary">修改</a>
                                            <a type="text" class="btn btn-sm btn-danger">删除</a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script src="{{ asset('/assets/js/bower_components/vue/dist/vue.min.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugincommon.js') }}"></script>


    <script>
        var userTable = new Vue({
            el: '#user_table',
            data: userList = [{
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }, {
                userId: 1,
                headImage: 'http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg',
                systemId: 1,
                alias: 1,
                email: 1,
                money: 1,
                status: 1,
                loginTime: 1,
                createTime: 1
            }]

        });
        createDataTable($('#user_table'));
    </script>
@endsection