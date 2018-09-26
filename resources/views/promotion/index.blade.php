@extends('layouts.default')
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
                    <div class="modal fade" id="modal-default">
                        <div class="modal-dialog" style="width:800px">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <form action="/promotion/add" method="post" class="form-horizontal">
                                        <div class="form-group">
                                            <label for="" class="col-xs-2 control-label">活动名称</label>
                                            <div class="col-xs-4">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-xs-2 control-label">活动名称</label>
                                            <div class="col-xs-4">
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="col-xs-4">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <input type="submit" class="btn btn-default col-xs-offset-1" value="创建">
                                        <input type="button" class="btn btn-default col-xs-offset-1" id="modal-cancel"
                                               value="取消">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <form action="" class="form-horizontal">
                            <div class="box-body">
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-4">
                                        <label for="time_begin" class="col-xs-4 control-label">开始时间：</label>
                                        <div class="col-xs-8">
                                            <input type="text" id="time_begin" class="form-control col-xs-8">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label for="time_end" class="col-xs-4 control-label">结束时间：</label>
                                        <div class="col-xs-8">
                                            <input type="text" id="time_end" class="form-control">
                                        </div>

                                    </div>
                                    <input type="button" class="btn" data-toggle="modal"
                                           data-target="#modal-default" value="创建活动">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="box">
                        <form action="" class="form-horizontal" method="get">
                            <div class="box-body">
                                <div class="col-xs-12">
                                    <div class="form-group col-xs-4">
                                        <label for="coupon_name" class="col-xs-4 control-label">活动名称：</label>
                                        <div class="col-xs-4">
                                            <input type="text" name="coupon_name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-8">
                                        <label for="coupon_status" class="col-xs-2 control-label">状态</label>
                                        <div class="col-xs-4">
                                            <select name="coupon_status" id="coupon_status" class="form-control">
                                                <option value="">全部</option>
                                                <option value="">未开始</option>
                                                <option value="">进行中</option>
                                                <option value="">已结束</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label for="" class="col-xs-4 control-label">创建时间：</label>
                                        <div class="col-xs-4">
                                            <select name="" id="" class="form-control">
                                                <option value="">请选择</option>
                                                <option value="seven">最近7天</option>
                                                <option value="one-month">最近1月</option>
                                                <option value="half-year">最近半年</option>
                                                <option value="year">最近1年</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-3">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group col-xs-3">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group col-xs-2">
                                        <button class="btn btn-info pull-right">查找</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="box">
                        <div class="box-body">
                            <div class="col-xs-12">
                                <table class="table table-hover table-striped table-bordered">
                                    <thead class="bg-info">
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
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script src="{{ asset('/js/laydate/laydate.js') }}"></script>
    <script>
        laydate.render({
            elem: '#use_time' //指定元素
            , type: 'datetime'
        });
        laydate.render({
            elem: '#take_time' //指定元素
            , type: 'datetime'
        });

        laydate.render({
            elem: '#time_begin' //指定元素
            , type: 'datetime'
        });

        laydate.render({
            elem: '#time_end' //指定元素
            , type: 'datetime'
        });
        $('#modal-cancel').click(function () {
            $("#modal-default").modal('hide');
        });
    </script>
@endsection