@extends('layouts.default')
@section('title')
    {{trans('common.system_name')}}
@endsection
@section('css')
    <style type="text/css">
        .content-item {
            height: 100%;
            border-right: 1px solid #c3c3c3;
            padding: 0;
            overflow: auto;
        }
        .con-item-title {
            line-height: 42px;
            font-size: 18px;
            margin: 0;
            padding-left: 20px;
        }
        .con-item-title span {
            font-weight: 600;
        }
        .con-item-title .fa {
            margin-right: 10px;
            margin-top: 10px;
        }
        .level-two {
            padding-left: 20px;
            color: #4d4d4d;
            border-bottom: 1px solid #e9e9e9;
        }
        .input-group {
            position: relative;
            display: table;
            border-collapse: separate;
        }
        .content-item .form-control {
            height: 40px;
        }
        .dropdown-menu {
            border: medium none;
            border-radius: 3px;
            box-shadow: 0 0 3px rgba(86, 96, 117, 0.7);
            display: none;
            float: left;
            font-size: 12px;
            left: 0;
            list-style: none outside none;
            padding: 0;
            position: absolute;
            text-shadow: none;
            top: 100%;
            z-index: 1000;
        }
        .content-item .input-group-addon {
            border-right: 0;
        }
        .content-item li {
            line-height: 40px;
        }
        .category-list li {
            cursor: pointer;
        }
        .category-list li {
            display: block;
        }
        .level-one {
            padding-left: 10px;
            border-bottom: 1px solid #e9e9e9;
        }
        .level-one .category-name {
            font-size: 16px;
        }
        .level-three {
            padding-left: 30px;
            color: #6e6e6e;
            border-bottom: 1px solid #e9e9e9;
        }
        .category-name {
            margin-right: 5px;
        }
        .category-num {
            color: #d1d1d1;
        }
        .ul-tree .fa {
            font-size: 20px;
            margin-right: 10px;
            margin-top: 10px;
            color: #636363;
        }
        .ul-two, .ul-three {
            display: none;
        }
        .con-message li {
            padding-left: 20px;
            line-height: 35px;
        }
        .mess-name {
            display: inline-block;
            color: #7d7d7d;
            padding-right: 10px;
            vertical-align: top;
        }
        .add {
            width: 70px;
            height: 24px;
            line-height: 23px;
            background: #555;
            color: #fff;
            border: none;
            border-radius: 2px;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                类目属性
                <small>类目管理</small>
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
                    <button type="button" id="addCategoryButton" class="btn btn-success col-xs-offset-9">新增类目</button>
                </div>
                <div class="box-body">
                    <div class="row" style="height: 650px;border: 1px solid #C3C3C4;padding: 0;">
                        <div class="col-xs-3 content-item category-list">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="输入要选择的分类" id="search-text" name="searchValue" value="" maxlength="200" onkeyup="autocomple()"><ul id="autocomplete" class="dropdown-menu" style="display: none;"></ul>
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            </div>
                            <ul class="ul-tree">
                                @foreach($categories as $category)
                                    <?php $category_two_level = $category->subCategories;?>
                                    <li>
                                        <div class="level-one" data-category_id="{{$category->id}}" data-sub_categorys_num="{{count($category_two_level)}}">
                                            <span class="category-name">{{$category->name}}</span>
                                            <span class="category-num">({{count($category_two_level)}})</span>
                                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                        </div>
                                        @if(count($category_two_level)>0)

                                            <ul class="ul-tree ul-two">
                                                @foreach($category_two_level as $subCategory)
                                                    <?php $category_three_level = $subCategory->subCategories;?>
                                                    <li>
                                                        <div class="level-two" data-category_id="{{$subCategory->id}}" data-sub_categorys_num="{{count($category_three_level)}}">
                                                            <span class="category-name">{{$subCategory->name}}</span>
                                                            <span class="category-num">({{count($category_three_level)}})</span>
                                                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                                        </div>
                                                        @if(count($category_three_level)>0)
                                                            <ul class="ul-tree ul-three">
                                                                @foreach($category_three_level as $sub_subCategory)
                                                                    <li>
                                                                        <div class="level-three" data-category_id="{{$sub_subCategory->id}}" data-sub_categorys_num="0">
                                                                            <span class="category-name">{{$sub_subCategory->name}}</span>
                                                                            <span class="category-num">(0)</span>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{--类目详情--}}
                        <div id="category_detail_container" class="col-xs-3 content-item" v-cloak>
                            <h2 class="con-item-title">
                                <span>类目详情</span>
                                <i class="fa fa-trash-o pull-right delete-property" onclick="deleteCategory()" v-show="select_categroy_name"></i>
                                <i class="fa fa-pencil pull-right" id="editCategoryButton" v-show="select_categroy_name"></i>
                            </h2>
                            <ul class="con-message" v-show="select_categroy_name">
                                <li>
                                    <span class="mess-name">类目名称:</span><span class="mess-key">@{{ select_categroy_name }}</span>
                                </li>
                                <li>
                                    <span class="mess-name">英文名称:</span><span class="mess-key">@{{ select_categroy_en_name }}</span>
                                </li>
                                <li>
                                    <span class="mess-name">排序值:</span><span class="mess-key">@{{ select_categroy_sort }}</span>
                                </li>
                                <li>
                                    <span class="mess-name">叶子类目:</span><span class="mess-key">@{{ select_categroy_is_final }}</span>
                                </li>

                            </ul>
                        </div>

                        {{--属性配置--}}
                        <div class="col-xs-3 content-item" id="category_attribute_container">
                            <h2 class="con-item-title">
                                <span>属性配置</span>
                            </h2>
                            <ul class="con-message property" v-show="is_select_category">
                                <li>
                                    <span class="mess-name">基础属性:</span>
                                    <ul class="product-attr">
                                        <li>
                                            <span>商品标题</span>
                                        </li>
                                        <li>
                                            <span>商品卖点</span>
                                        </li>
                                        <li>
                                            <span>商品主图</span>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <span class="mess-name">关键属性 :</span>
                                    <ul id="category_attribute_2" class="category_attribute_ul product-attr">
                                        <li v-show="is_last_category"><button class="add" data-type="2">+ 添加</button></li>
                                    </ul>
                                </li>
                                <li>
                                    <span class="mess-name">销售属性 :</span>
                                    <ul id="category_attribute_3" class="category_attribute_ul product-attr">
                                        <li v-show="is_last_category">
                                            <button class="add" data-type="3">+ 添加</button>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <span class="mess-name">非销售属性:</span>
                                    <ul id="category_attribute_4" class="category_attribute_ul product-attr">
                                        <li v-show="is_last_category">
                                            <button class="add" data-type="4">+ 添加</button>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div id="attribute_detail_container" class="col-xs-3 content-item">
                            <h2 class="con-item-title">
                                <span>属性详情</span>
                                <i class="fa fa-pencil pull-right" id="editAttributeButton" v-show="select_attribute_id"></i>
                            </h2>
                            <ul class="con-message">
                                <li v-for="attribute_item in attribute_items">
                                    <span class="mess-name">@{{ attribute_item.name }}:</span><span class="mess-key">@{{ attribute_item.value }}</span>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->

        <!-- 添加/编辑类目弹窗-->
        <div class="modal fade" id="updateCategoryContainer"  data-backdrop="static" tabindex="-1" aria-hidden="true" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">增加/修改类目</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            {!! csrf_field() !!}
                            <div class="modal-body">
                                <div class="form-group" style="height: 60px;">
                                    <div class="col-xs-1"></div>
                                    <label for="name" class="col-xs-2 control-label">
                                        父级类目：
                                    </label>
                                    <div class="col-xs-7">
                                        <select name="first_level_category" id='firstCategoryLevel' class="form-control">
                                            <option value="-1">一级类目</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        <select name="second_level_category" id= 'secondCategoryLevel' class="form-control">
                                            <option value="-1">二级类目</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" style="height: 30px;">
                                    <div class="col-xs-1"></div>
                                    <label for="name" class="col-xs-2 control-label">
                                        类目名称：
                                    </label>
                                    <div class="col-xs-7">
                                        <input name="name" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group" style="height: 30px;">
                                    <div class="col-xs-1"></div>
                                    <label for="name" class="col-xs-2 control-label">
                                        英文名称：
                                    </label>
                                    <div class="col-xs-7">
                                        <input name="en_name" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group" style="height: 30px;">
                                    <div class="col-xs-1"></div>
                                    <label for="name" class="col-xs-2 control-label">
                                        排序值：
                                    </label>
                                    <div class="col-xs-7">
                                        <input name="sort" value="0" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group" style="height: 30px;">
                                    <div class="col-xs-1"></div>
                                    <label for="name" class="col-xs-2 control-label">
                                        叶子类目：
                                    </label>
                                    <div class="col-xs-7">
                                        <input name="is_final" value="0" type="radio" checked>否
                                        <input name="is_final" value="1" type="radio">是
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                    <button type="button" class="btn btn-primary" id="saveUpdateCategoryInfoButton">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- 添加属性弹窗-->
        <div class="modal fade " id="configure_attribue_container" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">属性配置</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div class="col-sm-4 prop-property choice-style" id="prop-list-style" style="max-height: 650px;overflow-y: auto;">
                            <div class="input-group">
                                <input type="text" class="form-control" id="search_attribute_input">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            </div>
                            <div id="attribue_name_container" class="ul-popup">
                                <div class="radio select-input" v-for="attribute in attributes">
                                    <label><input type="radio" name="optionsRadios" @click="changeSelectValue($event)" v-bind:value="attribute.id" v-bind:data-name="attribute.name" v-model="attribue_picked_id">@if(App::isLocale('en'))@{{attribute.en_name}}@else@{{attribute.name}}@endif</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 prop-property choice-style" id="prop-add-style" style="max-height: 650px;overflow-y: auto;">
                            <div class="input-group">
                                <input type="text" class="form-control" id="search_attribute_value_input">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            </div>
                            <div class="select-all-box"><button class="select-all" data-selected="0">全选</button></div>
                            <div id="attribue_value_container" class="ul-popup add-pro-color">
                                <div class="select-input checkbox"  v-for="attribute_value in attribute_values">
                                    <label><input type="checkbox" v-bind:value="attribute_value.id" v-model="attribue_value_container_picked">
                                        @if(App::isLocale('en'))@{{ attribute_value.en_name }}@else@{{ attribute_value.name }}@endif
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="configure_attribute_detail_container" class="col-sm-4 prop-property" style="max-height: 650px;overflow-y: auto;">
                            <div>
                                <h4>属性详情</h4>
                                <div class="form-group" v-show="attr_type == 3">
                                    <div class="" style="margin-left: 10px">是否图片属性:</div>
                                    <label  class="property-radio">
                                        <input type="radio" name="is_image" value="2"  v-model="is_image">
                                        否
                                    </label>
                                    <label class="property-radio">
                                        <input type="radio" name="is_image" value="1"  v-model="is_image">
                                        是
                                    </label>
                                </div>
                                <div class="form-group" v-show="attr_type == 3">
                                    <div class="" style="margin-left: 10px">是否支持自定义:</div>
                                    <label  class="property-radio">
                                        <input type="radio" name="is_diy" value="2"  v-model="is_diy">
                                        不支持
                                    </label>
                                    <label class="property-radio">
                                        <input type="radio" name="is_diy" value="1"  v-model="is_diy">
                                        支持
                                    </label>
                                </div>
                                <div class="form-group">
                                    <div class="" style="margin-left: 10px">是否必填:</div>
                                    <label  class="property-radio">
                                        <input type="radio" name="is_required" value="1"  v-model="is_required">
                                        必填
                                    </label>
                                    <label class="property-radio">
                                        <input type="radio" name="is_required" value="2"  v-model="is_required">
                                        非必填
                                    </label>
                                </div>
                                <div class="form-group">
                                    <div class="" style="margin-left: 10px">单选/多选:</div>
                                    <label  class="property-radio">
                                        <input type="radio" name="check_type" value="2" v-model="check_type">
                                        单选
                                    </label>
                                    <label class="property-radio">
                                        <input type="radio" name="check_type" value="1" v-model="check_type">
                                        多选
                                    </label>
                                </div>
                                <div class="form-group" v-show="attr_type == 4">
                                    <div class="" style="margin-left: 10px">是否详情显示:</div>
                                    <label  class="property-radio">
                                        <input type="radio" name="is_detail" value="2" v-model="is_detail">
                                        不显示
                                    </label>
                                    <label class="property-radio">
                                        <input type="radio" name="is_detail" value="1" v-model="is_detail">
                                        显示
                                    </label>
                                </div>

                                <ul class="con-message">
                                    <li v-for="attribute_item in attribute_items">
                                        <span class="mess-name">@{{ attribute_item.name }}:</span><span class="mess-key">@{{ attribute_item.value }}</span>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button id="configure_attribue_container_submit" type="button" class="btn btn-primary">保存</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal end-->
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/vue.js')}}" type="text/javascript"></script>
    <script>
        //点击添加属性时点击的按钮所在dom
        var add_sel = '';
        var select_category_id = undefined;

        //reload
        function reload(){
            location.reload();
        }

        //分类详情的vue
        var category_detail_vue = new Vue({
            el: '#category_detail_container',
            data: {
                select_categroy_name: '',
                select_categroy_en_name: '',
                select_categroy_sort: '',
                select_categroy_is_final: 0,
            }
        })

        //属性详情vue
        var attribute_detail_container_vue = new Vue({
            el: '#attribute_detail_container',
            data: {
                attribute_items:[],
                select_attribute_id:'',
                select_attribute_name:'',
                select_attribute_type:''
            }
        })

        //配置属性栏vue
        var category_attribute_container_vue = new Vue({
            el: '#category_attribute_container',
            data: {
                is_select_category:false,
                is_last_category:false
            },
            computed: {
                is_select_category: function () {
                    return !(select_category_id == undefined);
                },
            }
        })

        //属性值vue
        var attribue_value_container_vue = new Vue({
            el: '#attribue_value_container',
            data: {
                backup_attribute_values:[],
                attribute_values:[],
                attribue_value_container_picked:[],
            },
            methods:{
            }
        })

        //属性名vue
        var attribue_name_container_vue
            = new Vue({
            el: '#attribue_name_container',
            data: {
                type:'',
                backup_attributes:[],
                attributes:[],
                attribue_picked_id:'',
                attribue_picked_name:'',
            },
            methods:{
                changeSelectValue:function (el) {
                    layer.load(1);
                    if(el == undefined){
                        this.attribue_picked_name = attribute_detail_container_vue.select_attribute_name;
                    }else{
                        this.attribue_picked_name = $(el.target).data('name');
                    }
                    configure_attribute_detail_container_vue.attr_type = attribue_name_container_vue.type;

                    attribue_value_container_vue.attribute_values = [];
                    attribue_value_container_vue.backup_attribute_values = [];
                    attribue_value_container_vue.attribue_value_container_picked = [];
                    $.ajax({
                        url:"/category/"+select_category_id+"/attribute/"+this.attribue_picked_id+'/detail',
                        type:'GET',
                        success: function (response) {
                            if (response.status == 200) {
                                console.log(600,response.content);
                                attribue_value_container_vue.attribute_values = response.content.attribute_values;
                                attribue_value_container_vue.backup_attribute_values = attribue_value_container_vue.attribute_values;
                                configure_attribute_detail_container_vue.attribute_items = response.content.attribute_items;
                                attribue_value_container_vue.attribue_value_container_picked=response.content.attribute_exist_values_id; //如果属性分类值已经有,勾选上
                                configure_attribute_detail_container_vue.is_image = response.content.is_image ? response.content.is_image : 0;
                                configure_attribute_detail_container_vue.is_diy = response.content.is_diy ? response.content.is_diy : 0;
                                configure_attribute_detail_container_vue.is_custom_text = response.content.is_custom_text;
                                configure_attribute_detail_container_vue.check_type = response.content.check_type;
                                configure_attribute_detail_container_vue.is_required = response.content.is_required;
                                configure_attribute_detail_container_vue.is_detail = response.content.is_detail;
                            }
                        },complete: function () {
                            layer.closeAll('loading');
                        },error: function (xmlHttpRequest, textStatus, errorThrown) {
                            toastr.warning('错误码: '+xmlHttpRequest.status);
                        }
                    });
                }
            }
        })

        //配置属性vue
        var configure_attribute_detail_container_vue = new Vue({
            el: '#configure_attribute_detail_container',
            data: {
                attribute_items:[],
                is_custom_text:0,
                attr_type:'',
                check_type:'',
                is_required:'',
                is_image:'',
                is_diy:'',
                is_detail:'',
            }
        });

        //菜单级联点击事件
        $(".ul-tree>li>div").on("click",function(){
            $(this).siblings(".ul-tree").slideToggle();
            $(this).find(".fa").toggleClass("fa-angle-down");
            $(".ul-tree>li>div").removeClass("tree-active");
            $(this).addClass("tree-active");
            select_category_id = $(this).data('category_id'); //当前选中的cateogory_id
            sub_categorys_num = $(this).data('sub_categorys_num');
            category_attribute_container_vue.is_select_category = true;
            category_attribute_container_vue.is_last_category = sub_categorys_num>0?false:true;
            refreshCategoryDetailInfo(select_category_id);
            refreshCategoryAttributes(select_category_id);
        });

        $(function(){
            $("<ul id='autocomplete' class='dropdown-menu'></ul>").hide().insertAfter("#search-text");
            $("#autocomplete").hide();
        });
        function autocomple(){
            $("#autocomplete").empty();
            $.ajax({
                url:"searchCategory",
                type:"get",
                data:"name="+$("#search-text").val(),
                dataType:"json",
                success:function(response){
                    if (response.status == 200) {
                        $("#autocomplete").empty();
                        $("#autocomplete").hide();
                        var data = response.content.categories;
                        var str = "";
                        $.each(data,function(n,obj){
                            $("#autocomplete").show();
                            str = "<li><a href='#' data-id='"+n+"'>"+obj+"</a><li>";
                            $("#autocomplete").append(str);
                            $("#autocomplete li a").click(function(){
                                //点击列表初始化类目列表，只显示一级类目，并且去掉所有选中效果
                                $(".ul-tree>li>div").removeClass("tree-active");
                                $(".ul-two").hide();
                                $(".ul-three").hide();
                                //当点击哪个列表时就把它的值load到输入框中
                                $("#search-text").val($(this).text());
                                $("#search-text").data('category_id', $(this).data('id'));
                                $("#autocomplete").empty();
                                $("#autocomplete").hide();
                                //模拟点击
                                //alert(n);
                                var clickObject = $(".ul-tree>li").find("div[data-category_id='"+$(this).data('id')+"']");
                                var clickAttr = clickObject.attr('class');console.log(clickAttr);
                                if(clickAttr == 'level-one'){
                                    clickObject.trigger("click");
                                } else if (clickAttr == 'level-two') {
                                    clickObject.parent().parent().siblings("div[class='level-one']").trigger("click");
                                    clickObject.trigger("click");
                                } else if (clickAttr == 'level-three') {
                                    clickObject.parent().parent().parent().parent().siblings("div[class='level-one']").trigger("click");
                                    clickObject.parent().parent().siblings("div[class='level-two']").trigger("click");
                                    clickObject.trigger("click");
                                }

                            });
                        });
                    }

                },
                error:function(textStatus){

                }
            });
        }

        //根据分类id获取下级类目
        $("#firstCategoryLevel").change(function(){
            var category_id = $(this).children('option:selected').val();
            if(category_id < 0){
                $("#secondCategoryLevel").empty();
                $("#secondCategoryLevel").prepend("<option value='-1'>{{trans('Category::category.select_second_category')}}</option>"); //为Select插入一个Option(第一个位置)
                return;
            }
            $.ajax({
                url:"{{secure_route('category.subcategories')}}",
                data:{'category_id':category_id,_token: "{{csrf_token()}}"},
                type:'POST',
                success: function (response) {
                    if (response.status == 200) {
                        $("#secondCategoryLevel").empty();
                        $("#secondCategoryLevel").prepend("<option value='-1'>二级类目</option>"); //为Select插入一个Option(第一个位置)
                        for(var i = 0;i<response.content.length;i++){
                            var html = "<option value="+response.content[i].id+">"+response.content[i].name+"</option>";
                            $("#secondCategoryLevel").append(html); //为Select追加一个Option(下拉项)
                        }
                    }
                },
                complete: function () {
                },error: function (xmlHttpRequest, textStatus, errorThrown) {
                    toastr.warning('错误码: '+xmlHttpRequest.status);
                }
            });
        });

        //添加新类目
        $("#addCategoryButton").on("click",function () {
            resetUpdateCategoryContainer();
            $('#updateCategoryContainer').modal('show');
        });

        //点击编辑类目
        $("#editCategoryButton").on("click",function () {
            category_id = select_category_id;
            if(category_id == undefined){
                toastr.warning('请选择一个分类',0);
                return;
            }

            //选定的类信息赋值到输入框
            $("#updateCategoryContainer").find("input[name=name]").val(category_detail_vue.select_categroy_name);
            $("#updateCategoryContainer").find("input[name=en_name]").val(category_detail_vue.select_categroy_en_name);
            $("#updateCategoryContainer").find("input[name=sort]").val(category_detail_vue.select_categroy_sort);
            $("#updateCategoryContainer").find("input[name=is_final][value="+category_detail_vue.select_categroy_is_final+"]").attr("checked",true);

            $("#saveUpdateCategoryInfoButton").data('category_id',category_id);

            //请求分类信息
            //显示编辑
            $.ajax({
                url:"/category/current_category_info/"+category_id,
                type:'GET',
                success: function (response) {
                    if (response.status == 200) {
                        $("#firstCategoryLevel").val(response.content.current_first_level_category.id);   //设置Select的Text值为jQuery的项选中


                        //console.log(response.content.current_first_level_category.amoeba_operator_id);

                        //$("#updateCategoryContainer").find("#amoeba_operator_id").val(response.content.current_first_level_category.amoeba_operator_id);//设置归属小组值.
                        $("#secondCategoryLevel").empty();
                        $("#secondCategoryLevel").prepend("<option value='-1'>二级类目</option>"); //为Select插入一个Option(第一个位置)
                        //分类详情
                        if(response.content.second_level_categories != undefined){
                            for(var i = 0;i<response.content.second_level_categories.length;i++){
                                var html = "<option value="+response.content.second_level_categories[i].id+">"+response.content.second_level_categories[i].name+"</option>";
                                $("#secondCategoryLevel").append(html); //为Select追加一个Option(下拉项)
                            }
                            $("#secondCategoryLevel").val(response.content.current_second_level_category.id);   //设置Select的Text值为jQuery的项选中
                        }
                    }
                },
                complete: function () {
                },error: function (xmlHttpRequest, textStatus, errorThrown) {
                    toastr.warning('错误码: '+xmlHttpRequest.status);
                }
            });
            $('#updateCategoryContainer').modal('show');
        })

        //保存类目信息
        $("#saveUpdateCategoryInfoButton").on("click",function () {
            first_level_category = $("#firstCategoryLevel").val();
            second_level_category = $("#secondCategoryLevel").val();
            name = $("#updateCategoryContainer").find("input[name=name]").val();
            en_name = $("#updateCategoryContainer").find("input[name=en_name]").val();
            sort = $("#updateCategoryContainer").find("input[name=sort]").val();
            is_final = $("#updateCategoryContainer").find("input[name=is_final]:checked").val();
            category_id = $("#saveUpdateCategoryInfoButton").data('category_id');

            if(category_id != undefined && first_level_category < 0){
                toastr.warning("{{trans('Category::category.please_select_a_category')}}",0);
                return;
            }
            if(name.length < 1){
                toastr.warning("{{trans('Category::category.please_enter_category_name')}}",0);
                return;
            }
            if(sort.length < 1){
                toastr.warning("{{trans('Category::category.please_enter_a_sort_value')}}",0);
                return;
            }
            if(category_id == undefined){
                category_id = '';
            }
            $.ajax({
                url:"{{secure_route('category.update')}}",
                data:{
                    "category_id":category_id,
                    "first_level_category":first_level_category,
                    "second_level_category":second_level_category,
                    "name":name,
                    "en_name":en_name,
                    "sort":sort,
                    "is_final": is_final,
                    "_token":"{{csrf_token()}}",
                },
                type:'POST',
                success: function (response) {
                    if (response.status == 200) {
                        toastr.success(response.msg);
                        $('#updateCategoryContainer').modal('hide');
                        reload();
                    }else {
                        toastr.warning('错误码: '+response.status+','+response.msg);
                    }
                },
                complete: function () {
                },error: function (xmlHttpRequest, textStatus, errorThrown) {
                    toastr.warning('错误码: '+xmlHttpRequest.status);
                }
            });
        });

        //删除类目
        function deleteCategory()
        {
            category_id = select_category_id;
            if(category_id == undefined){
                toastr.warning("{{trans('Category::category.please_select_category')}}",0);
                return;
            }
            configure = {
                title: "Warning",
                text: "删除"+category_detail_vue.select_categroy_name+"类目会导致此类目下所有商品同步清空，且无法恢复，确认要删除此类目吗？",
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
                    $.ajax({
                        url:"/category/"+category_id+'/delete',
                        type:'GET',
                        success: function (response) {
                            if (response.status == 200) {
                                swal("删除成功!", "", "success");
                                reload();
                            }else{
                                toastr.warning('错误码: '+response.status+','+response.msg);
                            }
                        },
                        complete: function () {
                        },error: function (xmlHttpRequest, textStatus, errorThrown) {
                            toastr.warning('错误码: '+xmlHttpRequest.status);
                        }
                    });
                }
            });
        }

        //重置编辑/新增类目页面
        function resetUpdateCategoryContainer() {
            $("#firstCategoryLevel").val(-1);
            $("#secondCategoryLevel").empty();
            $("#secondCategoryLevel").prepend("<option value='-1'>二级类目</option>"); //为Select插入一个Option(第一个位置)
            $("#updateCategoryContainer").find("input[name=name]").val('');
            $("#updateCategoryContainer").find("input[name=sort]").val('');
            $("#updateCategoryContainer").find("input[name=is_final]").val('0');
            $("#saveUpdateCategoryInfoButton").removeData('category_id');
        }

        //刷新类目详细信息
        function refreshCategoryDetailInfo(category_id) {
            $.ajax({
                url:"/category/detail/"+category_id,
                type:'GET',
                success: function (response) {
                    if (response.status == 200) {
                        category = JSON.parse(response.content);
                        category_detail_vue.select_categroy_name = category.name;
                        category_detail_vue.select_categroy_en_name = category.en_name;
                        category_detail_vue.select_categroy_sort = category.sort;
                        category_detail_vue.select_categroy_is_final = category.is_final;
                    }
                },
                complete: function () {
                },error: function (xmlHttpRequest, textStatus, errorThrown) {
                    toastr.warning('错误码: '+xmlHttpRequest.status);
                }
            });
        }

        //刷新分类属性
        function refreshCategoryAttributes(category_id) {
            $.ajax({
                url:"{{secure_route('category.attribute')}}",
                data:{
                    'category_id':category_id,
                    '_token': "{{csrf_token()}}"
                },
                type:'POST',
                success: function (response) {
                    //目前类型就
                    $('.category_attribute_ul').children('li .attribute_class').remove();
                    attribute_detail_container_vue.attribute_items = [];
                    attribute_detail_container_vue.select_attribute_id = '';
                    attribute_detail_container_vue.select_attribute_type = '';
                    attribute_detail_container_vue.select_attribute_name = '';
                    if (response.status == 200) {
                        for(var type in response.content){
                            var attributes = response.content[type];
                            for(var index = 0; index < attributes.length; index++){
                                console.log(attributes[index].attr_type);
                                addOneAttribute('category_attribute_'+type,attributes[index].id,attributes[index].name,attributes[index].attr_type);
                            }
                        }
                    }else{
                        toastr.warning('错误码: '+response.status+','+response.msg);
                    }
                },
                complete: function () {
                },error: function (xmlHttpRequest, textStatus, errorThrown) {
                    toastr.warning('错误码: '+xmlHttpRequest.status);
                }
            });
        }

        $("#search_attribute_input").on('input',function(){
            var input_val = $(this).val();
            attribue_value_container_vue.attribute_values = [];
            attribue_value_container_vue.attribue_value_container_picked = [];
            attribue_name_container_vue.attribue_picked_id = '';
            attribue_name_container_vue.attributes = $.grep(attribue_name_container_vue.backup_attributes,function(attribute){
                return (attribute.name.indexOf(input_val) >=0)
            });
        });

        $("#search_attribute_value_input").on('input',function(){
            var input_val = $(this).val();
            attribue_value_container_vue.attribue_value_container_picked = [];
            attribue_value_container_vue.attribute_values = $.grep(attribue_value_container_vue.backup_attribute_values,function(attribute_value){
                return (attribute_value.name.indexOf(input_val) >=0)
            });
        });

        //点击属性,刷新属性右边的信息
        function clickOneAttribute()
        {
            $(".attribute_class").find("span").removeClass("active");
            $(this).addClass("active");
            category_id = select_category_id;
            attribute_id = $(this).data('attribute_id');
            if(category_id == undefined || attribute_id == undefined)return;
            attribute_detail_container_vue.select_attribute_id = $(this).data('attribute_id');
            attribute_detail_container_vue.select_attribute_type = $(this).data('attribute_type');
            console.log(attribute_detail_container_vue.select_attribute_type);
            attribute_detail_container_vue.select_attribute_name = $(this).data('attribute_name');
            layer.load(1);
            $.ajax({
                url:"/category/"+category_id+"/attribute/"+attribute_detail_container_vue.select_attribute_id+'/detail',
                type:'GET',
                success: function (response) {
                    if (response.status == 200) {
                        attribute_detail_container_vue.attribute_items = response.content.attribute_items;
                    }else{
                        attribute_detail_container_vue.attribute_items = [];
                    }
                },
                complete: function () {
                    layer.closeAll('loading');
                },error: function (xmlHttpRequest, textStatus, errorThrown) {
                    toastr.warning('错误码: '+xmlHttpRequest.status);
                }
            });
        }

        //点击添加属性
        $('.category_attribute_ul li button.add').on("click",function () {
            configureAttributes($(this).data('type'),'');
        })

        //点击编辑类目属性
        $("#editAttributeButton").on("click",function () {
            console.log(attribute_detail_container_vue.select_attribute_type);
            configureAttributes(attribute_detail_container_vue.select_attribute_type,attribute_detail_container_vue.select_attribute_id);
        })

        //添加一个属性
        function addOneAttribute(sel,id,value,type) {
            var itemSpan = $("<span>").html(value);
            var itemDeleteBtn = $("<i>").addClass("fa fa-trash-o delete-property");
            var item = $("<li>").addClass('attribute_class').append(itemSpan).append(itemDeleteBtn);
            itemSpan.data('attribute_id',id);
            itemSpan.data('attribute_type',type);
            itemSpan.data('attribute_name',value);
            item.data('attribute_id',id);
            $("#"+sel).prepend(item);
            itemSpan.click(clickOneAttribute);
            itemDeleteBtn.data('attribute_type',type);
            itemDeleteBtn.click(deleteOneAttribute);
            return item;
        }

        //删除一个属性
        function deleteOneAttribute() {
            attribute_id = $(this).parent().data('attribute_id');
            attribute_type = $(this).data('attribute_type');
            category_id = select_category_id;
            will_delete_dom = $(this).parent();
            $.ajax({
                url:"/category/attribute/deleteRule",
                data:{
                    'category_id':category_id,
                    'attribute_id':attribute_id,
                    'attribute_type':attribute_type,
                },
                type:'POST',
                success: function (response) {
                    if(response.status == 200){
                        swal({
                            title: "",
                            text: response.content,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#444444",
                            confirmButtonText: "删除",
                            cancelButtonText: "取消",
                            closeOnConfirm: false,
                            closeOnCancel: true
                        },function(){
                            $.ajax({
                                url:"/category/attribute/delete",
                                data:{
                                    'category_id':category_id,
                                    'attribute_id':attribute_id,
                                },
                                type:'POST',
                                success:function(response){
                                    if(response.status == 200){
                                        will_delete_dom.remove();
                                        attribute_detail_container_vue.attribute_items =[];
                                        swal("删除成功", "success");
                                    } else {
                                        swal("警告", response.msg, "error");
                                    }
                                },
                                complete: function () {

                                },
                                error: function (xmlHttpRequest, textStatus, errorThrown) {
                                    toastr.warning('错误码: '+xmlHttpRequest.status);
                                }
                            })
                        });
                    } else {
                        swal("警告", response.msg, "error");
                    }
                },
                complete: function () {

                },error: function (xmlHttpRequest, textStatus, errorThrown) {
                    swal("错误", '错误码: '+xmlHttpRequest.status, "error");
                }
            });
        }

        //配置属性
        function configureAttributes(type,attribute_id) {
            //显示前重置这个页面
            attribue_value_container_vue.attribute_values = [];
            attribue_value_container_vue.attribue_value_container_picked = [];
            attribue_name_container_vue.attribue_picked_id = '';
            attribue_name_container_vue.attribue_picked_name = '';
            attribue_name_container_vue.attributes = [];
            attribue_name_container_vue.backup_attributes = [];
            attribue_name_container_vue.type = '';
            $('#configure_attribue_container').modal('show');


            attribue_name_container_vue.type = type; //保存添加的属性类别
            configure_attribute_detail_container_vue.attr_type = type;//区分属性类型
            layer.load(1);
            //获取所有的属性名(已配置除外)
            $.ajax({
                url:"{{secure_route('attribute.all')}}",
                type:'get',
                success: function (response) {
                    if (response.status == 200) {
                        attribue_name_container_vue.backup_attributes = response.content;
                        attribue_name_container_vue.attributes = response.content;
                        attribue_name_container_vue.attribue_picked_id = attribute_id;
                        if(attribute_id && attribute_id.toString().length > 0){
                            attribue_name_container_vue.changeSelectValue(undefined);
                        }
                    }else{
                        attribue_name_container_vue.attributes = [];
                        attribue_name_container_vue.backup_attributes = [];
                    }
                },
                complete: function () {
                    layer.closeAll('loading');
                },error: function (xmlHttpRequest, textStatus, errorThrown) {
                    toastr.warning('错误码: '+xmlHttpRequest.status);
                }
            });
        }

        //添加属性完成提交
        $("#configure_attribue_container_submit").on("click",function () {
            if(attribue_name_container_vue.attribue_picked_id.length<1){
                toastr.warning('请选择属性名');
                return;
            }
            if(configure_attribute_detail_container_vue.is_custom_text == 0){
                if(attribue_value_container_vue.attribue_value_container_picked.length<1){
                    toastr.warning('请选择属性值');
                    return;
                }
            }

            category_id = select_category_id;
            type = attribue_name_container_vue.type;
            is_required = $("input[name='is_required']:checked").val();
            check_type = $("input[name='check_type']:checked").val();
            is_image = $("input[name='is_image']:checked").val();
            is_diy = $("input[name='is_diy']:checked").val();
            is_detail = $("input[name='is_detail']:checked").val();
            layer.load(1);
            console.log(attribue_name_container_vue.attribue_picked_name);
            $.ajax({
                url:"{{secure_route('category.attribute.update')}}",
                type:'POST',
                data:{
                    'type':type,
                    'category_id':category_id,
                    'attribute_id':attribue_name_container_vue.attribue_picked_id,
                    'values_id':attribue_value_container_vue.attribue_value_container_picked,
                    'is_required':is_required,
                    'is_image':is_image,
                    'is_diy':is_diy,
                    'is_detail':is_detail,
                    'check_type':check_type,
                    '_token': "{{csrf_token()}}"
                },
                success: function (response) {
                    if (response.status == 200) {
                        $('#configure_attribue_container').modal('hide');
                        //判断是否已经存在了
                        var is_exist = false;
                        $('#category_attribute_'+type+' li.attribute_class span').each(function(){
                            console.log($(this).html());
                            console.log('click'+' ====='+attribue_name_container_vue.attribue_picked_name);

                            if($(this).html() == attribue_name_container_vue.attribue_picked_name){
                                is_exist = true;
                                console.log('clickddd');
                                $(this).click();
                            }
                        });
                        console.log(is_exist);
                        if(!is_exist){
                            item = addOneAttribute('category_attribute_'+type,attribue_name_container_vue.attribue_picked_id,attribue_name_container_vue.attribue_picked_name,type);
                            $(item).children('span').eq(0).click();
                        }
                        toastr.success('处理成功!');
                    }else{
                        toastr.warning('错误码: '+response.status+','+response.msg);
                    }
                },
                complete: function () {
                    layer.closeAll('loading');
                },error: function (xmlHttpRequest, textStatus, errorThrown) {
                    toastr.warning('错误码: '+xmlHttpRequest.status);
                }
            });
        })
        // 全选
        $(".select-all").on("click",function(){
            var array= new Array();
            var values = attribue_value_container_vue.attribute_values;
            for(var i=0;i<values.length;i++){
                array.push(values[i].id);
            }
            attribue_value_container_vue.attribue_value_container_picked=array;
        });

        $(function(){
            //  点击静止滚屏
            $("body").on("click",".category_attribute_ul .add",function(){
                $("#configure_attribue_container").css({
                    // overflow:"hidden",
                    // height:"100%"
                });
            });
            $(document).keyup(function(e){
                if(e.which == '27'){
                    $("body").css({
                        position:"static",
                        height:"100%",
                        overflow:"hidden"
                    });
                    $("#configure_attribue_container").css({
                        overflow:"static",
                        height:"100%"
                    });
                }
            })
        });

        $("input[name='is_image'][value='1']").on("click", function(){
            $.ajax({
                url:"/category/existCategoryPicAttribute",
                data:{category_id: select_category_id,attribute_id:attribue_name_container_vue.attribue_picked_id},
                type:'GET',
                success: function (response) {
                    if(response.status != 200){
                        swal({
                                title: "",
                                text: response.msg,
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#444444",
                                confirmButtonText: "确认",
                                cancelButtonText: "取消",
                                closeOnConfirm: true,
                                closeOnCancel: true
                            }, function (isConfirm) {
                                if (isConfirm) {
                                    $("input[name='is_image'][value='1']").prop('checked',true);
                                    $("input[name='is_image'][value='2']").prop('checked',false);
                                } else {
                                    $("input[name='is_image'][value='1']").prop('checked',false);
                                    $("input[name='is_image'][value='2']").prop('checked',true);
                                }
                            });
                    }
                },
                complete: function () {

                },error: function (xmlHttpRequest, textStatus, errorThrown) {
                    swal("错误", '错误码: '+xmlHttpRequest.status, "error");
                }
            });
        })

    </script>

@endsection