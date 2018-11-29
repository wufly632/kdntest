@extends('layouts.default')
@section('title')
    属性管理
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('assets/admin-lte/plugins/iCheck/all.css')}}">
    <style type="text/css">
        .content-item{
            height: 100%;
            border-right: 1px solid #c3c3c3;
            padding: 0;
            overflow: auto;
        }
        .content-item li{line-height:40px;}
        .level-one{
            padding-left: 20px;
            border-bottom: 1px solid #e9e9e9;
        }
        .con-item-title span{
            font-weight:600;
        }
        .con-item-title {
            line-height: 42px;
            font-size: 18px;
            margin: 0;
        }
        .con-item-title .fa {
            margin-right: 10px;
            margin-top: 10px;
        }
        .con-message li {
            padding-left: 20px;
            line-height: 35px;
        }
        .content-item:last-child {
            border-right: none;
        }
        .item-title-tabs {
            padding: 0;
            font-size: 0;
        }
        .con-item-title {
            line-height: 42px;
            margin: 0;
            padding-left: 20px;
        }
        .item-title-tabs span.tab-selected {
            background: #fff;
            color: #444;
        }
        .item-title-tabs span {
            display: inline-block;
            width: 50%;
            font-size: 18px;
            text-align: center;
            cursor: pointer;
            background: #e7e7e7;
            color: #c3c3c3;
        }
        .edit-property li:first-of-type {
            text-align: center;
        }
        .content-item li {
            line-height: 40px;
        }
        .plus-btn {
            background: #555;
            color: #fff;
            padding: 5px 20px;
            font-size: 14px;
        }
        .edit-property .fa-trash-o {
            margin-top: 13px;
            margin-right: 20px;
        }
        .edit-property .fa-pencil {
            margin-top: 13px;
            margin-right: 5px;
        }
        .tree-active {
            background: #3c8dbc;
            color: #fff;
        }
        .sa-button-container .sa-confirm-button-container{
            display: inline-block;
        }
    </style>
