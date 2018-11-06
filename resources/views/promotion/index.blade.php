@extends('layouts.default')
@section('css')
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-modal-bs3patch.css') }}">

    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                营销管理
                <small>促销活动</small>
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
                                                <input type="text" class="form-control create_time" id="daterange2"
                                                       name="daterange2">
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
                                            <input type="text" id="daterange" name="daterange"
                                                   class="form-control create_time"
                                                   autocomplete="off" value="{{old('daterange')}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-3">
                                        <label for="coupon_name" class="col-xs-4 control-label">活动名称：</label>
                                        <div class="col-xs-8">
                                            <input type="text" name="title" class="form-control"
                                                   value="{{old('title')}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-3">
                                        <label for="coupon_status" class="col-xs-4 control-label">状&nbsp;态</label>
                                        <div class="col-xs-8">
                                            <select name="status" id="status" class="form-control">
                                                <option value="">全部</option>
                                                @foreach(\App\Entities\Promotion\Promotion::$allStatus as $key => $status)
                                                    <option value="{{$key}}"
                                                            @if(old('status') == $key) selected @endif>{{$status}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button class="btn btn-success">查找</button>
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
                                        <td>活动名称</td>
                                        <td>促销详情</td>
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
                                            <td>{{$promotion->title}}</td>
                                            <td>@if($promotion->activity_type!=''){{$promotion->rule_text}}@else{{$promotion->title}}@endif</td>
                                            <td>{{$promotion->goods_value}}</td>
                                            <td>{{$promotion->stock}}</td>
                                            <td>
                                                @if(\Carbon\Carbon::now()->toDateTimeString() < $promotion->start_at)
                                                    未开始
                                                @elseif(\Carbon\Carbon::now()->toDateTimeString() > $promotion->end_at)
                                                    已结束
                                                @else
                                                    进行中
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{secure_route('promotion.edit', ['promotion' => $promotion->id])}}">修改</a><br>
                                                <a href="javascript:;" onclick="delPromotion({{$promotion->id}})">删除</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right">
                                {{$promotions->appends(Request::all())->links()}}
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
    <script src="{{ asset('/assets/js/bootstrap-modal.js') }}"></script>

    <script>
        $('#modal-cancel').click(function () {
            $("#modal-default").modal('hide');
        });
        $('.modal-content').css({'box-shadow': 'none'});
        $(function () {
            $('#promotion-add').on('click', '.save', function () {
                var _index = $(this);
                $.ajax({
                    type: 'post',
                    url: "{{secure_route('promotion.addPost')}}",
                    data: $('#promotion-add').serialize(),
                    beforeSend: function () {
                        _index.attr('disabled', true);
                        _index.html('创建中...');
                    },
                    success: function (data) {
                        if (data.status == 200) {
                            toastr.success(data.msg);
                            window.location.href = '/promotion/edit/' + data.content;
                        } else {
                            toastr.error(data.msg);
                            _index.attr('disabled', false);
                            _index.html('创建');
                        }
                    },
                    error: function (data) {
                        var json = eval("(" + data.responseText + ")");
                        toastr.error(json.msg);
                        _index.attr('disabled', false);
                        _index.html('创建');
                    }
                });
            })
        });

        function delPromotion(id) {
            layer.confirm('确定是否删除此活动?', {
                btn: ['删除', '取消'] //按钮
            }, function () {
                $.ajax({
                    type: 'post',
                    url: "{{secure_route('promotion.delete')}}",
                    data: {id: id, _token: "{{csrf_token()}}"},
                    success: function (data) {
                        if (data.status == 200) {
                            toastr.success(data.content);
                            layer.close();
                            window.location.href = "{{secure_route('promotion.index')}}";
                        } else {
                            toastr.error(data.msg);
                        }
                    },
                    error: function (data) {
                        var json = eval("(" + data.responseText + ")");
                        toastr.error(json.msg);
                    }
                });
            }, function () {
                layer.close();
            });
        }
    </script>
@endsection