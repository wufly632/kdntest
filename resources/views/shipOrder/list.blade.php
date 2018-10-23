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
        .mt-2{margin-top:20px;}

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
            <div class="row col-sm-12">
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
                                        <td>
                                            <a href="javascript:;" onclick="catShipOrder({{$order->id}})">
                                                {{$order->id}}
                                            </a>
                                        </td>
                                        <td>{{ $order->getSupplier->name }}</td>
                                        <td>{{ $order->num }}</td>
                                        <td>
                                            {{ \App\Entities\ShipOrder\ShipOrder::$allStatus[$order->status] }}
                                        </td>
                                        <td>
                                            {{ $order->released }}
                                        </td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>
                                            @if($order->getExpress)
                                                @foreach($order->getExpress as $express)
                                                <span>{{$express->shipper_code}}</span>
                                                <span>{{$express->waybill_id}}</span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $order->note }}</td>
                                        <td>
                                            <button class="btn btn-primary" onclick="addNote({{$order->id}})">添加备注</button>
                                            <button class="btn btn-primary">添加物流</button>
                                            <button class="btn btn-primary">异常关闭</button>
                                        </td>

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
                <div id="add_note" style="display: none;">
                    <form id="add-note">
                        <div class="col-sm-12 mt-2">
                            <input type="hidden" name="id" value="">
                            {!! csrf_field() !!}
                            <span class="col-sm-2">备注：</span>
                            <textarea name="note" rows="6" class="col-sm-10"></textarea>
                        </div>
                        <div class="col-sm-12 text-right mt-2">
                            <button type="button" class="btn btn-primary submit" onclick="subNote($(this))">确定</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script>
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
        function addNote(id) {
            $('#add_note').find('input[name=id]').val(id);
            layer.open({
                type: 1,
                skin: 'layui-layer-rim', //加上边框
                area: ['475px','300px'],
                fix: false, //不固定
                shadeClose: true,
                maxmin: true,
                shade:0.4,
                title: '添加备注',
                content: $('#add_note').html(),
                end: function(layero, index) {
                }
            });
        }
        function subNote(_index)
        {
            var id = _index.parents('#add-note').find('input[name=id]').val();
            var note = _index.parents('#add-note').find('textarea[name=note]').val();
            $.ajax({
                type:'post',
                url:"{{secure_route('shipOrder.addNote')}}",
                data:{id:id,note:note,_token:"{{csrf_token()}}"},
                beforeSend:function() {
                    _index.attr('disabled', true);
                    _index.html('保存中...');
                },
                success:function(data){
                    if (data.status == 200) {
                        toastr.success(data.content);
                        parent.location.reload();
                    } else {
                        toastr.error(data.msg);
                        _index.attr('disabled', false);
                        _index.html('保存');
                    }
                },
                error:function(data){
                    var json=eval("("+data.responseText+")");
                    toastr.error(json.msg);
                    _index.attr('disabled', false);
                    _index.html('保存');
                }
            });
        }
    </script>
@endsection