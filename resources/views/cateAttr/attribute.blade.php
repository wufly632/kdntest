@extends('layouts.default')
@section('css')
    <link rel="stylesheet" href="{{asset('/assets/css/reset.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/category.css')}}">
    <script src="{{asset('/assets/js/category.js')}}"></script>
    <style>
        .admin-text{background-color: #ecf0f5;}
    </style>
@endsection
@section('content')
    <div class="admin-text">
        <div class="jvdou-min admin-pol">
            <div class="mose-type mose-num clearfix">
                <div class="type-details">
                    <div class="type-head clearfix">
                        <h3>属性列表</h3>
                        <div class="type-option">
                            <a href="javascript:;" class="modify" data-target="#addCatalog" data-toggle="modal">新增</a>
                        </div>
                    </div>
                    <div class="prop-input" id="attribute_search">
                        <input type="text" class="green" name="attr_name">
                        <i class="iconfont">&#xe600;</i>
                    </div>
                    <ul id="attr_list" class="add-product prop-product">

                    </ul>
                </div>
                <div class="type-details prop-two" id="attribute_update">
                    <div class="type-head clearfix">
                        <h3>属性详情</h3>
                        <div class="type-option">
                            <a href="javascript:;" class="keep">保存</a>
                            <a href="javascript:;" class="return">返回</a>
                        </div>
                    </div>
                    <input name="id" type="hidden" value="">
                    <div class="exn-log clearfix">
                        <h6>属性名称：</h6>
                        <div class="exn-right">
                            <input type="text" class="green " name="name" value="" >
                            <label class="error"></label>
                        </div>
                    </div>
                    <div class="exn-log clearfix">
                        <h6>属性别名：</h6>
                        <div class="exn-right">
                            <input type="text" class="green" name="alias_name" value="" >
                            <label class="error"></label>
                        </div>
                    </div>
                    <div class="exn-log clearfix">
                        <h6>属性值类型：</h6>
                        <div class="exn-right clearfix">
                            <label>
                                <input type="radio" name="type" value="1"/>
                                <span>标准化文本</span>
                            </label>
                            <label>
                                <input type="radio" name="type" value="2"/>
                                <span>自定义文本</span>
                            </label>
                        </div>
                    </div>
                    <div class="exn-log clearfix">
                        <h6>排序值：</h6>
                        <div class="exn-right">
                            <input type="text" class="green" name="sort" value="99" >
                            <label class="error"></label>
                        </div>
                    </div>
                </div>
                <div class="type-details prop-three">
                    <div class="type-head clearfix">
                        <h3>属性详情</h3>
                        <div class="type-option">
                            <a href="javascript:;" class="deletes">删除</a>
                            <a href="javascript:;" class="modify">修改</a>
                        </div>
                    </div>
                    <div class="exn-log clearfix">
                        <h6>属性名称：</h6>
                        <div class="exn-right">
                            <p id="attr_detail_name"></p>
                        </div>
                    </div>
                    <div class="exn-log clearfix">
                        <h6>属性别名：</h6>
                        <div class="exn-right">
                            <p id="attr_detail_alias_name"></p>
                        </div>
                    </div>
                    <div class="exn-log clearfix">
                        <h6>属性值类型：</h6>
                        <div class="exn-right">
                            <p id="attr_detail_type"></p>
                        </div>
                    </div>
                    <div class="exn-log clearfix">
                        <h6>排序值：</h6>
                        <div class="exn-right">
                            <p id="attr_detail_sort"></p>
                        </div>
                    </div>
                </div>
                <div class="type-details">
                    <div class="type-head clearfix">
                        <h3>属性值</h3>
                        <div class="type-option">
                            <a href="javascript:;" class="modify" id="attribute_value_add" data-target="#addProp" data-toggle="modal">新增</a>
                        </div>
                    </div>
                    <div class="prop-input" id="attr_value_search">
                        <input type="text" class="green" name="value_name">
                        <i class="iconfont">&#xe600;</i>
                    </div>
                    <ul id="attr_value_list" class="add-product prop-product prop-active">

                    </ul>
                </div>
                <div class="type-details">
                    <div class="type-head clearfix">
                        <h3>关联类目</h3>
                    </div>
                    <ul class="add-product prop-product prop-active rel-ation" id="category_list">

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div id="addCatalog" class="forios  prop-cate modal hide fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <h3>新增属性</h3>
        <form class="forios-log" onsubmit="return attribute_create(this);">
            <div class="category clearfix">
                <h6>属性名称：</h6>
                <div class="iu-input">
                    {!! csrf_field() !!}
                    <input type="text" name="name" class="green"/>
                    <label class="error"></label>
                </div>
            </div>
            <div class="category clearfix">
                <h6>属性别名：</h6>
                <div class="iu-input">
                    <input type="text" name="alias_name" class="green"/>
                    <label class="error"></label>
                </div>
            </div>
            <div class="category clearfix">
                <h6>英文名：</h6>
                <div class="iu-input">
                    <input type="text" name="en_name" class="green"/>
                    <label class="error"></label>
                </div>
            </div>
            <div class="category radios clearfix">
                <h6>属性值类型：</h6>
                <div class="exn-right clearfix">
                    <label>
                        <input type="radio" value="1" name="type" checked>
                        <span>标准化文本</span>
                    </label>
                    <label>
                        <input type="radio" value="2" name="type">
                        <span>自定义文本</span>
                    </label>
                </div>
            </div>
            <div class="category clearfix">
                <h6>排序值：</h6>
                <div class="iu-input">
                    <input type="text" name="sort" class="green min " value="99"/>
                    <label class="error"></label>
                </div>
            </div>
            <div class="select">
                <button type="submit" class="submit">保存</button>
                <button class="cancel" data-dismiss="modal" aria-hidden="true">取消</button>
            </div>
        </form>
    </div>

    <div class="modal fade in" id="modal-default" style="display: none; padding-right: 15px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Default Modal</h4>
                </div>
                <div class="modal-body">
                    <p>One fine body…</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="addProp" class="forios modal hide fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <h3>新增属性值</h3>
        <form class="forios-log" onsubmit="return attribute_value_create(this);">
            <input type="hidden" id="value_create_id" name="attribute_id" value="">
            {!! csrf_field() !!}
            <div class="category clearfix">
                <h6>属性值名称：</h6>
                <div class="iu-input">
                    <input type="text" class="green" name="name"/>
                    <label class="error"></label>
                </div>
                <div class="color">
                    <div class="iu-color" style="background-color:#fff;"></div>
                </div>
            </div>
            <div class="category clearfix">
                <h6>英文属性值：</h6>
                <div class="iu-input">
                    <input type="text" class="green" name="en_name"/>
                    <label class="error"></label>
                </div>
                <div class="color">
                    <div class="iu-color" style="background-color:#fff;"></div>
                </div>
            </div>
            <div class="category clearfix">
                <h6>排序值：</h6>
                <div class="iu-input">
                    <input type="text" class="green min" name="sort" value="99"/>
                    <label class="error"></label>
                </div>
            </div>
            <div class="select">
                <button type="submit" class="submit">保存</button>
                <button class="cancel" data-dismiss="modal" aria-hidden="true">取消</button>
            </div>
        </form>
    </div>

    <div id="modifyProp" class="forios modal hide fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <h3>修改属性值</h3>
        <form class="forios-log" onsubmit="return attribute_value_update_submit(this);">
            <input type="hidden" name="id" value="">
            {!! csrf_field() !!}
            <div class="category clearfix">
                <h6>属性值名称：</h6>
                <div class="iu-input">
                    <input type="text" class="green" name="name" value=""/>
                    <label class="error"></label>
                </div>
                <div class="color">
                    <div class="iu-color" style="background-color:#fff;"></div>
                </div>
            </div>
            <div class="category clearfix">
                <h6>属性值英文名：</h6>
                <div class="iu-input">
                    <input type="text" class="green" name="en_name" value=""/>
                    <label class="error"></label>
                </div>
                <div class="color">
                    <div class="iu-color" style="background-color:#fff;"></div>
                </div>
            </div>
            <div class="category clearfix">
                <h6>排序值：</h6>
                <div class="iu-input">
                    <input type="text" class="green min " name="sort" value=""/>
                    <label class="error"></label>
                </div>
            </div>
            <div class="select">
                <button type="submit" class="submit">保存</button>
                <button class="cancel" data-dismiss="modal" aria-hidden="true">取消</button>
            </div>
        </form>
    </div>
@stop
@section('script')
    <script src="{{asset('/assets/js/jquery.bigcolorpicker.min')}}"></script>
    <script>
        var jvdou = {};
        jvdou.propList = function(){
            this.initialize.apply(this, arguments);
        };
        jvdou.propList.prototype = {
            //初始化
            initialize:function(){
                this.event();
            },
            //事件
            event:function(){
                $('.prop-three').on('click','.modify',function(event){
                    $('.mose-num').addClass('prop-show');
                    attribute_update();
                    event.stopPropagation();
                });
                $('.prop-two').on('click','.return',function(event){
                    $('.mose-num').removeClass('prop-show');
                    event.stopPropagation();
                });
                $('.prop-two').on('click','.keep',function(event){
                    if(empty($(this).attr('disabled'))) attribute_update_submit($(this));
                    event.stopPropagation();
                });
                $('#attr_value_list').on('click', 'a', function(event){
                    var id = $(this).attr('data-id');
                    attribute_value_update(id);
                    event.stopPropagation();
                });
                $('#addProp,#modifyProp').on('show',function(){
                    $('body').addClass('overflow');
                });
                $('#addProp,#modifyProp').on('hidden',function(){
                    $('body').removeClass('overflow');
                });
                $('.prop-three').on('click', '.deletes', function(){
                    if(empty($(this).attr('disabled'))) attribute_delete($(this));
                });
                $('#attribute_search').on('click', 'i', function(){
                    attribute_search();
                });
                $('#attr_value_search').on('click', 'i', function(){
                    attr_value_search();
                });
            }
        };
        sessionStorage.setItem('attribute', JSON.stringify(<?php echo $attribute;?>));
        sessionStorage.setItem('attribute_active', '');
        $(function(){
            var attr = "{{Request::input('id') ?? 0}}";
            attribute_init(attr);
            $('#attr_list').on('click', 'li', function(){
                $(this).addClass('active').siblings().removeClass('active');
                $('.mose-num').removeClass('prop-show');
                var id = $(this).attr('data-id');
                var attribute = JSON.parse(sessionStorage.getItem('attribute'));
                show_attribute_values(id);
                show_attribute_detail(attribute[0][id]);
                show_category(id);
                sessionStorage.setItem('attribute_active', JSON.stringify(attribute[0][id]));
            });
            var home = new jvdou.propList();
        });

        function show_attribute_detail(data){
            var attrStr = sessionStorage.getItem('attribute_active');
            if(attrStr) var attribute_active = JSON.parse(sessionStorage.getItem('attribute_active'));
            var data = ( typeof data == 'undefined' ) ? attribute_active : data;
            var str = '';
            $('#attr_detail_name').html(data['name']);
            $('#attr_detail_alias_name').html(data['alias_name']);
            switch(data['type']){
                case 1:
                    str = '标准化文本';
                    $('#attribute_value_add').show();
                    break;
                case 2:
                    str = '自定义文本';
                    $('#attribute_value_add').hide();
                    break;
            }
            $('#attr_detail_type').html(str);
            $('#attr_detail_sort').html(data['sort']);
            $('#value_create_id').val(data['id']);
            if(data['id'] == '1' || data['id'] == 1){
                var str = '<div class="iu-color" style="background-color:#fff;">选色</div><input type="hidden" name="value" value="">';
                $('#addProp').find('div.color').html(str);
                $(".iu-color").bigColorpicker(function(el,color){
                    $(el).css("background-color",color);
                    $(el).parent().find('input').val(color);
                });
            }else{
                $('#addProp').find('div.color').html('');
            }
        }
        function show_attribute_values(id){
            var attribute = JSON.parse(sessionStorage.getItem('attribute'));
            var str = '';
            for(var i in attribute[id]){
                str += '<li><p>'+attribute[id][i]['name']+'</p><a href="javascript:;" data-target="#modifyProp" data-id="'+attribute[id][i]['id']+'" data-toggle="modal">修改</a></li>';
            }
            $('#attr_value_list').html(str);
        }
        function attribute_init(id){
            var str = '';
            var active = '';
            var is_set_first = false;
            var attribute = JSON.parse(sessionStorage.getItem('attribute'));
            if(typeof id == 'undefined') is_set_first = true;
            for(var i in attribute[0]){
                if(is_set_first){
                    sessionStorage.setItem('attribute_active', JSON.stringify(attribute[0][i]));
                    show_attribute_detail();
                    show_attribute_values(attribute[0][i]['id']);
                    show_category(attribute[0][i]['id']);
                    is_set_first = false;
                    active = 'active';
                }
                if(id == attribute[0][i]['id']) {
                    sessionStorage.setItem('attribute_active', JSON.stringify(attribute[0][i]));
                    show_attribute_detail(attribute[0][i]);
                    show_attribute_values(id);
                    show_category(id);
                    active = 'active';
                }
                str += '<li class="'+active+'" data-id="'+attribute[0][i]['id']+'">'+attribute[0][i]['name']+'</li>';
                active = '';
            }
            $('#attr_list').html(str);
        }
        function attribute_create(obj){
            $(obj).find('button[type=submit]').attr('disabled', true);
            $(obj).find('button[type=submit]').html('提交中...');
            $.ajax({
                type:'post',
                url:"{{route('attribute.create')}}",
                data:$(obj).serialize(),
                success:function(data){
                    if(data.status == true){
                        toastr.success(data.messages);
                        /*if(window.confirm(data.messages))*/
                        sessionStorage.removeItem('attribute_all');
                        window.location.href = "{{route('attribute.index')}}"+'?id='+data.id;
                    }else{
                        toastr.error(data.message);
                        // var err_data = error_to_array(data.messages);
                        // show_error(obj, err_data);
                        $(obj).find('button[type=submit]').attr('disabled', false);
                    }
                },
                error:function(data){
                    var json=eval("("+data.responseText+")");
                    for (i in json.errors.name) {
                        toastr.error(json.errors.name[i])
                    }
                    obj.attr('disabled', false);
                },
                sync:true
            });
            return false;
        }

        function attribute_value_create(obj){
            $(obj).find('button[type=submit]').attr('disabled', true);
            var attr_id = $(obj).find('input[name=attribute_id]').val();
            $.ajax({
                type:'post',
                url:"{{route('attrvalue.create')}}",
                data:$(obj).serialize(),
                success:function(data){
                    if(data.status == true){
                        toastr.success(data.messages);
                        sessionStorage.removeItem('attribute_all');
                        window.location.href = "{{route('attribute.index')}}"+'?id='+attr_id;
                    }else{
                        toastr.error(data.messages);
                        $(obj).find('button[type=submit]').attr('disabled', false);
                    }
                },
                error:function(data){
                    var json=eval("("+data.responseText+")");
                    for (i in json.errors.name) {
                        toastr.error(json.errors.name[i])
                    }
                    obj.attr('disabled', false);
                },
                sync:true
            });
            return false;
        }

        function attribute_update(){
            var attribute_active = $.parseJSON(sessionStorage.getItem('attribute_active'));
            console.log(attribute_active);
            var attribute_update = $('#attribute_update');
            attribute_update.find('input[name=id]').val(attribute_active.id);
            attribute_update.find('input[name=name]').val(attribute_active.name);
            attribute_update.find('input[name=alias_name]').val(attribute_active.alias_name);
            var index = parseInt(attribute_active.type) - 1;
            $(attribute_update.find('input[name=type]')[index]).attr('checked', 'checked');
            attribute_update.find('input[name=sort]').val(attribute_active.sort);
        }

        function attribute_update_submit(obj){
            obj.attr('disabled', true);
            var data = {};
            var attribute_update = $('#attribute_update');
            var id = data.id = attribute_update.find('input[name=id]').val();
            data.name = attribute_update.find('input[name=name]').val();
            data.alias_name = attribute_update.find('input[name=alias_name]').val();
            data.type = attribute_update.find('input[name=type]:checked').val();
            data.sort = attribute_update.find('input[name=sort]').val();
            data._token = "{{csrf_token()}}";
            $.ajax({
                type:'post',
                url:"{{route('attribute.update')}}",
                data:data,
                success:function(data){
                    if(data.status == true){
                        toastr.success(data.messages);
                        sessionStorage.removeItem('attribute_all');
                        window.location.href = "{{route('attribute.index')}}"+'?id='+id;
                    }else{
                        toastr.error(data.messages);
                        obj.attr('disabled', false);
                    }
                },
                error:function(data){
                    var json=eval("("+data.responseText+")");
                    for (i in json.errors.name) {
                        toastr.error(json.errors.name[i])
                    }
                    obj.attr('disabled', false);
                },
                sync:true
            });
            return false;
        }

        function attribute_value_update(id){
            var attribute_active = JSON.parse(sessionStorage.getItem('attribute_active'));
            var attribute = JSON.parse(sessionStorage.getItem('attribute'));
            var attribute_value = attribute[attribute_active['id']][id];
            $('#modifyProp').find('input[name=id]').val(attribute_value['id']);
            $('#modifyProp').find('input[name=name]').val(attribute_value['name']);
            $('#modifyProp').find('input[name=en_name]').val(attribute_value['en_name']);
            $('#modifyProp').find('input[name=sort]').val(attribute_value['sort']);
            if(attribute_value['id'] == '1' || attribute_value['id'] == 1){
                var str = '<div class="iu-color" style="background-color:'+attribute_value['value_value']+';">选色</div><input type="hidden" name="value" value="'+attribute_value['value']+'">';
                $('#modifyProp').find('div.color').html(str);
                $(".iu-color").bigColorpicker(function(el,color){
                    $(el).css("background-color",color);
                    $(el).parent().find('input').val(color);
                });
            }else{
                $('#modifyProp').find('div.color').html('');
            }
            $('#modifyProp').find('input[name=value]').val(attribute_value['value']);
            $('#modifyProp').modal('show');
        }

        function attribute_value_update_submit(obj){
            $(obj).find('button[type=submit]').attr('disabled', true);
            $.ajax({
                type:'post',
                url:"{{route('attrvalue.update')}}",
                data:$(obj).serialize(),
                success:function(data){
                    if(data.status == true){
                        toastr.success(data.messages);
                        sessionStorage.removeItem('attribute_all');
                        window.location.href = "{{route('attribute.index')}}";
                    }else{
                        toastr.error(data.messages);
                        $(obj).find('button[type=submit]').attr('disabled', false);
                    }
                },
                error:function(data){
                    var json=eval("("+data.responseText+")");
                    for (i in json.errors.name) {
                        toastr.error(json.errors.name[i])
                    }
                    obj.attr('disabled', false);
                },
                sync:true
            });
            return false;
        }

        function show_category(id){
            $.ajax({
                type:'post',
                url:"{{route('attribute.attr')}}",
                data:{id:id,_token:"{{csrf_token()}}"},
                success:function(data){
                    if(data.status == true){
                        var str = '';
                        for(var i in data.messages){
                            var category_path = get_category_path(data.messages[i]);
                            str += '<li> <p title="'+category_path+'">'+category_path+'</p> <a href="{{route('category.index')}}?id='+data.messages[i]['category_id']+'" target="_blank">查看</a> </li>';
                        }
                        $('#category_list').html(str);
                    }
                },
                error:function(data){
                    var json=eval("("+data.responseText+")");
                    for (i in json.errors.name) {
                        toastr.error(json.errors.name[i])
                    }
                    obj.attr('disabled', false);
                },
                sync:true
            });
        }
        function show_error(obj, err_arr){
            if(typeof err_arr.name != 'undefined') $(obj).find('input[name=name]').addClass('error').next().html(err_arr.name);
            if(typeof err_arr.alias_name != 'undefined') $(obj).find('input[name=alias_name]').addClass('error').next().html(err_arr.name);
            if(typeof err_arr.sort != 'undefined') $(obj).find('input[name=sort]').addClass('error').next().html(err_arr.sort);
        }

        function error_to_array(err_str){
            var err_obj = {};
            if(err_str.indexOf('@@@') != -1){
                var err_tmp = err_str.split('@@@');
                for(var i=0; i<err_tmp.length; i++){
                    var err_sec_tmp = err_tmp[i].split('###');
                    err_obj[err_sec_tmp[0]] = err_sec_tmp[1];
                }
            }else{
                var err_sec_tmp = err_str.split('###');
                err_obj[err_sec_tmp[0]] = err_sec_tmp[1];
            }
            return err_obj;
        }

        function attribute_delete(obj){
            obj.attr('disabled', true);
            var attribute_active = JSON.parse(sessionStorage.getItem('attribute_active'));
            var id = attribute_active['id'];
            $.ajax({
                type:'post',
                url:"{{route('attribute.delete')}}",
                data:{id:id,_token:"{{csrf_token()}}"},
                success:function(data){
                    if(data.status == true){
                        toastr.success(data.messages);
                        sessionStorage.removeItem('attribute_all');
                        window.location.href = "{{route('attribute.index')}}";
                    }else{
                        toastr.error(data.messages);
                        obj.attr('disabled', false);
                    }
                },
                error:function(data){
                    var json=eval("("+data.responseText+")");
                    for (i in json.errors.name) {
                        toastr.error(json.errors.name[i])
                    }
                    obj.attr('disabled', false);
                },
                sync:true
            });
            return false;
        }

        function attribute_search(){
            var name = $('#attribute_search').find('input').val();
            if(empty(name)) return '';
            $.ajax({
                type:'post',
                url:"{{route('attribute.search')}}",
                data:{name:name,_token:"{{csrf_token()}}"},
                success:function(data){
                    if(data.status == true){
                        var active = '';
                        var str = '';
                        for(var i in data.messages){
                            if(i == 0){
                                sessionStorage.setItem('attribute_active', JSON.stringify(data.messages[i]));
                                show_attribute_detail();
                                show_attribute_values(data.messages[i]['id']);
                                show_category(data.messages[i]['id']);
                                active = 'active';
                            }
                            str += '<li class="'+active+'" data-id="'+data.messages[i]['id']+'">'+data.messages[i]['name']+'</li>';
                            active = '';
                        }
                        $('#attr_list').html(str);
                    }else{
                        alert(data.messages);
                    }
                },
                error:function(data){
                    var json=eval("("+data.responseText+")");
                    for (i in json.errors.name) {
                        toastr.error(json.errors.name[i])
                    }
                    obj.attr('disabled', false);
                },
                sync:true
            });
            return false;
        }


        function attr_value_search(){
            var name = $('#attr_value_search').find('input').val();
            var attribute_active = JSON.parse(sessionStorage.getItem('attribute_active'));
            var id = attribute_active['attr_id'];
            if(empty(name) || empty(id)) return '';
            $.ajax({
                type:'post',
                url:"{{route('attribute.search')}}",
                data:{name:name, id:id},
                success:function(data){
                    data = JSON.parse(data);
                    if(data.status == true){
                        var str = '';
                        for(var i in data.messages){
                            str += '<li><p>'+data.messages[i]['value_name']+'</p><a href="javascript:;" data-target="#modifyProp" data-id="'+data.messages[i]['value_id']+'" data-toggle="modal">修改</a></li>';
                        }
                        $('#attr_value_list').html(str);
                    }else{
                        alert(data.messages);
                    }
                },
                error:function(data){
                    var json=eval("("+data.responseText+")");
                    for (i in json.errors.name) {
                        toastr.error(json.errors.name[i])
                    }
                    obj.attr('disabled', false);
                },
                sync:true
            });
            return false;
        }

        function empty(obj){
            if( (typeof obj == 'undefined') || (obj == 'undefined') || (obj == '') || (obj == null) || (obj == 'null') || (obj == 0) || (obj == '0') ){
                return true;
            }else{
                return false;
            }
        }

        function get_category_path(data){
            var category = JSON.parse(sessionStorage.getItem('category'));
            var category_path = '';
            switch(data.level){
                case '1':
                    category_path = data.category_name;
                    break;
                case '2':
                    var parent_cate = category[data.level - 2][data.parent_id];
                    category_path = parent_cate.category_name+'>'+data.category_name;
                    break;
                case '3':
                    var parent_cate = category[data.level - 2][data.parent_id];
                    var grand_cate = category[data.level - 3][parent_cate.parent_id];
                    category_path = grand_cate.category_name+'>'+parent_cate.category_name+'>'+data.category_name;
                    break;
            }
            return category_path;
        }
    </script>
@endsection