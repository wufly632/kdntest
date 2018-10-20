@section('css')
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-modal-bs3patch.css') }}">
    <style>
        #vertical-middle tr td {
            vertical-align: middle;
        }

        .good-image {
            float: left;
        }

        .good-image > img {
            width: 80px;
            height: 80px;
        }

        .good-info {
            float: left;
            padding-left: 5px;
        }

        .good-info > p {
            padding: 4px;
        }

    </style>
    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
@stop
@extends('layouts.default')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                发货管理
                <small>发货单列表</small>
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
                        <div class="box-header">
                            <form action="{{ secure_route('orders.index') }}" method="get"
                                  class="form-horizontal clearfix">
                                <div class="form-group col-sm-4">
                                    <label for="order-id" class="control-label col-sm-4 text-right">订单号:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="order_id" id="order-id" class="input-sm form-control"
                                               value="{{ old('order_id') }}">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="good-name" class="control-label col-sm-4 text-right">商品名称:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="good_name" id="good-name"
                                               class="input-sm form-control" value="{{ old('good_name') }}">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="good-id" class="control-label col-sm-4 text-right">商品ID:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="good_id" id="good-id" class="input-sm form-control"
                                               value="{{ old('good_id') }}">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="good_code" class="control-label col-sm-4 text-right">货号:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="good_code" id="good_code" class="input-sm form-control"
                                               value="{{ old('good_code') }}">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="from-type" class="control-label col-sm-4 text-right">订单来源:</label>
                                    <div class="col-sm-8">
                                        <select name="from_type" id="from-type" class="form-control input-sm">
                                            <option value="0" selected>请选择</option>
                                            <option value="1">PC</option>
                                            <option value="2">H5</option>
                                            <option value="4">APP</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="order-status" class="control-label col-sm-4 text-right">状态:</label>
                                    <div class="col-sm-8">
                                        <select name="status" id="order-status" class="form-control input-sm">
                                            <option value="0" selected>全部</option>
                                            <option value="1">待付款</option>
                                            <option value="3">待发货</option>
                                            <option value="4">待收货</option>
                                            <option value="5">交易完成</option>
                                            <option value="6">交易取消</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="created_at" class="control-label col-sm-4 text-right">创建时间:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="created_at" id="created_at" autocomplete="off"
                                               class="input-sm form-control" value="{{ old('created_at') }}">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4 text-right">
                                    <input type="submit" value="查找" class="btn btn-sm btn-primary">
                                </div>
                            </form>
                        </div>
                        <hr>
                        <div class="box-body">
                            <table class="table vertical-middle table-bordered text-center" id="vertical-middle">
                                <thead>
                                <tr>
                                    <th>发货单ID <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>供应商信息 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>订单需求量 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>状态 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>发货数量 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>创建时间 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>物流信息 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>备注 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>操作 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($ship_orders as $order)
                                    <tr>
                                        <td>{{$order->id}}</td>
                                        <td>{{ $order->getSupplier->name }}</td>
                                        <td>{{ $order->num }}</td>
                                        <td>
                                            {{ \App\Entities\ShipOrder\ShipOrder::$allStatus[$order->status] }}
                                        </td>
                                        <td>
                                            {{ $order->released }}
                                        </td>
                                        <td>{{ $order->num }}</td>
                                        <td>{{ $order->supply_price }}</td>
                                        <td>{{ $order->num*$order->supply_price }}</td>
                                        <td>{{ $order->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pull-right">
                                {{ $ship_orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script src="{{ asset('/assets/js/bootstrap-modalmanager.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap-modal.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('/assets/js/plugincommon.js') }}"></script>
    <script src="{{asset('/assets/js/bower_components/axios/dist/axios.min.js')}}"></script>
    <script>
        addDateRangePicker($('#created_at'));
        if ("{{ old('from_type') }}") {
            $('#from-type').val("{{ old('from_type') }}");
        }
        if ("{{ old('status') }}") {
            $('#order-status').val("{{ old('status') }}");
        }
        $('.modal-content').css({'box-shadow': 'none'});
        $('.send-good').click(function () {
            showInfo('确认发货', $(this).attr('data-target-uri'));
        });
        $('.order-cancel').click(function () {
            var _clickEle = $(this);
            layer.confirm('<span class="text-danger">建议取消订单前与用户协商一致,避免不利影响</span>', {
                btn: ['确定', '取消'] //按钮
            }, function () {
                axios.post(_clickEle.attr('data-target-uri')).then(function (res) {
                    if (res.status === 200) {
                        toastr.options.timeOut = 0.5;
                        toastr.options.onHidden = function () {
                            location.reload();
                        };
                        layer.closeAll();
                        toastr.success('取消成功');
                    } else {
                        toastr.success('取消失败');
                    }
                }).catch(function () {
                    toastr.success('取消失败');
                });
            }, function () {

            });
        });
    </script>
@endsection