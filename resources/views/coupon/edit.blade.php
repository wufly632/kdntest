@extends('layouts.blank')
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
    <div class="modal-content">
        <div class="modal-body">
            <h2 class="text-center">修改优惠券</h2>
            <form id="coupon-edit" method="post" class="form-horizontal">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="{{$coupon->id}}">
                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label class="col-xs-2 control-label">
                        用途:
                    </label>
                    <div class="col-xs-8">
                        <div class="radio-inline">
                            <label>
                                <input type="radio" name="coupon_purpose" class="" id="method1" value="1"
                                       @if($coupon->coupon_purpose == 1) checked @endif>页面领取
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label>
                                <input type="radio" name="coupon_purpose" class="" id="method2" value="2"
                                       @if($coupon->coupon_purpose == 2) checked @endif>满返活动
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label>
                                <input type="radio" name="coupon_purpose" class="" id="method3" value="3"
                                       @if($coupon->coupon_purpose == 3) checked @endif>新人礼包
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label>
                                <input type="radio" name="coupon_purpose" class="" id="method4" value="4"
                                       @if($coupon->coupon_purpose == 4) checked @endif>通用
                            </label>
                        </div>
                        <p class="show-info text-danger"></p>
                    </div>
                    <div class="info-tips text-danger">

                    </div>
                </div>
                <div class="form-group @if($coupon->coupon_purpose != 4) dis-no @endif" id="coupon_key">
                    <div class="col-xs-1"></div>
                    <label for="coupon_name" class="col-xs-2 control-label">
                        券口令：
                    </label>
                    <div class="col-xs-7">
                        <input type="text" class="form-control" name="coupon_key" value="{{$coupon->coupon_key}}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label for="coupon_name" class="col-xs-2 control-label">
                        券名称：
                    </label>
                    <div class="col-xs-7">
                        <input type="text" id="coupon_name" class="form-control" name="coupon_name"
                               value="{{$coupon->coupon_name}}">
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
                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label for="currency" class="col-xs-2 control-label">
                        币种：
                    </label>
                    <div class="col-xs-7">
                        <select name="currency_code" id="currency" class="form-control">
                            @foreach($currencys as $currency)
                                <option value="{{ $currency->currency_code }}">{{ $currency->symbol.$currency->name }}</option>
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
                            <input type="text" id="coupon_price" class="form-control" name="coupon_price"
                                   value="{{$coupon->coupon_price}}"><span
                                    class="input-group-addon" id="rebate_type_show">元</span>
                        </div>
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
                                <input type="radio" name="use_type" value="1"
                                       @if($coupon->use_type == 1) checked @endif>固定时长
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label>
                                <input type="radio" name="use_type" value="2"
                                       @if($coupon->use_type == 2) checked @endif>固定起止时间
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group fixed_day @if($coupon->use_type != 1) hidden @endif">
                    <div class="col-xs-1"></div>
                    <label for="coupon_count" class="col-xs-2 control-label">
                        时长：
                    </label>
                    <div class="col-xs-7">
                        <div class="input-group">
                            <span class="input-group-addon">自获得起</span>
                            <input type="text" name="use_days" class="form-control" value="{{$coupon->use_days}}">
                            <span class="input-group-addon">天</span>
                        </div>
                    </div>
                </div>
                <div class="form-group fixed_time @if($coupon->use_type != 2) hidden @endif">
                    <div class="col-xs-1"></div>
                    <label for="coupon_count" class="col-xs-2 control-label">
                        起止时间：
                    </label>
                    <div class="col-xs-7">
                        <input type="text" autocomplete="off" class="form-control date_choice rangetime"
                               name="coupon_use"
                               value="{{$coupon->use_type ==2 ? $coupon->coupon_use_startdate.'~'.$coupon->coupon_use_enddate : ''}}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label for="coupon_count" class="col-xs-2 control-label">
                        发放时间：
                    </label>
                    <div class="col-xs-7">
                        <input type="text" id="create_take_time" autocomplete="off"
                               class="form-control date_choice rangetime" name="coupon_grant"
                               value="{{$coupon->coupon_grant_startdate.'~'.$coupon->coupon_grant_enddate}}"
                        >
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
                                       id="no_limit_count" value="1" @if($coupon->coupon_number == 0) checked @endif>不限量
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label>
                                <input type="radio" name="count_limit" class="count_limit"
                                       @if($coupon->coupon_number > 0) checked @endif
                                       id="limit_count" value="2">限量
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group @if($coupon->coupon_number == 0) hidden @endif coupon_number">
                    <div class="col-xs-1"></div>
                    <label for="coupon_count" class="col-xs-2 control-label">
                        发放总量：
                    </label>
                    <div class="col-xs-7">
                        <div class="input-group">
                            <input type="text" id="coupon_count" class="form-control" name="coupon_number"
                                   value="{{$coupon->coupon_number}}">
                            <span class="input-group-addon">张</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label for="coupon_count" class="col-xs-2 control-label">
                        使用条件：
                    </label>
                    <div class="col-xs-7">
                        <div class="input-group">
                            <input type="text" id="coupon_count" class="form-control" name="coupon_use_price"
                                   value="{{$coupon->coupon_use_price}}">
                            <span class="input-group-addon">元</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label for="coupon_count" class="col-xs-2 control-label">
                        备注：
                    </label>
                    <div class="col-xs-7">
                        <input type="text" id="coupon_count" class="form-control" name="coupon_remark"
                               value="{{$coupon->coupon_remark}}">
                    </div>
                </div>
                <div>
                    <button type="button" class="btn btn-success col-xs-offset-3 save">保存</button>
                    <button type="button" class="btn btn-danger col-xs-offset-4 cancel">取消</button>
                </div>
            </form>
        </div>
    </div>
