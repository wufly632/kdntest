@extends('layouts.default')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                商品列表
                <small>商品列表</small>
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
                        <!-- form start -->
                        <form class="form-horizontal">
                            <div class="box-body">
                                <!-- 第一行 -->
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-4">
                                        <label for="inputEmail3" class="col-sm-4 control-label">商品名称：</label>

                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="goods_name" placeholder="" name="good_title" value="{{old('good_title')}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-4 control-label">商品ID：</label>

                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="goods_id" placeholder="" name="id" value="{{old('id')}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-4 control-label">商品货号：</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="goods_number" placeholder="" name="good_code" value="{{old('good_code')}}">
                                        </div>
                                    </div>
                                </div>

                                <!-- 第四行 -->
                                {{--<div class="col-xs-12">
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-4 control-label">创建时间：</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="goods_status"
                                                    style="width: 100%;">
                                                <option selected="selected">最近7天</option>
                                                <option>最近15天</option>
                                                <option>最近一个月</option>
                                                <option>自定义</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-4">
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right" id="reservationtime">
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-default pull-left col-xs-offset-1">查找</button>
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
                                <thead>
                                <tr class="text-center">
                                    <th>商品图片</th>
                                    <th>商品信息</th>
                                    <th>采购价</th>
                                    <th>售价</th>
                                    <th>历史销量</th>
                                    <th>库存数量</th>
                                    <th>商品状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($coupons as $coupon)
                                    <tr>
                                        <td class="table-center text-center">
                                            <div class="mailbox-attachment-icon has-img" style="width: 80px;">
                                                <img src="{{$good->main_pic}}" alt="" width="60px" height="60px">
                                            </div>
                                        </td>
                                        <td class="table-center">
                                            <span>ID：{{$good->id}}</span><br>
                                            <span>名称：{{$good->good_title}}</span><br>
                                            <span>货号：{{$good->good_code}}</span><br>
                                        </td>
                                        <td class="table-center">
                                            <label for="">￥：</label>{{$good->stock_price}}
                                        </td>
                                        <td class="table-center">
                                            <label for="">￥：</label>{{$good->supply_price}}
                                        </td>
                                        <td class="table-center">{{$good->orders}}</td>
                                        <td class="table-center">{{$good->good_stock}}</td>
                                        <td class="table-center">{{\App\Entities\Good\Good::$allStatus[$good->status]}}</td>
                                        <td class="table-center">
                                            <a href="#">编辑</a>
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