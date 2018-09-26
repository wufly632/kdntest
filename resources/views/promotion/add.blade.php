@extends('layouts.default')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                添加店铺券
                <small>添加店铺券</small>
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
                                    <form class="form-horizontal">
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
                                        <input type="button" class="btn btn-default col-xs-offset-1"
                                               id="modal-cancel"
                                               value="取消">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="col-xs-2 control-label">活动时间：</label>
                            <div class="col-xs-2">
                                <input type="text" name="time_begin" class="form-control" id="time_begin">
                            </div>
                            <div class="col-xs-2">
                                <input type="text" name="time_end" class="form-control" id="time_end">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="time_prepare" class="col-xs-2 control-label">预热时间：</label>
                            <div class="col-xs-4">
                                <input type="text" name="time_prepare" class="form-control" id="time_prepare">天<span
                                        class="text-danger">(活动开始前，预热时间内，首页显示活动时间、活动名称及活动简介，可不预热。)</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-xs-2 control-label">活动名称：</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" id="promotion_title" name="promotion_title">
                            </div>
                        </div>

                        <div class="form-group">
                            <div for="" class="col-xs-2 text-right">
                                <b>促销方式：</b>
                            </div>
                            <div class="col-xs-10">
                                <label for="method1" class="label-inline">
                                    <input name="promotion_method" id="method1" type="radio">满减
                                </label>
                                <label for="method2" class="label-inline">
                                    <input name="promotion_method" id="method2" type="radio">满返
                                </label>
                                <label for="method3" class="label-inline">
                                    <input name="promotion_method" id="method3" type="radio">多件多折
                                </label>
                                <label for="method4" class="label-inline">
                                    <input name="promotion_method" id="method4" type="radio">x元n件
                                </label>
                                <label for="method5" class="label-inline">
                                    <input name="promotion_method" id="method5" type="radio">买n免一
                                </label>
                                <label for="method6" class="label-inline">
                                    <input name="promotion_method" id="method6" type="radio">限时特价
                                </label>
                                <label for="method7" class="label-inline">
                                    <input name="promotion_method" id="method7" type="radio">限量秒杀
                                </label>
                            </div>
                        </div>
                        <div class="form-group with-border " style="height: 60px">
                            <div class="col-xs-offset-2 detail-box">

                            </div>

                        </div>
                        <div class="container">
                            <div>活动商品
                                <button class="btn btn-default pull-right" data-toggle="modal"
                                        data-target="#modal-default">添加商品
                                </button>
                            </div>
                            <table class="table">
                                <thead class="bg-info">
                                <tr>
                                    <td>商品图片</td>
                                    <td>商品信息</td>
                                    <td>市场价</td>
                                    <td>售价</td>
                                    <td>最近30天销量</td>
                                    <td>库存数量</td>
                                    <td>操作</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                            <div>
                                <input type="text" class="btn btn-info col-xs-offset-1" value="保存">
                                <input type="text" class="btn btn-default col-xs-offset-2" value="取消">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script src="{{ asset('/js/laydate/laydate.js') }}"></script>
    <script>
        laydate.render({
            elem: '#time_begin' //指定元素
            , type: 'datetime'
        });
        laydate.render({
            elem: '#time_end' //指定元素
            , type: 'datetime'
        });
        $('#method1').click(function () {
            $('.detail-box').empty().append('活动期间，选购商品满 <input type="text" class="">元，立减 <input type="text"\n' +
                'class="">元');

        });
        $('#method2').click(function () {
            $('.detail-box').empty().append('活动期间，买满 <input type="text">\n' +
                '                                元，返 <select name="" id="">\n' +
                '                                    <option value="">券</option>\n' +
                '                                </select>');

        });
        $('#method3').click(function () {
            $('.detail-box').empty().append('活动期间，选购商品满 <input type="text">\n' +
                '                                件，立享 <input type="text">\n' +
                '                                折');

        });
        $('#method4').click(function () {
            $('.detail-box').empty().append('活动期间 <input type="text">\n' +
                '                                元任选 <input type="text">\n' +
                '                                件活动商品');

        });
        $('#method5').click(function () {
            $('.detail-box').empty().append('活动期间，选购商品满 <input type="text">\n' +
                '                                件，免其中价格最低的一件');

        });
        $('#method6').click(function () {
            $('.detail-box').empty().append('活动期间，购买活动商品统一 <select name="" id="">\n' +
                '                                    <option value="">立享</option>\n' +
                '                                    <option value="">立减</option>\n' +
                '                                </select> <input type="text">\n' +
                '                                <span>元</span>每人限购 <select name="" id="">\n' +
                '                                    <option value="">不限</option>\n' +
                '                                    <option value="">1</option>\n' +
                '                                    <option value="">2</option>\n' +
                '                                    <option value="">3</option>\n' +
                '                                    <option value="">4</option>\n' +
                '                                    <option value="">5</option>\n' +
                '                                </select>件 <input type="button" class="btn" value="确定">\n' +
                '                                <div>注：可在添加商品时针对每个商品分别设置优惠力度。</div>\n');

        });
        $('#method7').click(function () {
            $('.detail-box').empty().append('活动期间，活动商品统一\n' +
                '                                <select name="" id="">\n' +
                '                                    <option value="">价格</option>\n' +
                '                                    <option value="">折扣</option>\n' +
                '                                </select>\n' +
                '                                <input type="text">\n' +
                '                                元， 秒杀库存\n' +
                '                                <input type="text">\n' +
                '                                件(不设置件数即为当前库存均用于秒杀)每人限购件\n' +
                '                                <select name="" id="">\n' +
                '                                    <option value="">不限</option>\n' +
                '                                    <option value="">1</option>\n' +
                '                                    <option value="">2</option>\n' +
                '                                    <option value="">3</option>\n' +
                '                                    <option value="">4</option>\n' +
                '                                    <option value="">5</option>\n' +
                '                                </select>\n' +
                '                                <button class="btn">确定</button>\n' +
                '                                <div>\n' +
                '                                    注：可在添加商品时针对每个商品分别设置优惠力度。\n' +
                '                                </div>');

        });
    </script>
@endsection