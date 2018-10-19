@extends('layouts.default')
@section('content')
    <style>
        li {
            list-style: none;
        }

        .w100h100 {
            width: 100px;
            height: 100px;
        }
        .key-attribute{
            width:8%;padding-top: 8px;
            float: left;
        }
        .btn-edit{
            padding: 0px;
            font-size: 14px;
            line-height: 30px;
            margin-top: 10px;
        }
    </style>
    @inject('categoryPresenter', "App\Presenters\CateAttr\CategoryPresenter")
    @inject('goodPresenter',"App\Presenters\Good\GoodPresenter")
    <?php $good_attributes = $goodPresenter->displayGoodAttributes($good)['good_attributes'];?>
    <?php $displayAttr          = $goodPresenter->displayAttr($goodSkus);?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12" style="height: 50px;">
                    <div class="box box-default">
                        {{--<div class="col-xs-1 table-center" style="background-color: #293846;height: 50px;">
                            <label for="" style="color: white;line-height: 50px;">状态：</label>
                        </div>
                        <div class="col-xs-2 table-center" style="background-color: #e0e3e6;height: 50px;">
                            <label for="" style="color: #777777;line-height: 50px;">等待编辑：</label>
                        </div>
                        <a href="#">
                            <div class="col-xs-2 table-center" style="background-color: #e0e3e6;height: 50px;">
                                <i class="fa fa-fw fa-mail-reply-all"></i>
                                <label for="" style="color: #777777;line-height: 50px;">返回到列表页</label>
                            </div>
                        </a>--}}
                        <div class="col-xs-12 table-center" style="background-color: #e0e3e6;height: 50px;">
                            <div class="col-xs-7"></div>
                            @if(in_array($good->status, \App\Entities\Good\Good::$auditSave))
                            <div class="col-xs-1">
                                <button type="button" class="btn btn-block btn-success btn-lg btn-edit" data-toggle="modal" data-target="#modal-default">编辑</button>
                            </div>
                            @endif
                            @if(in_array($good->status, \App\Entities\Good\Good::$auditPass))
                            <div class="col-xs-1">
                                <button type="button" class="btn btn-block btn-success btn-lg auditPass btn-edit">审核通过</button>
                            </div>
                            @endif
                            @if(in_array($good->status, \App\Entities\Good\Good::$auditReturn))
                            <div class="col-xs-1">
                                <button type="button" class="btn btn-block btn-info btn-lg auditReturn btn-edit">退回修改</button>
                            </div>
                            @endif
                            @if(in_array($good->status, \App\Entities\Good\Good::$auditReject))
                            <div class="col-xs-1">
                                <button type="button" class="btn btn-block btn-warning btn-lg auditReject btn-edit">拒绝</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-xs-12">

                    <div class="box box-info">
                        <!-- form start -->
                        <div class="box-body">
                            <!-- 第一行 -->
                            <div class="col-xs-12">
                                <div class="form-group col-xs-5">
                                    <label for="inputEmail3" class="col-sm-4 control-label">商品类目：</label>

                                    <div class="col-sm-8" style="padding-top: 8px;">
                                        {{$categoryPresenter->getCatePathName($good->category_path)}}
                                    </div>
                                </div>
                            </div>

                            <!-- 第二行 -->
                            <div class="col-xs-12">
                                <div class="form-group col-xs-5">
                                    <label for="inputEmail3" class="col-sm-4 control-label">品牌：</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="brand" placeholder="" value="{{$good->brand_name}}" readonly="">
                                    </div>
                                </div>
                            </div>

                            <!-- 第三行 -->
                            <div class="col-xs-12">
                                <div class="form-group col-xs-5">
                                    <label for="inputPassword3" class="col-sm-4 control-label">货号：</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="number" placeholder="" value="{{$good->good_code}}" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- 第四行 -->
                            <div class="col-xs-12">
                                <div class="form-group col-xs-5">
                                    <label for="inputPassword3" class="col-sm-4 control-label">商品名称：</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="goods_name" placeholder="" value="{{$good->good_title}}" readonly>
                                    </div>
                                </div>
                            </div>

                            {{--商品关键属性--}}
                            @if($categoryAttributes && isset($categoryAttributes[2]))
                                @foreach($categoryAttributes[2] as $key => $category_attributes)
                                    <div class="col-xs-12">
                                        <div class="form-group col-xs-12">
                                            <label for="inputEmail3" class="col-sm-1 control-label">
                                                @if($category_attributes->attribute->is_required == 1)
                                                    <span class="text_red">*</span>
                                                @endif
                                                {{$category_attributes->attribute->name}}:
                                            </label>

                                            <div class="col-sm-8">
                                                {{$goodPresenter->bindGoodArributesPresenter($category_attributes)}}
                                                @inject('goodAttributesPresenter', 'App\Presenters\Good\GoodAttributesPresenterInterface')
                                                {!! $goodAttributesPresenter->showGoodAttributes($category_attributes->attr_id, $category_attributes, $good_attributes) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                    </div>
                    </div>
                    <!-- /.box -->
                    @if($categoryAttributes && isset($categoryAttributes[3]))
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">价格库存：</h3>
                        </div>
                        <!-- form start -->
                        <div class="box-body">
                            @foreach($categoryAttributes[3] as $category_attributes)
                                <div class="col-lg-12">
                                    <div class="form-group col-xs-12">
                                        <div class="col-sm-1" style="padding-left: 0;padding-right: 0;">
                                            <label for="inputEmail3" class="col-sm-12 control-label">{{$category_attributes->attribute->name}}：</label>
                                        </div>

                                        <div class="col-sm-8">
                                            {!! $displayAttr['sku_attribute_value_name'][$category_attributes->attr_id] !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-lg-12">
                                <hr>
                            </div>

                            <div class="col-lg-12">
                                <form id="edit-form">
                                    <div class="box-body">
                                        <table id="example2" class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                {!! $displayAttr['sku_th_names'] !!}
                                                <th class="table-center">供货价（￥）</th>
                                                <th class="table-center">售价（$）</th>
                                                <th class="table-center">库存（件）</th>
                                                <th class="table-center">商家编码</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($goodSkus as $key => $sku)
                                                <tr>
                                                    @foreach($sku->skuAttributes as $v)
                                                        <td class="" data-id="">
                                                            {{$v->value_name}}
                                                        </td>
                                                    @endforeach
                                                    <td class="table-center">
                                                        <label for=""></label>{{$sku->supply_price}}
                                                    </td>
                                                    <td class="table-center col-sm-2">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control"
                                                                   placeholder="" name="good_sku[price][{{$sku->id}}]"
                                                                value="{{$sku->productSku? $sku->productSku->price : 0}}"
                                                            >
                                                        </div>
                                                    </td>
                                                    <td class="table-center">{{$sku->good_stock}}</td>
                                                    <td class="table-center">{{$sku->supplier_code}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div class="modal fade in" id="modal-default" style="display: none;">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="id" value="{{$good->id}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span></button>
                                                        <h4 class="modal-title">属性值翻译</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="col-xs-12">
                                                            <div class="form-group col-xs-12">
                                                                <label for="inputEmail3" class="col-sm-2 control-label">商品名称：</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" value="{{$good->good_title}}" readonly="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-xs-12">
                                                                <label for="inputEmail3" class="col-sm-2 control-label">title：</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" name="good_en_title"  value="{{$good->good_en_title}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @foreach($notstandardAttr as $attr)
                                                            <div class="col-xs-12">
                                                                <div class="form-group col-xs-12">
                                                                    <label for="inputEmail3" class="col-sm-2 control-label">{{$attr->name}}：</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" class="form-control"  value="{{$attr->ch_attr_value}}" readonly="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-xs-12">
                                                                    <label for="inputEmail3" class="col-sm-2 control-label">{{$attr->en_name}}：</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" class="form-control" value="{{$attr->en_attr_value}}" name="attr_id[{{$attr->attr_id}}]">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">取消</button>
                                                        <button type="button" class="btn btn-primary save">保存</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.box -->

                    </div>
                    @endif
                    <!-- /.col -->

                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">商品图片：</h3>
                        </div>
                        <div class="box-body">
                            <!-- 第一行 -->
                            <div class="col-lg-12">
                                @foreach($good->good_sku_image as $attribute_id => $sku_images)
                                    <div class="form-group col-xs-12">
                                        <hr>
                                        <div class="col-sm-2">
                                            <li style="background-color: red;float: left;"></li>
                                            <span style="float: left;padding-left: 10px;line-height: 30px;">{{$displayAttr['sku_attribute_name'][$attribute_id]}}</span>
                                            <span style="float: left;padding-left: 10px;line-height: 30px;">：</span>
                                        </div>

                                        <div class="col-sm-8">
                                            <div class="timeline-body">
                                                @foreach($sku_images->pluck('src')->unique() as $sku_image)
                                                    <div class="col-sm-2">
                                                        <img src="{{$sku_image}}" alt="..."
                                                             class="margin w100h100">
                                                        {{--<button type="button" class="btn btn-block btn-default btn-xs" disabled>
                                                            已设置为主图
                                                        </button>--}}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- /.box -->

                    </div>
                    <!-- /.col -->

                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">商品属性：</h3>
                        </div>
                        <div class="box-body">
                            <!-- 第一行 -->
                            <div class="col-lg-12">
                                @if($categoryAttributes && isset($categoryAttributes[4]))
                                    @foreach($categoryAttributes[4] as $key => $category_attributes)
                                        <div class="col-xs-12">
                                            <div class="form-group col-xs-12">
                                                <label for="inputEmail3" class="col-sm-1 control-label">
                                                    @if($category_attributes->attribute->is_required == 1)
                                                        <span class="text_red">*</span>
                                                    @endif
                                                    {{$category_attributes->attribute->name}}:
                                                </label>

                                                <div class="col-sm-8">
                                                    {{$goodPresenter->bindGoodArributesPresenter($category_attributes)}}
                                                    @inject('goodAttributesPresenter', 'App\Presenters\Good\GoodAttributesPresenterInterface')
                                                    {!! $goodAttributesPresenter->showGoodAttributes($category_attributes->attr_id, $category_attributes, $good_attributes) !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <!-- /.box -->

                    </div>

                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">小视频：</h3>
                        </div>
                        <div class="box-body">
                            <!-- 第一行 -->
                            <div class="col-lg-12">
                                <div class="form-group col-xs-12">
                                    <div class="col-sm-1">

                                    </div>
                                    <div class="col-sm-8">
                                        @if($good->video)
                                            <video src="{{$good->video}}" controls="controls">
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.box -->

                    </div>
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">商品描述：</h3>
                        </div>
                        <div class="box-body">
                            <!-- 第一行 -->
                            <div class="col-lg-12">
                                <div class="form-group col-xs-12">
                                    <div class="col-sm-1">

                                    </div>
                                    <div class="col-sm-8">
                                        @if($good->content)
                                            @foreach(json_decode($good->content) as $content)
                                            <img src="{{$content}}" alt="" width="100%" height="100%">
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.box -->

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@stop
@section('script')
<script>
    /**
     * 编辑保存
     */
    $('#modal-default').on('click', '.save', function () {
        var _index = $(this);
        var data = $('#edit-form').serialize();
        $.ajax({
            type: 'post',
            data: data,
            url: "{{secure_route('good.edit')}}",
            dataType:'json',
            beforeSend: function () {
                _index.attr('disabled', true);
                _index.html('保存中...');
            },
            success: function (res) {
                if (res.status == 200) {
                    toastr.success(res.content);
                    window.location.reload();
                } else {
                    toastr.error(res.msg);
                    _index.attr('disabled', false);
                    _index.html('保存');
                }
            },
            error: function (data) {

            }
        })
    });
    /**
     * 审核通过
     */
    $('.auditPass').click(function () {
        var _index = $(this);
        $.ajax({
            type: 'post',
            data: {id: "{{$good->id}}", _token: "{{csrf_token()}}"},
            url: "{{secure_route('good.auditPass')}}",
            dataType:'json',
            beforeSend: function () {
                _index.attr('disabled', true);
                _index.html('审核中...');
            },
            success: function (res) {
                if (res.status == 200) {
                    toastr.success(res.content);
                    window.location.reload();
                } else {
                    toastr.error(res.msg);
                    _index.attr('disabled', false);
                    _index.html('审核');
                }
            },
            error: function (data) {

            }
        })
    })
    /**
     * 退回修改
     */
    $('.auditReturn').click(function () {
        var _index = $(this);
        $.ajax({
            type: 'post',
            data: {id: "{{$good->id}}", _token: "{{csrf_token()}}"},
            url: "{{secure_route('good.auditReturn')}}",
            dataType:'json',
            beforeSend: function () {
                _index.attr('disabled', true);
                _index.html('退回中...');
            },
            success: function (res) {
                if (res.status == 200) {
                    toastr.success(res.content);
                    window.location.reload();
                } else {
                    toastr.error(res.msg);
                    _index.attr('disabled', false);
                    _index.html('退回修改');
                }
            },
            error: function (data) {

            }
        })
    })
    /**
     * 审核拒绝
     */
    $('.auditReject').click(function () {
        var _index = $(this);
        $.ajax({
            type: 'post',
            data: {id: "{{$good->id}}", _token: "{{csrf_token()}}"},
            url: "{{secure_route('good.auditReject')}}",
            dataType:'json',
            beforeSend: function () {
                _index.attr('disabled', true);
                _index.html('拒绝中...');
            },
            success: function (res) {
                if (res.status == 200) {
                    toastr.success(res.msg);
                    window.location.reload();
                } else {
                    toastr.error(res.msg);
                    _index.attr('disabled', false);
                    _index.html('审核拒绝');
                }
            },
            error: function (data) {

            }
        })
    })
</script>
@endsection