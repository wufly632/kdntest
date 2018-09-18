<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>运营中心 - 句逗——新零售，用句逗</title>
<meta name="title" content="运营中心 - 句逗——新零售，用句逗">
<meta name="keywords" content="全渠道零售、全渠道解决方案、线上线下相融合、句逗新零售、多网点、一键小程序、小程序开发、微商城开发、杭州句逗科技有限公司、句逗科技">
<meta name="description" content="句逗，专注新零售（全渠道零售）解决方案,提供全渠道完美互通、深度融合的信息化管理工具。解决线上线下渠道拓展、打通，覆盖线上商城、线下多网点门店、线下加盟连锁、微信公众号商城、小程序、APP等">
<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="image/x-icon" rel="shortcut icon" href="{{asset('common/images/icon.png')}}; ?>">

<link rel="stylesheet" href="{{asset('/assets/admin/css/plugins.css')}}">
<link rel="stylesheet" href="{{asset('/assets/admin/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{mix('/assets/admin/css/style.css')}}">

<script src="{{asset('/assets/admin/js/plugins.js')}}"></script>
<script src="{{asset('/assets/admin/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('/assets/admin/plugins/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('/assets/admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{mix('/assets/admin/js/index.js')}}"></script>
@yield('css')
    <script>
        $(function () {
            var columns = {
                startDate: startDate,
                endDate: endDate,
                "autoApply": false,
                "opens": "center",
                autoUpdateInput: false, //set did not auto update input
                locale:{
                    format: "YYYY-MM-DD",
                    separator: ' - ',
                    applyLabel: '{{trans('确定')}}',
                    cancelLabel: '{{trans('取消')}}',
                    weekLabel: 'W',
                    customRangeLabel: '{{trans('自定义日期范围')}}',
                    daysOfWeek: moment.weekdaysMin(),
                    monthNames: moment.monthsShort(),
                    firstDay: moment.localeData().firstDayOfWeek()
                },
                ranges: {
                    '今天': [moment(), moment()],
                    '昨天': [moment().subtract(1, 'days'), moment().subtract(1,'days')],
                    '过去7天': [moment().subtract(6, 'days'), moment()],
                    '本月': [moment().startOf('month'), moment().endOf('month')]
                }
            };
            //Date range picker
            var start_at = $("input[name='start_at']"),
                end_at = $("input[name='end_at']"),
                daterange = $("input[name='date_range']"),daterange2 = $("input[name='date_range2']"),daterange3 = $("input[name='date_range3']");
            @if(\Illuminate\Support\Facades\Input::get('date_range3'))
            daterange3.val("{{\Illuminate\Support\Facades\Input::get('date_range3')}}");
                    @endif
            var startDate = start_at.val(),endDate = end_at.val();
            @if(\Illuminate\Support\Facades\Input::get('date_range2'))
            daterange2.val("{{\Illuminate\Support\Facades\Input::get('date_range2')}}");
            @endif
            @if(\Illuminate\Support\Facades\Input::get('date_range'))
            daterange.val("{{\Illuminate\Support\Facades\Input::get('date_range')}}");
            @else
                startDate = start_at.data('default');
            endDate = end_at.data('default');
            @endif
            daterange.daterangepicker(columns).on('cancel.daterangepicker', function(ev, picker) {
                //$(this).val(''); //click cancel button
            }).on('apply.daterangepicker', function(ev, picker) {
                $(this).focus();
                $(this).val(picker.startDate.format(picker.locale.format)+picker.locale.separator+picker.endDate.format(picker.locale.format));
                $(this).blur();
                picker.hide();
            });
            daterange2.daterangepicker(columns).on('cancel.daterangepicker', function(ev, picker) {
                //$(this).val(''); //click cancel button
            }).on('apply.daterangepicker', function(ev, picker) {
                $(this).focus();
                $(this).val(picker.startDate.format(picker.locale.format)+picker.locale.separator+picker.endDate.format(picker.locale.format));
                $(this).blur();
                picker.hide();
            });
            daterange3.daterangepicker(columns).on('cancel.daterangepicker', function(ev, picker) {
                //$(this).val(''); //click cancel button
            }).on('apply.daterangepicker', function(ev, picker) {
                $(this).focus();
                $(this).val(picker.startDate.format(picker.locale.format)+picker.locale.separator+picker.endDate.format(picker.locale.format));
                $(this).blur();
                picker.hide();
            });
            /**单选日期***/
            $('#date_single').datepicker({
                format: 'yyyy-mm-dd',
                language:'ch',
                autoclose:true,
                pickDate: true,
                pickTime: false
            });
        })
    </script>
</head>
<body>
<div class="admin clearfix">
    <div class="name"><img src="{{url('admin/images/logo.png')}}">运营中心</div>
    <div class="username clearfix">
        <p>{{\Auth::user()->name ?? \Auth::user()->realname}}</p>
        <a href="{{route('logout')}}">退出</a>
    </div>
</div>