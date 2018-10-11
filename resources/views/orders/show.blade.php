@section('css')
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

        .progress-text-bottom {
            position: absolute;
            top: 110px;
            left: -65px;
            width: 150px;
        }

        .progress-text-top {
            position: absolute;
            top: 0;
            width: 80px;
            left: -25px
        }

        .progress-block {
            position: absolute;
            top: 28px;
        }

        .progress-circle {
            position: absolute;
            left: 20%;
            top: 50px;
            height: 30px;
            width: 30px;
            border-radius: 15px
        }

        .progress-wrapper {
            height: 80px;
            width: 60%;
            margin-top: 80px;
        }

        .progress-fa {
            padding-left: 5px;
            font-size: 23px;
            line-height: 30px;
        }

        .progress-one {

        }

        .progress-two {
            left: 40%;
        }

        .progress-three {
            left: 60%;
        }

        .progress-four {
            left: 79%;
        }

        #good_table > tbody > tr > td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
@stop
@extends('layouts.default')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                订单详情
                <small>详情</small>
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
                            <div class="center-block progress-wrapper">
                                <div class="progress" style="height: 6px;">
                                    <span class="progress-bar progress-bar-success"
                                          style="width: 33%;"></span>
                                </div>
                                <div class="progress-one progress-block">
                                    <div class="text-gray text-center progress-text-top">laji
                                    </div>
                                    <span class="bg-success progress-circle"><span
                                                class="fa fa-fighter-jet progress-fa"></span></span>
                                    <div class="text-gray text-center progress-text-bottom">2015-04-03
                                        13:25:22
                                    </div>
                                </div>
                                <div class="progress-two progress-block">
                                    <div class="text-gray text-center progress-text-top">laji
                                    </div>
                                    <span class="bg-success progress-circle"></span>
                                    <div class="text-gray text-center progress-text-bottom" style="">2015-04-03
                                        13:25:22
                                    </div>
                                </div>
                                <div class="progress-three progress-block">
                                    <div class="text-gray text-center progress-text-top">laji
                                    </div>
                                    <span class="bg-success progress-circle"></span>
                                    <div class="text-gray text-center progress-text-bottom">2015-04-03
                                        13:25:22
                                    </div>
                                </div>
                                <div class="progress-four progress-block">
                                    <div class="text-gray text-center progress-text-top">laji
                                    </div>
                                    <span class="bg-success progress-circle"></span>
                                    <div class="text-gray text-center progress-text-bottom">2015-04-03
                                        13:25:22
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="container">
                                <div class="col-sm-4">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            订单信息：
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-sm-4">
                                                <div>收货地址：</div>
                                                <div>订单编号：</div>
                                                <div>买家留言：</div>
                                            </div>
                                            <div class="col-sm-8">
                                                @php($addressObject = $order->customerAddress)
                                                <div>{{ $addressObject->country.$addressObject->state.$addressObject->city.$addressObject->street_address }}</div>
                                                <div>{{ $order->message }}</div>
                                                <div>{{ $order->order_id }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="panel panel-info">
                                        <div class="panel-body">
                                            <div>订单状态：</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <table class="table table-bordered" id="good_table">
                                                <tbody>
                                                @foreach($order->customerOrderGood as $good)
                                                    <tr>
                                                        <td>
                                                            <p class="good-image"><img src="{{ $good->good->main_pic }}"
                                                                                       title="商品图片"
                                                                                       alt="商品图片"></p>
                                                            <div class="good-info text-left">
                                                                <p>{{ $good->good->good_title }}</p>
                                                                <p>{{ $good->good->good_code }}</p>
                                                                <p>
                                                                    @php($valueDecode = json_decode($good->attr_value,true))
                                                                    @foreach($valueDecode as $attrindex=>$attrItem)
                                                                        <span>{{ $attrindex }}: {{ $attrItem }}</span>
                                                                    @endforeach
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td>{{ $good->unit_price }}</td>
                                                        <td>{{ $good->num }}</td>
                                                        <td>{{ $good->total_price }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="panel text-right">
                                        <div class="panel-body">
                                            <table class="table pull-right">
                                                <tr>
                                                    @php($orderpayment = $order->customerOrderPayment)
                                                    <td class="">共 <span class="text-danger">{{ count($order->customerOrderGood) }}</span>件商品 商品金额:</td>
                                                    <td class="text-danger">￥200</td>
                                                </tr>
                                                <tr>
                                                    <td class="">活动优惠:</td>
                                                    <td class="text-danger">￥{{ $order->code_price }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="">总金额(未含运费):</td>
                                                    <td class="text-danger">￥{{ $orderpayment->amount }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script>
    </script>
@endsection