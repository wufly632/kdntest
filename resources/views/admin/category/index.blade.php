@extends('layout.default')
@section('content')
<div class="admin-text">
    <div class="jvdou-min admin-pol">
        <div class="search">
            <h6>分类搜索：</h6>
            <form  class="search-from clearfix" onsubmit="return category_search($(this));">
                <input type="text" value="" placeholder="请输入您要搜索的分类" onsubmit="return category_search($(this));"/>
                <button type="submit">搜索</button>
                <ul id="category_search_list">

                </ul>
            </form>
            <button type="button" class="found" data-target="#found" data-toggle="modal">创建类目</button>
        </div>
        <div class="equal clearfix">
            <div class="equal-x3">
                <ul id="category_level0">

                </ul>
            </div>
            <div class="equal-x3">
                <ul id="category_level1">

                </ul>
            </div>
            <div class="equal-x3">
                <ul id="category_level2">

                </ul>
            </div>
        </div>
        <p class="location">
            当前选择：<a id="category_nav_path"></a>
        </p>
        <div class="mose-type show-2 clearfix">
            <div class="type-details mose-one">
                <div class="type-head clearfix">
                    <h3>类目详情</h3>
                    <div class="type-option">
                        <a href="javascript:;" class="modify" >修改</a>
                    </div>
                </div>
                <div class="type-exhibition">
                    <div class="exn-log clearfix">
                        <h6>类目名称：</h6>
                        <div class="exn-right">
                            <p id="detail_title"></p>
                        </div>
                    </div>
                    <div class="exn-log clearfix">
                        <h6>类目路径：</h6>
                        <div class="exn-right">
                            <p id="detail_path"></p>
                        </div>
                    </div>
                    <div class="exn-log clearfix">
                        <h6>类目层级：</h6>
                        <div class="exn-right">
                            <p id="detail_level">三级类目（叶子类目）</p>
                        </div>
                    </div>
                    <div class="exn-log clearfix">
                        <h6>排序值：</h6>
                        <div class="exn-right">
                            <p id="detail_sort">98</p>
                        </div>
                    </div>
                    <div class="exn-log clearfix">
                        <h6>启用状态：</h6>
                        <div class="exn-right">
                            <p id="detail_status">启动</p>
                        </div>
                    </div>
                    <div id="category_attribute_show"></div>
                </div>
            </div>
            <div class="type-details mose-two">
                <div class="type-head clearfix">
                    <h3>属性详情</h3>
                    <div class="type-option">
                        <a href="javascript:;" class="modify">修改</a>
                        <a href="javascript:;" class="return">返回</a>
                    </div>
                </div>
                <div class="type-exhibition">
                    <div class="exn-log clearfix">
                        <h6>属性名称：</h6>
                        <div class="exn-right">
                            <p class="value_name">内存</p>
                        </div>
                    </div>
                    <div class="exn-log clearfix">
                        <h6>属性别名：</h6>
                        <div class="exn-right">
                            <p class="value_alias_name">手机内存大小</p>
                        </div>
                    </div>
                    <div class="exn-log clearfix">
                        <h6>属性值类型：</h6>
                        <div class="exn-right">
                            <p class="value_type">标准化文本</p>
                        </div>
                    </div>
                    <div id="category_value">
                        <div class="exn-log clearfix">
                            <h6>属性值：</h6>
                            <div class="exn-right">
                                <p>8G</p>
                                <p>16G</p>
                                <p>32G</p>
                                <p>64G</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="type-details mose-three" style="display: none">
                {!! csrf_field() !!}
                <div class="type-head clearfix">
                    <h3>属性详情</h3>
                    <div class="type-option">
                        <a href="javascript:;" class="keep">保存</a>
                        <a href="javascript:;" class="return">返回</a>
                    </div>
                </div>
                <div class="exn-log clearfix">
                    <h6>属性名称：</h6>
                    <div class="exn-right">
                        <p class="value_name">内存</p>
                    </div>
                </div>
                <div class="exn-log clearfix">
                    <h6>属性别名：</h6>
                    <div class="exn-right">
                        <p class="value_alias_name">手机内存大小</p>
                    </div>
                </div>
                <div class="exn-log clearfix">
                    <h6>属性值类型：</h6>
                    <div class="exn-right">
                        <p class="value_type">自定义文本</p>
                    </div>
                </div>
                <div id="category_value_update">

                </div>
            </div>
            <div class="type-details mose-four">
                <div class="type-head clearfix">
                    <h3>类目详情</h3>
                    <div class="type-option">
                        <a href="javascript:;" id="cate_update" class="keep">保存</a>
                        <a href="javascript:;" class="return">返回</a>
                    </div>
                </div>
                <input type="hidden" value="" name="id" id="cate_update_id">
                <div class="exn-log clearfix">
                    <h6>类目名称：</h6>
                    <div class="exn-right">
                        <input id="cate_update_name" name="name" type="text" class="green" value="" >
                    </div>
                </div>
                <div class="exn-log clearfix">
                    <h6>类目路径：</h6>
                    <div class="exn-right">
                        <p id="cate_update_path">玩具教育 > 学童玩具</p>
                    </div>
                </div>
                <div class="exn-log clearfix">
                    <h6>类目层级：</h6>
                    <div class="exn-right">
                        <p id="cate_update_level">三级类目（叶子类目）</p>
                    </div>
                </div>
                <div class="exn-log clearfix">
                    <h6>排序值：</h6>
                    <div class="exn-right">
                        <input id="cate_update_sort" type="text" name="sort" class="green" value="99" >
                    </div>
                </div>
                <div class="exn-log clearfix">
                    <h6>启用状态：</h6>
                    <div class="exn-right clearfix">
                        <label>
                            <input id="cate_update_status1" value="1" type="radio" name="status_update"/>
                            <span>启用</span>
                        </label>
                        <label>
                            <input id="cate_update_status2" value="2" type="radio" name="status_update"/>
                            <span>不启用</span>
                        </label>
                    </div>
                </div>
                <div id="category_attribute">

                </div>
            </div>
            <div class="type-details mose-five">
                <div class="type-head clearfix">
                    <h3>添加销售属性</h3>
                    <div class="type-option">
                        <a href="javascript:;" class="keep">保存</a>
                        <a href="javascript:;" class="return">返回</a>
                    </div>
                </div>
                <div class="type-add clearfix">
                    <div class="add-need" id="attribute">
                        <div class="add-input">
                            <input type="text" name="name" class="green">
                            <i class="iconfont">&#xe600;</i>
                        </div>
                        <ul id="attr_list" class="add-product">

                        </ul>
                    </div>
                    <div class="add-need" id="attribute_value">
                        <div class="add-input">
                            <input type="text" name="name" class="green">
                            <i class="iconfont">&#xe600;</i>
                            <input type="hidden" name="attr_id" value="">
                        </div>
                        <ul id="attr_value_list" class="add-product">

                        </ul>
                    </div>
                </div>
                <div class="exn-npm">

                </div>
            </div>
            <div class="type-details mose-six">
                <div class="type-head clearfix">
                    <h3>配置属性值</h3>
                    <div class="type-option">
                        <a href="javascript:;" class="keep">保存</a>
                        <a href="javascript:;" class="return">返回</a>
                    </div>
                </div>
                <div class="mate-mb">
                    <div class="type-mate">
                        <input type="text" class="green" name="name">
                        <i class="iconfont">&#xe600;</i>
                        <input type="hidden" name="attr_id" value="">
                    </div>
                    <ul>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="found" class="forios modal hide fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <h3>创建类目</h3>
    <form class="forios-log" onsubmit="return category_submit(this);">
        {!! csrf_field() !!}
        <div class="category clearfix">
            <h6>类目名称：</h6>
            <div class="iu-input">
                <input type="text" name="name" class="green"/>
                <label class="error"></label>
            </div>
        </div>
        <div class="category clearfix">
            <h6>英文名称：</h6>
            <div class="iu-input">
                <input type="text" name="en_name" class="green"/>
                <label class="error"></label>
            </div>
        </div>
        <div class="category clearfix">
            <h6>类目路径：</h6>
            <div class="iu-select">
                <select class="green" name="laval1" id="level_select1">
                    <option value="0" selected>选择一级类目</option>
                    <label class="error"></label>
                </select>
            </div>
            <div class="iu-select">
                <select class="green" name="laval2" id="level_select2">
                    <option value="0" selected>选择二级类目</option>
                    <label class="error"></label>
                </select>
            </div>
        </div>
        <div class="category clearfix">
            <h6>排序值：</h6>
            <div class="iu-input">
                <input type="text" name="sort" class="green min" value="99"/>
                <label class="error"></label>
            </div>
        </div>
        <div class="select">
            <button type="submit" class="submit">确定创建</button>
            <button class="cancel" data-dismiss="modal" aria-hidden="true">取消</button>
        </div>
    </form>
