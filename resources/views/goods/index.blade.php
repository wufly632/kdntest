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
                                        <label for="inputEmail3" class="col-sm-3 control-label">商品名称：</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="goods_name" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-3 control-label">商品ID：</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="goods_id" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-3 control-label">商品货号：</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="goods_number" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <!-- 第二行 -->
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-3 control-label">公司名称：</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="company_name" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-3 control-label">商家UID：</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="organization_uid"
                                                   placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <!-- 第三行 -->
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-3 control-label">品牌名：</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="brand_name" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-3 control-label">品牌ID：</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="brand_id" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-3 control-label">商品状态：</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name="goods_status"
                                                    style="width: 100%;">
                                                <option selected="selected">全部</option>
                                                <option>上架</option>
                                                <option>下架</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- 第四行 -->
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-3 control-label">创建时间：</label>
                                        <div class="col-sm-9">
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
                                </div>

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
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>商品图片</th>
                                    <th>商品信息</th>
                                    <th>建议零售价</th>
                                    <th>售价</th>
                                    <th>历史销量</th>
                                    <th>库存数量</th>
                                    <th>商品状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="table-center">
                                        <span class="mailbox-attachment-icon has-img" style="width: 120px;">
                                            <img src="{{asset('/images/photo1.png')}}" alt="Attachment">
                                        </span>
                                    </td>
                                    <td class="table-center">
                                        <span>ID：201808191021310</span><br>
                                        <span>名称：精品儿童童装</span><br>
                                        <span>货号：TZ201809123103</span><br>
                                    </td>
                                    <td class="table-center">
                                        <label for="">￥：</label>399
                                    </td>
                                    <td class="table-center">
                                        <label for="">￥：</label>
                                        99
                                    </td>
                                    <td class="table-center">1239</td>
                                    <td class="table-center">298</td>
                                    <td class="table-center">等待审核</td>
                                    <td class="table-center">
                                        <a href="#">编辑</a>
                                    </td>
                                </tr>
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