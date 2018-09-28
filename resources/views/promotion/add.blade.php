@section('css')
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-modal-bs3patch.css') }}">

    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <style>
        .text-padding-top {
            padding-top: 6px;
        }

        .no-padding-left {
            padding-left: 0;
        }

        .image-align-center {
            width: 80px;
            height: 80px;
            line-height: 80px;
        }
        .justify-align-center {
            vertical-align: middle !important;
        }

    </style>
@endsection
@extends('layouts.default')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                添加店铺券
                <small>添加店铺券</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Layout</a></li>
                <li class="active">Fixed</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div id="modal-default" class="modal fade" tabindex="-1" data-width="1200" style="display: none;">
                        <div class="modal-dialog" style="width: 1000px;">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h2 class="text-center">添加商品</h2>
                                    <form action="" class="form-inline">
                                        <div class="form-group">
                                            <label for="">商品名称：</label>
                                            <input type="text" class="form-control" id="">
                                        </div>
                                        <div class="form-group">
                                            <label for="">商品ID：</label>
                                            <input type="text" class="form-control" id="">
                                        </div>
                                        <div class="form-group">
                                            <label for="">商品货号：</label>
                                            <input type="text" class="form-control" id="">
                                        </div>
                                        <input type="button" class="btn pull-right" value="查找">
                                    </form>
                                    <table id="select_coupon_table"
                                           class="table table-hover table-striped table-bordered text-center">
                                        <thead>
                                        <tr>
                                            <td class="text-left"><input type="checkbox"></td>
                                            <td>商品图片</td>
                                            <td>商品信息</td>
                                            <td>市场价</td>
                                            <td>售价</td>
                                            <td>最近30天销量</td>
                                            <td>库存数量</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>啦啦啦</td>
                                            <td style="width: 200px;">
                                                <div>
                                                    <div class="col-xs-5 text-right">ID：</div>
                                                    <div class="col-xs-7 text-left">396</div>
                                                </div>
                                                <div>
                                                    <div class="col-xs-5 text-right">名称：</div>
                                                    <div class="col-xs-7 text-left">test</div>
                                                </div>
                                                <div>
                                                    <div class="col-xs-5 text-right">货号：</div>
                                                    <div class="col-xs-7 text-left">123</div>
                                                </div>
                                            </td>
                                            <td>买一送一</td>
                                            <td>衣服</td>
                                            <td>100</td>
                                            <td>60</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <div>
                                        <input type="button" class="btn btn-success" value="添加店铺所有商品">
                                        <input type="button" class="btn btn-danger pull-right" value="取消">
                                        <input type="button" class="btn btn-success pull-right" value="确认添加">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box box-info">
                        <form action="" method="post" class="form-horizontal">
                            {{ csrf_field() }}
                            <div class="box-header">
                                <div class="form-group">
                                    <label for="activity_time" class="col-xs-2 control-label">活动时间：</label>
                                    <div class="col-xs-2">
                                        <input type="text" name="activity_time" class="form-control" id="activity_time">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="prepare_time" class="col-xs-2 control-label">预热时间：</label>
                                    <div class="col-xs-2">
                                        <div class="input-group">
                                            <input type="text" name="pre_time" class="form-control"
                                                   id="prepare_time">
                                            <span class="input-group-addon">天</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 text-danger text-padding-top">
                                        (活动开始前，预热时间内，首页显示活动时间、活动名称及活动简介，可不预热。)
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-xs-2 control-label">活动名称：</label>
                                    <div class="col-xs-2">
                                        <input type="text" class="form-control" id="promotion_title"
                                               name="title">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-2 text-right">
                                        <b>促销方式：</b>
                                    </div>
                                    <div class="col-xs-10">
                                        <div class="col-xs-1">
                                            <label for="method1" id="method-label1" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method1"
                                                       type="radio" value="reduce" checked>满减
                                            </label>
                                        </div>
                                        <div class="col-xs-1">
                                            <label for="method2" id="method-label2" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method2"
                                                       type="radio" value="return">满返
                                            </label>
                                        </div>
                                        <div class="col-xs-1">
                                            <label for="method3" id="method-label3" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method3"
                                                       type="radio" value="discount">多件多折
                                            </label>
                                        </div>
                                        <div class="col-xs-1">
                                            <label for="method4" id="method-label4" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method4"
                                                       type="radio" value="wholesale">x元n件
                                            </label>
                                        </div>
                                        <div class="col-xs-1">
                                            <label for="method5" id="method-label5" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method5"
                                                       type="radio" value="onefree">买n免一
                                            </label>
                                        </div>
                                        <div class="col-xs-1">
                                            <label for="method6" id="method-label6" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method6"
                                                       type="radio" value="limit">限时特价
                                            </label>
                                        </div>
                                        <div class="col-xs-1">
                                            <label for="method7" id="method-label7" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method7"
                                                       type="radio" value="quantity">限量秒杀
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-info col-xs-10 col-xs-offset-1">
                                    <div class="panel-body">
                                        <div class="detail-box row col-xs-offset-1 with-border">

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="box-body">
                                <div class="col-xs-offset-1 col-xs-10">
                                    <div><span class="h2">活动商品</span>
                                        <button class="btn btn-default pull-right" data-toggle="modal"
                                                data-target="#modal-default">添加商品
                                        </button>
                                    </div>
                                    <div class="form-inline" style="padding-top: 20px;padding-bottom: 40px;">
                                        <div class="col-xs-3 no-padding-left">
                                            <label for="">商品名称：</label>
                                            <input type="text" class="form-control" id="">
                                        </div>
                                        <div class="col-xs-3">
                                            <label for="">商品ID：</label>
                                            <input type="text" class="form-control" id="">
                                        </div>
                                        <div class="col-xs-3">
                                            <label for="">商品货号：</label>
                                            <input type="text" class="form-control" id="">
                                        </div>
                                        <div class="col-xs-1">
                                            <input type="button" class="btn btn-success" value="查找">
                                        </div>
                                    </div>
                                    <table id="coupon_table" class="table table-bordered table-hover text-center">
                                        <thead>
                                        <tr>
                                            <td>商品图片</td>
                                            <td>商品信息</td>
                                            <td>市场价</td>
                                            <td>售价</td>
                                            <td>最近30天销量</td>
                                            <td>库存数量</td>
                                            <td>操作</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>图片</td>
                                            <td style="width: 200px;">
                                                <div>
                                                    <div class="col-xs-5 text-right">ID：</div>
                                                    <div class="col-xs-7 text-left">396</div>
                                                </div>
                                                <div>
                                                    <div class="col-xs-5 text-right">名称：</div>
                                                    <div class="col-xs-7 text-left">test</div>
                                                </div>
                                                <div>
                                                    <div class="col-xs-5 text-right">货号：</div>
                                                    <div class="col-xs-7 text-left">123</div>
                                                </div>
                                            </td>
                                            <td>¥20.00起</td>
                                            <td>¥10.00起</td>
                                            <td>35900</td>
                                            <td>20</td>
                                            <td>
                                                <div><a href="javascript:void(0);">删除</a></div>
                                                <div class="set_promotion"><a href="javascript:void(0);">设置优惠</a></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <table class="table table-bordered text-center">
                                                    <tr>
                                                        <td colspan="8" class="row">
                                                            <div class="goods_image image-align-center col-xs-1 no-padding">
                                                                <img src="http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg"
                                                                     width="80px" height="80px" alt=""></div>
                                                            <div class="col-xs-10 text-left">
                                                                <div class="good_name text-padding-top row">
                                                                    <div class="col-xs-1 text-right">名称：</div>
                                                                    <div class="col-xs-1 text-left">test</div></div>
                                                                <div class="good_id text-padding-top row" style="vertical-align: middle">
                                                                    <div class="col-xs-1 text-right text-padding-top">ID：</div>
                                                                    <div class="col-xs-1 text-left text-padding-top">292</div>
                                                                    <div class="good_num text-padding-top text-danger col-xs-2">
                                                                        最近30天销量
                                                                    </div>
                                                                    <div class="col-xs-6 col-xs-offset-2">
                                                                        <div class="col-xs-2 text-padding-top" style="padding-right: 0">每人限购</div>
                                                                        <div class="col-xs-5">
                                                                            <div class="input-group">
                                                                                <select name="" id="" class="form-control">
                                                                                    <option value="">不限</option>
                                                                                    <option value="">1</option>
                                                                                    <option value="">2</option>
                                                                                    <option value="">3</option>
                                                                                </select>
                                                                                <span class="input-group-addon">件</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xs-4">
                                                                            <input type="button" class="btn btn-success" value="一键设置">
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </td>
                                                        <td rowspan="4" class="justify-align-center">删除</td>
                                                    </tr>
                                                    <tr>
                                                        <td>颜色</td>
                                                        <td>尺寸</td>
                                                        <td>市场价</td>
                                                        <td>零售价</td>
                                                        <td><span class="text-danger">*</span> 秒杀价</td>
                                                        <td><span class="text-danger">*</span> 秒杀数量</td>
                                                        <td>库存数量</td>
                                                        <td>商家编码</td>
                                                    </tr>
                                                    <tr>
                                                        <td>蓝色</td>
                                                        <td>28</td>
                                                        <td>￥120</td>
                                                        <td>￥23</td>
                                                        <td class="col-xs-2"><input type="text" class="form-control">
                                                        </td>
                                                        <td class="col-xs-2" rowspan="2" style="padding-top: 30px;">
                                                            <input type="text" class="form-control"></td>
                                                        <td>2000</td>
                                                        <td>2000</td>
                                                    </tr>
                                                    <tr>
                                                        <td>蓝色</td>
                                                        <td>28</td>
                                                        <td>￥120</td>
                                                        <td>￥23</td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td>2000</td>
                                                        <td>2000</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div>
                                        <input type="button" class="btn btn-success col-xs-offset-4" value="保存">
                                        <input type="button" class="btn btn-danger col-xs-offset-2" value="取消">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script src="{{ asset('/assets/admin-lte/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap-modalmanager.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap-modal.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugincommon.js') }}"></script>
    <script>
        $('.detail-box').empty().append('<div class="col-xs-2 text-padding-top">活动期间，选购商品满</div>\n' +
            '                                    <div class="col-xs-2">\n' +
            '                                        <div class="input-group">\n' +
            '                                            <input type="text" class="form-control">\n' +
            '                                            <span class="input-group-addon">元</span>\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '                                    <div class="col-xs-1 text-padding-top">，立减</div>\n' +
            '                                    <div class="col-xs-2">\n' +
            '                                        <div class="input-group">\n' +
            '                                            <input type="text" class="form-control">\n' +
            '                                            <span class="input-group-addon">元</span>\n' +
            '                                        </div>\n' +
            '                                    </div>');
        $('#method-label1').click(function () {
            $('.detail-box').empty().append('<div class="col-xs-2 text-padding-top">活动期间，选购商品满</div>\n' +
                '                                    <div class="col-xs-2">\n' +
                '                                        <div class="input-group">\n' +
                '                                            <input type="text" class="form-control">\n' +
                '                                            <span class="input-group-addon">元</span>\n' +
                '                                        </div>\n' +
                '                                    </div>\n' +
                '                                    <div class="col-xs-1 control-label">，立减</div>\n' +
                '                                    <div class="col-xs-2">\n' +
                '                                        <div class="input-group">\n' +
                '                                            <input type="text" class="form-control">\n' +
                '                                            <span class="input-group-addon">元</span>\n' +
                '                                        </div>\n' +
                '                                    </div>');

        });
        $('#method-label2').click(function () {
            $('.detail-box').empty().append('<div class="col-xs-2 text-padding-top">活动期间，买满</div>\n' +
                '                                    <div class="col-xs-2">\n' +
                '                                        <div class="input-group">\n' +
                '                                            <input type="text" class="form-control">\n' +
                '                                            <span class="input-group-addon">元</span>\n' +
                '                                        </div>\n' +
                '                                    </div>\n' +
                '                                    <div class="col-xs-1 control-label" style="width: 40px;padding-left: 0;padding-right: 0">，返</div>\n' +
                '                                    <div class="col-xs-2">\n' +
                '                                        <select name="" id="" class="form-control">\n' +
                '                                            <option value="">券</option>\n' +
                '                                        </select>\n' +
                '                                    </div>');

        });
        $('#method-label3').click(function () {
            $('.detail-box').empty().append('<div class="col-xs-2 text-padding-top">\n' +
                '                                        活动期间，选购商品满\n' +
                '                                    </div>\n' +
                '                                    <div class="col-xs-2">\n' +
                '                                        <div class="input-group">\n' +
                '                                            <input type="text" class="form-control">\n' +
                '                                            <span class="input-group-addon">件</span>\n' +
                '                                        </div>\n' +
                '                                    </div>\n' +
                '                                    <div class="col-xs-1 control-label">\n' +
                '                                        ，立享\n' +
                '                                    </div>\n' +
                '                                    <div class="col-xs-2">\n' +
                '                                        <div class="input-group">\n' +
                '                                            <input type="text" class="form-control">\n' +
                '                                            <span class="input-group-addon">折</span>\n' +
                '                                        </div>\n' +
                '                                    </div>');

        });
        $('#method-label4').click(function () {
            $('.detail-box').empty().append('<div class="col-xs-2 text-padding-top">\n' +
                '                                                活动期间\n' +
                '                                            </div>\n' +
                '                                            <div class="col-xs-2">\n' +
                '                                                <div class="input-group">\n' +
                '                                                    <input type="text" class="form-control">\n' +
                '                                                    <span class="input-group-addon">元</span>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                            <div class="col-xs-1 control-label">\n' +
                '                                                任选\n' +
                '                                            </div>\n' +
                '                                            <div class="col-xs-2">\n' +
                '                                                <div class="input-group">\n' +
                '                                                    <input type="text" class="form-control">\n' +
                '                                                    <span class="input-group-addon">件</span>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                            <div class="col-xs-1 control-label">活动商品</div>');

        });
        $('#method-label5').click(function () {
            $('.detail-box').empty().append('<div class="col-xs-2 text-padding-top">\n' +
                '                                                活动期间，选购商品满\n' +
                '                                            </div>\n' +
                '                                            <div class="col-xs-2">\n' +
                '                                                <div class="input-group">\n' +
                '                                                    <input type="text" class="form-control">\n' +
                '                                                    <span class="input-group-addon">\n' +
                '                                                        件\n' +
                '                                                    </span>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                            <div class="col-xs-3 control-label">\n' +
                '                                                ，免其中价格最低的一件\n' +
                '                                            </div>');

        });
        $('#method-label6').click(function () {
            $('.detail-box').empty().append('<div class="col-xs-3 text-padding-top">\n' +
                '                                                活动期间，购买活动商品统一\n' +
                '                                            </div>\n' +
                '                                            <div class="col-xs-2">\n' +
                '                                                <select name="" id="" class="form-control">\n' +
                '                                                    <option value="1">立享</option>\n' +
                '                                                    <option value="2">立减</option>\n' +
                '                                                </select>\n' +
                '                                            </div>\n' +
                '                                            <div class="col-xs-2">\n' +
                '                                                <div class="input-group">\n' +
                '                                                    <input type="text" class="form-control">\n' +
                '                                                    <span class="input-group-addon">元</span>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                            <div class="col-xs-1 control-label">\n' +
                '                                                每人限购\n' +
                '                                            </div>\n' +
                '                                            <div class="col-xs-2">\n' +
                '                                                <div class="input-group">\n' +
                '                                                    <select name="" id="" class="form-control">\n' +
                '                                                        <option value="">不限</option>\n' +
                '                                                        <option value="">1</option>\n' +
                '                                                        <option value="">2</option>\n' +
                '                                                        <option value="">3</option>\n' +
                '                                                        <option value="">4</option>\n' +
                '                                                        <option value="">5</option>\n' +
                '                                                    </select>\n' +
                '                                                    <span class="input-group-addon">件</span>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                            <input type="button" class="btn" value="确定">\n' +
                '                                            <div class="text-info" style="padding: 6px;padding-left: 24px;">\n' +
                '                                                注：可在添加商品时针对每个商品分别设置优惠力度。\n' +
                '                                            </div>');

        });
        $('#method-label7').click(function () {
            $('.detail-box').empty().append('<div class="col-xs-2 text-padding-top">\n' +
                '                                                活动期间，活动商品统一\n' +
                '                                            </div>\n' +
                '                                            <div class="col-xs-2 no-padding" style="width: 90px;">\n' +
                '                                                <select name="" id="" class="form-control">\n' +
                '                                                    <option value="">价格</option>\n' +
                '                                                    <option value="">折扣</option>\n' +
                '                                                </select>\n' +
                '                                            </div>\n' +
                '                                            <div class="col-xs-2 no-padding" style="width: 90px;">\n' +
                '                                                <div class="input-group">\n' +
                '                                                    <input type="text" class="form-control">\n' +
                '                                                    <span class="input-group-addon">元</span>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                            <div class="col-xs-1 control-label" style="width: 110px;">， 秒杀库存</div>\n' +
                '                                            <div class="col-xs-1" style="width: 110px;">\n' +
                '                                                <div class="input-group">\n' +
                '                                                    <input type="text" class="form-control">\n' +
                '                                                    <span class="input-group-addon">件</span>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '\n' +
                '                                            <div class="col-xs-2 text-danger">\n' +
                '                                                (不设置件数即为当前库存均用于秒杀)\n' +
                '                                            </div>\n' +
                '                                            <div class="col-xs-1 control-label"  style="width: 110px;">每人限购件</div>\n' +
                '                                            <div class="col-xs-2 no-padding">\n' +
                '                                                <select name="" id="" class="form-control" style="width: 90px;">\n' +
                '                                                    <option value="">不限</option>\n' +
                '                                                    <option value="">1</option>\n' +
                '                                                    <option value="">2</option>\n' +
                '                                                    <option value="">3</option>\n' +
                '                                                    <option value="">4</option>\n' +
                '                                                    <option value="">5</option>\n' +
                '                                                </select>\n' +
                '                                            </div>\n' +
                '\n' +
                '                                            <div class="col-xs-12">\n' +
                '                                                <div class="text-left col-xs-4 text-info" style="padding: 10px 5px;">注：可在添加商品时针对每个商品分别设置优惠力度。</div>\n' +
                '                                                <input type="button" class="btn col-xs-offset-6" value="确定">\n' +
                '                                            </div>');

        });
        addDateRangePicker($('#activity_time'));
        createDataTable($('#select_coupon_table'));
        $('.modal-content').css({'box-shadow': 'none'});
    </script>
@endsection