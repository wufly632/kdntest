@extends('layouts.default')
@section('content')
    @inject('categoryPresenter', "App\Presenters\CateAttr\CategoryPresenter")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                商品列表
                <small>商品列表</small>
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
                        <!-- form start -->
                        <form class="form-horizontal">
                            <div class="box-body">
                                <!-- 第一行 -->
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-4">
                                        <label for="inputEmail3" class="col-sm-4 control-label">商品名称：</label>

                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="goods_name" placeholder="" name="good_title" value="{{old('good_title')}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-4 control-label">商品ID：</label>

                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="goods_id" placeholder="" name="id" value="{{old('id')}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-4 control-label">商品货号：</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="goods_number" placeholder="" name="good_code" value="{{old('good_code')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-4 control-label">商品状态：</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="status"
                                                    style="width: 100%;">
                                                <option value="">请选择</option>
                                                @foreach(\App\Entities\Good\Good::$allStatus as $key => $status)
                                                    <option value="{{$key}}" @if(old('status') == $key) selected @endif>{{$status}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-4 control-label">供应商：</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="supplier_id">
                                                <option value="">请选择</option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{$supplier->id}}" @if(old('supplier_id') == $supplier->id) selected @endif>{{$supplier->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- 第四行 -->
                                {{--<div class="col-xs-12">
                                    <div class="form-group col-xs-4">
                                        <label for="inputPassword3" class="col-sm-4 control-label">创建时间：</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="goods_status"
                                                    style="width: 100%;">
                                                <option selected="selected">最近7天</option>
                                                <option>最近15天</option>
                                                <option>最近一个月</option>
                                                <option>自定义</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-4">
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right" id="reservationtime">
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-default pull-left col-xs-offset-1">查找</button>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                    <!-- /.box -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">商品数据</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-hover text-center">
                                <thead>
                                <tr class="text-center">
                                    <th>商品图片</th>
                                    <th>供应商</th>
                                    <th>商品信息</th>
                                    <th>采购价(￥)</th>
                                    <th>售价($)</th>
                                    <th>历史销量</th>
                                    <th>库存数量</th>
                                    <th>创建时间</th>
                                    <th>商品状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($goods as $good)
                                    <tr>
                                        <td class="table-center text-center">
                                            <div class="mailbox-attachment-icon has-img" style="width: 80px;">
                                                <img src="{{$good->main_pic}}" alt="" width="60px" height="60px">
                                            </div>
                                        </td>
                                        <td class="table-center">
                                            <span>{{$good->getSupplier->name}}</span><br>
                                            <span>{{$good->getSupplier->mobile}}</span><br>
                                            <span>{{$good->getSupplier->email}}</span><br>
                                        </td>
                                        <td class="table-center">
                                            <span>ID：{{$good->id}}</span><br>
                                            <span>名称：{{$good->good_title}}</span><br>
                                            <span>货号：{{$good->good_code}}</span><br>
                                            <span>类目：{{$categoryPresenter->getCatePathName($good->category_path)}}</span><br>
                                        </td>
                                        <td class="table-center">
                                            <label for="">{{$good->supply_price}}</label>
                                        </td>
                                        <td class="table-center">
                                            <label for="">{{$good->price}}</label>
                                        </td>
                                        <td class="table-center">{{$good->orders}}</td>
                                        <td class="table-center">{{$good->good_stock}}</td>
                                        <td class="table-center">
                                            {{$good->created_at}}
                                        </td>
                                        <td class="table-center">
                                            {{\App\Entities\Good\Good::$allStatus[$good->status]}}<br>
                                            @if($good->getProduct)
                                                {{\App\Entities\Product\Product::$allStatus[$good->getProduct->status]}}
                                            @endif
                                        </td>
                                        <td class="table-center">
                                            @if(in_array($good->status, [\App\Entities\Good\Good::WAIT_AUDIT]))
                                                <a href="{{secure_route('good.audit', ['good' => $good->id])}}">审核</a>
                                                <br>
                                            @endif
                                            @if(! in_array($good->status, [\App\Entities\Good\Good::WAIT_AUDIT]))
                                                <a href="{{secure_route('good.audit', ['good' => $good->id])}}">编辑</a>
                                                <br>
                                            @endif
                                            @if(in_array($good->status, [\App\Entities\Good\Good::EDITED]) && $good->getProduct)
                                                @if($good->getProduct->status == \App\Entities\Product\Product::OFFLINE)
                                                    <a href="javascript:;" onclick="onshelf({{$good->id}})">上架</a><br>
                                                @endif
                                                @if($good->getProduct->status == \App\Entities\Product\Product::ONLINE)
                                                    <a href="javascript:;" onclick="offshelf({{$good->id}})">下架</a><br>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right">
                            {{$goods->appends(Request::all())->links()}}
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
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
<script>
    function onshelf(id) {
        var _index = $(this);
        $.ajax({
            type:'post',
            url:"{{secure_route('product.onshelf')}}",
            data:{id:id,_token:"{{csrf_token()}}"},
            beforeSend:function() {
                _index.attr('disabled', true);
            },
            success:function(data){
                if (data.status == 200) {
                    toastr.success(data.content);
                    parent.location.reload();
                } else {
                    toastr.error(data.msg);
                    _index.attr('disabled', false);
                }
            },
            error:function(data){
                var json=eval("("+data.responseText+")");
                toastr.error(json.msg);
                _index.attr('disabled', false);
                _index.html('保存');
            },
        });
    }
    function offshelf(id) {
        var _index = $(this);
        $.ajax({
            type:'post',
            url:"{{secure_route('product.offshelf')}}",
            data:{id:id,_token:"{{csrf_token()}}"},
            beforeSend:function() {
                _index.attr('disabled', true);
            },
            success:function(data){
                if (data.status == 200) {
                    toastr.success(data.content);
                    parent.location.reload();
                } else {
                    toastr.error(data.msg);
                    _index.attr('disabled', false);
                }
            },
            error:function(data){
                var json=eval("("+data.responseText+")");
                toastr.error(json.msg);
                _index.attr('disabled', false);
                _index.html('保存');
            },
        });
    }
</script>
@endsection