@stop
@section('script')
    <script src="{{ cdn_asset('/assets/admin-lte/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ cdn_asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ cdn_asset('/assets/js/bootstrap-modalmanager.js') }}"></script>
    <script src="{{ cdn_asset('/assets/js/bootstrap-modal.js') }}"></script>
    <script src="{{ cdn_asset('/assets/admin-lte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ cdn_asset('/assets/admin-lte/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ cdn_asset('/assets/admin-lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $.fn.datepicker.dates['zh-cn'] = {
            days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"],
            daysShort: ["日", "一", "二", "三", "四", "五", "六"],
            daysMin: ["日", "一", "二", "三", "四", "五", "六"],
            months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
            monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
            today: "今日",
            clear: "清除",
            weekStart: 0
        };
        $('#take_time').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            language: 'zh-cn',

        });
        $('[name=currency_code]').val('{{ $coupon->currency_code }}');
        let locale = {
            "format": 'YYYY-MM-DD hh:mm:ss',
            "separator": "~",
            "applyLabel": "确定",
            "cancelLabel": "取消",
            "fromLabel": "起始时间",
            "toLabel": "结束时间'",
            "customRangeLabel": "自定义",
            "weekLabel": "W",
            "daysOfWeek": ["日", "一", "二", "三", "四", "五", "六"],
            "monthNames": ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
            "firstDay": 1
        };
        $('.rangetime').daterangepicker({
            "timePicker": true,
            "autoApply": true,
            "timePicker24Hour": true,
            locale: locale,
            ranges: {
                '今日': [moment(), moment()],
                '昨日': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '最近7日': [moment().subtract(6, 'days'), moment()],
                '最近30日': [moment().subtract(29, 'days'), moment()],
                '本月': [moment().startOf('month'), moment().endOf('month')],
                '上月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
        }, function (start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
        $('#modal-cancel').click(function () {
            $("#responsive").modal('hide');
        });
        $('#coupon_edit').click(function () {
            $('#responsive').modal('show');
        });
        $('#method1').click(function () {
            $('.show-info').text('用户可在店铺主页领取，显示最新提交的3张；或在已设置的活动页面领取');
            $('#coupon_key').addClass('dis-no');
        });

        $('#method2').click(function () {
            $('.show-info').text('满返活动券需要在满返活动中进行配置，用户方可在活动中获得返券');
            $('#coupon_key').addClass('dis-no');
        });

        $('#method3').click(function () {
            $('.show-info').text('');
            $('#coupon_key').addClass('dis-no');
        });
        $('#method4').click(function () {
            $('.show-info').text('');
            $('#coupon_key').removeClass('dis-no');
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
        $(function () {
            $('#coupon-edit').on('click', '.save', function () {
                var _index = $(this);
                $.ajax({
                    type: 'post',
                    url: "{{secure_route('coupon.update')}}",
                    data: $('#coupon-edit').serialize(),
                    beforeSend: function () {
                        _index.attr('disabled', true);
                        _index.html('保存中...');
                    },
                    success: function (data) {
                        if (data.status == 200) {
                            toastr.success(data.content);
                            parent.location.reload();
                        } else {
                            toastr.error(data.msg);
                            _index.attr('disabled', false);
                            _index.html('保存');
                        }
                    },
                    error: function (data) {
                        var json = eval("(" + data.responseText + ")");
                        toastr.error(json.msg);
                        _index.attr('disabled', false);
                        _index.html('保存');
                    },
                    sync: true
                });
            });
            $('#coupon-edit').on('click', '.cancel', function () {
                parent.location.reload();
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

        let rebateType = $('#rebate_type');
        let rebateTypeShow = $('#rebate_type_show')
        rebateType.val('{{ $coupon->rebate_type }}');
        if (rebateType.val() == 1) {
            rebateTypeShow.html('元');
        } else {
            rebateTypeShow.html('%减免');
        }

        rebateType.change(function () {
            if (rebateType.val() == 1) {
                rebateTypeShow.html('元');
            } else {
                rebateTypeShow.html('%减免');
            }
        })
    </script>
@stop