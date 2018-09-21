@extends('layouts.default')
@section('content')
    <style>
        li {
            list-style: none;
            width: 30px;
            height: 30px;
            margin-bottom: 20px;
        }
        .w100h100 {
            width: 100px;
            height: 100px;
        }
    </style>
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
                    <div class="box box-default">
                        <div class="box-body navbar-custom-menu">
                            <ul class="nav navbar-nav  col-md-1" style="background-color: #293846">
                                <!-- Messages: style can be found in dropdown.less-->
                                <li class="dropdown messages-menu">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                                       style="color: white;">
                                        <span>状态：</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav col-lg-1" style="background-color: #ccc;">
                                <!-- Messages: style can be found in dropdown.less-->
                                <li class="dropdown messages-menu">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                                       style="color: white;">
                                        <span>状态：</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">

                    <div class="box box-info">
                        <!-- form start -->
                        <form class="form-horizontal">
                            <div class="box-body">
                                <!-- 第一行 -->
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-4">
                                        <label for="inputEmail3" class="col-sm-3 control-label">商品类目：</label>

                                        <div class="col-sm-9">
                                            <label for="">婴儿服装</label> --
                                            <label for="">婴儿装</label> --
                                            <label for="">婴儿内衣</label>
                                            <label for="" style="margin-left: 5%;"><a href="">重新选择</a></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- 第二行 -->
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-4">
                                        <label for="inputEmail3" class="col-sm-3 control-label">品牌：</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="brand" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <!-- 第三行 -->
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-3 control-label">货号：</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="number" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <!-- 第四行 -->
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-3 control-label">商品名称：</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="goods_name" placeholder="">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <!-- /.box -->

                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">价格库存：</h3>
                        </div>
                        <!-- form start -->
                        <form class="form-horizontal">
                            <div class="box-body">
                                <!-- 第一行 -->
                                <div class="col-lg-12">
                                    <div class="form-group col-xs-12">
                                        <div class="col-sm-1">
                                            <label for="inputEmail3" class="col-sm-12 control-label">颜色：</label>
                                        </div>

                                        <div class="col-sm-8">
                                            <div class="col-sm-2">
                                                <li style="background-color: red;float: left;"></li>
                                                <span style="float: left;padding-left: 10px;line-height: 30px;">红色</span>
                                            </div>
                                            <div class="col-sm-2">
                                                <li style="background-color: red;float: left;"></li>
                                                <span style="float: left;padding-left: 10px;line-height: 30px;">红色</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 第二行 -->
                                <div class="col-lg-12">
                                    <div class="form-group col-xs-12">
                                        <div class="col-sm-1">
                                            <label for="inputEmail3" class="col-sm-12 control-label">尺码：</label>
                                        </div>

                                        <div class="col-sm-8">
                                            <div class="col-sm-2">
                                                <span style="float: left;padding-left: 10px;line-height: 30px;">80cm</span>
                                            </div>
                                            <div class="col-sm-2">
                                                <span style="float: left;padding-left: 10px;line-height: 30px;">90cm</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <hr>
                                </div>

                                <div class="col-lg-12">
                                    <div class="box-body">
                                        <table id="example2" class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th class="table-center">颜色</th>
                                                <th class="table-center">尺码</th>
                                                <th class="table-center">供货价（￥）</th>
                                                <th class="table-center">售价（$）</th>
                                                <th class="table-center">库存（件）</th>
                                                <th class="table-center">商品条码</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="table-center">
                                                    紫色
                                                </td>
                                                <td class="table-center">
                                                    80cm
                                                </td>
                                                <td class="table-center">
                                                    <label for="">￥：</label>399.00
                                                </td>
                                                <td class="table-center col-sm-2">
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control" id="money" placeholder="">
                                                    </div>
                                                </td>
                                                <td class="table-center">95</td>
                                                <td class="table-center">20180920123982</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- /.box -->

                    </div>
                    <!-- /.col -->

                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">商品图片：</h3>
                        </div>
                            <div class="box-body">
                            <!-- 第一行 -->
                            <div class="col-lg-12">
                                <div class="form-group col-xs-12">
                                    <hr>
                                    <div class="col-sm-1">
                                        <li style="background-color: red;float: left;"></li>
                                        <span style="float: left;padding-left: 10px;line-height: 30px;">红色</span>
                                        <span style="float: left;padding-left: 10px;line-height: 30px;">：</span>
                                    </div>

                                    <div class="col-sm-8">
                                        <div class="timeline-body">
                                            <div class="col-sm-2">
                                                <img src="{{asset('images/photo1.png')}}" alt="..." class="margin w100h100">
                                                <button type="button" class="btn btn-block btn-default btn-xs" disabled>已设置为主图</button>
                                            </div>
                                            <div class="col-sm-2">
                                                <img src="{{asset('images/photo1.png')}}" alt="..." class="margin w100h100">
                                                <button type="button" class="btn btn-block btn-primary btn-xs">设置为主图</button>
                                            </div>
                                            <div class="col-sm-2">
                                                <img src="{{asset('images/photo1.png')}}" alt="..." class="margin w100h100">
                                                <button type="button" class="btn btn-block btn-primary btn-xs">设置为主图</button>
                                            </div>
                                            <div class="col-sm-2">
                                                <img src="{{asset('images/photo1.png')}}" alt="..." class="margin w100h100">
                                                <button type="button" class="btn btn-block btn-primary btn-xs">设置为主图</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group col-xs-12">
                                    <hr>
                                    <div class="col-sm-1">
                                        <li style="background-color: pink;float: left;"></li>
                                        <span style="float: left;padding-left: 10px;line-height: 30px;">粉色</span>
                                        <span style="float: left;padding-left: 10px;line-height: 30px;">：</span>
                                    </div>

                                    <div class="col-sm-8">
                                        <div class="timeline-body">
                                            <div class="col-sm-2">
                                                <img src="{{asset('images/photo1.png')}}" alt="..." class="margin w100h100">
                                                <button type="button" class="btn btn-block btn-default btn-xs" disabled>已设置为主图</button>
                                            </div>
                                            <div class="col-sm-2">
                                                <img src="{{asset('images/photo1.png')}}" alt="..." class="margin w100h100">
                                                <button type="button" class="btn btn-block btn-primary btn-xs">设置为主图</button>
                                            </div>
                                            <div class="col-sm-2">
                                                <img src="{{asset('images/photo1.png')}}" alt="..." class="margin w100h100">
                                                <button type="button" class="btn btn-block btn-primary btn-xs">设置为主图</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box -->

                    </div>
                    <!-- /.col -->

                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">商品属性：</h3>
                        </div>
                        <div class="box-body">
                            <!-- 第一行 -->
                            <div class="col-lg-12">
                                <div class="form-group col-xs-12">
                                    <div class="col-sm-1">
                                        <label for="inputEmail3" class="col-sm-12 control-label">产地：</label>
                                    </div>

                                    <div class="col-sm-8">
                                        <div class="col-sm-2">
                                            
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group col-xs-12">
                                    <hr>
                                    <div class="col-sm-1">
                                        <li style="background-color: pink;float: left;"></li>
                                        <span style="float: left;padding-left: 10px;line-height: 30px;">粉色</span>
                                        <span style="float: left;padding-left: 10px;line-height: 30px;">：</span>
                                    </div>

                                    <div class="col-sm-8">
                                        <div class="timeline-body">
                                            <div class="col-sm-2">
                                                <img src="{{asset('images/photo1.png')}}" alt="..." class="margin w100h100">
                                                <button type="button" class="btn btn-block btn-default btn-xs" disabled>已设置为主图</button>
                                            </div>
                                            <div class="col-sm-2">
                                                <img src="{{asset('images/photo1.png')}}" alt="..." class="margin w100h100">
                                                <button type="button" class="btn btn-block btn-primary btn-xs">设置为主图</button>
                                            </div>
                                            <div class="col-sm-2">
                                                <img src="{{asset('images/photo1.png')}}" alt="..." class="margin w100h100">
                                                <button type="button" class="btn btn-block btn-primary btn-xs">设置为主图</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box -->

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop