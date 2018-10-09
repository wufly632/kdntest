@extends('layouts.default')
@section('title')
    {{trans('common.system_name')}}
@endsection
@section('css')
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
                    <button type="button" class="btn btn-success col-xs-offset-9" data-toggle="modal" data-target="#add-property">新增属性</button>
                </div>
                <div class="box-body">
                    <div class="row" style="height: 650px;">
                        <div class="col-md-4 content-item">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="输入要选择的属性" id="search-text" name="searchValue" value="" maxlength="200" onkeyup="autocomple()"><ul id="autocomplete" class="dropdown-menu" style="display: none;"></ul>
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            </div>
                            <ul class="ul-tree">
                                <li>
                                    <div class="level-one" data-attribute_id="18" data-attribute_name="颜色">
                                        <span class="attribute-name">颜色</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one tree-active" data-attribute_id="19" data-attribute_name="童装尺码">
                                        <span class="attribute-name">童装尺码</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="20" data-attribute_name="女装尺码">
                                        <span class="attribute-name">女装尺码</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="21" data-attribute_name="童鞋尺码">
                                        <span class="attribute-name">童鞋尺码</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="22" data-attribute_name="女鞋尺码">
                                        <span class="attribute-name">女鞋尺码</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="23" data-attribute_name="运动户外项目">
                                        <span class="attribute-name">运动户外项目</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="24" data-attribute_name="衣长">
                                        <span class="attribute-name">衣长</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="25" data-attribute_name="衣门襟">
                                        <span class="attribute-name">衣门襟</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="26" data-attribute_name="洗涤说明">
                                        <span class="attribute-name">洗涤说明</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="27" data-attribute_name="袜子种类">
                                        <span class="attribute-name">袜子种类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="28" data-attribute_name="花纹">
                                        <span class="attribute-name">花纹</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="29" data-attribute_name="填充物">
                                        <span class="attribute-name">填充物</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="30" data-attribute_name="适用性别">
                                        <span class="attribute-name">适用性别</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="31" data-attribute_name="适用年龄">
                                        <span class="attribute-name">适用年龄</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="32" data-attribute_name="适合季节">
                                        <span class="attribute-name">适合季节</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="33" data-attribute_name="裙型">
                                        <span class="attribute-name">裙型</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="34" data-attribute_name="件数">
                                        <span class="attribute-name">件数</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="35" data-attribute_name="货号">
                                        <span class="attribute-name">货号</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="36" data-attribute_name="含绒量">
                                        <span class="attribute-name">含绒量</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="37" data-attribute_name="功能">
                                        <span class="attribute-name">功能</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="38" data-attribute_name="服装类型">
                                        <span class="attribute-name">服装类型</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="39" data-attribute_name="风格">
                                        <span class="attribute-name">风格</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="40" data-attribute_name="防水透气指数">
                                        <span class="attribute-name">防水透气指数</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="41" data-attribute_name="产地">
                                        <span class="attribute-name">产地</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="42" data-attribute_name="材质">
                                        <span class="attribute-name">材质</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="43" data-attribute_name="安全等级">
                                        <span class="attribute-name">安全等级</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="44" data-attribute_name="参考链接">
                                        <span class="attribute-name">参考链接</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="45" data-attribute_name="大码女装尺码">
                                        <span class="attribute-name">大码女装尺码</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="46" data-attribute_name="亲子装尺码">
                                        <span class="attribute-name">亲子装尺码</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="55" data-attribute_name="组合形式">
                                        <span class="attribute-name">组合形式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="56" data-attribute_name="中老年女装图案">
                                        <span class="attribute-name">中老年女装图案</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="57" data-attribute_name="中老年女装分类">
                                        <span class="attribute-name">中老年女装分类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="58" data-attribute_name="中老年风格">
                                        <span class="attribute-name">中老年风格</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="59" data-attribute_name="质地">
                                        <span class="attribute-name">质地</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="60" data-attribute_name="制作工艺">
                                        <span class="attribute-name">制作工艺</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="61" data-attribute_name="腰型">
                                        <span class="attribute-name">腰型</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="62" data-attribute_name="袖长">
                                        <span class="attribute-name">袖长</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="63" data-attribute_name="袖型">
                                        <span class="attribute-name">袖型</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="64" data-attribute_name="图案">
                                        <span class="attribute-name">图案</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="65" data-attribute_name="适用对象">
                                        <span class="attribute-name">适用对象</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="66" data-attribute_name="适用场景">
                                        <span class="attribute-name">适用场景</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="67" data-attribute_name="设计裁剪">
                                        <span class="attribute-name">设计裁剪</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="68" data-attribute_name="裙长">
                                        <span class="attribute-name">裙长</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="69" data-attribute_name="皮质">
                                        <span class="attribute-name">皮质</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="70" data-attribute_name="牛仔面料盎司">
                                        <span class="attribute-name">牛仔面料盎司</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="71" data-attribute_name="内胆类型">
                                        <span class="attribute-name">内胆类型</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="72" data-attribute_name="面料主材质含量">
                                        <span class="attribute-name">面料主材质含量</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="73" data-attribute_name="面料材质">
                                        <span class="attribute-name">面料材质</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="74" data-attribute_name="面料">
                                        <span class="attribute-name">面料</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="75" data-attribute_name="毛线粗细">
                                        <span class="attribute-name">毛线粗细</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="76" data-attribute_name="流行元素">
                                        <span class="attribute-name">流行元素</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="77" data-attribute_name="领子">
                                        <span class="attribute-name">领子</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="78" data-attribute_name="领型">
                                        <span class="attribute-name">领型</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="79" data-attribute_name="里料图案">
                                        <span class="attribute-name">里料图案</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="80" data-attribute_name="里料分类">
                                        <span class="attribute-name">里料分类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="81" data-attribute_name="里料材质">
                                        <span class="attribute-name">里料材质</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="82" data-attribute_name="礼服裙长">
                                        <span class="attribute-name">礼服裙长</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="83" data-attribute_name="礼服摆型">
                                        <span class="attribute-name">礼服摆型</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="84" data-attribute_name="廓形">
                                        <span class="attribute-name">廓形</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="85" data-attribute_name="款式">
                                        <span class="attribute-name">款式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="86" data-attribute_name="裤长">
                                        <span class="attribute-name">裤长</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="87" data-attribute_name="克重">
                                        <span class="attribute-name">克重</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="88" data-attribute_name="开衩高度">
                                        <span class="attribute-name">开衩高度</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="89" data-attribute_name="襟形">
                                        <span class="attribute-name">襟形</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="90" data-attribute_name="厚薄">
                                        <span class="attribute-name">厚薄</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="91" data-attribute_name="功能性">
                                        <span class="attribute-name">功能性</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="92" data-attribute_name="服装款式细节">
                                        <span class="attribute-name">服装款式细节</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="93" data-attribute_name="服装版型">
                                        <span class="attribute-name">服装版型</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="94" data-attribute_name="服饰工艺">
                                        <span class="attribute-name">服饰工艺</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="95" data-attribute_name="大码女装分类">
                                        <span class="attribute-name">大码女装分类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="96" data-attribute_name="穿着方式">
                                        <span class="attribute-name">穿着方式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="97" data-attribute_name="充绒量">
                                        <span class="attribute-name">充绒量</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="98" data-attribute_name="成分含量">
                                        <span class="attribute-name">成分含量</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="99" data-attribute_name="帮面材质">
                                        <span class="attribute-name">帮面材质</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="100" data-attribute_name="闭合方式">
                                        <span class="attribute-name">闭合方式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="101" data-attribute_name="材质工艺">
                                        <span class="attribute-name">材质工艺</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="102" data-attribute_name="流行靴款">
                                        <span class="attribute-name">流行靴款</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="103" data-attribute_name="配皮材质">
                                        <span class="attribute-name">配皮材质</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="104" data-attribute_name="皮质材料">
                                        <span class="attribute-name">皮质材料</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="105" data-attribute_name="适用季节">
                                        <span class="attribute-name">适用季节</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="106" data-attribute_name="鞋帮高度">
                                        <span class="attribute-name">鞋帮高度</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="107" data-attribute_name="鞋底材质">
                                        <span class="attribute-name">鞋底材质</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="108" data-attribute_name="鞋跟款式">
                                        <span class="attribute-name">鞋跟款式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="109" data-attribute_name="鞋类">
                                        <span class="attribute-name">鞋类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="110" data-attribute_name="鞋面材质">
                                        <span class="attribute-name">鞋面材质</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="111" data-attribute_name="鞋头款式">
                                        <span class="attribute-name">鞋头款式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="112" data-attribute_name="靴筒高度">
                                        <span class="attribute-name">靴筒高度</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="113" data-attribute_name="学步鞋鞋底材质">
                                        <span class="attribute-name">学步鞋鞋底材质</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="114" data-attribute_name="运动鞋分类">
                                        <span class="attribute-name">运动鞋分类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="115" data-attribute_name="品牌">
                                        <span class="attribute-name">品牌</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="117" data-attribute_name="洗涤方式">
                                        <span class="attribute-name">洗涤方式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="118" data-attribute_name="可否氯漂">
                                        <span class="attribute-name">可否氯漂</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="119" data-attribute_name="干衣方式">
                                        <span class="attribute-name">干衣方式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="120" data-attribute_name="熨烫方式">
                                        <span class="attribute-name">熨烫方式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="121" data-attribute_name="干洗">
                                        <span class="attribute-name">干洗</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="122" data-attribute_name="商品条形码">
                                        <span class="attribute-name">商品条形码</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="123" data-attribute_name="规格">
                                        <span class="attribute-name">规格</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="124" data-attribute_name="尺码">
                                        <span class="attribute-name">尺码</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="125" data-attribute_name="卫生巾分类">
                                        <span class="attribute-name">卫生巾分类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="126" data-attribute_name="卫生巾表层">
                                        <span class="attribute-name">卫生巾表层</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="127" data-attribute_name="是否有护翼">
                                        <span class="attribute-name">是否有护翼</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="128" data-attribute_name="是否可拆洗">
                                        <span class="attribute-name">是否可拆洗</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="129" data-attribute_name="条数">
                                        <span class="attribute-name">条数</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="130" data-attribute_name="容量">
                                        <span class="attribute-name">容量</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="131" data-attribute_name="母乳存储器分类">
                                        <span class="attribute-name">母乳存储器分类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="132" data-attribute_name="抽数">
                                        <span class="attribute-name">抽数</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="133" data-attribute_name="包装种类">
                                        <span class="attribute-name">包装种类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="134" data-attribute_name="湿巾用途">
                                        <span class="attribute-name">湿巾用途</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="135" data-attribute_name="包装">
                                        <span class="attribute-name">包装</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="136" data-attribute_name="类型">
                                        <span class="attribute-name">类型</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="137" data-attribute_name="样式">
                                        <span class="attribute-name">样式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="138" data-attribute_name="null">
                                        <span class="attribute-name">null</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="139" data-attribute_name="用途">
                                        <span class="attribute-name">用途</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="140" data-attribute_name="型号">
                                        <span class="attribute-name">型号</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="141" data-attribute_name="可自定义属性5个">
                                        <span class="attribute-name">可自定义属性5个</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="142" data-attribute_name="防辐射面料">
                                        <span class="attribute-name">防辐射面料</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="143" data-attribute_name="开口方式">
                                        <span class="attribute-name">开口方式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="144" data-attribute_name="裤门襟">
                                        <span class="attribute-name">裤门襟</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="145" data-attribute_name="上下装分类">
                                        <span class="attribute-name">上下装分类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="146" data-attribute_name="毛衣厚薄">
                                        <span class="attribute-name">毛衣厚薄</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="147" data-attribute_name="毛衣质地">
                                        <span class="attribute-name">毛衣质地</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="148" data-attribute_name="是否带帽子">
                                        <span class="attribute-name">是否带帽子</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="149" data-attribute_name="针织面料">
                                        <span class="attribute-name">针织面料</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="150" data-attribute_name="罩杯款式">
                                        <span class="attribute-name">罩杯款式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="151" data-attribute_name="模杯厚度">
                                        <span class="attribute-name">模杯厚度</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="152" data-attribute_name="肩带样式">
                                        <span class="attribute-name">肩带样式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="153" data-attribute_name="搭扣排数">
                                        <span class="attribute-name">搭扣排数</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="154" data-attribute_name="插片">
                                        <span class="attribute-name">插片</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="155" data-attribute_name="有无钢圈">
                                        <span class="attribute-name">有无钢圈</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="156" data-attribute_name="内裤类型">
                                        <span class="attribute-name">内裤类型</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="157" data-attribute_name="腰围是否可调">
                                        <span class="attribute-name">腰围是否可调</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="158" data-attribute_name="帽围">
                                        <span class="attribute-name">帽围</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="159" data-attribute_name="帽子类型">
                                        <span class="attribute-name">帽子类型</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="160" data-attribute_name="帽檐款式">
                                        <span class="attribute-name">帽檐款式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="161" data-attribute_name="帽顶款式">
                                        <span class="attribute-name">帽顶款式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="162" data-attribute_name="用途功效">
                                        <span class="attribute-name">用途功效</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="163" data-attribute_name="文胸尺码">
                                        <span class="attribute-name">文胸尺码</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="164" data-attribute_name="婴童睡袋尺码">
                                        <span class="attribute-name">婴童睡袋尺码</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="165" data-attribute_name="适合体重">
                                        <span class="attribute-name">适合体重</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="166" data-attribute_name="净含量">
                                        <span class="attribute-name">净含量</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="167" data-attribute_name="条形码">
                                        <span class="attribute-name">条形码</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="168" data-attribute_name="温度测试范围">
                                        <span class="attribute-name">温度测试范围</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="169" data-attribute_name="感温液类型">
                                        <span class="attribute-name">感温液类型</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="170" data-attribute_name="盆种类">
                                        <span class="attribute-name">盆种类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="171" data-attribute_name="浴网分类">
                                        <span class="attribute-name">浴网分类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="172" data-attribute_name="背带方式">
                                        <span class="attribute-name">背带方式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="173" data-attribute_name="尺寸">
                                        <span class="attribute-name">尺寸</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="174" data-attribute_name="承重">
                                        <span class="attribute-name">承重</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="175" data-attribute_name="是否有导购视频">
                                        <span class="attribute-name">是否有导购视频</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="176" data-attribute_name="饰面材质">
                                        <span class="attribute-name">饰面材质</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="177" data-attribute_name="形状">
                                        <span class="attribute-name">形状</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="178" data-attribute_name="个数">
                                        <span class="attribute-name">个数</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="179" data-attribute_name="适合床垫高度">
                                        <span class="attribute-name">适合床垫高度</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="180" data-attribute_name="长度">
                                        <span class="attribute-name">长度</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="181" data-attribute_name="防护高度">
                                        <span class="attribute-name">防护高度</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="182" data-attribute_name="高度是否可调节">
                                        <span class="attribute-name">高度是否可调节</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="183" data-attribute_name="吸鼻器样式">
                                        <span class="attribute-name">吸鼻器样式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="184" data-attribute_name="配合奶瓶口径">
                                        <span class="attribute-name">配合奶瓶口径</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="185" data-attribute_name="奶瓶是否带柄">
                                        <span class="attribute-name">奶瓶是否带柄</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="186" data-attribute_name="口径大小">
                                        <span class="attribute-name">口径大小</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="187" data-attribute_name="使用方式">
                                        <span class="attribute-name">使用方式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="188" data-attribute_name="喂药器样式">
                                        <span class="attribute-name">喂药器样式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="189" data-attribute_name="是否电动">
                                        <span class="attribute-name">是否电动</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="190" data-attribute_name="食品口味">
                                        <span class="attribute-name">食品口味</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="191" data-attribute_name="配件类型">
                                        <span class="attribute-name">配件类型</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="192" data-attribute_name="流速">
                                        <span class="attribute-name">流速</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="193" data-attribute_name="孔型">
                                        <span class="attribute-name">孔型</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="194" data-attribute_name="奶嘴品类">
                                        <span class="attribute-name">奶嘴品类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="195" data-attribute_name="奶瓶容量">
                                        <span class="attribute-name">奶瓶容量</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="196" data-attribute_name="材质特征">
                                        <span class="attribute-name">材质特征</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="197" data-attribute_name="检测标准">
                                        <span class="attribute-name">检测标准</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="198" data-attribute_name="安装方式">
                                        <span class="attribute-name">安装方式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="199" data-attribute_name="人体固定方式">
                                        <span class="attribute-name">人体固定方式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="200" data-attribute_name="防晒指数">
                                        <span class="attribute-name">防晒指数</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="201" data-attribute_name="百货品类">
                                        <span class="attribute-name">百货品类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="202" data-attribute_name="香味">
                                        <span class="attribute-name">香味</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="203" data-attribute_name="是否防水">
                                        <span class="attribute-name">是否防水</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="204" data-attribute_name="是否带柄">
                                        <span class="attribute-name">是否带柄</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="205" data-attribute_name="奶粉盒样式">
                                        <span class="attribute-name">奶粉盒样式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="206" data-attribute_name="结构材质">
                                        <span class="attribute-name">结构材质</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="207" data-attribute_name="是否可升降">
                                        <span class="attribute-name">是否可升降</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="208" data-attribute_name="具体规格">
                                        <span class="attribute-name">具体规格</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="209" data-attribute_name="适用部位">
                                        <span class="attribute-name">适用部位</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="210" data-attribute_name="种类">
                                        <span class="attribute-name">种类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="211" data-attribute_name="电源方式">
                                        <span class="attribute-name">电源方式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="212" data-attribute_name="床垫类型">
                                        <span class="attribute-name">床垫类型</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="213" data-attribute_name="厚度">
                                        <span class="attribute-name">厚度</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="214" data-attribute_name="枕头类型">
                                        <span class="attribute-name">枕头类型</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="215" data-attribute_name="产品品类">
                                        <span class="attribute-name">产品品类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="216" data-attribute_name="消毒时间">
                                        <span class="attribute-name">消毒时间</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="217" data-attribute_name="用品品类">
                                        <span class="attribute-name">用品品类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="218" data-attribute_name="均码">
                                        <span class="attribute-name">均码</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="219" data-attribute_name="镶嵌材质">
                                        <span class="attribute-name">镶嵌材质</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="220" data-attribute_name="发饰分类">
                                        <span class="attribute-name">发饰分类</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="221" data-attribute_name="手套款式">
                                        <span class="attribute-name">手套款式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="222" data-attribute_name="大小">
                                        <span class="attribute-name">大小</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="223" data-attribute_name="是否带电">
                                        <span class="attribute-name">是否带电</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="224" data-attribute_name="季节">
                                        <span class="attribute-name">季节</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="225" data-attribute_name="场合">
                                        <span class="attribute-name">场合</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="226" data-attribute_name="样式">
                                        <span class="attribute-name">样式</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="227" data-attribute_name="商品标签">
                                        <span class="attribute-name">商品标签</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="228" data-attribute_name="亲子装尺码（自营）">
                                        <span class="attribute-name">亲子装尺码（自营）</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="229" data-attribute_name="设计师款">
                                        <span class="attribute-name">设计师款</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="230" data-attribute_name="属性">
                                        <span class="attribute-name">属性</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="231" data-attribute_name="拖鞋尺码">
                                        <span class="attribute-name">拖鞋尺码</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="232" data-attribute_name="戒指尺码">
                                        <span class="attribute-name">戒指尺码</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="233" data-attribute_name="手机壳尺码">
                                        <span class="attribute-name">手机壳尺码</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="234" data-attribute_name="带包装重量（KG）">
                                        <span class="attribute-name">带包装重量（KG）</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="235" data-attribute_name="包装后体积（长*宽*高；cm）">
                                        <span class="attribute-name">包装后体积（长*宽*高；cm）</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="236" data-attribute_name="投放区域">
                                        <span class="attribute-name">投放区域</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="237" data-attribute_name="散货／大货">
                                        <span class="attribute-name">散货／大货</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="level-one" data-attribute_id="238" data-attribute_name="尺码标准">
                                        <span class="attribute-name">尺码标准</span>
                                    </div>
                                </li>
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
                                        <span class="mess-name">属性名(中文):</span>
                                        <span class="mess-key">颜色</span>
                                    </li>
                                    <li>
                                        <span class="mess-name">属性别名:</span>
                                        <span class="mess-key">Color</span>
                                    </li>
                                    <li>
                                        <span class="mess-name">属性名(英文):</span>
                                        <span class="mess-key">Color</span>
                                    </li>
                                    <li>
                                        <span class="mess-name">排序值:</span>
                                        <span class="mess-key">10</span>
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
                                <ul id="attributes_values" class="edit-property"><li style=""><span id="add_value_button" class="plus-btn"><i class="fa fa-plus"></i>添加</span></li> <li><div class="level-one"><span class="category-name">黄色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">领带</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">麻灰</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">藏青</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">白色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">黑色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">绿色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">红色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">蓝色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">橙色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">粉色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">紫色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">棕色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">浅蓝</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">乳白色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">浅黄</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">卡其色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">浅灰</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">淡绿</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">淡黄</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">薰衣草紫</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">混色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">灰色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">薄荷绿</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">玫瑰色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">米色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">浅绿</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">深蓝色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">豆沙色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">浅紫</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">淡红</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">玫红色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">金色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">蓝绿色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">香槟色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">银色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">多色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">海军蓝</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">无色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">深绿</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">玫瑰金</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">酒红色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">珊瑚色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">深紫红色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">深灰</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">蓝灰色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">浅粉</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">咖啡色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">杏黄色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">深粉色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">品蓝色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">米色长袖</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">红色长袖</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">Maxi Blue</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">黑色狐狸</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">Maxi Pink</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">黑色几何</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">亮黄色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">Maxi Sapphire</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">宝蓝色</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">西瓜红</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">大</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">小</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">款6</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">款1</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">款3</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">款2</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">款4</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">款7</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">款5</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">妈妈</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">2</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">1</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">爸爸</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">女孩</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">男孩</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">哈衣</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">宝宝</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">套装</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">连衣裙</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li><li><div class="level-one"><span class="category-name">灰色（美）</span> <!----> <span style="display: none;">中国码</span> <i class="fa fa-trash-o pull-right delete-property-value"></i> <i data-toggle="modal" data-target="#editProperty" class="fa fa-pencil pull-right"></i></div></li></ul>
                                <ul id="attributes_categories" class="edit-property"><li></li> </ul>
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
                        <h4 class="modal-title" id="myModalLabel" v-text = "title"></h4>
                    </div>
                    <form id="attribute_edit_form" class="form-horizontal">
                        <input type="hidden" name="id" v-model="id">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-xs-1"></div>
                                <label for="coupon_name" class="col-xs-2 control-label">
                                    属性名称：
                                </label>
                                <div class="col-xs-7">
                                    <input name="name" v-model="name" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-1"></div>
                                <label for="coupon_name" class="col-xs-2 control-label">
                                    属性别名：
                                </label>
                                <div class="col-xs-7">
                                    <input name="alias_name" v-model="alias_name" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-1"></div>
                                <label for="coupon_name" class="col-xs-2 control-label">
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
                                <button type="button" class="btn btn-success col-xs-offset-3">取消</button>
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
                        <input type="hidden" name="id" v-model="id">
                        <input type="hidden" name="attribute_id" v-model="attribute_id">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ trans('Attribute::attribute.attribute_value_name_chs') }}：</label>
                                <input type="text" name="name" v-model="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('Attribute::attribute.attribute_value_name_en') }}：</label>
                                <input type="text" name="en_name" v-model="en_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('Attribute::attribute.attribute_value_name_ar') }}：</label>
                                <input type="text" name="ar_name" v-model="ar_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('Attribute::attribute.attribute_value_name_es') }}：</label>
                                <input type="text" name="es_name" v-model="es_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('Attribute::attribute.attribute_value_name_fr') }}：</label>
                                <input type="text" name="fr_name" v-model="fr_name" class="form-control">
                            </div>
                            {{--<div class="form-group">
                                <label>{{ trans('Attribute::attribute.attribute_value_name_it') }}：</label>
                                <input type="text" name="it_name" v-model="it_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('Attribute::attribute.attribute_value_name_ge') }}：</label>
                                <input type="text" name="ge_name" v-model="ge_name" class="form-control">
                            </div>--}}
                            <div class="form-group">
                                <label>{{ trans('Attribute::attribute.attribute_standard_value') }}：</label>
                                <input type="text" name="standard_value" v-model="standard_value" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('Attribute::attribute.sort_value') }}：</label>
                                <input type="text" name="sort" v-model="sort" class="form-control">
                            </div>
                            <div class="form-group" v-if="alias == 'Size'">
                                <label>属性分组：</label>
                                <select name="attribute_group" v-model="attribute_group" class="form-control">
                                    <option value="0">中国码</option>
                                    <option value="1">欧美码</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('Attribute::attribute.description') }}：</label>
                                <textarea class="form-control" name="description" v-model="description" rows="3" placeholder="Enter ..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('Attribute::attribute.cancel') }}</button>
                            <button type="button" v-on:click="submit" class="btn btn-primary">{{ trans('Attribute::attribute.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal end-->
    </div>
@endsection
@section('scripts')
    <script src="/assets/js/vue.js" type="text/javascript"></script>
    <script src="{{ asset ("/assets/adminlte/plugins/iCheck/icheck.min.js") }}"></script>
    <script>


        var attribute = {!! $defaultSelectAttribute !!};
        //初始化默认选中属性的详情
        {{--refreshAttributeDetailInfo({!! $defaultSelectAttribute->id !!});--}}

        //绑定属性详细信息的UI属性
        var attribute_info_data = {
            attribute_info: ''
        };
        var myTask = Vue.component('my-task',{
            template : '#task-template',
            data : function(){
                return this.tasks
            },
            props : ['task']
        });
        new Vue({
            el: '#attribute_detail_container',
            data: attribute_info_data,
        });

        //渲染属性值列表
        var attributes_values_data = {
            items:[],
            is_custom_text:false,
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
            title: "{{trans('Attribute::attribute.new_attribute')}}",
            mold: 0,
            name: '',
            en_name: '',
            ar_name: '',
            es_name: '',
            fr_name: '',
            /*it_name: '', //意大利语
            ge_name: '', //德语*/
            standard_value: '',
            alias: '',
            sort: '',
            description: ''
        };
        new Vue({
            el: '#add_edit_attribute',
            data: add_edit_attribute_data,
            methods: {
                submit: function () {
                    if (!add_edit_attribute_data.name){
                        toastr.warning("{{trans('Attribute::attribute.attribute_name_Chinese_can_not_be_empty')}}");
                    }else if(!add_edit_attribute_data.alias){
                        toastr.warning("{{trans('Attribute::attribute.attribute_name_alias_can_not_be_empty')}}");
                    }else {
                        var inputs = $("#attribute_edit_form").serialize();
                        $.ajax({
                            url:"/attribute/add_or_edit",
                            data:inputs,
                            type:'POST',
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
            title: "{{trans('Attribute::attribute.new_attribute_value')}}",
            name: '',
            en_name: '',
            ar_name: '',
            es_name: '',
            fr_name: '',
            /*it_name: '',
            ge_name: '',*/
            standard_value: '',
            sort: '',
            description: '',
            attribute_group:'',
            alias: '',
        };
        new Vue({
            el: '#add_edit_attribute_value',
            data: add_edit_attribute_value_data,
            methods: {
                submit: function () {
                    if (!add_edit_attribute_value_data.name){
                        toastr.warning("{{trans('Attribute::attribute.attribute_value_Chinese_can_not_be_empty')}}");
                    }else if (!add_edit_attribute_value_data.en_name){
                        toastr.warning("{{trans('Attribute::attribute.attribute_value_English_can_not_be_empty')}}");
                    }else {
                        var inputs = $("#attribute_value_edit_form").serialize();
                        $.ajax({
                            url:"/attribute/add_or_edit_value",
                            data:inputs,
                            type:'POST',
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
                            },error: function (xmlHttpRequest, textStatus, errorThrown) {
                                swal("{{trans('Attribute::attribute.warning')}}", '错误码: '+xmlHttpRequest.status, "error");
                            }
                        });
                    }
                }
            }
        });

        function refreshAttributeDetailInfo(attribute_id) {
            $.ajax({
                url:"/attribute/"+attribute_id+'/detail',
                type:'GET',
                success: function (response) {
                    if (response.status == 200) {
                        attribute = response.content;
                        updateDetailView(attribute);
                        //更新属性值列表
                        attributes_values_data.items = attribute.values;
                        //自定义文本不显示属性值添加按钮
                        attributes_values_data.is_custom_text = attribute.type == 1 ? false : true;
                        attributes_values_data.alias = attribute.alias;
                        //更新属性关联类别列表
                        attributes_categories_data.items = attribute.categories;
                        //更新编辑Form默认信息
                        updateEditFormDefaultInfo(attribute);
                        add_edit_attribute_value_data.attribute_id = attribute.id;
                        add_edit_attribute_value_data.alias = attribute.alias;
                        /* 切换属性成功 */
                        $("#attributes_values").find(".pull-right").show();
                        edit_attribute_button();
                        selectProperty();
                        deleteProperty();
                        addValue()
                    }
                },
                complete: function () {
                },error: function (xmlHttpRequest, textStatus, errorThrown) {
                    toastrVoice('错误码: '+xmlHttpRequest.status);
                }
            });
        }

        //更新属性详细信息
        function updateDetailView(attribute) {
            {{--attribute.mold_v =  JSON.parse('{!! json_encode($allMold) !!}')[attribute.mold];--}}
            // attribute_info_data.attribute_info =  attribute;
        }

        //更新编辑Form默认信息
        function updateEditFormDefaultInfo(attribute) {
            add_edit_attribute_data.id = attribute.id;
            add_edit_attribute_data.title = "编辑属性";
            add_edit_attribute_data.mold = attribute.mold;
            add_edit_attribute_data.name = attribute.name;
            add_edit_attribute_data.en_name = attribute.en_name;
            add_edit_attribute_data.ar_name = attribute.ar_name;
            add_edit_attribute_data.es_name = attribute.es_name;
            add_edit_attribute_data.fr_name = attribute.fr_name;
            /*add_edit_attribute_data.it_name = attribute.it_name;
            add_edit_attribute_data.ge_name = attribute.ge_name;*/
            //add_edit_attribute_data.standard_value = attribute.standard_value;
            add_edit_attribute_data.alias = attribute.alias;
            $("input[type='radio'][name='type'][value='"+ attribute.type +"']").iCheck('check');
            $("input[type='radio'][name='is_required'][value='"+ attribute.is_required +"']").iCheck('check');
            $("input[type='radio'][name='is_multiselect'][value='"+ attribute.is_multiselect +"']").iCheck('check');

            if (attribute.type == 1){
                $("#div_is_multiselect").hide();
            }else {
                $("#div_is_multiselect").show();
            }
            add_edit_attribute_data.sort = attribute.sort;
            add_edit_attribute_data.description =  attribute.description;
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
                $.ajax({
                    url:"/attribute/deleteRule",
                    data:{id: attribute.id, name:attribute.name},
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
                                    url:"/attribute/delete",
                                    data:{id: attribute.id, name:attribute.name},
                                    type:'POST',
                                    success:function(response){
                                        if(response.status == 200){
                                            swal("Deleted!", "属性:"+ response.content +" 已经被成功删除!", "success");
                                            $(".tree-active").remove();
                                            $(".ul-tree>li>div").first().click();
                                        } else {
                                            swal("警告", response.msg, "error");
                                        }
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
            });
        }
        //添加属性
        function addValue(){
            $("#add_value_button").on('click', function () {
                add_edit_attribute_value_data.title = '新增属性值';
                add_edit_attribute_value_data.id = '';
                add_edit_attribute_value_data.name = '';
                add_edit_attribute_value_data.en_name = '';
                add_edit_attribute_value_data.ar_name = '';
                add_edit_attribute_value_data.es_name = '';
                add_edit_attribute_value_data.fr_name = '';
                /*add_edit_attribute_value_data.it_name = '';
                add_edit_attribute_value_data.ge_name = '';*/
                add_edit_attribute_value_data.standard_value = '';
                add_edit_attribute_value_data.sort = '';
                add_edit_attribute_value_data.description = '';
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
                add_edit_attribute_data.mold = 0;
                add_edit_attribute_data.name = '';
                add_edit_attribute_data.en_name = '';
                add_edit_attribute_data.ar_name = '';
                add_edit_attribute_data.es_name = '';
                add_edit_attribute_data.fr_name = '';
                /*add_edit_attribute_data.it_name = '';
                add_edit_attribute_data.ge_name = '';*/
                add_edit_attribute_data.standard_value = '';
                add_edit_attribute_data.alias = '';
                add_edit_attribute_data.sort = '';
                $("input[type='radio'][name='type'][value='0']").iCheck('check');
                $("input[type='radio'][name='is_required'][value='0']").iCheck('check');
                $("input[type='radio'][name='is_multiselect'][value='0']").iCheck('check');
                add_edit_attribute_data.description = '';
            });

            // $("#edit_attribute_button").on('click', function () {
            //     updateEditFormDefaultInfo(attribute);
            // });
            edit_attribute_button()
            // $(".delete-property").on("click",function(){
            //     $.ajax({
            //         url:"/attribute/deleteRule",
            //         data:{id: attribute.id, name:attribute.name},
            //         type:'POST',
            //         success: function (response) {
            //             if(response.status == 200){
            //                 swal({
            //                     title: "",
            //                     text: response.content,
            //                     type: "warning",
            //                     showCancelButton: true,
            //                     confirmButtonColor: "#444444",
            //                     confirmButtonText: "删除",
            //                     cancelButtonText: "取消",
            //                     closeOnConfirm: false,
            //                     closeOnCancel: true
            //                 },function(){
            //                     $.ajax({
            //                         url:"/attribute/delete",
            //                         data:{id: attribute.id, name:attribute.name},
            //                         type:'POST',
            //                         success:function(response){
            //                             if(response.status == 200){
            //                                 swal("Deleted!", "属性:"+ response.content +" 已经被成功删除!", "success");
            //                                 $(".tree-active").remove();
            //                                 $(".ul-tree>li>div").first().click();
            //                             } else {
            //                                 swal("警告", response.msg, "error");
            //                             }
            //                         }
            //                     })
            //                 });
            //             } else {
            //                 swal("警告", response.msg, "error");
            //             }
            //         },
            //         complete: function () {
            //
            //         },error: function (xmlHttpRequest, textStatus, errorThrown) {
            //             swal("错误", '错误码: '+xmlHttpRequest.status, "error");
            //         }
            //     });
            // });
            deleteProperty()
            // $(".delete-property").on("click",function(){
            //     swal({
            //         title: "",
            //         text: "删除会导致此属性下所有属性值值同步清空，且无法恢复，确认要删除此属性吗？",
            //         type: "warning",
            //         showCancelButton: true,
            //         confirmButtonColor: "#444444",
            //         confirmButtonText: "删除",
            //         cancelButtonText: "取消",
            //         closeOnConfirm: false,
            //         closeOnCancel: true
            //     },function(){
            //         $.ajax({
            //             url:"/attribute/deleteRule",
            //             data:{id: attribute.id, name:attribute.name},
            //             type:'POST',
            //             success: function (response) {
            //                 if(response.status == 200){
            //                     swal({
            //                         title: "",
            //                         text: response.msg,
            //                         type: "warning",
            //                         showCancelButton: true,
            //                         confirmButtonColor: "#444444",
            //                         confirmButtonText: "删除",
            //                         cancelButtonText: "取消",
            //                         closeOnConfirm: false,
            //                         closeOnCancel: true
            //                     },function(){
            //                         $.ajax({
            //                             url:"/attribute/delete",
            //                             data:{id: attribute.id, name:attribute.name},
            //                             type:'POST',
            //                             success:function(response){
            //                                 if(response.status == 200){
            //                                     swal("Deleted!", "属性:"+ response.content +" 已经被成功删除!", "success");
            //                                     $(".tree-active").remove();
            //                                     $(".ul-tree>li>div").first().click();
            //                                 } else {
            //                                     swal("警告", response.msg, "error");
            //                                 }
            //                             }
            //                         })
            //                     });
            //                 } else {
            //                     swal("警告", response.msg, "error");
            //                 }
            //             },
            //             complete: function () {

            //             },error: function (xmlHttpRequest, textStatus, errorThrown) {
            //                 swal("错误", '错误码: '+xmlHttpRequest.status, "error");
            //             }
            //         });

            //     });
            // });

            // $("#add_value_button").on('click', function () {
            //     add_edit_attribute_value_data.title = '新增属性值';
            //     add_edit_attribute_value_data.id = '';
            //     add_edit_attribute_value_data.name = '';
            //     add_edit_attribute_value_data.en_name = '';
            //     add_edit_attribute_value_data.ar_name = '';
            //     add_edit_attribute_value_data.es_name = '';
            //     add_edit_attribute_value_data.fr_name = '';
            //     add_edit_attribute_value_data.standard_value = '';
            //     add_edit_attribute_value_data.sort = '';
            //     add_edit_attribute_value_data.description = '';
            // });
            addValue()
        });

        function deleteAttributeValue(attribute_value_id, attribute_value_name) {
            $.ajax({
                url:"/attribute/deleteValueRule",
                data:{id: attribute_value_id, name:attribute_value_name},
                type:'POST',
                success: function (response) {console.log(response)
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
                                url:"/attribute/delete_value",
                                data:{id: attribute_value_id, name:attribute_value_name},
                                type:'POST',
                                success:function(response){
                                    if(response.status == 200){
                                        swal("Success!", response.msg, "success");
                                        var attribute_values = response.content;
                                        attribute.values = attribute_values;
                                        attributes_values_data.items = attribute.values;
                                    } else {
                                        swal("警告", response.msg, "error");
                                    }
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

        // function deleteAttributeValue(attribute_value_id, attribute_value_name) {
        //     swal({
        //         title: "",
        //         text: "确认要删除此属性值: "+ attribute_value_name +" 吗？",
        //         type: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#444444",
        //         confirmButtonText: "删除",
        //         cancelButtonText: "取消",
        //         closeOnConfirm: false,
        //         closeOnCancel: true
        //     },function(){
        //         $.ajax({
        //             url:"/attribute/delete_value",
        //             data:{id: attribute_value_id, name: attribute_value_name},
        //             type:'POST',
        //             success: function (response) {
        //                 if (response.status == 200) {
        //                     swal("Success!", response.msg, "success");
        //                     var attribute_values = response.content;
        //                     attribute.values = attribute_values;
        //                     attributes_values_data.items = attribute.values;
        //                 }else {
        //                     swal("警告", response.msg, "error");
        //                 }
        //             },
        //             complete: function () {

        //             },error: function (xmlHttpRequest, textStatus, errorThrown) {
        //                 swal("错误", '错误码: '+xmlHttpRequest.status, "error");
        //             }
        //         });
        //     });
        // }


        function editAttributeValue(attribute_value) {
            add_edit_attribute_value_data.title = "{{trans('Attribute::attribute.edit_the_attribute_value')}}";
            add_edit_attribute_value_data.id = attribute_value.id;
            add_edit_attribute_value_data.name = attribute_value.name;
            add_edit_attribute_value_data.en_name = attribute_value.en_name;
            add_edit_attribute_value_data.ar_name = attribute_value.ar_name;
            add_edit_attribute_value_data.es_name = attribute_value.es_name;
            add_edit_attribute_value_data.fr_name = attribute_value.fr_name;
            /*add_edit_attribute_value_data.it_name = attribute_value.it_name;
            add_edit_attribute_value_data.ge_name = attribute_value.ge_name;*/
            add_edit_attribute_value_data.standard_value = attribute_value.standard_value;
            add_edit_attribute_value_data.sort = attribute_value.sort;
            add_edit_attribute_value_data.description = attribute_value.description;
            add_edit_attribute_value_data.attribute_group = attribute_value.attribute_group;
        }

        $(function(){
            $("<ul id='autocomplete' class='dropdown-menu'></ul>").hide().insertAfter("#search-text");
            $("#autocomplete").hide();
        });
        function autocomple(){
            $("#autocomplete").empty();
            $.ajax({
                url:"searchAttribute",
                type:"get",
                data:"name="+$("#search-text").val(),
                dataType:"json",
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
                error:function(textStatus){

                }
            });
        }
    </script>
@endsection