</div>
@endsection()
@section('script')
<script>
    $(function(){
        var select_str = '<option value="0">选择一级类目</option>';
        var category = JSON.parse(sessionStorage.getItem('category'));
        for(var i in category[0]){
            select_str += '<option value="'+category[0][i]['id']+'">'+category[0][i]['name']+'</option>';
            $('#level_select1').html(select_str);
        }
        var cate_info = <?php echo $cate_info;?>;
        if( cate_info.length > 0 || (typeof cate_info.length == 'undefined') ){
            var cate_ids = cate_info['category_ids'];
            var cate_id_arr = cate_ids.split(',');
            switch (cate_id_arr.length){
                case 1:
                    set_category_init(cate_info['id']);
                    break;
                case 2:
                    set_category_init(cate_id_arr[1], cate_info['id']);
                    break;
                case 3:
                    set_category_init(cate_id_arr[1], cate_id_arr[2], cate_info['id']);
                    break;
            }
        }else{
            set_category_init();
        }
        $('.equal-x3').on('click', 'li',function(){
            $('.mose-one').show().siblings().hide();
            $('.mose-type').addClass('show-2').removeClass('show-1 show-4 show-3 show-5');
            $(this).addClass('active').siblings().removeClass('active');
            var level = parseInt($(this).attr('cate_level'));
            var id = $(this).attr('category_id');
            if(level < 3) set_category(level, id);
            sessionStorage.setItem('category_active', JSON.stringify(category[(level-1)][id]));
            category_detail(category[(level-1)][id]);
        });
        $('#level_select1').on('change', function(){
            var id = $(this).val();
            set_select(id);
        });
        var home = new jvdou.prop();
        $('#cate_update').on('click', function(){
            if(empty($(this).attr('disabled'))){
                category_update_submit();
            }
        });

        $('#category_attribute').on('click', 'button', function(){
            if($(this).hasClass('close')){
                var attr_id = $(this).attr('data-attr');
                var attr_type = $(this).attr('data-type');
                var category_attribute = JSON.parse(sessionStorage.getItem('category_attr_values'));
                for(var i in category_attribute){
                    if( empty(category_attribute[i]) ) continue;
                    if(category_attribute[i]['attr_id'] == attr_id && category_attribute[i]['attr_type'] == attr_type){
                        if(empty(category_attribute[i]['id'])){
                            if(typeof category_attribute == 'object') {
                                delete category_attribute[i];
                            }else{
                                category_attribute.splice(i, 1);
                            }
                        }else{
                            category_attribute[i]['is_delete'] = 1;
                        }
                    }
                }
                if(attr_type == '3'){
                    var attr_list = $('#category_attribute_type'+attr_type).find('button.close');
                    var attr_add = $('#category_attribute_type'+attr_type).find('div.add-state');
                    if(attr_list.length <= 3 && attr_add['length'] == 0){
                        var str = '<div class="add-state" type="3">+</div>';
                        $('#category_attribute_type'+attr_type).append(str);
                    }
                }
                sessionStorage.setItem('category_attr_values', JSON.stringify(category_attribute));
            }else{
                var str = '<input id="cate_update_is_final" type="hidden" value="1" name="is_final"><div class="exn-log clearfix"><h6>基础信息：</h6> <div class="exn-right"> <p>商品标题</p> <p>详情描述</p> </div> </div><div class="exn-log clearfix"><h6>关键属性：</h6><div class="exn-right" id="category_attribute_type2"><p>品牌</p><div class="add-state" type="2">+</div></div></div><div class="exn-log clearfix"><h6>销售属性：</h6><div class="exn-right" id="category_attribute_type3"><div class="add-state" type="3">+</div></div></div><div class="exn-log clearfix"><h6>非关键属性：</h6><div class="exn-right" id="category_attribute_type4"><div class="add-state" type="4">+</div></div></div>';
                $('#category_attribute_count').show();
                $('#category_attribute').html(str);
            }
        });
        $('#attribute').on('click', 'i', function(){
            var name = $('#attribute').find('input[name=name]').val();
            if( name != ''){
                $.ajax({
                    type:'post',
                    url:"{{route('attribute.search')}}",
                    data:{name:name,_token:"{{csrf_token()}}"},
                    success:function(data){
                        if(data.status == true){
                            show_attribute(data.messages);
                        }else{
                            toastr.error(data.messaegs);
                        }
                    },
                    sync:true
                });
            }else{
                alert('请输入要查询的属性关键字！');
            }
        });

        $('#attribute_value').on('click', 'i', function(){
            attr_value_search($('#attribute_value'), $('#attr_value_list'));
        });
        $('.mose-six').on('click', 'i', function(){
            attr_value_search($('.mose-six'), $('.mose-six').find('ul'));
        });
        $('.mose-three').on('click', 'button.close', function(){
            var id = $(this).attr('data-id');
            var values = $('.mose-three').find('input[name=attr_values]').val();
            var values_arr = values.split(',');
            for(var i in values_arr){
                if( id == values_arr[i]){
                    values_arr.splice(i, 1);
                }
            }
            $('.mose-three').find('input[name=attr_values]').val(values_arr.join(','));
        });
        $('.mose-three').on('click', '.keep', function(){
            if(empty($(this).attr('disabled'))) attribute_update_submit($(this), $('.mose-three').find('input').serialize());
        });
    });

    var jvdou = {};
    jvdou.prop = function(){
        this.initialize.apply(this, arguments);
    };
    jvdou.prop.prototype = {
        //初始化
        initialize:function(){
            this.event();
        },
        //事件
        event:function(){
            var inputTimeout;
            $('.search').on('keyup','.search-from input',function(event){
                var input = $(this);
                clearInterval(inputTimeout);
                inputTimeout = setTimeout(function(){
                    if(input.val()){
                        $('.search-from ul').addClass('hover');
                        input = input.parents('form');
                        category_search(input);
                    }else{
                        $('.search-from ul').removeClass('hover');
                    }
                },500);
                event.stopPropagation();
            });
            //下拉列表被点击时
            $('.search').on('click','.search-from li',function(event){
                var input = $(this).text();
                var id = $(this).attr('data-id');
                var ids = $(this).attr('data-path');
                var id_arr = ids.split(',');
                var category = JSON.parse(sessionStorage.getItem('category'));
                switch (id_arr.length){
                    case 1:
                        set_category_init(id);
                        category_detail(category[0][id]);
                        break;
                    case 2:
                        set_category_init(id_arr[1], id);
                        category_detail(category[1][id]);
                        break;
                    case 3:
                        set_category_init(id_arr[1], id_arr[2], id);
                        category_detail(category[2][id]);
                        break;
                }
                $('.search-from input').val(input);
                $('.search-from ul').removeClass('hover');
                event.stopPropagation();
            });
            //搜索筛选取消
            $(document).on('click',function(event){
                var $target = $(event.target);
                if(!$target.is('.search-from,.search-from *')) {
                    $('.search-from ul').removeClass('hover');
                };
                event.stopPropagation();
            });
            //非关键属性
            $('.mose-one').on('click','.exn-right a',function(event){
                $(this).addClass('active').parents('p').siblings().find('a').removeClass('active');
                $(this).addClass('active').parents('div.exn-log').siblings().find('a').removeClass('active');
                var id = $(this).parent().attr('data-id');
                var attr_id = $(this).parent().attr('data-attr');
                var attr_value = $(this).parent().attr('data-value');

                category_attribute_detail(id, attr_id, attr_value);
                $('.mose-two').show();
                $('.mose-two .modify').attr('data-id', id).attr('data-attr', attr_id).attr('data-value', attr_value).show();
                $('.mose-type').addClass('show-1').removeClass('show-2 show-3 show-4 show-5');
                event.stopPropagation();
            });
            //属性修改
            $('.mose-two').on('click','.modify',function(event){
                $('.mose-type').addClass('show-2').removeClass('show-1 show-3 show-4 show-5');
                var id = $(this).attr('data-id');
                var attr_id = $(this).attr('data-attr');
                var attr_value = $(this).attr('data-value');
                attribute_update(id, attr_id, attr_value);
                $('.mose-six').find('input[name=attr_id]').val(attr_id);
                $('.mose-two').hide();
                $('.mose-three').show();
                event.stopPropagation();
            });
            //属性详情-返回
            $('.mose-two').on('click','.return',function(event){
                $('.mose-two').hide();
                $('.mose-type').addClass('show-2').removeClass('show-1 show-3 show-4 show-5');
                event.stopPropagation();
            });
            //修改返回
            $('.mose-three').on('click','.return',function(event){
                $('.mose-two').show();
                $('.mose-one').show();
                $('.mose-three').hide();
                $('.mose-six').hide();
                $('.mose-type').addClass('show-2').removeClass('show-1 show-3 show-4 show-5');
                event.stopPropagation();
            });
            //类目修改
            $('.mose-one').on('click','.modify',function(event){
                if(category_update()){
                    return false;
                }
                $('.mose-type').addClass('show-4').removeClass('show-1 show-2 show-3 show-5');
                $('.mose-four').show().siblings().hide();
                event.stopPropagation();
            });
            //类目修改 - 返回
            $('.mose-four').on('click','.return',function(event){
                $('.mose-one').show().siblings().hide();
                $('.mose-type').addClass('show-2').removeClass('show-1 show-3 show-4 show-5');
                event.stopPropagation();
            });
            //类目修改 - 添加
            $('.mose-four').on('click','.add-state',function(event){
                var title = '';
                var inputs = '<input type="hidden" name="attr_values" value=""><input type="hidden" name="attr_id" value="">';
                var attr_type = $(this).attr('type');
                switch(attr_type){
                    case '2':
                        title = '添加关键属性';
                        inputs += '<input type="hidden" name="attr_type" value="2"><div class="exn-log clearfix"><h6>是否必填：</h6><div class="exn-right clearfix"><label><input type="radio" name="is_required" value="1" checked/><span>必填</span></label> <label><input type="radio" name="is_required" value="2"/><span>非必填</span></label></div></div><div class="exn-log clearfix"><h6>单选/多选：</h6><div class="exn-right clearfix"><label><input type="radio" name="check_type" value="2" checked/><span>单选</span></label><label><input type="radio" name="check_type" value="1"/><span>多选</span></label></div></div>';
                        break;
                    case '3':
                        title = '添加销售属性';
                        inputs += '<input type="hidden" name="attr_type" value="3"><div class="exn-log clearfix"><h6>是否必填：</h6><div class="exn-right clearfix"><label><input type="radio" name="is_required" value="1" checked/><span>必填</span></label> </div></div><div class="exn-log clearfix"><h6>单选/多选：</h6><div class="exn-right clearfix"><label><input type="radio" name="check_type" value="1" checked/><span>多选</span></label></div></div><div class="exn-log clearfix"><h6>是否图片属性：</h6><div class="exn-right clearfix"><label><input type="radio" name="is_image" value="1"/><span>是</span></label><label><input type="radio" name="is_image" value="2" checked /><span>否</span></label></div></div><div class="exn-log clearfix"><h6>是否支持自定义：</h6><div class="exn-right clearfix"><label><input type="radio" name="is_diy" value="1" /><span>支持</span></label><label><input type="radio" name="is_diy" value="2" checked /><span>不支持</span></label></div></div>';
                        break;
                    case '4':
                        title = '添加非关键属性';
                        inputs += '<input type="hidden" name="attr_type" value="4"><div class="exn-log clearfix"><h6>单选/多选：</h6><div class="exn-right clearfix"><label><input type="radio" name="check_type" value="2" checked/><span>单选</span></label><label><input type="radio" name="check_type" value="1"/><span>多选</span></label></div></div><div class="exn-log clearfix"><h6>是否必填：</h6><div class="exn-right clearfix"><label><input type="radio" name="is_required" value="1" checked/><span>必填</span></label> <label><input type="radio" name="is_required" value="2"/><span>非必填</span></label></div></div><div class="exn-log clearfix"><h6>是否详情显示：</h6><div class="exn-right clearfix"><label><input type="radio" name="is_detail" checked value="2"/><span>不显示</span></label><label><input type="radio" name="is_detail" value="1"/><span>显示</span></label></div></div>';
                        break;

                }
                $('.mose-five').find('h3').html(title);
                $('.mose-five .exn-npm').html(inputs);
                show_attribute('', attr_type);
                $('.mose-five').show();
                $('.mose-type').addClass('show-4').removeClass('show-1 show-2 show-3 show-5');
                attr_value_init();
                event.stopPropagation();
            });
            //添加属性 - 返回
            $('.mose-five').on('click','.return',function(event){
                $('.mose-five').hide();
                $('.mose-type').addClass('show-4').removeClass('show-1 show-2 show-3 show-5');
                attr_value_init();
                event.stopPropagation();
            });
            //添加属性 - 保存
            $('.mose-five').on('click','.keep',function(event){
                if(attr_value_save()){
                    return;
                }
                attr_value_init();
                $('.mose-five').hide();
                $('.mose-type').addClass('show-4').removeClass('show-1 show-2 show-3 show-5');
                event.stopPropagation();
            });
            //非关键属性 - 添加
            $('.mose-three').on('click','.add-state',function(event){
                $('.mose-six').show();
                $('.mose-one').hide();
                $('.mose-type').addClass('show-5').removeClass('show-1 show-2 show-3 show-4');
                var attr_id = $(this).attr('data-attr');
                show_attribute_value(attr_id, $('.mose-six ul'));
                attr_value_init();
                event.stopPropagation();
            });
            //添加属性详情 - 返回
            $('.mose-six').on('click','.return',function(event){
                $('.mose-six').hide();
                $('.mose-one').show();
                $('.mose-type').addClass('show-2').removeClass('show-1 show-3 show-4 show-5');
                event.stopPropagation();
            });
            //添加属性详情 - 保存
            $('.mose-six').on('click','.keep',function(event){
                attr_value_update();
                $('.mose-one').show();
                $('.mose-six').hide();
                $('.mose-type').addClass('show-2').removeClass('show-1 show-3 show-4 show-5');
                event.stopPropagation();
            });
            $('#attr_list').on('click', 'li', function(){
                var id = $(this).attr('data-id');
                $(this).addClass('active').siblings().removeClass('active');
                show_attribute_value(id);
                attr_value_add_init(id);
            });
            $('#attr_value_list').on('click', 'li', function(){
                $(this).toggleClass('active');
                attr_value_add();
            });
            $('.mose-six').on('click', 'li', function(){
                $(this).toggleClass('active');
            });
        }
    };
    sessionStorage.setItem('category', JSON.stringify(<?php echo $category;?>));
    sessionStorage.setItem('category_active', '');
    sessionStorage.setItem('category_attribute', JSON.stringify(<?php echo $category_attrs;?>));

    function attr_value_search(input, output){
        var name = $(input).find('input[name=name]').val();
        var id = $(input).find('input[name=attr_id]').val();
        if( !empty(name) ){
            if( !empty(id) ){
                $.ajax({
                    type:'post',
                    url:"{{route('attrvalue.search')}}",
                    data:{name:name, id:id,_token:"{{csrf_token()}}"},
                    success:function(data){
                        if(data.status == true){
                            var str = '';
                            var attribute_value = data.messages;
                            for(var i in attribute_value){
                                str += '<li data-id="'+attribute_value[i]['id']+'">'+attribute_value[i]['name']+'</li>';
                            }
                            $(output).html(str);
                        }else{
                            toastr.error(data.messages);
                        }
                    },
                    sync:true
                });
            }else{
                toastr.error('请输入要查询的属性值关键字！');
            }
        }else{
            toastr.error('请选择属性');
        }
    }
    function set_category_init(level0, level1, level2){
        $('#category_level1').html('');
        $('#category_level2').html('');
        sessionStorage.setItem('category_attr_values', '');
        var category = JSON.parse(sessionStorage.getItem('category'));
        var level_str = '';
        var active = '';
        var is_set_first = false;
        if(typeof level0 == 'undefined') is_set_first = true;
        for(var i in category[0]) {
            if(is_set_first){
                sessionStorage.setItem('category_active', JSON.stringify(category[0][i]));
                category_detail(category[0][i]);
                is_set_first = false;
            }
            active = ( level0 == category[0][i]['id'] ) ? 'active' : '';
            level_str += '<li class="'+active+'" cate_level="1" category_id="' + category[0][i]['id'] + '">' + category[0][i]['name'] + '</li>';
        }
        $('#category_level0').html(level_str);
        if(typeof level1 != 'undefined'){
            set_category(1, level0, level1);
            category_detail(category[1][level1]);
            if(typeof level2 != 'undefined'){
                set_category(2, level1, level2);
                category_detail(category[2][level2]);
            }else{
                set_category(2, level1);
                category_detail(category[1][level1]);
            }
        }
    }

    function attr_value_init(){
        $('#attr_value_list').html('');
        $('#attribute_value').find('input[name=attr_id]').val('');
        $('.mose-five .exn-npm').find('input[name=attr_id]').val('');
    }

    function attr_value_add_init(id){
        $('#attribute_value').find('input[name=attr_id]').val(id);
        $('.mose-five .exn-npm').find('input[name=attr_id]').val(id);
        $('.mose-five .exn-npm').find('input[name=attr_values]').val('');
    }
    function set_category(level, parent_id, id){
        var category = JSON.parse(sessionStorage.getItem('category'));
        var level = parseInt(level);
        var tmp = category[level][parent_id];
        var str = '';
        var active = '';
        for(var i in tmp){
            active = ( id == tmp[i]['id'] ) ? 'active' : '';
            str += '<li cate_level="'+(level + 1)+'" class="'+active+'" category_id="'+tmp[i]['id']+'">'+tmp[i]['name']+'</li>'
        }
        if(typeof $('#category_level'+(level+1)) != 'undefined')$('#category_level'+(level+1)).html('');
        $('#category_level'+level).html(str);
    }

    function set_select(parent_id){
        var category = JSON.parse(sessionStorage.getItem('category'));
        var val = parseInt(parent_id);
        var data = category[1][val];
        var str = '<option value="0">选择二级类目</option>';
        for(var i in data){
            str += '<option value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
        }
        $('#level_select2').html(str);
    }

    function category_submit(obj){
        $.ajax({
            type:'post',
            url:"{{route('category.create')}}",
            data:$(obj).serialize(),
            success:function(data){
                if(data.status == true){
                    toastr.success(data.messages);
                    /*$(obj).find('input').val('').removeClass('error');
                    $(obj).find('label').html('');*/
                    window.location.href = "{{route('category.index')}}";
                }else{
                    var err_data = error_to_array(data.messages);
                    if(typeof err_data.name != 'undefined') $(obj).find('input[name=name]').addClass('error').next().html(err_data.name);
                    if(typeof err_data.laval1 != 'undefined') $(obj).find('input[name=laval1]').addClass('error').next().html(err_data.laval1);
                    if(typeof err_data.laval2 != 'undefined') $(obj).find('input[name=laval2]').addClass('error').next().html(err_data.laval2);
                    if(typeof err_data.sort != 'undefined') $(obj).find('input[name=sort]').addClass('error').next().html(err_data.sort);
                }
            },
            error:function(data){
                var json=eval("("+data.responseText+")");
                for (i in json.errors.name) {
                    toastr.error(json.errors.name[i])
                }
            },
            sync:true
        });
        return false;
    }

    function category_detail(data){
        $('#detail_title').html(data.name);
        var level = '';
        switch(data.level){
            case 1:
                level = '一级类目';
                break;
            case 2:
                level = '二级类目';
                break;
            case 3:
                level = '三级类目';
                break;
        }
        var category_path = get_category_path(data);
        $('#detail_path').html(category_path);
        $('#category_nav_path').html(category_path);
        if(data.is_final == 1) level += '（叶子类目）';
        $('#detail_level').html(level);
        $('#detail_sort').html(data.sort);
        if(data.status == 1){
            $('#detail_status').html('启用');
        }else{
            $('#detail_status').html('未启用');
        }
        if(data.is_final == 1) {
            $('#category_detail_count').show();
        }else{
            $('#category_detail_count').hide();
        }
        if(data['is_final'] == '1' || data['is_final'] == 1){
            category_attribute_init(data['id']);
        }else{
            category_attribute_init();
        }
        sessionStorage.setItem('category_active', JSON.stringify(data));
    }

    function category_update(){
        var data = JSON.parse(sessionStorage.getItem('category_active'));
        if(typeof data.id == 'undefined'){
            alert('请选择类目！');
            return true;
        }
        $('#cate_update_id').val(data.id);
        $('#cate_update_name').val(data.name);
        $('#cate_update_path').html(get_category_path(data));
        var level = '';
        switch(data.level){
            case '1':
                level = '一级类目';
                break;
            case '2':
                level = '二级类目';
                break;
            case '3':
                level = '三级类目';
                break;
        }
        if(data.is_final == '1') level += '（叶子类目）';
        $('#cate_update_level').html(level);
        $('#cate_update_sort').val(data.sort);
        $('#cate_update_status'+data.status).attr('checked', 'checked');
        if(data['is_final'] == '1' || data['is_final'] == 1){
            category_attribute_update(data['id']);
            $('#category_attribute_count').show();
        }else{
            $('#category_attribute').html('<div class="adds"><button>设置为叶子类目</button></div>');
            $('#category_attribute_count').hide();
        }
        return false;
    }
    function category_update_submit(){
        $('#cate_update').attr('disabled', true);
        var data = {id:0, name:'', sort:0, status:0, attribute:''};
        data.id = $('#cate_update_id').val();
        data.name = $('#cate_update_name').val();
        data.sort = $('#cate_update_sort').val();
        data.status = $('.mose-four').find('input[name=status_update]').val();
        data.attribute = sessionStorage.getItem('category_attr_values');
        data.final = $('#cate_update_is_final').val();
        data._token = "{{csrf_token()}}";
        var id = data.id;
        $.ajax({
            type:'post',
            url:"{{route('category.update')}}",
            data:data,
            success:function(data){
                if(data.status == true){
                    toastr.success(data.messages);
                    sessionStorage.removeItem('category_attr_values');
                    window.location.href="{{route('category.index')}}"+'?id='+id;
                }else{
                    toastr.error(data.messages);
                    sessionStorage.removeItem('category_attr_values');
                    window.location.href="{{route('category.index')}}"+'?id='+id
                }
            },
            error:function(){
                var json=eval("("+data.responseText+")");
                for (i in json.errors.name) {
                    toastr.error(json.errors.name[i])
                }
                $('#cate_update').attr('disabled', false);
            },
            sync:true
        });
        return false;
    }
    function category_attribute_init(id){
        if(typeof id == 'undefined'){
            $('#category_attribute_show').html('');
            return false;
        }
        var attribute = get_attributes_by_id(id);
        sessionStorage.setItem('category_attr_values', JSON.stringify(attribute));
        var str = '';
        if(typeof attribute.length == 'undefined'){
            str += '<div class="exn-log clearfix"><h6>基础信息：</h6> <div class="exn-right"> <p>商品标题</p> <p>详情描述</p> </div> </div>';
            var str2 = '<div class="exn-log clearfix"><h6>关键属性：</h6> <div class="exn-right"><p>品牌</p>';
            var str3 = '<div class="exn-log clearfix"><h6>销售属性：</h6> <div class="exn-right" >';
            var str4 = '<div class="exn-log clearfix"><h6>非关键属性：</h6> <div class="exn-right" >';
            for(var i in attribute){
                switch (attribute[i]['attr_type']) {
                    case 2:
                        str2 += '<p data-id="'+attribute[i]['id']+'" data-attr="'+attribute[i]['attr_id']+'" data-value="'+attribute[i]['attr_values']+'"><a href="javascript:;">'+attribute[i]['attr_title']+'</a></p>';
                        break;
                    case 3:
                        str3 += '<p data-id="'+attribute[i]['id']+'" data-attr="'+attribute[i]['attr_id']+'" data-value="'+attribute[i]['attr_values']+'"><a href="javascript:;">'+attribute[i]['attr_title']+'</a></p>';
                        break;
                    case 4:
                        str4 += '<p data-id="'+attribute[i]['id']+'" data-attr="'+attribute[i]['attr_id']+'" data-value="'+attribute[i]['attr_values']+'"><a href="javascript:;">'+attribute[i]['attr_title']+'</a></p>';
                        break;
                }
            }
            str2 += '</div></div>';
            str3 += '</div></div>';
            str4 += '</div></div>';
            str += str2 + str3 + str4;
        }else{
            str += '<div class="exn-log clearfix"><h6>基础信息：</h6> <div class="exn-right"> <p>商品标题</p> <p>详情描述</p> </div> </div><div class="exn-log clearfix"><h6>关键属性：</h6><div class="exn-right" ></div></div><div class="exn-log clearfix"><h6>销售属性：</h6><div class="exn-right"></div></div><div class="exn-log clearfix"><h6>非关键属性：</h6><div class="exn-right"></div></div>';
        }
        $('#category_attribute_show').html(str);
    }

    function category_attribute_update(id){
        var attribute = get_attributes_by_id(id);
        var str = '';
        if(typeof attribute.length == 'undefined'){
            str += '<div class="exn-log clearfix"><h6>基础信息：</h6> <div class="exn-right"> <p>商品标题</p> <p>详情描述</p> </div> </div>';
            var str2 = '<div class="exn-log clearfix"><h6>关键属性：</h6> <div class="exn-right" id="category_attribute_type2"><p>品牌</p>';
            var str3 = '<div class="exn-log clearfix"><h6>销售属性：</h6> <div class="exn-right" id="category_attribute_type3">';
            var str4 = '<div class="exn-log clearfix"><h6>非关键属性：</h6> <div class="exn-right" id="category_attribute_type4">';
            var count = 0;
            for(var i in attribute){
                switch (attribute[i]['attr_type']) {
                    case 2:
                        str2 += '<div class="alert fade clearfix in"><button type="button" class="close" data-dismiss="alert" data-type="'+attribute[i]['attr_type']+'" data-attr="'+attribute[i]['attr_id']+'" data-id="'+attribute[i]['id']+'">×</button><div class="exn">'+attribute[i]['attr_title']+'</div></div>';
                        break;
                    case 3:
                        str3 += '<div class="alert fade clearfix in"><button type="button" class="close" data-dismiss="alert" data-type="'+attribute[i]['attr_type']+'" data-attr="'+attribute[i]['attr_id']+'" data-id="'+attribute[i]['id']+'">×</button><div class="exn">'+attribute[i]['attr_title']+'</div></div>';
                        count += 1;
                        break;
                    case 4:
                        str4 += '<div class="alert fade clearfix in"><button type="button" class="close" data-dismiss="alert" data-type="'+attribute[i]['attr_type']+'" data-attr="'+attribute[i]['attr_id']+'" data-id="'+attribute[i]['id']+'">×</button><div class="exn">'+attribute[i]['attr_title']+'</div></div>';
                        break;
                }
            }
            str2 += '<div class="add-state" type="2">+</div></div></div>';
            if(count < 3) {
                str3 += '<div class="add-state" type="3">+</div></div></div>';
            }else{
                str3 += '</div></div>';
            }
            str4 += '<div class="add-state" type="4">+</div></div></div>';
            str += str2 + str3 + str4;
        }else{
            str += '<div class="exn-log clearfix"><h6>基础信息：</h6> <div class="exn-right"> <p>商品标题</p> <p>详情描述</p> </div> </div><div class="exn-log clearfix"><h6>关键属性：</h6><div class="exn-right" id="category_attribute_type2"><p>品牌</p><div class="add-state" type="2">+</div></div></div><div class="exn-log clearfix"><h6>销售属性：</h6><div class="exn-right" id="category_attribute_type3"><div class="add-state" type="3">+</div></div></div><div class="exn-log clearfix"><h6>非关键属性：</h6><div class="exn-right" id="category_attribute_type4"><div class="add-state" type="4">+</div></div></div>';

        }
        $('#category_attribute').html(str);
    }

    function category_attribute_detail(id, attr_id, attr_value){
        var category_attr_values = JSON.parse(sessionStorage.getItem('category_attr_values'));
        var category_value = category_attr_values[id];
        $('.mose-two').find('.value_name').html(category_value['attr_title']);
        $('.mose-two').find('.value_alias_name').html(category_value['attr_alias_title']);
        switch (category_value['attr0_type']) {
            case 1:
                var tmp = '标准化属性';
                break;
            case 2:
                var tmp = '非标准化属性';
                break;
        }
        $('.mose-two').find('.value_type').html(tmp);
        var str = '';
        var tmp = '';
        if(!empty(category_value['is_required'])){
            if(category_value['is_required'] == 1){
                tmp = '是'
            }else{
                tmp = '否';
            }
            str += '<div class="exn-log clearfix"> <h6>是否必填：</h6> <div class="exn-right"> <p>'+tmp+'</p> </div> </div>';
        }
        if(!empty(category_value['check_type'])){
            if(category_value['check_type'] == 1){
                tmp = '多选';
            }else{
                tmp = '单选';
            }
            str += '<div class="exn-log clearfix"> <h6>单选/多选：</h6> <div class="exn-right"><p>'+tmp+'</p></div></div>';
        }
        if(!empty(category_value['is_image'])){
            if(category_value['is_image'] == 1){
                tmp = '是';
            }else{
                tmp = '否';
            }
            str += '<div class="exn-log clearfix"> <h6>是否图片属性：</h6> <div class="exn-right"> <p>'+tmp+'</p> </div> </div>';
        }
        if(!empty(category_value['is_diy'])){
            if(category_value['is_diy'] == 1){
                tmp = '是';
            }else{
                tmp = '否';
            }
            str += '<div class="exn-log clearfix"> <h6>是否支持自定义：</h6> <div class="exn-right"> <p>'+tmp+'</p> </div> </div>';
        }
        if(!empty(category_value['is_detail'])){
            if(category_value['is_detail'] == 1){
                tmp = '是';
            }else{
                tmp = '否';
            }
            str += '<div class="exn-log clearfix"> <h6>是否详情显示：</h6> <div class="exn-right"> <p>'+tmp+'</p> </div> </div>';
        }
        str += '<div class="exn-log clearfix"> <h6>属性值：</h6> <div class="exn-right">';
        var attribute = JSON.parse(sessionStorage.getItem('attribute_all'));
        attribute = JSON.parse(attribute);
        if(empty(attribute)){
            $.ajax({
                type:'post',
                url:"{{route('attrvalue.detail')}}",
                data:{id:attr_value,_token:"{{csrf_token()}}"},
                success:function(data){
                    console.log(data);
                    if(data.status == true){
                        for(var i in data.messages){
                            str += '<p>'+data.messages[i]['name']+'</p>';
                        }
                        str += '</div> </div>';
                        sessionStorage.setItem('category_attribute_detail', JSON.stringify(data.messages));
                        $('#category_value').html(str);
                    }else{
                        toastr.error(data.messages);
                    }
                },
                sync:true
            });
        }else{
            var value_arr = attr_value.split(',');
            for(var i in value_arr){
                if(value_arr[i] != '0') str += '<p>'+attribute[attr_id][value_arr[i]]['name']+'</p>';
            }
            str += '</div> </div>';
        }
        $('#category_value').html(str);
    }

    function attribute_update(id, attr_id, attr_value){
        var category_attr_values = JSON.parse(sessionStorage.getItem('category_attr_values'));
        var category_value = category_attr_values[id];
        $('.mose-three').find('.value_name').html(category_value['attr_title']);
        $('.mose-three').find('.value_alias_name').html(category_value['attr_alias_title']);
        switch (category_value['attr0_type']) {
            case 1:
                var tmp = '标准化属性';
                break;
            case 2:
                var tmp = '非标准化属性';
                break;
        }
        $('.mose-three').find('.value_type').html(tmp);
        var str = '<input type="hidden" name="id" value="'+id+'"><input type="hidden" name="attr_values" value="'+attr_value+'">';
        if(!empty(category_value['is_required'])){
            str += '<div class="exn-log clearfix"> <h6>是否必填：</h6> <div class="exn-right clearfix"> ';
            if(category_value['is_required'] == '1'){
                str += '<label> <input type="radio" name="is_required" value="1" checked /> <span>必填</span> </label> <label> <input type="radio" name="is_required" value="2" /> <span>非必填</span> </label> ';
            }else{
                str += '<label> <input type="radio" name="is_required" value="1" /> <span>必填</span> </label> <label> <input type="radio" name="is_required" value="2" checked /> <span>非必填</span> </label> ';
            }
            str += '</div> </div>';
        }
        if(!empty(category_value['check_type'])){
            str += '<div class="exn-log clearfix"> <h6>单选/多选：</h6> <div class="exn-right clearfix"> ';
            if(category_value['check_type'] == '1'){
                str += '<label> <input type="radio" name="check_type" value="1" checked /> <span>多选</span> </label> <label> <input type="radio" name="check_type" value="2" /> <span>单选</span> </label> ';
            }else{
                str += '<label> <input type="radio" name="check_type" value="1" /> <span>多选</span> </label> <label> <input type="radio" name="check_type" value="2" checked /> <span>单选</span> </label> ';
            }
            str += '</div> </div>';
        }
        if(!empty(category_value['is_image'])){
            str += '<div class="exn-log clearfix"> <h6>是否图片属性：</h6> <div class="exn-right clearfix"> ';
            if(category_value['is_image'] == '1'){
                str += '<label> <input type="radio" name="is_image" value="1" checked /> <span>是</span> </label> <label> <input type="radio" name="is_image" value="2" /> <span>否</span> </label> ';
            }else{
                str += '<label> <input type="radio" name="is_image" value="1" /> <span>是</span> </label> <label> <input type="radio" name="is_image" value="2" checked /> <span>否</span> </label> ';
            }
            str += '</div> </div>';
        }
        if(!empty(category_value['is_diy'])){
            str += '<div class="exn-log clearfix"> <h6>是否支持自定义：</h6> <div class="exn-right clearfix"> ';
            if(category_value['is_diy'] == '1'){
                str += '<label> <input type="radio" name="is_diy" value="1" checked /> <span>是</span> </label> <label> <input type="radio" name="is_diy" value="2" /> <span>否</span> </label> ';
            }else{
                str += '<label> <input type="radio" name="is_diy" value="1" /> <span>是</span> </label> <label> <input type="radio" name="is_diy" value="2" checked /> <span>否</span> </label> ';
            }
            str += '</div> </div>';
        }
        if(!empty(category_value['is_detail'])){
            str += '<div class="exn-log clearfix"> <h6>是否详情显示：</h6> <div class="exn-right clearfix"> ';
            if(category_value['is_detail'] == '1'){
                str += '<label> <input type="radio" name="is_detail" value="1" checked /> <span>是</span> </label> <label> <input type="radio" name="is_detail" value="2" /> <span>否</span> </label> ';
            }else{
                str += '<label> <input type="radio" name="is_detail" value="1" /> <span>是</span> </label> <label> <input type="radio" name="is_detail" value="2" checked /> <span>否</span> </label> ';
            }
            str += '</div> </div>';
        }
        str += '<div class="exn-log clearfix"> <h6>属性值：</h6> <div class="exn-right" id="category_value_update_detail">';
        var attribute = JSON.parse(sessionStorage.getItem('attribute_all'));
        attribute = JSON.parse(attribute);
        if(empty(attribute)){
            var attr_values = sessionStorage.getItem('category_attribute_detail');
            attr_values = JSON.parse(attr_values);
            if(empty(attr_values)){
                $.ajax({
                    type:'post',
                    url:"{{route('attrvalue.detail')}}",
                    data:{id:attr_value},
                    success:function(data){
                        data = JSON.parse(data);
                        if(data.status == true){
                            for(var i in data.messages){
                                str += '<div class="alert fade clearfix in"> <button type="button" class="close" data-dismiss="alert" data-id="'+data.messages[i]['id']+'">×</button> <div class="exn">'+data.messages[i]['name']+'</div></div>';
                            }
                            str += '<div class="add-state" data-attr="'+attr_id+'">+</div></div> </div>';
                            sessionStorage.setItem('category_attribute_detail', JSON.stringify(data.messages));
                            $('#category_value_update').html(str);
                        }else{
                            alert(data.messages);
                        }
                    },
                    sync:true
                });
            }else{
                for(var i in attr_values){
                    str += '<div class="alert fade clearfix in"> <button type="button" class="close" data-dismiss="alert" data-id="'+attr_values[i]['id']+'">×</button> <div class="exn">'+attr_values[i]['name']+'</div></div>';
                }
                str += '<div class="add-state" data-attr="'+attr_id+'">+</div></div> </div>';
            }
        }else{
            var value_arr = attr_value.split(',');
            for(var i in value_arr){
                str += '<div class="alert fade clearfix in"> <button type="button" class="close" data-dismiss="alert" data-id="'+attribute[attr_id][value_arr[i]]['id']+'">×</button> <div class="exn">'+attribute[attr_id][value_arr[i]]['name']+'</div></div>';
            }
            str += '<div class="add-state" data-attr="'+attr_id+'">+</div></div> </div>';
        }
        $('#category_value_update').html(str);
    }

    function attribute_update_submit(obj, data){
        obj.attr('disabled', true);
        $.ajax({
            type:'post',
            url:"{{route('category.value')}}",
            data:data,
            success:function(data){
                if(data.status == true){
                    toastr.success(data.messages);
                    window.location.href = "{{route('category.index')}}";
                }else{
                    toastr.error(data.messages);
                }
            },
            sync:true
        });
    }

    function get_attributes_by_id(id){
        var attributes = JSON.parse(sessionStorage.getItem('category_attribute'));
        if(typeof attributes[id] != 'undefined'){
            sessionStorage.setItem('category_attr_values', JSON.stringify(attributes[id]));
            return attributes[id];
        }else{
            return [];
        }
    }

    function show_attribute(data, type){
        if(empty(data)){
            var attribute = get_all_attribute();
            if(attribute){
                attribute = ( typeof attribute == 'string' ) ? JSON.parse(attribute) : attribute;
                var str = '';
                for(var i in attribute[0]){
                    type = parseInt(type);
                    if(type == 3) {
                        if(attribute[0][i]['attr_type'] != 2) str += '<li data-id="'+attribute[0][i]['id']+'">'+attribute[0][i]['name']+'</li>';
                    }else{
                        str += '<li data-id="'+attribute[0][i]['id']+'">'+attribute[0][i]['name']+'</li>';
                    }
                }
            }else{
                return;
            }
        }else{
            var str = '';
            for(var i in data){
                str += '<li data-id="'+data[i]['id']+'">'+data[i]['name']+'</li>';
            }
        }
        $('#attr_list').html(str);
    }
    function show_attribute_value(id, obj){
        if(typeof obj != 'undefined'){
            var attribute = get_all_attribute(id, obj);
        }else{
            var attribute = get_all_attribute();
        }
        attribute = ( typeof attribute == 'string' ) ? JSON.parse(attribute) : attribute;
        var attribute_value = attribute[id];
        var type = $('.mose-five .exn-npm').find('input[name=attr_type]').val();
        if(type == 4 || type == 2){
            var attribute_active = attribute[0][id];
            var inputs = '<input type="hidden" name="attr_values" value=""><input type="hidden" name="attr_id" value="">';
            if(attribute_active.attr_type == 2){
                inputs += '<input type="hidden" name="attr_type" value="'+type+'"><div class="exn-log clearfix"><h6>是否必填：</h6><div class="exn-right clearfix"><label><input type="radio" name="is_required" value="1" checked/><span>必填</span></label> <label><input type="radio" name="is_required" value="2"/><span>非必填</span></label></div></div>';
            }else{
                if(type == 2){
                    inputs += '<input type="hidden" name="attr_type" value="2"><div class="exn-log clearfix"><h6>是否必填：</h6><div class="exn-right clearfix"><label><input type="radio" name="is_required" value="1" checked/><span>必填</span></label> <label><input type="radio" name="is_required" value="2"/><span>非必填</span></label></div></div><div class="exn-log clearfix"><h6>单选/多选：</h6><div class="exn-right clearfix"><label><input type="radio" name="check_type" value="2" checked/><span>单选</span></label><label><input type="radio" name="check_type" value="1"/><span>多选</span></label></div></div>';
                }else{
                    inputs += '<input type="hidden" name="attr_type" value="4"><div class="exn-log clearfix"><h6>单选/多选：</h6><div class="exn-right clearfix"><label><input type="radio" name="check_type" value="2" checked/><span>单选</span></label><label><input type="radio" name="check_type" value="1"/><span>多选</span></label></div></div><div class="exn-log clearfix"><h6>是否必填：</h6><div class="exn-right clearfix"><label><input type="radio" name="is_required" value="1" checked/><span>必填</span></label> <label><input type="radio" name="is_required" value="2"/><span>非必填</span></label></div></div><div class="exn-log clearfix"><h6>是否详情显示：</h6><div class="exn-right clearfix"><label><input type="radio" name="is_detail" checked value="2"/><span>不显示</span></label><label><input type="radio" name="is_detail" value="1"/><span>显示</span></label></div></div>';
                }
            }
        }
        $('.mose-five .exn-npm').html(inputs);
        var str = '';
        for(var i in attribute_value){
            str += '<li data-id="'+attribute_value[i]['id']+'">'+attribute_value[i]['name']+'</li>';
        }
        if(typeof obj == 'undefined') {
            $('#attr_value_list').html(str);
        }else{
            obj.html(str);
        }
    }
    function get_all_attribute(id, obj){
        var attribute = JSON.parse(sessionStorage.getItem('attribute_all'));
        if(empty(attribute)){
            $.ajax({
                type:'get',
                url:"{{route('attribute.all')}}",
                data:{},
                success:function(data){
                    if(data.status == true){
                        attribute = data.messages;
                        sessionStorage.setItem('attribute_all', JSON.stringify(attribute));
                        if(typeof id != 'undefined'){
                            show_attribute_value(id, obj);
                        }else{
                            show_attribute(JSON.parse(attribute)[0]);
                        }
                    }else{
                        toastr.error('网络错误，请稍后重试');
                    }
                },
                sync:true
            });
        }
        return attribute;
    }
    function attr_value_add(){
        var attr_value_lists = $('#attr_value_list li');
        var length = attr_value_lists.length;
        var values_arr = [];
        for(var i=0; i<length; i++){
            if($(attr_value_lists[i]).hasClass('active')){
                values_arr.push($(attr_value_lists[i]).attr('data-id'));
            }
        }
        var values_str = values_arr.join(',');
        $('.mose-five .exn-npm').find('input[name=attr_values]').val(values_str);
    }
    function attr_value_save(){
        var category_attr_values = sessionStorage.getItem('category_attr_values');
        var name = $('#attr_list li.active').text();
        var obj = $('.mose-five .exn-npm');
        var data = {};
        data.attr_id = obj.find('input[name=attr_id]').val();
        var attribute = get_all_attribute();
        if(attribute){
            attribute = ( typeof attribute == 'string' ) ? JSON.parse(attribute) : attribute;
            var attribute_active = attribute[0][data.attr_id];
        }else{
            return;
        }
        if(attribute_active.attr_type == 2 && empty(obj.find('input[name=attr_values]').val())){
            obj.find('input[name=attr_values]').val('0');
        }
        data.attr_values = obj.find('input[name=attr_values]').val();
        data.attr_type = obj.find('input[name=attr_type]').val();
        data.is_required = obj.find('input[name=is_required]:checked').val();
        data.check_type = obj.find('input[name=check_type]:checked').val();
        data.is_image = obj.find('input[name=is_image]:checked').val();
        data.is_diy = obj.find('input[name=is_diy]:checked').val();
        data.is_detail = obj.find('input[name=is_detail]:checked').val();
        if(data.attr_values == ''){
            alert('请选择属性值！');return true;
        }
        if(empty(category_attr_values)){
            category_attr_values = [data];
        }else{
            category_attr_values = JSON.parse(category_attr_values);
            if(typeof category_attr_values == 'object'){
                var arr = [];
                for(var i in category_attr_values){
                    arr[i] = category_attr_values[i];
                }
                category_attr_values = arr;
            }
            var hasImage = false;
            if(data.attr_type == 3){
                for(var k in category_attr_values){
                    if(parseInt(category_attr_values[k].is_image) == 1) hasImage = true;
                }
                if(hasImage && parseInt(data.is_image) == 1){
                    alert('图片销售属性只能有一个');
                    return true;
                }
            }
            category_attr_values.push(data);
        }
        sessionStorage.setItem('category_attr_values', JSON.stringify(category_attr_values));
        var str = '<div class="alert fade in"><button type="button" class="close" data-type="'+data.attr_type+'" data-attr="'+data.attr_id+'" data-dismiss="alert">×</button><div class="exn">'+name+'</div></div>';
        $('#category_attribute_type'+data.attr_type).prepend(str);
        if(data.attr_type == '3'){
            var attr_list = $('#category_attribute_type'+data.attr_type).find('button.close');
            if(attr_list.length >= 3){
                $('#category_attribute_type'+data.attr_type).find('div.add-state').remove();
            }
        }
        return false;
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

    function empty(obj){
        if( (typeof obj == 'undefined') || (obj == 'undefined') || (obj == '') || (obj == null) || (obj == 'null') || (obj == 0) || (obj == '0') ){
            return true;
        }else{
            return false;
        }
    }

    function attr_value_update(){
        var attr_value_lists = $('.mose-six li');
        var length = attr_value_lists.length;
        var values_arr = [];
        var str = '';
        var values_old = $('#category_value_update').find('input[name=attr_values]').val();
        var old_arr = values_old.split(',');
        for(var i=0; i<length; i++){
            if($(attr_value_lists[i]).hasClass('active')){
                var id = $(attr_value_lists[i]).attr('data-id');
                if($.inArray(id, old_arr) == -1){
                    values_arr.push(id);
                    str += '<div class="alert fade clearfix in"><button type="button" class="close" data-dismiss="alert" data-id="'+id+'">×</button><div class="exn">'+$(attr_value_lists[i]).text()+'</div></div>';
                }
            }
        }
        for(var i in old_arr){
            if(!empty(old_arr[i])) values_arr.push(old_arr[i]);
        }
        var values_str = values_arr.join(',');
        $('#category_value_update').find('input[name=attr_values]').val(values_str);
        $('#category_value_update_detail').prepend(str);
    }

    function getQueryString(name, url) {
        var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
        var r = url.match(reg);
        if (r != null) {
            return unescape(r[2]);
        }
        return null;
    }

    function get_category_path(data){
        var category = JSON.parse(sessionStorage.getItem('category'));
        var category_path = '';
        switch(data.level){
            case 1:
                category_path = data.name;
                break;
            case 2:
                var parent_cate = category[data.level - 2][data.parent_id];
                category_path = parent_cate.name+'>'+data.name;
                break;
            case 3:
                var parent_cate = category[data.level - 2][data.parent_id];
                var grand_cate = category[data.level - 3][parent_cate.parent_id];
                category_path = grand_cate.name+'>'+parent_cate.name+'>'+data.name;
                break;
        }
        return category_path;
    }

    function category_search(input){
        var title =  input.find('input').val();
        if(empty(title)) return false;
        $.ajax({
            type:'post',
            url:"{{route('category.search')}}",
            data:{title:title,_token:"{{csrf_token()}}"},
            success:function(data){
                if(data.status == true){
                    var category = data.messages;
                    var str = '';
                    for(var i in category){
                        str += '<li data-id="'+category[i]['id']+'" data-path="'+category[i]['category_ids']+'">'+get_category_path(category[i])+'</li>';
                    }
                    $('.search-from ul').html(str).addClass('hover');
                }
            },
            sync:true
        });
        return false;
    }
</script>
@endsection