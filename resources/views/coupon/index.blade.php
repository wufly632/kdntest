@extends('layouts.default')
@section('css')
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-modal-bs3patch.css') }}">
    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
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
                                    <h2 class="text-center">创建店铺券</h2>
                                    <form id="coupon-create" method="post" class="form-horizontal">
                                        {!! csrf_field() !!}
                                        <div class="form-group">
                                            <div class="col-xs-1"></div>
                                            <label class="col-xs-2 control-label">
                                                用途:
                                            </label>
                                            <div class="col-xs-7">
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" name="coupon_purpose" class="" id="method1" value="1">页面领取
                                                    </label>
                                                </div>
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" name="coupon_purpose" class="" id="method2" value="2">满返活动
                                                    </label>
                                                </div>
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" name="coupon_purpose" class="" id="method3" value="3">新人礼包
                                                    </label>
                                                </div>
                                                <p class="show-info text-danger"></p>
                                            </div>
                                            <div class="info-tips text-danger">

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-1"></div>
                                            <label for="coupon_name" class="col-xs-2 control-label">
                                                券名称：
                                            </label>
                                            <div class="col-xs-7">
                                                <input type="text" id="coupon_name" class="form-control" name="coupon_name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-1"></div>
                                            <label for="coupon_price" class="col-xs-2 control-label">
                                                券面额：
                                            </label>
                                            <div class="col-xs-7">
                                                <div class="input-group">
                                                    <input type="text" id="coupon_price" class="form-control" name="coupon_price"><span
                                                            class="input-group-addon">元</span>
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
                                                <input type="text" autocomplete="off" class="form-control date_choice rangetime" name="coupon_use">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-1"></div>
                                            <label for="coupon_count" class="col-xs-2 control-label">
                                                发放时间：
                                            </label>
                                            <div class="col-xs-7">
                                                <input type="text" id="create_take_time" autocomplete="off"
                                                       class="form-control date_choice rangetime" name="coupon_grant">
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
                                                    <input type="text" id="coupon_count" class="form-control" name="coupon_number"><span
                                                            class="input-group-addon">张</span>
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
                                                    <input type="text" id="coupon_count" class="form-control" name="coupon_use_price"><span
                                                            class="input-group-addon">元</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-1"></div>
                                            <label for="coupon_count" class="col-xs-2 control-label">
                                                备注：
                                            </label>
                                            <div class="col-xs-7">
                                                <input type="text" id="coupon_count" class="form-control" name="coupon_remark">
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-success col-xs-offset-3 save">创建</button>
                                            <button type="button" class="btn btn-danger col-xs-offset-4" id="modal-cancel">取消</button>
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
                                            <select name="coupon_purpose" id="coupon_usage" class="form-control">
                                                <option value="">全部</option>
                                                @foreach(\App\Entities\Coupon\Coupon::$allPurpose as $id => $purpose)
                                                    <option value="{{$id}}">{{$purpose}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-3">
                                        <label for="coupon_status" class="col-sm-4 control-label">状态：</label>
                                        <div class="col-sm-8">
                                            <select name="status" id="coupon_status" class="form-control">
                                                <option value="">全部</option>
                                                @foreach(\App\Entities\Coupon\Coupon::$allStatus as $key => $status)
                                                    <option value="{{$key}}">{{$status}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- 第四行 -->
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-3">
                                        <label for="use_time" class="col-sm-4 control-label date_choice">使用时间：</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="use_time" class="form-control use_time rangetime"
                                                   name="use_time" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="take_time" class="col-sm-4 control-label date_choice">发放时间：</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control take_time rangetime"
                                                   name="grant_time" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-body clearfix">
                                <button type="submit" class="btn btn-success pull-left col-xs-offset-1">查找</button>
                                <button type="button" class="btn btn-success col-xs-offset-9" data-toggle="modal"
                                        data-target="#responsive">创建店铺券
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
                                                <label for="">￥</label>{{$coupon->coupon_price}}
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
    <script src="{{ asset('/assets/admin-lte/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap-modalmanager.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap-modal.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
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
        $('#method1').click(function () {
            $('.show-info').text('用户可在店铺主页领取，显示最新提交的3张；或在已设置的活动页面领取');
        });

        $('#method2').click(function () {
            $('.show-info').text('满返活动券需要在满返活动中进行配置，用户方可在活动中获得返券');
        });

        $('#method3').click(function () {
            $('.show-info').text('');
        });
        /*$('#coupon_table').DataTable({
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
        });*/
        $('.modal-content').css({'box-shadow': 'none'});
        $(function () {
            $('#coupon-create').on('click', '.save', function () {
                var _index = $(this);
                $.ajax({
                    type:'post',
                    url:"{{secure_route('coupon.create')}}",
                    data:$('#coupon-create').serialize(),
                    beforeSend:function() {
                        _index.attr('disabled', true);
                        _index.html('创建中...');
                    },
                    success:function(data){
                        if (data.status == 200) {
                            toastr.success(data.content);
                            window.location.reload();
                        } else {
                            toastr.error(data.msg);
                            _index.attr('disabled', false);
                            _index.html('创建');
                        }
                    },
                    error:function(data){
                        var json=eval("("+data.responseText+")");
                        toastr.error(json.msg);
                        _index.attr('disabled', false);
                        _index.html('创建');
                    },
                    sync:true
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
                area: ['60%','600px'],
                fix: false, //不固定
                shadeClose: true,
                maxmin: true,
                shade:0.4,
                title: ' ',
                content: "/coupon/edit/"+id,
                end: function(layero, index){
                }
            });
        }
    </script>
@stop