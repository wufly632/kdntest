@extends('layouts.default')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                店铺券列表
                <small>店铺券</small>
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
                    <div class="modal fade" id="modal-default">
                        <div class="modal-dialog" style="width:800px">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <form action="" method="post" class="form-horizontal">
                                        <h2 class="text-center">创建店铺券</h2>
                                        <div class="form-group">
                                            <label class="col-xs-2 control-label">
                                                用途:
                                            </label>
                                            <div class="col-xs-9">
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" name="usage" class="" id="method1">页面领取
                                                    </label>
                                                </div>
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" name="usage" class="" id="method2">制作纸质券
                                                    </label>
                                                </div>
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" name="usage" class="" id="method3">满返活动
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="info-tips text-danger">

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="coupon_name" class="col-xs-2 control-label">
                                                券名称：
                                            </label>
                                            <div class="col-xs-9">
                                                <input type="text" id="coupon_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="coupon_price" class="col-xs-2 control-label">
                                                券面额：
                                            </label>
                                            <div class="col-xs-9">
                                                <input type="text" id="coupon_price" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="coupon_count" class="col-xs-2 control-label">
                                                发放总量：
                                            </label>
                                            <div class="col-xs-9">
                                                <input type="text" id="coupon_count" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="coupon_count" class="col-xs-2 control-label">
                                                使用条件：
                                            </label>
                                            <div class="col-xs-9">
                                                <input type="text" id="coupon_count" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="coupon_count" class="col-xs-2 control-label">
                                                使用有效期：
                                            </label>
                                            <div class="col-xs-9">
                                                <input type="text" id="coupon_count" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="coupon_count" class="col-xs-2 control-label">
                                                发放时间：
                                            </label>
                                            <div class="col-xs-4">
                                                <input type="text" id="coupon_begin" autocomplete="off" class="form-control date_choice">
                                            </div>
                                            <div class="col-xs-4 col-xs-offset-1">
                                                <input type="text" id="coupon_end" autocomplete="off" class="form-control date_choice">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="coupon_count" class="col-xs-2 control-label">
                                                备注：
                                            </label>
                                            <div class="col-xs-9">
                                                <input type="text" id="coupon_count" class="form-control">
                                            </div>
                                        </div>
                                        <div>
                                            <input type="submit" class="btn btn-default col-xs-offset-2" value="创建">
                                            <input type="button" class="btn btn-default col-xs-offset-2"
                                                   id="modal-cancel" value="取消">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                    <div class="box box-info">
                        <!-- form start -->
                        <form class="form-horizontal" action="" method="get">
                            <div class="box-body">
                                <!-- 第一行 -->
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-4">
                                        <label for="coupon_title" class="col-sm-4 control-label">券名称：</label>

                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="coupon_title" placeholder=""
                                                   name="coupon_title" value="{{old('coupon_title')}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label for="coupon_id" class="col-sm-4 control-label">券ID：</label>

                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="coupon_id" placeholder=""
                                                   name="coupon_id" value="{{old('coupon_id')}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-2">
                                        <label for="coupon_usage" class="col-sm-4 control-label">用途：</label>
                                        <div class="col-sm-8">
                                            <select name="coupon_usage" id="coupon_usage" class="form-control">
                                                <option value="1">全部</option>
                                                <option value="2">页面领取</option>
                                                <option value="3">制作纸质券</option>
                                                <option value="4">满返活动</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-2">
                                        <label for="coupon_status" class="col-sm-4 control-label">状态：</label>
                                        <div class="col-sm-8">
                                            <select name="coupon_status" id="coupon_status" class="form-control">
                                                <option value="">全部</option>
                                                <option value="">未开始</option>
                                                <option value="">使用中</option>
                                                <option value="">已过期</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- 第四行 -->
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-4">
                                        <label for="use_time" class="col-sm-4 control-label date_choice">使用时间：</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="use_time" class="form-control use_time"
                                                   name="use_time" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-4">
                                        <label for="take_time" class="col-sm-4 control-label date_choice">发放时间：</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="take_time" class="form-control take_time"
                                                   name="take_time" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-default pull-left col-xs-offset-1">查找</button>
                                <button type="button" class="btn btn-default pull-right" data-toggle="modal"
                                        data-target="#modal-default">创建店铺券
                                </button>
                            </div>

                            <!-- /.box-footer -->
                        </form>
                    </div>
                    <!-- /.box -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">商品数据</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-hover text-center">
                                <thead class="bg-info">
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>名称</th>
                                    <th>面额</th>
                                    <th>使用/发放/总量</th>
                                    <th>用途</th>
                                    <th>使用有效期</th>
                                    <th>发放时间</th>
                                    <th>券状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($coupons as $coupon)
                                    <tr>
                                        <td class="table-center text-center">
                                            {{$coupon->id}}
                                        </td>
                                        <td class="table-center">
                                            {{$coupon->coupon_name}}
                                        </td>
                                        <td class="table-center">
                                            <label for="">￥：</label>{{$coupon->coupon_price}}
                                        </td>
                                        <td class="table-center">
                                            <label for="">￥：</label>{{$coupon->supply_price}}
                                        </td>
                                        <td class="table-center">
                                            {{$coupon->coupon_use_enddate}}
                                        </td>
                                        <td class="table-center">
                                            {{$coupon->coupon_purpose}}
                                        </td>
                                        <td class="table-center">
                                            {{$coupon->coupon_grant_startdate}}
                                        </td>
                                        <td class="table-center">{{$coupon->status}}</td>
                                        <td class="table-center">
                                            <a href="javascript:void(0);" id="coupon_edit">编辑</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop
@section('script')
    <script src="{{ asset('/js/laydate/laydate.js') }}"></script>
    <script>
        laydate.render({
            elem: '#use_time' //指定元素
            , type: 'datetime'
        });
        laydate.render({
            elem: '#take_time' //指定元素
            , type: 'datetime'
        });

        laydate.render({
            elem: '#coupon_begin' //指定元素
            , type: 'datetime'
        });

        laydate.render({
            elem: '#coupon_end' //指定元素
            , type: 'datetime'
        });
        $('#modal-cancel').click(function () {
            $("#modal-default").modal('hide');
        });
        $('#coupon_edit').click(function () {
            $('#modal-default').modal('show');
        });
    </script>
@stop