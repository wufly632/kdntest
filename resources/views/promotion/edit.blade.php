@section('css')
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-modal-bs3patch.css') }}">

    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <style>
        .text-padding-top {
            padding-top: 6px;
        }

        .no-padding-left {
            padding-left: 0;
        }

        .image-align-center {
            width: 80px;
            height: 80px;
            line-height: 80px;
        }

        .justify-align-center {
            vertical-align: middle !important;
        }
        .promotion_type {margin-right: 15px;}
        .box-header .col-xs-1{width: 10%;}
        .dis-no{display: none;}
        .addcontain{height: 35px;}
        .add-row{margin-top: 10px;}
        #myModal-four .add-coupon-title{
            margin: 30px 0;
            font-size: 20px;
            font-weight: 500;
        }
        #myModal-four table{
            width: 80%;
            margin-left: 10%;
        }
        #myModal-four table tr{
            height: 50px;
        }
        #myModal-four table td{
            vertical-align: middle;
        }
        #myModal-four .lastRow{
            margin-top: 30px;
            text-align: right;
            margin-right: 10%;
            margin-bottom: 30px;
        }
        .acTable{
            margin-top: 10px;
            text-align: center;
        }
        .acTable th{
            text-align: center;
        }
        .acTable .ac-id{
            width: 10%;
        }
        .acTable .ac-name{
            width: 15%;
        }
        .acTable .ac-position{
            width: 10%;
        }
        .acTable .ac-valid{
            width: 30%;
        }
        .acTable .ac-time{
            width: 30%;
        }
        .acTable,.acTable tr th, .acTable tr td { border:1px solid #E4E4E4;
            padding: 5px;}
        ._goodDetail{
            width: 90%;
            margin-left: 5%;
        }
        ._goodDetail,._goodDetail tr th, ._goodDetail tr td { border:1px solid #E4E4E4;padding: 5px;}
        .promotion-goods-list,.promotion-goods-list tr th, .promotion-goods-list tr td{border:1px solid #E4E4E4;padding: 5px;}
        .promotion-goods-list{width: 90%;margin: 30px 5%;}
        .fl{float: left;}
        .fr{float: right;}
        .png-add{
            position: absolute;
            top: 24px;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
        }
    </style>
@endsection
@extends('layouts.default')
@section('content')
    @inject('goodPresenter',"App\Presenters\Good\GoodPresenter")
    <?php $promotion_rule =$promotion->rule ? json_decode($promotion->rule) : [];?>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                营销活动
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
                    <div id="myModal-one" class="modal fade" tabindex="-1" data-width="1200" style="display: none;">
                        <form class="seckill-modal" method="get" onsubmit="return getGoods(this);" action="{{secure_route('promotion.getGoods')}}">
                            {!! $promotion_goods !!}
                        </form>
                    </div>
                    <!-- Modal4-->
                    <div id="myModal-four" class="modal fade" tabindex="-1" data-width="1200" style="display: none;">
                        <form class="seckill-modal" onsubmit="return coupon.add(this);" >
                            <?php echo $coupon_list;?>
                        </form>
                    </div>
                    <div class="box box-info">
                        <form id="promotion-form" method="post" class="form-horizontal">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$promotion->id}}">
                            <div class="box-header">
                                <div class="form-group">
                                    <label for="promotion_time" class="col-xs-1 control-label">活动图：</label>
                                    <div class="col-xs-3">
                                        <input type="hidden" class="poster_pic" name="poster_pic" value="{{$promotion->poster_pic}}">
                                        <div class="add-upload">
                                            <img src="{{$promotion->poster_pic ?: 'http://placehold.it/150x100'}}" alt="" class="promotion-pic" width="150px" height="150px">
                                            <input type="file" class="png-add" name="img_file">
                                        </div>
                                    </div>
                                    <div class="col-xs-3" style="margin-left: -60px;">
                                        <input type="hidden"  class="poster_pic" name="h5_poster_pic" value="{{$promotion->poster_pic}}">
                                        <div class="add-upload">
                                            <img src="{{$promotion->h5_poster_pic ?: 'http://placehold.it/150x100'}}" alt="" class="promotion-pic" width="150px" height="150px">
                                            <input type="file" class="png-add" name="img_file">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="promotion_time" class="col-xs-1 control-label">活动时间：</label>
                                    <div class="col-xs-3">
                                        <input type="text" name="promotion_time" class="form-control" id="promotion_time" value="{{$promotion->start_at.'~'.$promotion->end_at}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="prepare_time" class="col-xs-1 control-label">预热时间：</label>
                                    <div class="col-xs-2">
                                        <div class="input-group">
                                            <input type="text" name="pre_time" class="form-control"
                                                   id="prepare_time" value="{{$promotion->pre_time}}">
                                            <span class="input-group-addon">天</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 text-danger text-padding-top">
                                        (活动开始前，预热时间内，首页显示活动时间、活动名称及活动简介，可不预热。)
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-xs-1 control-label">活动名称：</label>
                                    <div class="col-xs-2">
                                        <input type="text" class="form-control" id="promotion_title"
                                               name="title" value="{{$promotion->title}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-1 text-right">
                                        <b>促销方式：</b>
                                    </div>
                                    <div class="col-xs-10">
                                        <span class="promotion_type">
                                            <label for="method1" id="method-label1" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method1"
                                                       @if($promotion->activity_type == 'reduce' || ! $promotion->activity_type) checked @endif
                                                       type="radio" value="reduce">满减
                                            </label>
                                        </span>
                                        <span class="promotion_type">
                                            <label for="method2" id="method-label2" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method2"
                                                       @if($promotion->activity_type == 'return') checked @endif
                                                       type="radio" value="return">满返
                                            </label>
                                        </span>
                                        <span class="promotion_type">
                                            <label for="method3" id="method-label3" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method3"
                                                       @if($promotion->activity_type == 'discount') checked @endif
                                                       type="radio" value="discount">多件多折
                                            </label>
                                        </span>
                                        <span class="promotion_type">
                                            <label for="method4" id="method-label4" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method4"
                                                       @if($promotion->activity_type == 'wholesale') checked @endif
                                                       type="radio" value="wholesale">x元n件
                                            </label>
                                        </span>
                                        <span class="promotion_type">
                                            <label for="method5" id="method-label5" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method5"
                                                       @if($promotion->activity_type == 'give') checked @endif
                                                       type="radio" value="give">买n免一
                                            </label>
                                        </span>
                                        <span class="promotion_type">
                                            <label for="method6" id="method-label6" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method6"
                                                       @if($promotion->activity_type == 'limit') checked @endif
                                                       type="radio" value="limit">限时特价
                                            </label>
                                        </span>
                                        <span class="promotion_type">
                                            <label for="method7" id="method-label7" class="label-inline method_radio">
                                                <input name="activity_type" class="promotion_method" id="method7"
                                                       @if($promotion->activity_type == 'quantity') checked @endif
                                                       type="radio" value="quantity">限量秒杀
                                            </label>
                                        </span>
                                    </div>
                                </div>
                                <div class="panel panel-info col-xs-offset-1 col-xs-10">
                                    <div class="panel-body">
                                        <div class="detail-box row with-border">
                                            <div class="@if($promotion->activity_type != 'reduce' && $promotion->activity_type) hidden @endif detail reduce-detail">
                                                <div class="reduce-detail-row addcontain">
                                                    <div class="pull-left text-padding-top">活动期间，买满</div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="reduce_name[]" value="@if($promotion->activity_type == 'reduce') {{$promotion_rule ? $promotion_rule[0]->money : ''}} @endif">
                                                            <span class="input-group-addon">元</span>
                                                        </div>
                                                    </div>
                                                    <div class="pull-left text-padding-top" style="width: 60px;padding-left: 0;padding-right: 0">，立减</div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="reduce_value[]" value="@if($promotion->activity_type == 'reduce') {{$promotion_rule ? $promotion_rule[0]->reduce : ''}} @endif">
                                                            <span class="input-group-addon">元</span>
                                                        </div>
                                                    </div>
                                                    <button id="add-reduce-detail" type="button" class="btn btn-primary btn-flat icon-add @if($promotion->activity_type == 'reduce' && count($promotion_rule) > 1) dis-no @endif" style="border-radius: 90px;">+</button>
                                                </div>
                                                <div class="reduce-detail-row add-row @if($promotion->activity_type != 'reduce' || count($promotion_rule) <= 1) dis-no @endif">
                                                    <div class="pull-left text-padding-top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;满</div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="reduce_name[]" value=""@if($promotion->activity_type == 'reduce' && isset($promotion_rule[1])) {{$promotion_rule[1]->money}} @endif">
                                                            <span class="input-group-addon">元</span>
                                                        </div>
                                                    </div>
                                                    <div class="pull-left text-padding-top" style="width: 60px;padding-left: 0;padding-right: 0">，立减</div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="reduce_value[]" value="@if($promotion->activity_type == 'reduce' && isset($promotion_rule[1])) {{$promotion_rule[1]->reduce}} @endif">
                                                            <span class="input-group-addon">元</span>
                                                        </div>
                                                    </div>
                                                    <button id="add-reduce-detail" type="button" class="btn btn-primary btn-flat icon-minus" style="border-radius: 90px;">-</button>
                                                </div>
                                            </div>
                                            <div class="@if($promotion->activity_type != 'return') hidden @endif detail return-detail">
                                                <div class="return-detail-row">
                                                    <div class="pull-left text-padding-top">活动期间，买满</div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="return_price" value="@if($promotion->activity_type == 'return') {{$promotion->consume}} @endif">
                                                            <span class="input-group-addon">元</span>
                                                        </div>
                                                        <input type="hidden" class="price fl" name="return-sum" id="coupon-price-sum" value=""/>
                                                    </div>
                                                    <div class="col-xs-1 control-label" style="width: 40px;padding-left: 0;padding-right: 0">，返</div>
                                                    <div class="col-xs-2">
                                                        <select name="" id="" class="form-control">
                                                            <option value="">券</option>
                                                        </select>
                                                    </div>
                                                    <button type="button" class="btn btn-primary" style="border-radius: 90px;"  data-toggle="modal" data-target="#myModal-four">+</button>
                                                    <span class="span-tex" id="return-price_sum"></span>
                                                </div>
                                                <div class="clearfix dis-no" id="return-detail">
                                                    <table class="acTable">
                                                        <thead>
                                                        <tr>
                                                            <th class="ac-id">ID</th>
                                                            <th class="ac-name">名称</th>
                                                            <th class="ac-position">面额</th>
                                                            <th class="ac-valid">使用有效期</th>
                                                            <th class="ac-time">发放时间</th>
                                                            <th class="ac-operate">操作</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="@if($promotion->activity_type != 'discount') hidden @endif detail discount-detail">
                                                <div class="discount-detail-row addcontain">
                                                    <div class="pull-left text-padding-top">
                                                        活动期间，选购商品满
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="discount_name[]" value="@if($promotion->activity_type == 'discount') {{$promotion_rule ? $promotion_rule[0]->num : ''}} @endif">
                                                            <span class="input-group-addon">件</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-1 control-label">
                                                        ，立享
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="discount_value[]" value="@if($promotion->activity_type == 'discount') {{$promotion_rule ? $promotion_rule[0]->discount : ''}} @endif">
                                                            <span class="input-group-addon">折</span>
                                                        </div>
                                                    </div>
                                                    <button id="add-discount-detail" type="button" class="btn btn-primary btn-flat icon-add @if($promotion->activity_type == 'discount' || (is_array($promotion_rule) && count($promotion_rule) > 1)) dis-no @endif" style="border-radius: 90px;">+</button>
                                                </div>
                                                <div class="discount-detail-row add-row @if($promotion->activity_type != 'discount' || count($promotion_rule) <= 1) dis-no @endif">
                                                    <div class="pull-left text-padding-top">
                                                        　　　　　　　　　满
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="discount_name[]" value="@if($promotion->activity_type == 'discount' && isset($promotion_rule[1])) {{$promotion_rule[1]->num}} @endif">
                                                            <span class="input-group-addon">件</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-1 control-label">
                                                        ，立享
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="discount_value[]" value="@if($promotion->activity_type == 'discount' && isset($promotion_rule[1])) {{$promotion_rule[1]->discount}} @endif">
                                                            <span class="input-group-addon">折</span>
                                                        </div>
                                                    </div>
                                                    <button id="add-discount-detail" type="button" class="btn btn-primary btn-flat icon-minus" style="border-radius: 90px;">-</button>
                                                </div>
                                            </div>

                                            <div class="@if($promotion->activity_type != 'wholesale') hidden @endif detail wholesale-detail">
                                                <div class="pull-left text-padding-top">
                                                    活动期间
                                                </div>
                                                <div class="col-xs-2">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="wholesale_name[]" value="@if($promotion->activity_type == 'wholesale') {{$promotion_rule ? $promotion_rule[0]->money : ''}} @endif">
                                                        <span class="input-group-addon">元</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-1 control-label">
                                                    任选
                                                </div>
                                                <div class="col-xs-2">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="wholesale_value[]" value="@if($promotion->activity_type == 'wholesale') {{$promotion_rule ? $promotion_rule[0]->wholesale : ''}} @endif">
                                                        <span class="input-group-addon">件</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-1 control-label">活动商品</div>
                                            </div>
                                            <div class="@if($promotion->activity_type != 'give') hidden @endif detail give-detail">
                                                <div class="pull-left text-padding-top">
                                                    活动期间，选购商品满
                                                </div>
                                                <div class="col-xs-2">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="give_num" value="@if($promotion->activity_type == 'give') {{$promotion->rule}} @endif">
                                                        <span class="input-group-addon">
                                                        件
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-3 control-label">
                                                    ，免其中价格最低的一件
                                                </div></div>
                                            <div class="@if($promotion->activity_type != 'limit') hidden @endif detail limit-detail">
                                                <div class="pull-left text-padding-top">
                                                    活动期间，购买活动商品统一
                                                </div>
                                                <div class="col-xs-2">
                                                    <select name="limit_type" class="form-control active-select">
                                                        <option value="1">立减</option>
                                                        <option value="2">立享</option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-2">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="limit_num">
                                                        <span class="input-group-addon limit-type-html">元</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-1 control-label">
                                                    每人限购
                                                </div>
                                                <div class="col-xs-1">
                                                    <div class="input-group">
                                                        <select name="limit_per_num" class="form-control">
                                                            <option value="">不限</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="5">5</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-primary" onclick="setGoodInfo(this)">确定</button>
                                                <div class="text-info" style="padding: 6px;padding-left: 24px;">
                                                    注：可在添加商品时针对每个商品分别设置优惠力度。
                                                </div>
                                            </div>
                                            <div class="@if($promotion->activity_type != 'quantity') hidden @endif detail quantity-detail">
                                                <div class="pull-left text-padding-top">
                                                    活动期间，活动商品统一
                                                </div>
                                                <div class="col-xs-2 no-padding" style="width: 90px;margin:0 10px;">
                                                    <select name="quantity_type" class="form-control active-select">
                                                        <option value="1">价格</option>
                                                        <option value="2">折扣</option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-2 no-padding" style="width: 90px;">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="quantity_price1">
                                                        <span class="input-group-addon limit-type-html">元</span>
                                                    </div>
                                                    <div class="input-group dis-no">
                                                        <input type="text" class="form-control" name="quantity_price2">
                                                        <span class="input-group-addon limit-type-html">元</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-1 control-label text-left" style="width: 110px;margin-left: -15px;">， 秒杀库存</div>
                                                <div class="col-xs-1" style="width: 110px;margin-left: -20px">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="quantity_num">
                                                        <span class="input-group-addon">件</span>
                                                    </div>
                                                </div>

                                                <div class="col-xs-2 text-danger" style="margin-left: -20px;">
                                                    (不设置件数即为当前库存均用于秒杀)
                                                </div>
                                                <div class="col-xs-1 control-label" style="width: 110px;margin-left: -30px">每人限购件</div>
                                                <div class="col-xs-2 no-padding">
                                                    <select name="" class="form-control" style="width: 90px;">
                                                        <option value="">不限</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>

                                                <div class="col-xs-12">
                                                    <div class="text-left col-xs-5 text-info" style="padding: 10px 5px;">注：可在添加商品时针对每个商品分别设置优惠力度。</div>
                                                    <button type="button" class="btn col-xs-offset-5 btn-primary" onclick="setGoodInfo(this)">确定</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="box-body">
                                <div class="col-xs-12">
                                    <div><span class="h2">活动商品</span>
                                        <button type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#myModal-one">添加商品
                                        </button>
                                    </div>
                                    <div class="table promotion_good_table table-hover text-center promotion-activity-type1
                                        @if(! in_array($promotion->activity_type, ['limit','quantity'])) dis-no @endif
                                    ">
                                        {{--<tbody class="tableTbody">--}}
                                            @foreach($promotion->getPromotionGoods as $promotionGood)
                                            <?php $good = $promotionGood->getProduct;?>
                                            <?php $displayAttr          = $goodPresenter->displayAttr($good->productSku);?>
                                            <table class="promotion-goods-list" id="good-list{{$good->id}}" data-stock="{{$good->good_stock}}">
                                                <tbody>
                                                <tr>
                                                    <?php $num = $promotion->activity_type == 'limit' ? 5 : 6;?>
                                                    <td colspan="{{$displayAttr['attr_num']+$num}}">
                                                        <div class="clearfix">
                                                            <div class="fl good-pic">
                                                                <img src="{{ImgResize($good->main_pic, 100)}}" alt=""/>
                                                            </div>
                                                            <div class="fl good-detail" style="">
                                                                <div class="text-left" style="margin: 30px 0 20px 5px;">名称：{{$good->good_title}}</div>
                                                                <div class="clearfix" style="margin-left: 5px;">
                                                                    <span class="fl go-id">ID：{{$good->id}}</span>
                                                                    <span class="fl go-num" style="margin-left: 20px;">货号：{{$good->good_code}}</span>
                                                                    <span class="fl go-nunber" style="margin-left: 20px;">最近30天销量</span>
                                                                    <div class="fl clearfix limitnum-container" style="margin-left: 200px;">
                                                                        <span class="fl">每人限购</span>
                                                                        <select class="fl promotion-per-num" name="per_num{{$good->id}}">
                                                                            <option value="0">不限</option>
                                                                            <option value="1">1</option>
                                                                            <option value="2">2</option>
                                                                            <option value="3">3</option>
                                                                            <option value="5">5</option>
                                                                        </select>
                                                                        <span class="fl">件</span>
                                                                    </div>
                                                                    <button class="btn btn-primary fr" style="margin-left: 30px;" data-toggle="modal" data-target="">一键设置</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td rowspan="{{$good->productSku->count()+2}}" style="width: 80px;">
                                                        <span class="good-delete promotion-goods-delete" data-id="{{$good->id}}" >删除</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    {!! $displayAttr['sku_th_names'] !!}
                                                    <td>
                                                        供货价
                                                        <input type="hidden" name="good_id[]" value="{{$good->id}}"/>
                                                    </td>
                                                    <td>售价</td>
                                                    <?php switch($promotion->activity_type){
                                                        case 'quantity':
                                                            echo '<td><span class="color-span">* </span>秒杀价</td><td><span class="color-span">* </span>秒杀数量</td>';
                                                            break;
                                                        case 'limit':
                                                            echo '<td><span class="color-span">* </span>限时特价</td>';
                                                            break;
                                                    }?>
                                                    <td>库存数量</td>
                                                    <td>商家编码</td>
                                                </tr>
                                                @foreach($good->productSku as $key => $kv)
                                                    <tr>
                                                        @foreach($kv->skuAttributes as $v)
                                                            <td class="" data-id="">
                                                                <div class="text">{{$v->value_name}}</div>
                                                            </td>
                                                        @endforeach
                                                        <td>
                                                            <input type="hidden" name="sku_id{{$good->id}}[]" value="{{$kv->id}}"/>
                                                            <input type="hidden" name="sku_str{{$good->id}}[]" value="{{$kv->value_ids}}"/>
                                                            {{$kv->supply_price}}
                                                        </td>
                                                        <td data-price="10">
                                                            10
                                                        </td>
                                                        @if($promotion->activity_type == 'quantity')
                                                            <td>
                                                                <input class="table-into-input promotion-price" name="price{{$kv->id}}" value="">
                                                            </td>
                                                            @if($key == 0)
                                                                <td rowspan="{{$val->productSku->count()}}">
                                                                    <input class="table-into-input promotion-num" name="num{{$val->id}}" value="">
                                                                </td>
                                                            @endif
                                                        @elseif($promotion->activity_type == 'limit')
                                                            <td><input class="table-into-input promotion-price" name="price{{$kv->id}}" value=""></td>
                                                        @endif
                                                        <td>{{$kv->good_stock}}</td>
                                                        <td>{{$kv->supplier_code}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                                <script type="text/javascript">
                                                    $('.good-sku-set').on('click', function(){
                                                        var id = $(this).data('good');
                                                        var target = $(this).data('target');
                                                        $(target+'-goodid').val(id);
                                                    });
                                                </script>
                                            @endforeach
                                        {{--</tbody>--}}
                                    </div>
                                    <table class="table promotion_good_table table-bordered table-hover text-center promotion-activity-type2
                                    @if(! in_array($promotion->activity_type, ['reduce','return','discount','wholesale'])) dis-no @endif
                                    ">
                                        <thead>
                                        <tr>
                                            <td>商品图片</td>
                                            <td>商品信息</td>
                                            <td>采购价</td>
                                            <td>供应价</td>
                                            <td>最近30天销量</td>
                                            <td>库存数量</td>
                                            <td>操作</td>
                                        </tr>
                                        </thead>
                                        <tbody class="tableTbody">
                                        @if(! in_array($promotion->activity_type, ['limit', 'quantity']))
                                        @foreach($promotion->getPromotionGoods as $promotionGood)
                                            <?php $product = $promotionGood->getProduct;?>
                                            <tr class="table-level-one">
                                                <td>
                                                    <img src="{{ImgResize($product->main_pic, 100)}}" alt="" width="100px" height="100px">
                                                </td>
                                                <td style="width: 200px;">
                                                    <div>
                                                        <div class="col-xs-5 text-right">ID：</div>
                                                        <div class="col-xs-7 text-left">{{$product->id}}</div>
                                                    </div>
                                                    <div>
                                                        <div class="col-xs-5 text-right">名称：</div>
                                                        <div class="col-xs-7 text-left">{{$product->good_title}}</div>
                                                    </div>
                                                    <div>
                                                        <div class="col-xs-5 text-right">货号：</div>
                                                        <div class="col-xs-7 text-left">{{$product->good_code}}</div>
                                                    </div>
                                                </td>
                                                <td>{{$product->stock_price}}起</td>
                                                <td>¥{{$product->supply_price}}起</td>
                                                <td>{{$product->orders}}</td>
                                                <td>{{$product->good_stock}}</td>
                                                <td>
                                                    <div><a href="javascript:void(0);" class="promotion-goods-delete" data-id="{{$product->id}}">删除</a></div>
                                                    <div class="set_promotion"><span class="promotion-goods-single" data-id="{{$product->id}}">设置优惠</span></div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                    <div>
                                        <input type="button" class="btn btn-success col-xs-offset-4 submit" value="保存">
                                        <input type="button" class="btn btn-danger col-xs-offset-2" value="取消">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script src="{{ asset('/assets/admin-lte/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap-modalmanager.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap-modal.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugincommon.js') }}"></script>
    <script>
        $(function () {
            $('input[name=activity_type]').change(function () {
                var val = $(this).val();
                $('.detail-box').find('.detail').addClass('hidden');
                $('.detail-box').find('.'+val+'-detail').removeClass('hidden');
                if (val == 'limit' || val == 'quantity') {
                    $('.promotion-activity-type1').removeClass('dis-no');
                    $('.promotion-activity-type2').addClass('dis-no');
                } else {
                    $('.promotion-activity-type2').removeClass('dis-no');
                    $('.promotion-activity-type1').addClass('dis-no');
                }
            });
        });
        addDateRangePicker($('#promotion_time'));
        createDataTable($('#select_coupon_table'));
        $('.modal-content').css({'box-shadow': 'none'});

        /*$('.set_promotion').click(function () {
            let thisParent = $(this).parents('.table-level-one');
            console.log(thisParent.next().hasClass('table-level-two'));
            if (thisParent.next().hasClass('table-level-two')) {
                thisParent.next().remove();
            } else {
                $(this).parents('.table-level-one').after(newTable);
            }
        });*/

        //添加促销商品
        $('#myModal-one').on('click', '.submit', function (event) {
            var event = event || window.event;
            event.preventDefault(); // 兼容标准浏览器
            window.event.returnValue = false; // 兼容IE6~8
           var _index = $(this);
           var id = [];
           var type = $('input[name=activity_type]:checked').val();
           $('.good-id').each(function () {
               if ($(this).is(':checked')) {
                   id.push($(this).val());
               }
           });
           if (id.length == 0) {
               toastr.error('请先选择促销商品');
               return false;
           }
            $.ajax({
                type:'post',
                url:"{{secure_route('promotion.add.goodPost')}}",
                data:{'good_id': id.join(','),'_token': "{{csrf_token()}}", 'activity_id': "{{$promotion->id}}", type:type},
                beforeSend:function() {
                    _index.attr('disabled', true);
                    _index.html('添加中...');
                },
                success:function(data){
                    console.log(data);
                    if (data.status == 200) {
                        if(type == 'quantity' || type == 'limit'){
                            $('.promotion-activity-type1').append(data.content);
                            $('.promotion-activity-type1').removeClass('dis-no');
                            $('.promotion-activity-type2').addClass('dis-no');
                        }else{
                            $('.promotion-activity-type2').find('.tableTbody').append(data.content);
                            $('.promotion-activity-type2').removeClass('dis-no');
                            $('.promotion-activity-type1').addClass('dis-no');
                        }
                        getGoods($('#myModal-one').find('form'));
                        $('#myModal-one').modal('hide');
                    } else {
                        toastr.error(data.msg);
                        _index.removeAttr('disabled');
                    }
                },
                error:function(data){

                }
            })
        });
        $(function () {
            $(".detail-box").on("click",'.icon-add', function(){
                $(this).addClass("dis-no");
                var rowclass=$(this).parent().next(".add-row");
                rowclass.removeClass("dis-no");
                // $(".seckill .se-sale").css("height","189px");
            });
            $(".detail-box").on("click", '.icon-minus', function(){
                var minushtml=$(this).parent();
                var adclass=$(this).parent().prev(".addcontain").children(".icon-add");
                $(this).parent('.add-row').find('input').val('');
                adclass.removeClass("dis-no");
                minushtml.addClass("dis-no");
                // $(".seckill .se-sale").css("height","140px");
            });
            $('#myModal-one').on('click', 'ul li a', function(){
                var url = $(this).attr('href');
                var page = $(this).html();
                console.log(url);
                $(this).attr('href', 'javascript:;');
                /*if(url.indexOf('http://') == -1 || url.indexOf('https://') == -1){
                    console.log(77);
                    return false;
                }*/
                // getGoods('', url);
                var _index = $(this);
                $.ajax({
                    type:'get',
                    url:"{{secure_route('promotion.getGoods')}}",
                    data:{is_ajax:1,page:page},
                    beforeSend:function() {
                        _index.attr('disabled', true);
                    },
                    success:function(data){
                        console.log(data);
                        $('#myModal-one').find('.seckill-modal').html(data);
                        /*if (data.status == 200) {
                            toastr.success(data.content);
                            window.location.href = "{{secure_route('promotion.index')}}";
                        } else {
                            toastr.error(data.msg);
                            _index.attr('disabled', false);
                        }*/
                    },
                    error:function(data){
                        var json=eval("("+data.responseText+")");
                        toastr.error(json.msg);
                        _index.attr('disabled', false);
                    }
                })
                return false;
            });
            $('#promotion-form').on('click', '.submit', function (event) {
                var _index = $(this);
                $.ajax({
                    type:'post',
                    url:"{{secure_route('promotion.editPost')}}",
                    data:$('#promotion-form').serialize(),
                    beforeSend:function() {
                        _index.attr('disabled', true);
                        _index.text('保存中...');
                    },
                    success:function(data){
                        console.log(data);
                        if (data.status == 200) {
                            toastr.success(data.content);
                            window.location.href = "{{secure_route('promotion.index')}}";
                        } else {
                            toastr.error(data.msg);
                            _index.attr('disabled', false);
                            _index.text('保存');
                        }
                    },
                    error:function(data){
                        var json=eval("("+data.responseText+")");
                        toastr.error(json.msg);
                        _index.attr('disabled', false);
                        _index.text('保存');
                    }
                })
            });
            $('.promotion_good_table').on('click', '.promotion-goods-delete', function () {
                if(confirm("确定要删除活动商品吗？")){
                    var activity_id = $('input[name=id]').val();
                    var _this = $(this);
                    var good_id = _this.data('id');
                    $.ajax({
                        type:'post',
                        data:{activity_id:activity_id, good_id:good_id,_token:"{{csrf_token()}}"},
                        url:"{{secure_route('promotion.good.delete')}}",
                        beforeSend: function() {
                            _this.attr('disabled', true);
                        },
                        success:function(data){
                            if (data.status == 200) {
                                if(_this.parents('.promotion-activity-type1').length > 0){
                                    _this.parents('.promotion-goods-list').remove();
                                }else{
                                    var addtable = _this.parents('tr').next().find('.add_Table');
                                    if(addtable.length > 0){
                                        addtable.remove();
                                    }
                                    _this.parents('tr').remove();
                                }
                                getGoods($('#myModal-one').find('form'));
                                $('#myModal-one').modal('hide');
                            } else {
                                toastr.error(data.msg);
                                _this.removeAttr('disabled');
                            }
                            /*var d = JSON.parse(d);
                            if(d.status){
                                if(_this.parents('#promotion-activity-type1').length > 0){
                                    _this.parents('table').remove();
                                }else{
                                    var addtable = _this.parents('tr').next().find('.add_Table');
                                    if(addtable.length > 0){
                                        addtable.remove();
                                    }
                                    _this.parents('tr').remove();
                                }
                                getGoods($('#myModal-one').find('form'));
                                $('#myModal-one').modal('hide');
                                isAllStoreGoods();
                            }else{
                                alert(d.messages);
                                _this.removeAttr('disabled');
                            }*/
                        }
                    });
                }
            });

            //立减/立享
            $(".limit-detail").on("change", '.active-select', function(){
                console.log(22);
                var value=$(this).val();
                if(value==1){
                    $(".limit-type-html").text("元");
                }else if(value==2){
                    $(".limit-type-html").text("折");
                }

            });

            $(".quantity-detail").on("change", '.active-select', function(){
                var value=$(this).val();
                if(value==1){
                    $(".Input-select").removeClass("dis-no");
                    $(".input-Select").addClass("dis-no");
                    $(this).parents('.active-container').find('.quantity-text').text('元， 秒杀库存');
                }else if(value==2){
                    $(".Input-select").addClass("dis-no");
                    $(".input-Select").removeClass("dis-no");
                    $(this).parents('.active-container').find('.quantity-text').text('折， 秒杀库存');
                }

            });

            $("input[name=activity_type]").change(function(e){
                if ($(this).val()) {
                    if(!confirm("确定修改内容？整个页面内容会被覆盖。")){
                        e.preventDefault();
                    }
                }
            });

            //设置优惠
            $('.promotion-activity-type1,.promotion-activity-type2').on('click', '.promotion-goods-single', function(){
                var activity_id = $('input[name=id]').val();
                var _this = $(this);
                var toggle = _this.attr('data-toggle');
                console.log(1);
                if( toggle == 'false' ) return;
                console.log(2);
                var good_id = _this.data('id');
                _this.attr('data-toggle', false);
                $.ajax({
                    type:'post',
                    data:{activity_id:activity_id, good_id:good_id,_token:"{{csrf_token()}}"},
                    url:"{{secure_route('promotion.getSingleSkuHtml')}}",
                    dataType:'json',
                    success:function(d){
                        if(d.status == 200){
                            _this.parents('tr').after(d.content);
                        }else{
                            _this.attr('data-toggle', true);
                            toastr.warning(d.msg);
                        }
                    }
                });
            });
            $('#promotion-activity-type1,#promotion-activity-type2').on('click', '.promotion-goods-single-clear', function(){
                $(this).parents('td.add_Table').parent().prev().find('.promotion-goods-single').attr('data-toggle', true);
                $(this).parents('td.add_Table').parent().remove();
            });
        });
        function getGoods(obj, url){
            if(! url){
                var _this = $(obj);
                var data = _this.serialize();
                data += '&is_ajax=1';
                var url = _this.attr('action');
                var activity_id = $('input[name=id]').val();
                if(! activity_id) {
                    toastr.error('请重新选择要编辑的活动');
                    window.location.href = "{{secure_route('promotion.index')}}";
                }else{
                    data += '&activity_id='+activity_id;
                }
            }else{
                var data = {};
            }
            $.ajax({
                url : url,
                type : 'get',
                data : data,
                success : function(data){
                    $('#myModal-one').find('form').html(data);
                    /*var d = JSON.parse(d);
                    if(d.status){
                        $('#myModal-one').find('form').html(d.messages);
                    }else{
                        alert(d.messages);
                    }*/
                }
            });
            return false;
        }

        function setGoodInfo(obj){
            var _this = $(obj);
            var type = $('input[name=activity_type]:checked').val();
            var perNum = $('input[name=limit_per_num]').val();
            if(type == 'limit'){
                var activity_type = $('select[name='+type+'_type]').val();
                var num = $('input[name='+type+'_num]').val();
                if( parseInt(activity_type) == 1){
                    if(!/^\d+(\.\d{0,2})?$/.test(num)){
                        toastr.warning('价格格式错误，请重新修改');
                        return false;
                    }
                    $('.promotion-price').each(function(){
                        var tmpPrice = $(this).parent().prev().data('price');
                        var price = parseFloat(tmpPrice) - parseFloat(num);
                        if(price <= 0) price = 0.01;
                        $(this).val(price);
                    });
                }else if(parseInt(activity_type) == 2){
                    if(!/^\d(\.\d?)?$/.test(num)){
                        toastr.warning('折扣格式错误，请重新修改');
                        return false;
                    }
                    $('.promotion-price').each(function(){
                        var tmpPrice = $(this).parent().prev().data('price');
                        var price = Math.round(parseFloat(tmpPrice) * parseFloat(num) * 100) /1000;
                        if(price <= 0) price = 0.01;
                        $(this).val(price);
                    });
                }
            }else if(type == 'quantity'){
                var activity_type = $('select[name='+type+'_type]').val();
                var price = $('input[name=quantity_price'+activity_type+']').val();
                var num = $('input[name='+type+'_num]').val();
                if(parseInt(activity_type) == 1){
                    if(!/^\d+(\.\d{0,2})?$/.test(price)){
                        toastr.warning('价格格式错误，请重新修改');
                        return false;
                    }
                    if(num && !/^\d+$/.test(num)){
                        toastr.warning('活动商品数量只能为整数');
                        return false;
                    }
                    $('.promotion-price').each(function(){
                        $(this).val(price);
                    });
                    $('.promotion-num').each(function(){
                        var maxNum = $(this).parents('table').data('stock');
                        var tmp = (!num || num > maxNum) ? maxNum : num;
                        $(this).val(tmp);
                    });
                }else if(parseInt(activity_type) == 2){
                    if(!/^\d(\.\d?)?$/.test(price)){
                        toastr.warning('折扣格式错误，请重新修改');
                        return false;
                    }
                    if(num && !/^\d+$/.test(num)){
                        toastr.warning('活动商品数量只能为整数');
                        return false;
                    }
                    $('.promotion-price').each(function(){
                        var tmpPrice = $(this).parent().prev().data('price');
                        $(this).val(Math.round(parseFloat(tmpPrice) * parseFloat(price) * 100) /1000);
                    });
                    $('.promotion-num').each(function(){
                        var maxNum = $(this).parents('table').data('stock');
                        var tmp = (!num || num > maxNum) ? maxNum : num;
                        $(this).val(tmp);
                    });
                }
            }
        }
        var coupon = {
            add:function(obj){
                var event = event || window.event;
                event.preventDefault(); // 兼容标准浏览器
                window.event.returnValue = false; // 兼容IE6~8
                var _this = $(obj);
                var str = '';
                var ids = [];
                var price = '';
                var return_coupons = this.coupons;
                _this.find('input[name=coupon-ids]').each(function(i, item){
                    console.log(1);
                    var that = $(item);
                    if(that.prop('checked')){
                        console.log(2);
                        if($.inArray(that.val(), return_coupons) != -1) {
                            return true;
                        }else{
                            return_coupons.push(that.val());
                        }
                        ids.push(that.val());
                        str += '<tr><input type="hidden" name="return_ids[]" value="'+that.val()+'">';
                        that.parents('td').siblings().each(function(ii, iitem){
                            str += iitem.outerHTML;
                        });
                        str += '<td class="ac-delete" data-id="'+that.val()+'" onClick="coupon.del(this);" data-price="'+that.data('price')+'">删除</td></tr>';
                        price += parseFloat(that.data('price'));
                    }
                });
                this.coupons = return_coupons;
                this.sum = price;
                $('#coupon-price-sum').val(price);
                $('#myModal-four').modal('hide');
                $('#return-detail').removeClass('dis-no').find('tbody').append(str);
                var tr=$('#return-detail .acTable').find("tr").length
                console.log(tr)
                var height=(tr+1)*43+50
                $('.seckill .se-sale').css('height',height+'px');
                $('#return-price_sum').html('(总价值￥'+price+'元)');
            },
            del:function(obj){
                var tr=$(obj).parents("table").find('tr').length;
                console.log(tr)
                var height=tr*43+50
                var id = $(obj).data('id');
                var price = $(obj).data('price');
                var return_coupons = this.coupons;
                price = this.sum - parseFloat(price);
                return_coupons.splice($.inArray(''+id, return_coupons), 1);
                this.coupons = return_coupons;
                $(obj).parents('tr').remove();
                $('.seckill .se-sale').css('height',height+'px');
                $('#return-price_sum').html('(总价值￥'+price+'元)');
                $('#coupon-price-sum').val(price);
                this.sum = price;
            },
            coupons:[],
            sum:0
        };

        function upload_img(img){
            var _this = $(img);
            var img_name = _this.attr("name");
            var url = "{{secure_route('promotion.imgUpload')}}";
            _this.wrap("<form id="+img_name+" action="+url+" method='post' enctype='multipart/form-data'></form>");
            $("#"+img_name).ajaxSubmit({
                data: {
                    "_token": "{{csrf_token()}}",
                    "img_name": img_name
                },
                beforeSend: function() {
                    _this.siblings('.add').html('正在上传...');
                    _this.attr({ disabled: "disabled" })
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    console.log('进度'+percentComplete);
                },
                success: function(data) {
                    console.log(data);
                    _this.unwrap();
                    _this.removeAttr("disabled");
                    if (data.status == 200) {
                        toastr.success(data.msg);
                        _this.parents('.add-upload').prev('input').val(data.content);
                        _this.parents('.add-upload').find('.promotion-pic').attr('src', data.content);
                    } else {
                        toastr.warning(data.msg);
                    }
                },
                error:function(xhr){
                    _this.unwrap();
                    _this.removeAttr("disabled");
                    toastr.error(xhr.responseText+ "图片上传失败");
                }
            });
        }
        //当用户上传商品图片时
        $('.add-upload').on('change','.png-add',function(event){
            var _file = this;
            var reader = new FileReader();
            reader.onload = function(evt){
                var image = new Image();
                image.onload = function () {
                    // if (this.width == this.height && this.width >= 500 && this.width <= 1000 && this.height >= 500 && this.height <= 1000) {
                    upload_img(_file);
                    // } else {
                    //     layer.msg('图片大小不符合要求，请重试。', {icon: 2});
                    // return false;
                    // }
                };
                image.src = evt.target.result;
            };
            if(typeof(_file.files[0])=='object'){
                reader.readAsDataURL(_file.files[0]);
            }

            event.stopPropagation();
        });
    </script>
@endsection