@endsection
<?php
$defaultSelectAttribute = count($attribute_list)>0?$attribute_list[0]:0;
?>
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                类目属性
                <small>属性管理</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Layout</a></li>
                <li class="active">Fixed</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box box-default color-palette-box">
                <div class="box-header with-border text-right">
                    <button type="button" id="add_attribute_button" class="btn btn-success col-xs-offset-9" data-toggle="modal" data-target="#add-property">新增属性</button>
                </div>
                <div class="box-body">
                    <div class="row" style="height: 650px;">
                        <div class="col-md-4 content-item">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="输入要选择的属性" id="search-text" name="searchValue" value="" maxlength="200" onkeyup="autocomple()"><ul id="autocomplete" class="dropdown-menu" style="display: none;"></ul>
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            </div>
                            <ul class="ul-tree">
                                @foreach($attribute_list as $attribute)
                                    <li>
                                        <div class="level-one @if($attribute->id == $defaultSelectAttribute->id) tree-active @endif" data-attribute_id="{{$attribute->id}}" data-attribute_name="{{$attribute->name}}">
                                            <span class="attribute-name">@if(App::isLocale('en')){{$attribute->en_name}}@else{{$attribute->name}}@endif</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- /.col -->
                        <div id="attribute_detail_container" class="col-xs-4 content-item">
                            <h2 class="con-item-title">
                                <span>属性详情</span>
                                <i class="fa fa-trash-o pull-right delete-property"></i>
                                <i id="edit_attribute_button" class="fa fa-pencil pull-right"></i>
                            </h2>
                            <components>
                                <ul class="con-message">
                                    <li>
                                        <span class="mess-name" >属性ID:</span>
                                        <span class="mess-key" v-text = "attribute_info.id"></span>
                                    </li>
                                    <li>
                                        <span class="mess-name" >属性名(中文):</span>
                                        <span class="mess-key" v-text = "attribute_info.name"></span>
                                    </li>
                                    <li>
                                        <span class="mess-name">属性别名:</span>
                                        <span class="mess-key" v-text = "attribute_info.alias_name"></span>
                                    </li>
                                    <li>
                                        <span class="mess-name">属性名(英文):</span>
                                        <span class="mess-key" v-text = "attribute_info.en_name"></span>
                                    </li>
                                    <li>
                                        <span class="mess-name">属性类型:</span>
                                        <span class="mess-key" v-text = "attribute_info.type == 1 ? '标准化属性' : '自定义文本'"></span>
                                    </li>
                                    <li>
                                        <span class="mess-name">排序值:</span>
                                        <span class="mess-key" v-text = "attribute_info.sort"></span>
                                    </li>
                                </ul>
                            </components>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4 content-item">
                            <h2 class="con-item-title item-title-tabs">
                                <span class="tab-selected">属性值</span>
                                <span>关联类目</span>
                            </h2>
                            <div>
                                <ul id="attributes_values" class="edit-property">
                                    <li {{--v-show="is_custom_text"--}}>
                                        <span class="plus-btn" id="add_value_button"><i class="fa fa-plus"></i>添加</span>
                                    </li>
                                    <li v-for="item in items">
                                        <div class="level-one">
                                            <span class="category-name" @if (App::isLocale('en')) v-text="item.en_name"@else v-text="item.name" @endif></span>
                                            <i class="fa fa-trash-o pull-right delete-property-value" v-on:click = "deleteAttributeValue(item.id, item.name)"></i>
                                            <i class="fa fa-pencil pull-right" data-toggle="modal" v-on:click = "editAttributeValue(item)" data-target="#editProperty"></i>
                                        </div>
                                    </li>
                                </ul>
                                <ul id="attributes_categories" class="edit-property">
                                    <li></li>
                                    <li v-for="item in items">
                                        <div class="level-one">
                                            <span class="category-name" v-text = "item.name"></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->

        <!-- 添加/编辑属性弹窗-->
        <div class="modal fade" id="add-property" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content" id="add_edit_attribute">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span id="add_edit_attribute_close_button" aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel" v-text="title"></h4>
                    </div>
                    <form id="attribute_edit_form" class="form-horizontal">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" v-model="id">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-xs-1"></div>
                                <label for="name" class="col-xs-2 control-label">
                                    属性名称：
                                </label>
                                <div class="col-xs-7">
                                    <input name="name" v-model="name" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-1"></div>
                                <label for="alias_name" class="col-xs-2 control-label">
                                    属性别名：
                                </label>
                                <div class="col-xs-7">
                                    <input name="alias_name" v-model="alias_name" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-1"></div>
                                <label for="en_name" class="col-xs-2 control-label">
                                    英文名：
                                </label>
                                <div class="col-xs-7">
                                    <input name="en_name" v-model="en_name" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-1"></div>
                                <label for="coupon_count" class="col-xs-2 control-label">
                                    属性值类型：
                                </label>
                                <div class="col-xs-7">
                                    <div class="radio-inline">
                                        <label>
                                            <input type="radio" name="type" value="1" class="radio_type" checked="checked"/>
                                            标准化文本
                                        </label>
                                    </div>
                                    <div class="radio-inline">
                                        <label>
                                            <input type="radio" name="type" value="2" class="radio_type"/>
                                            自定义文本
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-1"></div>
                                <label for="coupon_name" class="col-xs-2 control-label">
                                    排序值：
                                </label>
                                <div class="col-xs-7">
                                    <input name="sort" v-model="sort" type="text" class="form-control">
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn btn-success col-xs-offset-3" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-danger col-xs-offset-4" v-on:click="submit">保存</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- 添加/编辑属性值弹窗-->
        <div class="modal fade" id="editProperty" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" id="add_edit_attribute_value">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span id="add_edit_attribute_value_close_button" aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel" v-text = "title"></h4>
                    </div>
                    <form id="attribute_value_edit_form" class="form-horizontal">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" v-model="id">
                        <input type="hidden" name="attribute_id" v-model="attribute_id">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-xs-1"></div>
                                <label for="name" class="col-xs-3 control-label">
                                    属性值名称：
                                </label>
                                <div class="col-xs-6">
                                    <input name="name" v-model="name" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-1"></div>
                                <label for="name" class="col-xs-3 control-label">
                                    英文属性值：
                                </label>
                                <div class="col-xs-6">
                                    <input name="en_name" v-model="en_name" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-1"></div>
                                <label for="name" class="col-xs-3 control-label">
                                    排序值：
                                </label>
                                <div class="col-xs-6">
                                    <input name="sort" v-model="sort" type="text" class="form-control">
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn btn-success col-xs-offset-3" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-danger col-xs-offset-4" v-on:click="submit">保存</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal end-->
    </div>
