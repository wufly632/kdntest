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
                商家列表
                <small>商家</small>
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
                                <div class="col-xs-1"><a href="javascript:void(0)" class="user_create" data-target-uri="{{ secure_route('supplierusers.create') }}"><input type="button"
                                                                                                          id="create_user"
                                                                                                          value="创建新用户"
                                                                                                          class="btn btn-success"></a>
                                </div>
                            </form>
                        </div>
                        <hr>
                        <div class="box-body">
                            <table class="table table-hover table-striped table-bordered text-center text-vertical"
                                   id="user_table">
                                <thead>
                                <tr>
                                    <th>商家ID <span class="fa fa-gray fa-sort-numeric-desc pull-right"></span></th>
                                    <th>商家名称<span class="fa fa-gray fa-unsorted pull-right"></span></th>
                                    <th>手机号<span class="fa fa-gray fa-unsorted pull-right"></span></th>
                                    <th>邮箱<span class="fa fa-gray fa-unsorted pull-right"></span></th>
                                    <th>账户余额<span class="fa fa-gray fa-unsorted pull-right"></span></th>
                                    <th>状态<span class="fa fa-gray fa-unsorted pull-right"></span></th>
                                    <th>创建时间<span class="fa fa-gray fa-unsorted pull-right"></span></th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->mobile }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->amount_money }}</td>
                                        <td>{{ $user->status }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td id="bread-actions" class="no-sort no-click">
                                            <div class="btn-group">
                                                <a href="javascript:void(0)"
                                                   class="btn btn-sm btn-warning user_show"
                                                   data-target-uri="{{ secure_route('supplierusers.show',['id'=>$user->id]) }}"><span
                                                            class="fa fa-eye"></span>
                                                    查看</a>
                                                <a href="javascript:void(0)"
                                                   class="btn btn-sm btn-primary user_edit"
                                                   data-target-uri="{{ secure_route('supplierusers.edit',['id'=>$user->id]) }}"><span
                                                            class="fa fa-edit"></span>
                                                    编辑</a>
                                                <a href="javascript:void(0)"
                                                   class="btn btn-sm btn-danger user_delete"
                                                   data-target-uri="{{ secure_route('supplierusers.destroy',['id'=>$user->id]) }}"><span
                                                            class="fa fa-trash"></span>
                                                    删除</a>
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
    <script src="{{ asset('/assets/js/bower_components/axios/dist/axios.min.js') }}"></script>
    <script>
        function showInfo(title, content) {
            layer.open({
                type: 2,
                skin: 'layui-layer-rim', //加上边框
                area: ['60%', '600px'],
                fix: false, //不固定
                shadeClose: true,
                maxmin: true,
                shade: 0.4,
                title: title,
                content: content,
                end: function (layero, index) {

                }
            });
        }

        $('.user_create').click(function () {
            showInfo('新建商家', $(this).attr('data-target-uri'));
        });
        $('.user_show').click(function () {
            showInfo('商家信息', $(this).attr('data-target-uri'));
        });
        $('.user_edit').click(function () {
            showInfo('商家信息', $(this).attr('data-target-uri'));
        });
        $('.user_delete').click(function () {
            layer.confirm('确定删除此用户', {
                btn: ['删除','取消'] //按钮
            }, function(){
                axios.delete($(this).attr('data-target-uri')).then(function () {
                    layer.closeAll();
                    toastr.success('删除成功');
                });
            }, function(){

            });

        });
    </script>
@endsection