@extends('layouts.default')
@section('css')
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-modal-bs3patch.css') }}">

    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                店铺券列表
                <small>店铺券</small>
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
                    <div id="modal-default" class="modal fade" tabindex="-1" data-width="800" style="display: none;">
                        <div class="modal-dialog" style="width:800px">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <form id="promotion-add" method="post" class="form-horizontal">
                                        {!! csrf_field() !!}
                                        <div class="form-group">
                                            <label for="" class="col-xs-4 control-label">活动名称</label>
                                            <div class="col-xs-4">
                                                <input type="text" class="form-control" name="title">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="active_time" class="col-xs-4 control-label">活动时间</label>
                                            <div class="col-xs-4">
                                                <input type="text" class="form-control create_time" id="active_time" name="promotion_time">
                                            </div>
                                        </div>
                                        <input type="button" class="btn btn-danger col-xs-offset-4" id="modal-cancel"
                                               value="取消">
                                        <input type="button" class="btn btn-success col-xs-offset-1 save" value="创建">

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <form class="form-horizontal" method="get">
                            <div class="box-body">
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-3">
                                        <label for="" class="col-xs-4 control-label">创建时间：</label>
                                        <div class="col-xs-8">
                                            <input type="text" id="create_time" class="form-control create_time"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-3">
                                        <label for="coupon_name" class="col-xs-4 control-label">活动名称：</label>
                                        <div class="col-xs-8">
                                            <input type="text" name="coupon_name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-3">
                                        <label for="coupon_status" class="col-xs-4 control-label">状&nbsp;态</label>
                                        <div class="col-xs-8">
                                            <select name="coupon_status" id="coupon_status" class="form-control">
                                                <option value="">全部</option>
                                                <option value="">未开始</option>
                                                <option value="">进行中</option>
                                                <option value="">已结束</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="button" class="btn btn-success" value="查找">
                                    <input type="button" class="btn btn-success col-xs-offset-1" data-toggle="modal"
                                           data-target="#modal-default" value="创建活动">
                                </div>
                            </div>
                            <div class="box-footer">
                                <table id="promotion_table" class="table table-hover table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <td>序号</td>
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
                                    @foreach($promotions as $promotion)
                                    <tr>
                                        <td>{{$promotion->id}}</td>
                                        <td>{{$promotion->start_at.'~'.$promotion->end_at}}</td>
                                        <td>{{$promotion->rule_text}}</td>
                                        <td>{{$promotion->activity_type}}</td>
                                        <td></td>
                                        <td>{{$promotion->goods_value}}</td>
                                        <td>{{$promotion->stock}}</td>
                                        <td>{{$promotion->status}}</td>
                                        <td>
                                            <div><a href="{{secure_route('promotion.edit', ['promotion' => $promotion->id])}}">修改</a></div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script src="{{ asset('/assets/js/bootstrap-modalmanager.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap-modal.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script>
        $('#modal-cancel').click(function () {
            $("#modal-default").modal('hide');
        });
        $('#promotion_table').DataTable({
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
        let locale = {
            "format": 'YYYY-MM-DD hh:mm',
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
        $('#create_time').daterangepicker({
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
        $('#active_time').daterangepicker({
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
        $('.modal-content').css({'box-shadow': 'none'});
        $(function () {
            $('#promotion-add').on('click', '.save', function () {
                var _index = $(this);
                $.ajax({
                    type:'post',
                    url:"{{secure_route('promotion.addPost')}}",
                    data:$('#promotion-add').serialize(),
                    beforeSend:function() {
                        _index.attr('disabled', true);
                        _index.html('创建中...');
                    },
                    success:function(data){
                        if (data.status == 200) {
                            toastr.success(data.msg);
                            window.location.href = '/promotion/edit/'+data.content;
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
                    }
                });
            })
        })
    </script>
@endsection