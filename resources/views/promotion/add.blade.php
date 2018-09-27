@section('css')
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-modal-bs3patch.css') }}">

    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
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
                                    <table id="coupon_table" class="table table-hover table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>活动时间</td>
                                            <td>活动详情</td>
                                            <td>促销详情</td>
                                            <td>促销范围</td>
                                            <td>货值</td>
                                            <td>库存深度</td>
                                            <td>状态</td>
                                            <td>操作</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>1970-2099</td>
                                            <td>啦啦啦</td>
                                            <td>买一送一</td>
                                            <td>衣服</td>
                                            <td>100</td>
                                            <td>60</td>
                                            <td>进行中</td>
                                            <td>
                                                <div><a href="javascript:void(0);">删除</a></div>
                                            </td>
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
                            <div class="box-header">
                                <div class="form-group">
                                    <label for="time_limit" class="col-xs-2 control-label">活动时间：</label>
                                    <div class="col-xs-2">
                                        <input type="text" name="time_limit" class="form-control" id="time_limit">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="time_prepare" class="col-xs-2 control-label">预热时间：</label>
                                    <div class="col-xs-2">
                                        <div class="input-group">
                                            <input type="text" name="time_prepare" class="form-control"
                                                   id="time_prepare">
                                            <span class="input-group-addon">元</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 text-danger" style="padding-top: 6px;">
                                        (活动开始前，预热时间内，首页显示活动时间、活动名称及活动简介，可不预热。)
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-xs-2 control-label">活动名称：</label>
                                    <div class="col-xs-2">
                                        <input type="text" class="form-control" id="promotion_title"
                                               name="promotion_title">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div for="" class="col-xs-2 text-right">
                                        <b>促销方式：</b>
                                    </div>
                                    <div class="col-xs-10">
                                        <div class="col-xs-1">
                                            <label for="method1" id="method-label1" class="label-inline method_radio">
                                                <input name="promotion_method" class="promotion_method" id="method1"
                                                       type="radio" value="1" checked>满减
                                            </label>
                                        </div>
                                        <div class="col-xs-1">
                                            <label for="method2" id="method-label2" class="label-inline method_radio">
                                                <input name="promotion_method" class="promotion_method" id="method2"
                                                       type="radio" value="2">满返
                                            </label>
                                        </div>
                                        <div class="col-xs-1">
                                            <label for="method3" id="method-label3" class="label-inline method_radio">
                                                <input name="promotion_method" class="promotion_method" id="method3"
                                                       type="radio" value="3">多件多折
                                            </label>
                                        </div>
                                        <div class="col-xs-1">
                                            <label for="method4" id="method-label4" class="label-inline method_radio">
                                                <input name="promotion_method" class="promotion_method" id="method4"
                                                       type="radio" value="4">x元n件
                                            </label>
                                        </div>
                                        <div class="col-xs-1">
                                            <label for="method5" id="method-label5" class="label-inline method_radio">
                                                <input name="promotion_method" class="promotion_method" id="method5"
                                                       type="radio" value="5">买n免一
                                            </label>
                                        </div>
                                        <div class="col-xs-1">
                                            <label for="method6" id="method-label6" class="label-inline method_radio">
                                                <input name="promotion_method" class="promotion_method" id="method6"
                                                       type="radio" value="6">限时特价
                                            </label>
                                        </div>
                                        <div class="col-xs-1">
                                            <label for="method7" id="method-label7" class="label-inline method_radio">
                                                <input name="promotion_method" class="promotion_method" id="method7"
                                                       type="radio" value="7">限量秒杀
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
                                            <td>信息</td>
                                            <td>场价</td>
                                            <td>售价</td>
                                            <td>销量</td>
                                            <td>数量</td>
                                            <td>操作</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div>
                                        <input type="button" class="btn btn-info col-xs-offset-1" value="保存">
                                        <input type="button" class="btn btn-default col-xs-offset-2" value="取消">
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
    <script src="{{ asset('/assets/admin-lte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap-modalmanager.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap-modal.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $('.detail-box').empty().append('<div class="col-xs-2 control-label">活动期间，选购商品满</div>\n' +
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
        $('#method-label1').click(function () {
            $('.detail-box').empty().append('<div class="col-xs-2 control-label">活动期间，选购商品满</div>\n' +
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
            $('.detail-box').empty().append('<div class="col-xs-2 control-label">活动期间，买满</div>\n' +
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
            $('.detail-box').empty().append('<div class="col-xs-2 control-label">\n' +
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
            $('.detail-box').empty().append('<div class="col-xs-2 control-label">\n' +
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
            $('.detail-box').empty().append('<div class="col-xs-2 control-label">\n' +
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
            $('.detail-box').empty().append('<div class="col-xs-3 control-label" style="width: 220px;">\n' +
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
            $('.detail-box').empty().append('<div class="col-xs-1 control-label" style="width: 190px;">\n' +
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
        $('#coupon_table').DataTable({
            language: {
                paginate: {
                    first: '首页',
                    previous: '上一页',
                    next: '下一页',
                    last: '末页'
                },
                aria: {
                    paginate: {
                        first: 'First',
                        previous: 'Previous',
                        next: 'Next',
                        last: 'Last'
                    }
                },
                info: '显示 _START_ 到 _END_ 条，共 _TOTAL_ 条'
            },
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false,
        });
        $('.modal-content').css({'box-shadow': 'none'});
    </script>
@endsection