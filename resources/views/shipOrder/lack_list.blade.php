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
                <small>缺货申请记录</small>
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
                            <form method="get"
                                  class="form-horizontal clearfix">
                                <div class="form-group col-sm-4">
                                    <label for="order-id" class="control-label col-sm-4 text-right">ID:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="id" id="order-id" class="input-sm form-control"
                                               value="{{ old('id') }}">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="good-name" class="control-label col-sm-4 text-right">SKU ID:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="sku_id" id="good-name"
                                               class="input-sm form-control" value="{{ old('sku_id') }}">
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
                                    <label for="order-status" class="control-label col-sm-4 text-right">状态:</label>
                                    <div class="col-sm-8">
                                        <select name="status" id="order-status" class="form-control input-sm select2">
                                            <option value="" selected>全部</option>
                                            @foreach(\App\Entities\ShipOrder\GoodSkuLack::$allStatus as $key => $status)
                                                <option value="{{$key}}" @if(old('status') == $key) selected @endif>{{$status}}</option>
                                            @endforeach
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
                                    <td>ID <span class="pull-right fa fa-gray fa-unsorted"></span></td>
                                    <th>待发货ID <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>供应商信息 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>SKU信息 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>缺货数量 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>申请时间 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>申请原因 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>状态 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>操作 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($lackList as $lack)
                                    <tr>
                                        <td>
                                            {{$lack->id}}
                                        </td>
                                        <td>
                                            {{$lack->pre_ship_order_id}}
                                        </td>
                                        <td>
                                            {{$lack->getSupplier->name}}
                                        </td>
                                        <td>
                                            {{$lack->sku_id}}
                                        </td>
                                        <td>
                                            {{$lack->num}}
                                        </td>
                                        <td>
                                            {{$lack->created_at}}
                                        </td>
                                        <td>
                                            {{$lack->apply_note}}
                                        </td>
                                        <td>
                                            {{\App\Entities\ShipOrder\GoodSkuLack::$allStatus[$lack->status]}}
                                        </td>
                                        <td>
                                            @if($lack->status == \App\Entities\ShipOrder\GoodSkuLack::WAIT_AUDIT)
                                                <button class="btn btn-primary" onclick="lackAudit({{$lack->id}})">审核</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pull-right">
                                {{ $lackList->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script src="{{ asset('/assets/admin-lte/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('/assets/js/plugincommon.js') }}"></script>
    <script>
        addDateRangePicker($('#created_at'));
        function catShipOrder(id) {
            layer.open({
                type: 2,
                skin: 'layui-layer-rim', //加上边框
                area: ['80%','600px'],
                fix: false, //不固定
                shadeClose: true,
                maxmin: true,
                shade:0.4,
                title: '发货单明细',
                content: "/shipOrder/detail/"+id,
                end: function(layero, index) {
                }
            });
        }

        function lackAudit(id) {
            layer.open({
                type: 2,
                skin: 'layui-layer-rim', //加上边框
                area: ['55%','400px'],
                fix: false, //不固定
                shadeClose: true,
                maxmin: true,
                shade:0.4,
                title: '缺货审核',
                content: "/shipOrder/lackAudit/"+id,
                end: function(layero, index) {
                }
            });
        }
    </script>
@endsection