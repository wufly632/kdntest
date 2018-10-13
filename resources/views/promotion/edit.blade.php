@section('css')
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-modal-bs3patch.css') }}">

    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('/assets/admin-/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
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
        .promotion_type {margin-right: 15px;}
        .box-header .col-xs-1{width: 10%;}
        .dis-no{display: none;}
        .addcontain{height: 35px;}
        .add-row{margin-top: 10px;}
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
                    <div id="myModal-one" class="modal fade" tabindex="-1" data-width="1200" style="display: none;">
                        <form class="seckill-modal" method="get" onsubmit="return getGoods(this);" action="{{secure_route('promotion.getGoods')}}">
                            {!! $promotion_goods !!}
                        </form>
                    </div>
                    <div class="box box-info">
                        <form id="promotion-form" method="post" class="form-horizontal">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$promotion->id}}">
                            <div class="box-header">
                                <div class="form-group">
                                    <label for="promotion_time" class="col-xs-1 control-label">活动时间：</label>
                                    <div class="col-xs-3">
                                        <input type="text" name="promotion_time" class="form-control" id="promotion_time" value="{{$promotion->start_at.'~'.$promotion->end_at}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="prepare_time" class="col-xs-1 control-label">预热时间：</label>
                                    <div class="col-xs-2">
                                        <div class="input-group">
                                            <input type="text" name="pre_time" class="form-control"
                                                   id="prepare_time" value="{{$promotion->pre_time}}">
                                            <span class="input-group-addon">天</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 text-danger text-padding-top">
                                        (活动开始前，预热时间内，首页显示活动时间、活动名称及活动简介，可不预热。)
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-xs-1 control-label">活动名称：</label>
                                    <div class="col-xs-2">
                                        <input type="text" class="form-control" id="promotion_title"
                                               name="title" value="{{$promotion->title}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-1 text-right">
                                        <b>促销方式：</b>
                                    </div>
                                    <div class="col-xs-10">
                                        <span class="promotion_type">
                                            <label for="method1" id="method-label1" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method1"
                                                       type="radio" value="reduce" checked>满减
                                            </label>
                                        </span>
                                        <span class="promotion_type">
                                            <label for="method2" id="method-label2" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method2"
                                                       type="radio" value="return">满返
                                            </label>
                                        </span>
                                        <span class="promotion_type">
                                            <label for="method3" id="method-label3" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method3"
                                                       type="radio" value="discount">多件多折
                                            </label>
                                        </span>
                                        <span class="promotion_type">
                                            <label for="method4" id="method-label4" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method4"
                                                       type="radio" value="wholesale">x元n件
                                            </label>
                                        </span>
                                        <span class="promotion_type">
                                            <label for="method5" id="method-label5" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method5"
                                                       type="radio" value="give">买n免一
                                            </label>
                                        </span>
                                        <span class="promotion_type">
                                            <label for="method6" id="method-label6" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method6"
                                                       type="radio" value="limit">限时特价
                                            </label>
                                        </span>
                                        <span class="promotion_type">
                                            <label for="method7" id="method-label7" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method7"
                                                       type="radio" value="quantity">限量秒杀
                                            </label>
                                        </span>
                                    </div>
                                </div>
                                <div class="panel panel-info col-xs-offset-1 col-xs-10">
                                    <div class="panel-body">
                                        <div class="detail-box row with-border">
                                            <div class="@if($promotion->activity_type != 'reduce' && $promotion->activity_type) hidden @endif detail reduce-detail">
                                                <div class="reduce-detail-row addcontain">
                                                    <div class="pull-left text-padding-top">活动期间，买满</div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="reduce_name[]">
                                                            <span class="input-group-addon">元</span>
                                                        </div>
                                                    </div>
                                                    <div class="pull-left text-padding-top" style="width: 60px;padding-left: 0;padding-right: 0">，立减</div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="reduce_value[]">
                                                            <span class="input-group-addon">元</span>
                                                        </div>
                                                    </div>
                                                    <button id="add-reduce-detail" type="button" class="btn btn-primary btn-flat icon-add" style="border-radius: 90px;">+</button>
                                                </div>
                                                <div class="reduce-detail-row add-row dis-no">
                                                    <div class="pull-left text-padding-top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;满</div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="reduce_name[]">
                                                            <span class="input-group-addon">元</span>
                                                        </div>
                                                    </div>
                                                    <div class="pull-left text-padding-top" style="width: 60px;padding-left: 0;padding-right: 0">，立减</div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="reduce_value[]">
                                                            <span class="input-group-addon">元</span>
                                                        </div>
                                                    </div>
                                                    <button id="add-reduce-detail" type="button" class="btn btn-primary btn-flat icon-minus" style="border-radius: 90px;">-</button>
                                                </div>
                                            </div>
                                            <div class="@if($promotion->activity_type != 'return') hidden @endif detail return-detail">
                                                <div class="return-detail-row">
                                                    <div class="pull-left text-padding-top">活动期间，买满</div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control">
                                                            <span class="input-group-addon">元</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-1 control-label" style="width: 40px;padding-left: 0;padding-right: 0">，返</div>
                                                    <div class="col-xs-2">
                                                        <select name="" id="" class="form-control">
                                                            <option value="">券</option>
                                                        </select>
                                                    </div>
                                                    <button id="add-return-detail" type="button" class="btn btn-primary btn-flat icon-add" style="border-radius: 90px;">+</button>
                                                </div>
                                            </div>
                                            <div class="@if($promotion->activity_type != 'discount') hidden @endif detail discount-detail">
                                                <div class="discount-detail-row addcontain">
                                                    <div class="pull-left text-padding-top">
                                                        活动期间，选购商品满
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="discount_name[]">
                                                            <span class="input-group-addon">件</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-1 control-label">
                                                        ，立享
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="discount_value[]">
                                                            <span class="input-group-addon">折</span>
                                                        </div>
                                                    </div>
                                                    <button id="add-discount-detail" type="button" class="btn btn-primary btn-flat icon-add" style="border-radius: 90px;">+</button>
                                                </div>
                                                <div class="discount-detail-row add-row dis-no">
                                                    <div class="pull-left text-padding-top">
                                                        　　　　　　　　　满
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="discount_name[]">
                                                            <span class="input-group-addon">件</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-1 control-label">
                                                        ，立享
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="discount_value[]">
                                                            <span class="input-group-addon">折</span>
                                                        </div>
                                                    </div>
                                                    <button id="add-discount-detail" type="button" class="btn btn-primary btn-flat icon-minus" style="border-radius: 90px;">-</button>
                                                </div>
                                            </div>

                                            <div class="@if($promotion->activity_type != 'wholesale') hidden @endif detail wholesale-detail">
                                                <div class="pull-left text-padding-top">
                                                    活动期间
                                                </div>
                                                <div class="col-xs-2">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="wholesale_name[]">
                                                        <span class="input-group-addon">元</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-1 control-label">
                                                    任选
                                                </div>
                                                <div class="col-xs-2">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="wholesale_value[]">
                                                        <span class="input-group-addon">件</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-1 control-label">活动商品</div></div>
                                            <div class="@if($promotion->activity_type != 'give') hidden @endif detail give-detail">
                                                <div class="pull-left text-padding-top">
                                                    活动期间，选购商品满
                                                </div>
                                                <div class="col-xs-2">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control">
                                                        <span class="input-group-addon">
                                                        件
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-3 control-label">
                                                    ，免其中价格最低的一件
                                                </div></div>
                                            <div class="@if($promotion->activity_type != 'limit') hidden @endif detail limit-detail">
                                                <div class="pull-left text-padding-top">
                                                    活动期间，购买活动商品统一
                                                </div>
                                                <div class="col-xs-2">
                                                    <select name="" id="" class="form-control">
                                                        <option value="1">立享</option>
                                                        <option value="2">立减</option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-2">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control">
                                                        <span class="input-group-addon">元</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-1 control-label">
                                                    每人限购
                                                </div>
                                                <div class="col-xs-2">
                                                    <div class="input-group">
                                                        <select name="" id="" class="form-control">
                                                            <option value="">不限</option>
                                                            <option value="">1</option>
                                                            <option value="">2</option>
                                                            <option value="">3</option>
                                                            <option value="">4</option>
                                                            <option value="">5</option>
                                                        </select>
                                                        <span class="input-group-addon">件</span>
                                                    </div>
                                                </div>
                                                <input type="button" class="btn" value="确定">
                                                <div class="text-info" style="padding: 6px;padding-left: 24px;">
                                                    注：可在添加商品时针对每个商品分别设置优惠力度。
                                                </div>
                                            </div>
                                            <div class="@if($promotion->activity_type != 'quantity') hidden @endif detail quantity-detail">
                                                <div class="pull-left text-padding-top">
                                                    活动期间，活动商品统一
                                                </div>
                                                <div class="col-xs-2 no-padding" style="width: 90px;">
                                                    <select name="" id="" class="form-control">
                                                        <option value="">价格</option>
                                                        <option value="">折扣</option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-2 no-padding" style="width: 90px;">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control">
                                                        <span class="input-group-addon">元</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-1 control-label" style="width: 110px;">， 秒杀库存</div>
                                                <div class="col-xs-1" style="width: 110px;">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control">
                                                        <span class="input-group-addon">件</span>
                                                    </div>
                                                </div>

                                                <div class="col-xs-2 text-danger">
                                                    (不设置件数即为当前库存均用于秒杀)
                                                </div>
                                                <div class="col-xs-1 control-label" style="width: 110px;">每人限购件</div>
                                                <div class="col-xs-2 no-padding">
                                                    <select name="" id="" class="form-control" style="width: 90px;">
                                                        <option value="">不限</option>
                                                        <option value="">1</option>
                                                        <option value="">2</option>
                                                        <option value="">3</option>
                                                        <option value="">4</option>
                                                        <option value="">5</option>
                                                    </select>
                                                </div>

                                                <div class="col-xs-12">
                                                    <div class="text-left col-xs-4 text-info" style="padding: 10px 5px;">注：可在添加商品时针对每个商品分别设置优惠力度。</div>
                                                    <input type="button" class="btn col-xs-offset-6" value="确定">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="box-body">
                                <div class="col-xs-12">
                                    <div><span class="h2">活动商品</span>
                                        <button type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#myModal-one">添加商品
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
                                    <hr>
                                    <table id="promotion_good_table" class="table table-bordered table-hover text-center">
                                        <thead>
                                        <tr>
                                            <td>商品图片</td>
                                            <td>商品信息</td>
                                            <td>采购价</td>
                                            <td>供应价</td>
                                            <td>最近30天销量</td>
                                            <td>库存数量</td>
                                            <td>操作</td>
                                        </tr>
                                        </thead>
                                        <tbody class="tableTbody">

                                        </tbody>
                                    </table>
                                    <div>
                                        <input type="button" class="btn btn-success col-xs-offset-4 submit" value="保存">
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
        $(function () {
            $('input[name=activity_type]').change(function () {
                var val = $(this).val();
                $('.detail-box').find('.detail').addClass('hidden');
                $('.detail-box').find('.'+val+'-detail').removeClass('hidden');
            });
        });
        addDateRangePicker($('#promotion_time'));
        createDataTable($('#select_coupon_table'));
        $('.modal-content').css({'box-shadow': 'none'});
        let tableLevelTwo = '<tr class="table-level-two">\n' +
            '        <td colspan="7">\n' +
            '            <table class="table table-bordered text-center">\n' +
            '            <tr>\n' +
            '            <td colspan="8" class="row">\n' +
            '            <div class="goods_image image-align-center col-xs-1 no-padding">\n' +
            '            <img src="http://localhost/assets/admin-lte//dist/img/user2-160x160.jpg"\n' +
            '        width="80px" height="80px" alt=""></div>\n' +
            '            <div class="col-xs-10 text-left">\n' +
            '            <div class="good_name text-padding-top row">\n' +
            '            <div class="col-xs-1 text-right">名称：</div>\n' +
            '        <div class="col-xs-1 text-left">test</div></div>\n' +
            '        <div class="good_id text-padding-top row" style="vertical-align: middle">\n' +
            '            <div class="col-xs-1 text-right text-padding-top">ID：</div>\n' +
            '        <div class="col-xs-1 text-left text-padding-top">292</div>\n' +
            '            <div class="good_num text-padding-top text-danger col-xs-2">\n' +
            '            最近30天销量\n' +
            '            </div>\n' +
            '            <div class="col-xs-6 col-xs-offset-2">\n' +
            '            <div class="col-xs-2 text-padding-top" style="padding-right: 0">每人限购</div>\n' +
            '            <div class="col-xs-5">\n' +
            '            <div class="input-group">\n' +
            '            <select name="" id="" class="form-control">\n' +
            '            <option value="">不限</option>\n' +
            '            <option value="">1</option>\n' +
            '            <option value="">2</option>\n' +
            '            <option value="">3</option>\n' +
            '            </select>\n' +
            '            <span class="input-group-addon">件</span>\n' +
            '            </div>\n' +
            '            </div>\n' +
            '            <div class="col-xs-4">\n' +
            '            <input type="button" class="btn btn-success" value="一键设置">\n' +
            '            </div>\n' +
            '            </div>\n' +
            '\n' +
            '            </div>\n' +
            '\n' +
            '            </div>\n' +
            '            </td>\n' +
            '            <td rowspan="4" class="justify-align-center">删除</td>\n' +
            '            </tr>\n' +
            '            <tr>\n' +
            '            <td>颜色</td>\n' +
            '            <td>尺寸</td>\n' +
            '            <td>市场价</td>\n' +
            '            <td>零售价</td>\n' +
            '            <td><span class="text-danger">*</span> 秒杀价</td>\n' +
            '        <td><span class="text-danger">*</span> 秒杀数量</td>\n' +
            '        <td>库存数量</td>\n' +
            '        <td>商家编码</td>\n' +
            '        </tr>\n' +
            '        <tr>\n' +
            '        <td>蓝色</td>\n' +
            '        <td>28</td>\n' +
            '        <td>￥120</td>\n' +
            '        <td>￥23</td>\n' +
            '        <td class="col-xs-2"><input type="text" class="form-control">\n' +
            '            </td>\n' +
            '            <td class="col-xs-2" rowspan="2" style="padding-top: 30px;">\n' +
            '            <input type="text" class="form-control"></td>\n' +
            '            <td>2000</td>\n' +
            '            <td>2000</td>\n' +
            '            </tr>\n' +
            '            <tr>\n' +
            '            <td>蓝色</td>\n' +
            '            <td>28</td>\n' +
            '            <td>￥120</td>\n' +
            '            <td>￥23</td>\n' +
            '            <td><input type="text" class="form-control"></td>\n' +
            '            <td>2000</td>\n' +
            '            <td>2000</td>\n' +
            '            </tr>\n' +
            '            </table>\n' +
            '            </td>\n' +
            '            </tr>';
        let newTable = $(tableLevelTwo);
        $('.set_promotion').click(function () {
            let thisParent = $(this).parents('.table-level-one');
            console.log(thisParent.next().hasClass('table-level-two'));
            if (thisParent.next().hasClass('table-level-two')) {
                thisParent.next().remove();
            } else {
                $(this).parents('.table-level-one').after(newTable);
            }
        });

        //添加促销商品
        $('#myModal-one').on('click', '.submit', function (event) {
            var event = event || window.event;
            event.preventDefault(); // 兼容标准浏览器
            window.event.returnValue = false; // 兼容IE6~8
           var _index = $(this);
           var id = [];
           var type = $('input[name=activity_type]:checked').val();
           $('.good-id').each(function () {
               if ($(this).is(':checked')) {
                   id.push($(this).val());
               }
           });
           if (id.length == 0) {
               toastr.error('请先选择促销商品');
               return false;
           }
            $.ajax({
                type:'post',
                url:"{{secure_route('promotion.add.goodPost')}}",
                data:{'good_id': id.join(','),'_token': "{{csrf_token()}}", 'activity_id': "{{$promotion->id}}", type:type},
                beforeSend:function() {
                    _index.attr('disabled', true);
                    _index.html('添加中...');
                },
                success:function(data){
                    console.log(data);
                    if (data.status == 200) {
                        if(type == 'quantity' || type == 'limit'){
                            $('#promotion-activity-type1').append(data.msg);
                        }else{
                            var html = '';
                            var data_content = data.content.goods;
                            console.log(data_content);
                            for (var i in data_content) {
                                html += '<tr class="table-level-one">\n' +
                                    '                                <td>\n' +
                                    '                                <img src="'+data_content[i].main_pic+'" alt="" width="100px" height="100px">\n' +
                                    '                                </td>\n' +
                                    '                                <td style="width: 200px;">\n' +
                                    '                                <div>\n' +
                                    '                                <div class="col-xs-5 text-right">ID：</div>\n' +
                                    '                            <div class="col-xs-7 text-left">'+data_content[i].id+'</div>\n' +
                                    '                                </div>\n' +
                                    '                                <div>\n' +
                                    '                                <div class="col-xs-5 text-right">名称：</div>\n' +
                                    '                            <div class="col-xs-7 text-left">'+data_content[i].good_title+'</div>\n' +
                                    '                                </div>\n' +
                                    '                                <div>\n' +
                                    '                                <div class="col-xs-5 text-right">货号：</div>\n' +
                                    '                            <div class="col-xs-7 text-left">'+data_content[i].good_code+'</div>\n' +
                                    '                                </div>\n' +
                                    '                                </td>\n' +
                                    '                                <td>'+data_content[i].stock_price+'起</td>\n' +
                                    '                                <td>¥'+data_content[i].supply_price+'起</td>\n' +
                                    '                                <td>'+data_content[i].orders+'</td>\n' +
                                    '                                <td>'+data_content[i].good_stock+'</td>\n' +
                                    '                                <td>\n' +
                                    '                                <div><a href="javascript:void(0);" class="promotion-goods-delete" data-id="'+data_content[i].id+'">删除</a></div>\n' +
                                    '                            <div class="set_promotion"><a href="javascript:void(0);">设置优惠</a></div>\n' +
                                    '                            </td>\n' +
                                    '                            </tr>';
                            }
                            $('#promotion_good_table').find('.tableTbody').append(html);
                        }
                        getGoods($('#myModal-one').find('form'));
                        $('#myModal-one').modal('hide');
                    } else {
                        toastr.error(data.msg);
                        _index.removeAttr('disabled');
                    }
                },
                error:function(data){

                }
            })
        });
        $(function () {
            $(".detail-box").on("click",'.icon-add', function(){
                $(this).addClass("dis-no");
                var rowclass=$(this).parent().next(".add-row");
                rowclass.removeClass("dis-no");
                // $(".seckill .se-sale").css("height","189px");
            });
            $(".detail-box").on("click", '.icon-minus', function(){
                var minushtml=$(this).parent();
                var adclass=$(this).parent().prev(".addcontain").children(".icon-add");
                $(this).parent('.add-row').find('input').val('');
                adclass.removeClass("dis-no");
                minushtml.addClass("dis-no");
                // $(".seckill .se-sale").css("height","140px");
            });
            $('#myModal-one').on('click', 'ul li a', function(){
                var url = $(this).attr('href');
                if(url.indexOf('http://') == -1) return false;
                getGoods('', url);
                return false;
            });
            $('#promotion-form').on('click', '.submit', function (event) {
                var _index = $(this);
                $.ajax({
                    type:'post',
                    url:"{{secure_route('promotion.editPost')}}",
                    data:$('#promotion-form').serialize(),
                    beforeSend:function() {
                        _index.attr('disabled', true);
                        _index.text('保存中...');
                    },
                    success:function(data){
                        console.log(data);
                        if (data.status == 200) {
                            toastr.success(data.content);
                            window.location.href = "{{secure_route('promotion.index')}}";
                        } else {
                            toastr.error(data.msg);
                            _index.attr('disabled', false);
                            _index.text('保存');
                        }
                    },
                    error:function(data){
                        var json=eval("("+data.responseText+")");
                        toastr.error(json.msg);
                        _index.attr('disabled', false);
                        _index.text('保存');
                    }
                })
            });
            $('#promotion_good_table').on('click', '.promotion-goods-delete', function () {
                if(confirm("确定要删除活动商品吗？")){
                    var activity_id = $('input[name=id]').val();
                    var _this = $(this);
                    var good_id = _this.data('id');
                    $.ajax({
                        type:'post',
                        data:{activity_id:activity_id, good_id:good_id,_token:"{{csrf_token()}}"},
                        url:"{{secure_route('promotion.good.delete')}}",
                        beforeSend: function() {
                            _this.attr('disabled', true);
                        },
                        success:function(data){
                            if (data.status == 200) {
                                if(_this.parents('#promotion-activity-type1').length > 0){
                                    _this.parents('table').remove();
                                }else{
                                    var addtable = _this.parents('tr').next().find('.add_Table');
                                    if(addtable.length > 0){
                                        addtable.remove();
                                    }
                                    _this.parents('tr').remove();
                                }
                                getGoods($('#myModal-one').find('form'));
                                $('#myModal-one').modal('hide');
                            } else {
                                toastr.error(data.msg);
                                _this.removeAttr('disabled');
                            }
                            /*var d = JSON.parse(d);
                            if(d.status){
                                if(_this.parents('#promotion-activity-type1').length > 0){
                                    _this.parents('table').remove();
                                }else{
                                    var addtable = _this.parents('tr').next().find('.add_Table');
                                    if(addtable.length > 0){
                                        addtable.remove();
                                    }
                                    _this.parents('tr').remove();
                                }
                                getGoods($('#myModal-one').find('form'));
                                $('#myModal-one').modal('hide');
                                isAllStoreGoods();
                            }else{
                                alert(d.messages);
                                _this.removeAttr('disabled');
                            }*/
                        }
                    });
                }
            })
        });
        function getGoods(obj, url){
            if(! url){
                var _this = $(obj);
                var data = _this.serialize();
                data += '&is_ajax=1';
                var url = _this.attr('action');
                var activity_id = $('input[name=id]').val();
                if(! activity_id) {
                    toastr.error('请重新选择要编辑的活动');
                    window.location.href = "{{secure_route('promotion.index')}}";
                }else{
                    data += '&activity_id='+activity_id;
                }
            }else{
                var data = {};
            }
            $.ajax({
                url : url,
                type : 'get',
                data : data,
                success : function(data){
                    $('#myModal-one').find('form').html(data);
                    /*var d = JSON.parse(d);
                    if(d.status){
                        $('#myModal-one').find('form').html(d.messages);
                    }else{
                        alert(d.messages);
                    }*/
                }
            });
            return false;
        }
    </script>
@endsection