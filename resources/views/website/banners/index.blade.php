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
                订单列表
                <small>订单</small>
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
                        <div class="box-header" style="padding: 20px 10px;">
                            <form action="{{ secure_route('banners.index') }}" class="form-horizontal">
                                <div class="form-group col-sm-4">
                                    <label for="title" class="control-label col-sm-2">标题</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="col-sm-3 form-control" name="title" id="title">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="type" class="control-label col-sm-4">类型</label>
                                    <div class="col-sm-8">
                                        <select name="type" id="type" class="form-control">
                                            <option value="1" selected>PC</option>
                                            <option value="2">移动设备</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <input type="submit" class="btn-sm btn-info">
                                </div>
                                <div class="col-sm-2">
                                    <input type="button" class="btn-sm btn-primary" value="创建" id="create-banner"
                                           data-target-uri="{{ secure_route('banners.create') }}">
                                </div>
                            </form>
                        </div>
                        <hr>
                        <div class="box-body">
                            <table class="table table-bordered table-hover table-striped" id="banner-table">
                                <thead>
                                <tr>
                                    <th>标题 <span class="fa fa-unsorted pull-right"></span></th>
                                    <th>图片<span class="fa fa-unsorted pull-right"></span></th>
                                    <th>描述<span class="fa fa-unsorted pull-right"></span></th>
                                    <th>类型<span class="fa fa-unsorted pull-right"></span></th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($banners as $banner)
                                    <tr>
                                        <td>{{ $banner->title }}</td>
                                        <td><img src="{{ $banner->src }}" alt="{{ $banner->title }}"
                                                 title="{{ $banner->title }}" width="300px;">
                                        </td>
                                        <td>{{ $banner->describe }}</td>
                                        <td>@if($banner->type==1)PC端
                                            @else
                                                移动设备
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group-sm">
                                                <button class="btn btn-warning order-modify"
                                                        data-target-uri="{{ secure_route('banners.edit',['id'=>$banner->id]) }}">
                                                    修改
                                                </button>
                                                <button class="btn btn-danger order-delete"
                                                        data-target-uri="{{ secure_route('banners.destroy',['id'=>$banner->id]) }}"
                                                        id="banner-delete">
                                                    删除
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pull-right">
                                {{ $banners->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script src="{{ asset('/assets/js/plugincommon.js') }}"></script>
    <script src="{{asset('/assets/js/bower_components/axios/dist/axios.min.js')}}"></script>
    <script>
        $('.order-modify').click(function () {
            showInfo('banner修改', $(this).attr('data-target-uri'))
        });
        $('#create-banner').click(function () {
            showInfo('banner创建', $(this).attr('data-target-uri'))
        });
        $('#banner-delete').click(function () {
            let _clickEle = $(this);
            layer.confirm('确定删除此用户', {
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