@extends('layouts.default')
@section('css')
    <link rel="stylesheet" href="{{ cdn_asset('/assets/css/bootstrap-modal.css') }}">
    <link rel="stylesheet" href="{{ cdn_asset('/assets/css/bootstrap-modal-bs3patch.css') }}">
    <style>
        .dis-no {
            display: none;
        }
    </style>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                营销管理
                <small>优惠券</small>
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
                    <div id="responsive" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h2 class="text-center">创建优惠券</h2>
                                    <form id="coupon-create" method="post" class="form-horizontal">
                                        {!! csrf_field() !!}
                                        <div class="form-group">
                                            <div class="col-xs-1"></div>
                                            <label class="col-xs-2 control-label">
                                                用途:
                                            </label>
                                            <div class="col-xs-8">
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" name="coupon_purpose" class="coupon-method" id="method1"
                                                               value="1">页面领取
                                                    </label>
                                                </div>
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" name="coupon_purpose" class="coupon-method" id="method2"
                                                               value="2">满返活动
                                                    </label>
                                                </div>
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" name="coupon_purpose" class="coupon-method" id="method3"
                                                               value="3">新人礼包
                                                    </label>
                                                </div>
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" name="coupon_purpose" class="coupon-method" id="method4"
                                                               value="4">通用券
                                                    </label>
                                                </div>
                                                <p class="show-info text-danger"></p>
                                            </div>
                                            <div class="info-tips text-danger">

                                            </div>
                                        </div>
                                        <div class="form-group dis-no" id="coupon_key">
                                            <div class="col-xs-1"></div>
                                            <label for="coupon_name" class="col-xs-2 control-label">
                                                券口令：
                                            </label>
                                            <div class="col-xs-7">
                                                <input type="text" class="form-control" name="coupon_key">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-1"></div>
                                            <label for="coupon_name" class="col-xs-2 control-label">
                                                券名称：
                                            </label>
                                            <div class="col-xs-7">
                                                <input type="text" id="coupon_name" class="form-control"
                                                       name="coupon_name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-1"></div>
                                            <label for="coupon_count" class="col-xs-2 control-label">
                                                有效期：
                                            </label>
                                            <div class="col-xs-7">
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" name="use_type" value="1">固定时长
                                                    </label>
                                                </div>
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" name="use_type" value="2">固定起止时间
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group fixed_day hidden">
                                            <div class="col-xs-1"></div>
                                            <label for="coupon_count" class="col-xs-2 control-label">
                                                时长：
                                            </label>
                                            <div class="col-xs-7">
                                                <div class="input-group">
                                                    <span class="input-group-addon">自获得起</span>
                                                    <input type="text" name="use_days" class="form-control">
                                                    <span class="input-group-addon">天</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group fixed_time hidden">
                                            <div class="col-xs-1"></div>
                                            <label for="coupon_count" class="col-xs-2 control-label">
                                                起止时间：
                                            </label>
                                            <div class="col-xs-7">
                                                <input type="text" autocomplete="off"
                                                       class="form-control date_choice rangetime" id="daterange"
                                                       name="coupon_use">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-1"></div>
                                            <label for="coupon_count" class="col-xs-2 control-label">
                                                发放时间：
                                            </label>
                                            <div class="col-xs-7">
                                                <input type="text" id="daterange2" autocomplete="off"
                                                       class="form-control date_choice" name="coupon_grant">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-1"></div>
                                            <label for="rebate_type" class="col-xs-2 control-label">
                                                优惠券类型：
                                            </label>
                                            <div class="col-xs-7">
                                                <select name="rebate_type" id="rebate_type" class="form-control">
                                                    <option value="1">面额券</option>
                                                    <option value="2">折扣券</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group currency_code">
                                            <div class="col-xs-1"></div>
                                            <label for="currency" class="col-xs-2 control-label">
                                                币种：
                                            </label>
                                            <div class="col-xs-7">
                                                <select name="currency_code" id="currency" class="form-control">
                                                    <option value="">请选择</option>
                                                    @foreach($currencys as $currency)
                                                        <option value="{{ $currency->currency_code }}" data-unit="{{$currency->name}}">{{ $currency->symbol.$currency->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-1"></div>
                                            <label for="coupon_price" class="col-xs-2 control-label">
                                                券面额：
                                            </label>
                                            <div class="col-xs-7">
                                                <div class="input-group">
                                                    <input type="text" id="coupon_price" class="form-control"
                                                           name="coupon_price"><span
                                                            class="input-group-addon" id="rebate_type_show">元</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-1"></div>
                                            <label for="coupon_count" class="col-xs-2 control-label">
                                                是否限量：
                                            </label>
                                            <div class="col-xs-7">
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" name="count_limit" class="count_limit"
                                                               id="no_limit_count" value="1">不限量
                                                    </label>
                                                </div>
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" name="count_limit" class="count_limit"
                                                               id="limit_count" value="2">限量
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group hidden coupon_number">
                                            <div class="col-xs-1"></div>
                                            <label for="coupon_count" class="col-xs-2 control-label">
                                                发放总量：
                                            </label>
                                            <div class="col-xs-7">
                                                <div class="input-group">
                                                    <input type="text" id="coupon_count" class="form-control"
                                                           name="coupon_number"><span
                                                            class="input-group-addon">张</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group use_price_limit">
                                            <div class="col-xs-1"></div>
                                            <label for="coupon_count" class="col-xs-2 control-label">
                                                使用条件：
                                            </label>
                                            <div class="col-xs-7">
                                                <div class="input-group">
                                                    <input type="text" id="coupon_count" class="form-control"
                                                           name="coupon_use_price"><span
                                                            class="input-group-addon currency_name">元</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-1"></div>
                                            <label for="coupon_count" class="col-xs-2 control-label">
                                                备注：
                                            </label>
                                            <div class="col-xs-7">
                                                <input type="text" id="coupon_count" class="form-control"
                                                       name="coupon_remark">
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-success col-xs-offset-3 save">创建
                                            </button>
                                            <button type="button" class="btn btn-danger col-xs-offset-4"
                                                    id="modal-cancel">取消
                                            </button>
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
                            <div class="box-header">
                                <!-- 第一行 -->
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-3">
                                        <label for="coupon_title" class="col-sm-4 control-label">券名称：</label>

                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="coupon_title" placeholder=""
                                                   name="coupon_title" value="{{old('coupon_title')}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-3">
                                        <label for="coupon_id" class="col-sm-4 control-label">券ID：</label>

                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="coupon_id" placeholder=""
                                                   name="id" value="{{old('id')}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-3">
                                        <label for="coupon_usage" class="col-sm-4 control-label">用途：</label>
                                        <div class="col-sm-8">
                                            <select name="coupon_purpose" id="coupon_usage"
                                                    class="form-control select2">
                                                <option value="">全部</option>
                                                @foreach(\App\Entities\Coupon\Coupon::$allPurpose as $id => $purpose)
                                                    <option value="{{$id}}"
                                                            @if(old('coupon_purpose') == $id) selected @endif>{{$purpose}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-3">
                                        <label for="coupon_status" class="col-sm-4 control-label">状态：</label>
                                        <div class="col-sm-8">
                                            <select name="status" id="coupon_status" class="form-control select2">
                                                <option value="">全部</option>
                                                @foreach(\App\Entities\Coupon\Coupon::$allStatus as $key => $status)
                                                    <option value="{{$key}}"
                                                            @if(old('status') == $key) selected @endif>{{$status}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- 第四行 -->
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-3">
                                        <label for="daterange" class="col-sm-4 control-label date_choice">使用时间：</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="daterange" class="form-control use_time rangetime"
                                                   name="daterange" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="daterange2" class="col-sm-4 control-label date_choice">发放时间：</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="daterange2" class="form-control take_time rangetime"
                                                   name="daterange2" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-body clearfix">
                                <button type="submit" class="btn btn-success pull-left col-xs-offset-1">查找</button>
                                <button type="button" class="btn btn-success col-xs-offset-9" data-toggle="modal"
                                        data-target="#responsive">创建优惠券
                                </button>
                            </div>
                            <div class="box-footer">
                                <table id="coupon_table" class="table table-bordered table-hover text-center">
                                    <thead>
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
                                                @if($coupon->rebate_type==1)
                                                    <label for="">￥</label>{{$coupon->coupon_price}}
                                                @else
                                                    {{$coupon->coupon_price}}<label for="">%</label>
                                                @endif
                                            </td>
                                            <td class="table-center">
                                                1/1/{{$coupon->coupon_number}}
                                            </td>
                                            <td class="table-center">
                                                {{\App\Entities\Coupon\Coupon::$allPurpose[$coupon->coupon_purpose]}}
                                            </td>
                                            <td class="table-center">
                                                @if($coupon->use_type == 2)
                                                    {{$coupon->coupon_use_startdate}}
                                                    ~
                                                    {{$coupon->coupon_use_enddate}}
                                                @else
                                                    自领取后{{$coupon->use_days}}天有效
                                                @endif
                                            </td>
                                            <td class="table-center">
                                                {{$coupon->coupon_grant_startdate}}
                                            </td>
                                            <td class="table-center">
                                                @if($coupon->use_type == 2)
                                                    @if($coupon->coupon_use_enddate < \Carbon\Carbon::now())
                                                        已过期
                                                    @elseif($coupon->coupon_use_startdate <= \Carbon\Carbon::now() && $coupon->coupon_use_enddata > \Carbon\Carbon::now())
                                                        使用中
                                                    @else
                                                        未开始
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="table-center">
                                                <a href="javascript:editCoupon({{$coupon->id}})">编辑</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right">
                                {{$coupons->appends(Request::all())->links()}}
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
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
    <script src="{{ cdn_asset('/assets/js/bootstrap-modalmanager.js') }}"></script>
    <script src="{{ cdn_asset('/assets/js/bootstrap-modal.js') }}"></script>
    <script>
        $('#modal-cancel').click(function () {
            $("#responsive").modal('hide');
        });
        $('.coupon-method').change(function () {
            var va = $(this).val();
            if (va == 1) { //页面领取
                $('.show-info').text('用户可在店铺主页领取，显示最新提交的3张；或在已设置的活动页面领取');
                $('#coupon_key').addClass('dis-no');
            } else if (va == 2) { //满返活动
                $('.show-info').text('满返活动券需要在满返活动中进行配置，用户方可在活动中获得返券');
                $('#coupon_key').addClass('dis-no');
            } else if (va == 3) { //新人礼包
                $('.show-info').text('');
                $('#coupon_key').addClass('dis-no');
            } else if (va == 4) { // 通用券
                $('.show-info').text('');
                $('#coupon_key').removeClass('dis-no');
            }
            if (va == 3) {
                //取消币种和面额券
                $('#rebate_type').val(2);
                $('#rebate_type').find('option[value=1]').addClass('dis-no');
                $('#rebate_type_show').html('%');
                $('.currency_code').addClass('dis-no');
                $('.use_price_limit').find('input[name=coupon_use_price]').val(0);
                $('.use_price_limit').addClass('dis-no');
            }  else {
                $('#rebate_type').find('option[value=1]').removeClass('dis-no');
                $('.currency_code').removeClass('dis-no');
                $('.use_price_limit').removeClass('dis-no');
            }
        });
        $('.modal-content').css({'box-shadow': 'none'});
        $(function () {
            $('#coupon-create').on('click', '.save', function () {
                var _index = $(this);
                $.ajax({
                    type: 'post',
                    url: "{{secure_route('coupon.create')}}",
                    data: $('#coupon-create').serialize(),
                    beforeSend: function () {
                        _index.attr('disabled', true);
                        _index.html('创建中...');
                    },
                    success: function (data) {
                        if (data.status == 200) {
                            toastr.success(data.content);
                            window.location.reload();
                        } else {
                            toastr.error(data.msg);
                            _index.attr('disabled', false);
                            _index.html('创建');
                        }
                    },
                    error: function (data) {
                        var json = eval("(" + data.responseText + ")");
                        toastr.error(json.msg);
                        _index.attr('disabled', false);
                        _index.html('创建');
                    },
                    sync: true
                });
            });
            //有效期类型
            $('input[name=use_type]').change(function () {
                if ($(this).val() == 1) {
                    $('.fixed_day').removeClass('hidden');
                    $('.fixed_time').addClass('hidden');
                } else {
                    $('.fixed_day').addClass('hidden');
                    $('.fixed_time').removeClass('hidden');
                }
            });
            // 是否限量
            $('input[name=count_limit]').change(function () {
                if ($(this).val() == 2) {
                    $('.coupon_number').removeClass('hidden');
                } else {
                    $('.coupon_number').addClass('hidden');
                }
            });
        });

        // 优惠券编辑
        function editCoupon(id) {
            layer.open({
                type: 2,
                skin: 'layui-layer-rim', //加上边框
                area: ['60%', '600px'],
                fix: false, //不固定
                shadeClose: true,
                maxmin: true,
                shade: 0.4,
                title: ' ',
                content: "/coupon/edit/" + id,
                end: function (layero, index) {
                }
            });
        }

        let rebateType = $('#rebate_type');
        let rebateTypeShow = $('#rebate_type_show')
        rebateType.change(function () {
            if (rebateType.val() == 1) {
                var unit = $('#currency').find('option:checked').data('unit');
                rebateTypeShow.html(unit);
            } else {
                rebateTypeShow.html('%');
            }
        })
        $('#currency').change(function () {
            var unit = $(this).find('option:checked').data('unit');
            $('.currency_name').html(unit);
            if ($('#rebate_type').val() == 1) {
                $('#rebate_type_show').html(unit);
            }
        })
    </script>
@stop