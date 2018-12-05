@section('css')
    <link rel="stylesheet" href="{{ cdn_asset('/assets/css/bootstrap-modal.css') }}">
    <link rel="stylesheet" href="{{ cdn_asset('/assets/css/bootstrap-modal-bs3patch.css') }}">
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
          href="{{ cdn_asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
@stop
@extends('layouts.default')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                发货管理
                <small>待发货商品</small>
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
                            <form action="" method="get"
                                  class="form-horizontal clearfix">
                                <div class="form-group col-sm-4">
                                    <label for="order-id" class="control-label col-sm-4 text-right">订单ID:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="id" id="order-id" class="input-sm form-control"
                                               value="{{ old('id') }}">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="good-title" class="control-label col-sm-4 text-right">商品名称:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="good_title" id="good-title"
                                               class="input-sm form-control" value="{{ old('good_title') }}">
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
                                            <option value="">全部</option>
                                            @foreach(\App\Entities\ShipOrder\PreShipOrder::$allStatus as $key => $status)
                                                <option value="{{$key}}">{{$status}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="created_at" class="control-label col-sm-4 text-right">创建时间:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="daterange" id="created_at" autocomplete="off"
                                               class="input-sm form-control" value="{{ old('daterange') }}">
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
                                    <th>订单ID <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>SKU ID <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>商品ID <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>产品信息 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>供应商信息 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>订单需求量 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>供货价 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>总金额 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                    <th>创建时间 <span class="pull-right fa fa-gray fa-unsorted"></span></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($pre_ship_orders as $order)
                                    <tr>
                                        <td>{{$order->id}}</td>
                                        <td>{{$order->sku_id}}</td>
                                        <td>{{$order->good_id}}</td>
                                        <td>
                                            <p class="good-image">
                                                <img src="{{ $order->getSku->icon }}" title="商品图片"
                                                                       alt="商品图片">
                                            </p>
                                            <div class="good-info text-left">
                                                <p>{{ $order->getProduct->good_title ?? '' }}</p>
                                                <p>{{ $order->getProduct->good_code ?? '' }}</p>
                                                <p>

                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $order->getSupplier->name }}
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
                                {{ $pre_ship_orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script src="{{ cdn_asset('/assets/js/bootstrap-modalmanager.js') }}"></script>
    <script src="{{ cdn_asset('/assets/js/bootstrap-modal.js') }}"></script>



    <script src="{{cdn_asset('/assets/js/bower_components/axios/dist/axios.min.js')}}"></script>
    <script>

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