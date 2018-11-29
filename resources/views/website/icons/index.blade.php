@section('css')
    <style>
        #banner-table > tbody > tr > td, #banner-table > thead > tr > th {
            text-align: center;
            vertical-align: middle;
        }
    </style>
@endsection
@extends('layouts.default')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Icon列表
                <small>Icon</small>
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
                            <form action="{{ secure_route('icons.index') }}" class="form-horizontal">
                                <form action="{{ secure_route('icons.index') }}" class="form-horizontal">
                                    <div class="form-group col-sm-3">
                                        <label for="title" class="control-label col-sm-2">标题</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="col-sm-3 form-control" name="title" id="title"
                                                   value="{{ old('title') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="daterange" class="control-label col-sm-4">起止时间</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control time_duration" id="daterange"
                                                   name="daterange" autocomplete="off"
                                                   value="{{ old('daterange') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="submit" class="btn-sm btn-info" value="查找">
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="button" class="btn-sm btn-primary" value="创建" id="create-banner"
                                               data-target-uri="{{ secure_route('icons.create') }}">
                                    </div>
                                </form>
                            </form>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-hover table-striped" id="banner-table">
                                <thead>
                                <tr>
                                    <th>标题 <span class="fa fa-unsorted pull-right"></span></th>
                                    <th>图标<span class="fa fa-unsorted pull-right"></span></th>
                                    <th>开始时间<span class="fa fa-unsorted pull-right"></span></th>
                                    <th>结束时间<span class="fa fa-unsorted pull-right"></span></th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($icons as $icon)
                                    <tr>
                                        <td>{{ $icon->title }}</td>
                                        <td><img src="{{ $icon->src }}" alt="{{ $icon->title }}"
                                                 title="{{ $icon->title }}" width="150px;">
                                        </td>
                                        <td>{{ $icon->start_at }}</td>
                                        <td>{{ $icon->end_at }}</td>
                                        <td>
                                            <div class="btn-group-sm">
                                                <button class="btn btn-warning order-modify"
                                                        data-target-uri="{{ secure_route('icons.edit',['id'=>$icon->id]) }}">
                                                    修改
                                                </button>
                                                <button class="btn btn-danger order-delete icons-delete"
                                                        data-target-uri="{{ secure_route('icons.destroy',['id'=>$icon->id]) }}">
                                                    删除
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
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
    <script src="{{asset('/assets/js/bower_components/axios/dist/axios.min.js')}}"></script>
    <script>
        $('.order-modify').click(function () {
            showInfo('ICON修改', $(this).attr('data-target-uri'), "65%")
        });
        $('#create-banner').click(function () {
            showInfo('ICON创建', $(this).attr('data-target-uri'), "65%")
        });
        $('.icons-delete').click(function () {
            let _clickEle = $(this);
            layer.confirm('确定删除', {
                btn: ['删除', '取消'] //按钮
            }, function () {
                axios.delete(_clickEle.attr('data-target-uri')).then(function (res) {
                    if (res.status === 200) {
                        toastr.options.timeOut = 0.5;
                        toastr.options.onHidden = function () {
                            location.reload();
                        };
                        layer.closeAll();
                        toastr.success('删除成功');
                    } else {
                        toastr.success('删除失败');
                    }
                }).catch(function (error) {
                    toastr.success('删除失败');
                });
            }, function () {

            })
        });
    </script>
@endsection