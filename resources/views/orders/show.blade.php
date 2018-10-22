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
            border-radius: 15px;
        }

        .progress-wrapper {
            height: 80px;
            width: 60%;
            margin-top: 80px;
        }

        .progress-fa {
            font-size: 20px;
            line-height: 30px;
            text-align: center;
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

        #table_count > tbody > tr > td {
            border-top: none;
        }

        .box-wrapper {
            margin-left: -120px;
        }

        .box-body {
            margin-top: 50px;
        }

        .text-gray-self {
            color: #d2d6de;
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
                    <div class="box box-info ">
                        <div class="box-header box-wrapper">
                            <div class="center-block progress-wrapper">
                                <div class="progress" style="height: 6px;">
                                    <span class="progress-bar progress-bar-success"></span>
                                </div>
                                <div class="progress-one progress-block">
                                    <div class="text-gray-self text-center progress-text-top">待付款
                                    </div>
                                    <span class="bg-success progress-circle fa fa-home progress-fa"
                                          data-status="1"></span>
                                    <div class="text-gray-self text-center progress-text-bottom">2015-04-03
                                        13:25:22
                                    </div>
                                </div>
                                <div class="progress-two progress-block">
                                    <div class="text-gray-self text-center progress-text-top">待发货
                                    </div>
                                    <span class="bg-success progress-circle" data-status="3"></span>
                                    <div class="text-gray-self text-center progress-text-bottom" style="">2015-04-03
                                        13:25:22
                                    </div>
                                </div>
                                <div class="progress-three progress-block">
                                    <div class="text-gray-self text-center progress-text-top">待收货
                                    </div>
                                    <span class="bg-success progress-circle" data-status="4"></span>
                                    <div class="text-gray-self text-center progress-text-bottom">2015-04-03
                                        13:25:22
                                    </div>
                                </div>
                                <div class="progress-four progress-block">
                                    <div class="text-gray-self text-center progress-text-top">交易完成
                                    </div>
                                    <span class="bg-success progress-circle" data-status="5"></span>
                                    <div class="text-gray-self text-center progress-text-bottom">2015-04-03
                                        13:25:22
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body box-wrapper">
                            <div class="container order-panel">
                                <div class="">
                                    <div class="col-sm-4">
                                        <div class="panel panel-info" style="height: 263px;">
                                            <div class="panel-heading">
                                                订单信息：
                                            </div>
                                            <div class="panel-body">
                                                @php($addressObject = $order->customerAddress)
                                                <table style="height: 200px;width: 100%">
                                                    <tr>
                                                        <td style="width: 80px;">收货地址：</td>
                                                        <td style="word-break: break-word">
                                                            {{ $addressObject->country.$addressObject->state.$addressObject->city.$addressObject->street_address }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>订单编号：</td>

                                                        <td style="word-break: break-word">{{ $order->order_id }}</td>

                                                    </tr>
                                                    <tr>
                                                        <td>买家留言：</td>
                                                        <td style="word-break: break-word">
                                                            {{ $order->message }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="panel panel-info">
                                        <div class="panel-body">
                                            <div class="col-sm-2">
                                                <div class="h5">订单状态：</div>
                                                @if($order->status==6)
                                                    <div class="text-danger">交易取消</div>
                                                @endif
                                            </div>
                                            <div class="col-sm-10"
                                                 style="height: 230px;overflow-y: auto;padding-top: 20px;padding-left: -10px;">
                                                @if(in_array($order->status,[4,5]))
                                                    <ul class="timeline" id="track-info">
                                                        <li v-for="(item, index) in trackIinfo">
                                                            <i class="fa fa-rocket bg-blue"></i>

                                                            <div class="timeline-item">
                                                            <span class="time"><i
                                                                        class="fa fa-clock-o"></i> @{{ item.Date }}</span>

                                                                <h3 class="timeline-header">@{{ item.StatusDescription
                                                                    }}</h3>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="panel panel-info">
                                        <div class="panel-body" style="padding: 0">
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
                                                        @if($loop->first)
                                                            <td rowspan="{{ $loop->count }}">
                                                                {{ $order->final_price }}
                                                            </td>
                                                            <td rowspan="{{ $loop->count }}">
                                                                {{ $order->fare }}
                                                            </td>
                                                            <td rowspan="{{ $loop->count }}">
                                                                {{ $order->StatusWords[$order->status] }}
                                                            </td>
                                                        @endif
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
                                            <div class="col-sm-4 pull-right">
                                                <table class="table" id="table_count">
                                                    <tr>
                                                        @php($orderpayment = $order->customerOrderPayment)
                                                        <td class="">共 <span
                                                                    class="text-danger">{{ count($order->customerOrderGood) }}</span>件商品
                                                            商品金额:
                                                        </td>
                                                        <td class="text-danger">{{ $order->total_price }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">活动优惠:</td>
                                                        <td class="text-danger">￥{{ $order->prefer_price }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">总金额(未含运费):</td>
                                                        <td class="text-danger">￥{{ $order->final_price }}</td>
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
            </div>
        </section>
    </div>
@stop
@section('script')
    <script src="{{asset('/assets/js/bower_components/axios/dist/axios.min.js')}}"></script>
    <script src="{{asset('/assets/admin/js/vue.min.js')}}"></script>

    <script>
        var progressBar = $('.progress-bar');
        var dataStatus = $('[data-status="1"]');

        @if($order->status!=6)
        @switch($order->status)
        @case(1)
        progressBar.css('width', '0%');
        @break
                @case(3)
            dataStatus = $('[data-status="3"]');
        dataStatus.addClass('fa fa-rocket progress-fa');
        progressBar.css('width', '33%');
        console.log(dataStatus.prev());

        @break
                @case(4)
            dataStatus = $('[data-status="4"]');
        dataStatus.addClass('fa fa-rocket progress-fa');
        progressBar.css('width', '68%');
        @break
                @case(5)
            dataStatus = $('[data-status="5"]');
        dataStatus.addClass('fa fa-rocket progress-fa');
        progressBar.css('width', '100%');
        @break
        @default

        dataStatus.addClass('fa fa-rocket progress-fa');
        progressBar.css('width', '0%');
        @break
        @endswitch
        dataStatus.prev().css('color', '#000');
        dataStatus.next().css('color', '#000');
        @else
        dataStatus.css('color', '#fff');
                @endif
                @if(in_array($order->status,[4,5]))
        var trackIinfo = new Vue({
                el: '#track-info',
                data: {
                    trackIinfo: []
                },
                created: function () {
                    _index = this;
                    axios.get('{{ secure_route('trackingmore.getstream',['id'=>$order->id,'shipper_code'=>$order->shipper_code,'waybill_id'=>$order->waybill_id]) }}').then(function (res) {
                        if (res.data.status === 200) {
                            _index.trackIinfo = res.data.content.trackinfo;
                        }
                    });

                }
            });
        @endif
    </script>
@endsection