@endsection
@section('script')
    <script src="/assets/js/vue.js" type="text/javascript"></script>
    <script src="{{ asset ("/assets/admin-lte/plugins/iCheck/icheck.min.js") }}"></script>
    <script>
        var attribute = {!! $defaultSelectAttribute !!};
        //初始化默认选中属性的详情
        refreshAttributeDetailInfo({!! $defaultSelectAttribute->id !!});

        //绑定属性详细信息的UI属性
        var attribute_info_data = {
            attribute_info: ''
        };

        new Vue({
            el: '#attribute_detail_container',
            data: attribute_info_data,
        });

        //渲染属性值列表
        var attributes_values_data = {
            items:[],
            alias:''
        };
        new Vue({
            el: '#attributes_values',
            data: attributes_values_data,
            methods:{
                deleteAttributeValue: function (id, name) {
                    deleteAttributeValue(id, name);
                },
                editAttributeValue: function (item) {
                    editAttributeValue(item);
                }
            },
            updated:function () {
                console.log("更新了DOM");
            }
        });

        //渲染属性关联类目列表
        var attributes_categories_data = {
            items:[]
        };
        new Vue({
            el: '#attributes_categories',
            data: attributes_categories_data
        });

        //添加/编辑 From的默认数据,和表单验证
        var add_edit_attribute_data = {
            id: '',
            title: "新增属性",
            name: '',
            en_name: '',
            alias_name: '',
            sort: '',
        };
        new Vue({
            el: '#add_edit_attribute',
            data: add_edit_attribute_data,
            methods: {
                submit: function () {
                    if (!add_edit_attribute_data.name){
                        toastr.warning("属性名称不能为空");
                    }else if(!add_edit_attribute_data.alias_name){
                        toastr.warning("属性别名不能为空");
                    }else {
                        var inputs = $("#attribute_edit_form").serialize();
                        var _loading = '';
                        $.ajax({
                            url:"{{secure_route('attribute.update_or_insert')}}",
                            data:inputs,
                            type:'POST',
                            beforeSend:function() {
                                _loading = layer.load();
                            },
                            success: function (response) {
                                if (response.status == 200) {
                                    $("#add_edit_attribute_close_button").click();
                                    toastr.success(response.msg);
                                    var attribute_info = response.content;
                                    if(!attribute_info.isCreated) { //根据wasRecentlyCreated判断是新增还是更新
                                        $(".tree-active>span").text(attribute_info.name);
                                        $(".tree-active").click();
                                    }else {
                                        var html = '<li><div class="level-one tree-active" data-attribute_id="'+ attribute_info.id +'">';
                                        html += '<span class="attribute-name">'+ attribute_info.name +'</span>';
                                        html += '</div></li>';
                                        $(".ul-tree>li>div").removeClass("tree-active");
                                        $(".ul-tree").append(html);
                                        monitoringMenuClick();
                                        $(".tree-active").click();
                                    }
                                }else {
                                    swal("{{trans('Attribute::attribute.warning')}}", response.msg, "error");
                                }
                            },
                            complete: function () {
                                layer.close(_loading);
                            },error: function (xmlHttpRequest, textStatus, errorThrown) {
                                swal("错误", '错误码: '+xmlHttpRequest.status, "error");
                            }
                        });
                    }
                }
            }
        });

        //添加/编辑属性值 From的默认数据,和表单验证
        var add_edit_attribute_value_data = {
            id: '',
            attribute_id: '',
            title: "新增属性值",
            name: '',
            en_name: '',
            sort: '',
        };
        new Vue({
            el: '#add_edit_attribute_value',
            data: add_edit_attribute_value_data,
            methods: {
                submit: function () {
                    if (!add_edit_attribute_value_data.name){
                        toastr.warning("属性值名称不能为空");
                    }else if (!add_edit_attribute_value_data.en_name){
                        toastr.warning("属性值英文名称不能为空");
                    }else {
                        var _loading = '';
                        var inputs = $("#attribute_value_edit_form").serialize();
                        $.ajax({
                            url:"{{secure_route('attrvalue.update_or_insert')}}",
                            data:inputs,
                            type:'POST',
                            beforeSend:function() {
                                _loading = layer.load();
                            },
                            success: function (response) {
                                if (response.status == 200) {
                                    toastr.success(response.msg);
                                    var attribute_values = response.content;
                                    attribute.values = attribute_values;
                                    attributes_values_data.items = attribute.values;
                                    $("#add_edit_attribute_value_close_button").click();
                                }else {
                                    swal("警告", response.msg, "error");
                                }
                            },
                            complete: function () {
                                layer.close(_loading);
                            },error: function (xmlHttpRequest, textStatus, errorThrown) {
                                swal("警告", '错误码: '+xmlHttpRequest.status, "error");
                            }
                        });
                    }
                }
            }
        });

        function refreshAttributeDetailInfo(attribute_id) {
            var _loading = '';
            $.ajax({
                url:"/attribute/detail/"+attribute_id,
                type:'GET',
                beforeSend:function() {
                    _loading = layer.load();
                },
                success: function (response) {
                    if (response.status == 200) {
                        attribute = response.content;
                        updateDetailView(attribute);
                        //更新属性值列表
                        attributes_values_data.items = attribute.attribute_values;
                        //自定义文本不显示属性值添加按钮
                        attributes_values_data.is_custom_text = attribute.type == 2 ? false : true;
                        attributes_values_data.alias = attribute.alias_name;
                        //更新属性关联类别列表
                        attributes_categories_data.items = attribute.categories;
                        //更新编辑//渲染属性值列表Form默认信息
                        updateEditFormDefaultInfo(attribute);
                        add_edit_attribute_value_data.attribute_id = attribute.id;
                        /* 切换属性成功 */
                        $("#attributes_values").find(".pull-right").show();
                        edit_attribute_button();
                        selectProperty();
                        deleteProperty();
                        addValue()
                    }
                },
                complete: function () {
                    layer.close(_loading);
                },error: function (xmlHttpRequest, textStatus, errorThrown) {
                    toastr.error('错误码: '+xmlHttpRequest.status);
                }
            });
        }

        //更新属性详细信息
        function updateDetailView(attribute) {
            attribute_info_data.attribute_info =  attribute;
        }

        //更新编辑Form默认信息
        function updateEditFormDefaultInfo(attribute) {
            add_edit_attribute_data.id = attribute.id;
            add_edit_attribute_data.title = "编辑属性";
            add_edit_attribute_data.name = attribute.name;
            add_edit_attribute_data.en_name = attribute.en_name;
            add_edit_attribute_data.alias_name = attribute.alias_name;
            add_edit_attribute_data.type = attribute.type;
            $("input[type='radio'][name='type'][value='"+ attribute.type +"']").iCheck('check');
            add_edit_attribute_data.sort = attribute.sort;
        }

        //监听一级菜单点击
        function monitoringMenuClick() {
            //菜单级联点击事件
            $(".ul-tree>li>div").on("click",function(){
                $(this).siblings(".ul-tree").slideToggle();
                $(this).find(".fa").toggleClass("fa-angle-down");
                $(".ul-tree>li>div").removeClass("tree-active");
                $(this).addClass("tree-active");
                var attribute_id = $(this).data("attribute_id");
                refreshAttributeDetailInfo(attribute_id);
                //点击时   屏蔽属性编辑&删&属性值添加,修改,删除
                $("#attributes_values").find(".pull-right").hide();//切换属性时隐藏属性值编辑与删除按钮
                $(".delete-property").off("click")
                $("#edit_attribute_button").off("click")
                $("#add_value_button").off("click")
                $(".item-title-tabs>span").off("click")
            });
        }
        //绑定编辑属性\删除属性
        function edit_attribute_button(){
            $("#edit_attribute_button").on('click', function () {
                updateEditFormDefaultInfo(attribute);
                $("#add-property").modal("show")
            });
        }
        //切换属性值/关联类目
        function selectProperty(){
            var itemTabs = $(".item-title-tabs>span");
            var conTabs = $(".edit-property");
            itemTabs.on("click",function(){
                var index = $(this).index();
                itemTabs.removeClass("tab-selected");
                $(this).addClass("tab-selected");
                conTabs.hide().eq(index).show();
            });
        }
        //删除属性
        function deleteProperty(){
            $(".delete-property").on("click",function(){
                var _loading = '';
                $.ajax({
                    url:"{{secure_route('attribute.delete')}}",
                    data:{id: attribute.id, name:attribute.name,_token: "{{csrf_token()}}"},
                    type:'POST',
                    beforeSend:function() {
                        _loading = layer.load();
                    },
                    success: function (response) {
                        if(response.status == 200){
                            toastr.success(response.content);
                            window.location.reload();
                        } else {
                            toastr.warning(response.msg);
                        }
                    },
                    complete: function () {
                        layer.close(_loading);
                    },error: function (xmlHttpRequest, textStatus, errorThrown) {
                        swal("错误", '错误码: '+xmlHttpRequest.status, "error");
                    }
                });
            });
        }
        //添加属性值
        function addValue(){
            $("#add_value_button").on('click', function () {
                add_edit_attribute_value_data.title = '新增属性值';
                add_edit_attribute_value_data.id = '';
                add_edit_attribute_value_data.name = '';
                add_edit_attribute_value_data.en_name = '';
                add_edit_attribute_value_data.sort = '';
                $("#editProperty").modal("show")
            });
        }

        $(function () {
            //切换属性值/关联类目
            selectProperty()
            $('input[type="radio"]').iCheck({
                radioClass: 'iradio_flat-red'
            });
            $('input[type="radio"].radio_type').on('ifChecked',function(event){
                var _this = $(this);
                if (_this.val()==1){
                    $("#div_is_multiselect").hide();
                } else {
                    $("#div_is_multiselect").show();
                }
            });
            monitoringMenuClick();
            $("#add_attribute_button").on('click', function () {
                add_edit_attribute_data.id = '';
                add_edit_attribute_data.title = '添加属性';
                add_edit_attribute_data.name = '';
                add_edit_attribute_data.en_name = '';
                add_edit_attribute_data.alias_name = '';
                add_edit_attribute_data.sort = '';
                $("input[type='radio'][name='type'][value='1']").iCheck('check');
            });


            edit_attribute_button()

            deleteProperty()

            addValue()
        });

        function deleteAttributeValue(attribute_value_id, attribute_value_name) {
            configure = {
                title: "Warning",
                text: "删除属性值"+attribute_value_name+"会导致所有含有该属性值的商品同步清空，且无法恢复，确认删除此属性值吗？",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#444444",
                confirmButtonText: "删除",
                cancelButtonText: "取消",
                closeOnConfirm: false,
                closeOnCancel: true
            };
            swal(configure,function (isConfirm) {
                if (isConfirm) {
                    var _loading = '';
                    $.ajax({
                        url:"{{secure_route('attrvalue.delete')}}",
                        data:{id: attribute_value_id, name:attribute_value_name,_token:"{{csrf_token()}}"},
                        type:'POST',
                        beforeSend:function() {
                            _loading = layer.load();
                        },
                        success: function (response) {
                            if(response.status == 200){
                                toastr.success(response.content);
                                window.location.reload();
                            } else {
                                toastr.warning(response.msg);
                            }
                        },
                        complete: function () {
                            layer.close(_loading);
                        },error: function (xmlHttpRequest, textStatus, errorThrown) {
                            swal("错误", '错误码: '+xmlHttpRequest.status, "error");
                        }
                    });
                }
            });
        }



        function editAttributeValue(attribute_value) {
            add_edit_attribute_value_data.title = "修改属性值";
            add_edit_attribute_value_data.id = attribute_value.id;
            add_edit_attribute_value_data.name = attribute_value.name;
            add_edit_attribute_value_data.en_name = attribute_value.en_name;
            add_edit_attribute_value_data.sort = attribute_value.sort;
        }

        $(function(){
            $("<ul id='autocomplete' class='dropdown-menu'></ul>").hide().insertAfter("#search-text");
            $("#autocomplete").hide();
        });
        function autocomple(){
            $("#autocomplete").empty();
            var _loading = '';
            $.ajax({
                url:"{{secure_route('attribute.search')}}",
                type:"get",
                data:"name="+$("#search-text").val(),
                dataType:"json",
                beforeSend:function() {
                    _loading = layer.load();
                },
                success:function(response){
                    if (response.status == 200) {
                        $("#autocomplete").empty();
                        $("#autocomplete").hide();
                        var data = response.content.attributes;
                        var str = "";
                        $.each(data,function(n,obj){
                            $("#autocomplete").show();
                            str = "<li><a href='#' data-id='"+n+"'>"+obj+"</a><li>";
                            $("#autocomplete").append(str);
                            $("#autocomplete li a").click(function(){
                                //当点击哪个列表时就把它的值load到输入框中
                                $("#search-text").val($(this).text());
                                $("#autocomplete").empty();
                                $("#autocomplete").hide();
                                //模拟点击
                                var clickObject = $(".ul-tree>li").find("div[data-attribute_name='"+$(this).text()+"']");
                                clickObject.trigger("click");
                            });
                        });
                    }

                },
                complete: function () {
                    layer.close(_loading);
                },
                error:function(textStatus){

                }
            });
        }
    </script>
@endsection