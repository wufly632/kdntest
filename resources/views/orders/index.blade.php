@section('css')
    <style>
        #vertical-middle tr td {
            vertical-align: middle;
        }
        .good-image{
            float: left;
        }
        .good-image>img{
            width: 80px;
            height: 80px;
        }
        .good-info{
            float: left;
            padding-left: 5px;
        }
        .good-info>p{
            padding: 4px;
        }

    </style>
@stop
@extends('layouts.default')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                订单列表
                <small>订单</small>
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
                            <form action="javascript:viod(0)" method="get" class="form-horizontal clearfix">
                                <div class="form-group col-sm-4">
                                    <label for="order-id" class="control-label col-sm-4 text-right">订单号:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="order_id" id="order-id" class="input-sm form-control">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="good-name" class="control-label col-sm-4 text-right">商品名称:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="good_name" id="good-name"
                                               class="input-sm form-control">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="good-id" class="control-label col-sm-4 text-right">商品ID:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="good_id" id="good-id" class="input-sm form-control">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="good-id" class="control-label col-sm-4 text-right">货号:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="good_id" id="good-id" class="input-sm form-control">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="from-type" class="control-label col-sm-4 text-right">订单来源:</label>
                                    <div class="col-sm-8">
                                        <select name="from_type" id="from-type" class="form-control input-sm">
                                            <option value="0">请选择</option>
                                            <option value="1">PC</option>
                                            <option value="2">H5</option>
                                            <option value="3">小程序</option>
                                            <option value="4">APP</option>
                                            <option value="5">门店</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="order-status" class="control-label col-sm-4 text-right">状态:</label>
                                    <div class="col-sm-8">
                                        <select name="status" id="order-status" class="form-control input-sm">
                                            <option value="0">全部</option>
                                            <option value="2">待成团</option>
                                            <option value="3">等待发货</option>
                                            <option value="4">待签收</option>
                                            <option value="5">已签收</option>
                                            <option value="6">交易取消</option>
                                            <option value="7">待配送</option>
                                            <option value="8">待自提</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="" class="control-label col-sm-4 text-right">创建时间:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="good_id" id="good-id" class="input-sm form-control">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4 text-right">
                                    <input type="button" value="查找" class="btn btn-sm btn-primary">
                                </div>
                            </form>
                        </div>
                        <hr>
                        <div class="box-body">
                            <table class="table vertical-middle table-bordered text-center" id="vertical-middle">
                                <thead>
                                <tr>
                                    <th>商品信息 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>单价 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>数量 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>成交金额 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>状态 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>操作 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $orderlist)
                                    <tr class="">
                                        <td colspan="6">
                                            <p class="col-sm-3">订单号: <span class="text-primary"
                                                                           style="cursor: help">{{ $orderlist->order_id }}</span>
                                            </p>
                                            <p class="col-sm-3">下单时间: <span class="text-primary"
                                                                            style="cursor: help">{{ $orderlist->created_at }}</span>
                                            </p>
                                            <p class="col-sm-2">
                                                来源: <span class="text-primary"
                                                          style="cursor: help">{{ $orders->OriginWords[$orderlist->from_type] }}</span>
                                            </p>
                                            <p class="col-sm-2">收货人: <span class="text-primary"
                                                                           style="cursor: help">{{ $orderlist->customer_id }}</span>
                                            </p>
                                        </td>
                                    </tr>
                                    @foreach($orderlist->customerOrderGood as $order)
                                        <tr>
                                            <td>
                                                @php( $goodinfo =$order->good)
                                                <p class="good-image"><img src="{{ $goodinfo->main_pic }}" title="商品图片" alt="商品图片"></p>
                                                <div class="good-info text-left">
                                                    <p>{{ $goodinfo->good_title }}</p>
                                                    <p>{{ $goodinfo->good_code }}</p>
                                                    <p>
                                                        @php($valueDecode = json_decode($order->attr_value,true))
                                                        @foreach($valueDecode as $attrindex=>$attrItem)
                                                            <span>{{ $attrindex }}: {{ $attrItem }}</span>
                                                        @endforeach
                                                    </p>
                                                </div>
                                            </td>
                                            <td>{{ $order->unit_price }}</td>
                                            <td>{{ $order->num }}</td>
                                            <td>{{ $order->total_price }}</td>
                                            <td>{{ $orders->StatusWords[$orderlist->status] }}</td>
                                            @if($loop->index=($loop->first))
                                                <td rowspan="{{ $loop->count }}">
                                                    <a href="{{ secure_route('orders.show',['id'=>$orderlist->id]) }}">查看详情</a>
                                                </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pull-right">
                                {{ $orders->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')

@endsection