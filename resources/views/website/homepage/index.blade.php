@section('css')
    <style>
        .my-form-control {
            display: inline;
            width: 200px;
        }

        .my-form-control-sm {
            display: inline;
            width: 150px;
        }
    </style>
@endsection
@extends('layouts.default')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                PC首页
                <small>首页</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Layout</a></li>
                <li class="active">Fixed</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel">
                        <div class="panel-body text-center" style="position: relative" id="panel-banner">
                            <div class="" v-if="bannerEditShow" @click="editHide"
                                 style="position: absolute;left:0;right: 0;bottom:0;opacity: 0.6;height: 100%;background-color: #000000;z-index: 9998">
                            </div>
                            <div class="" v-if="bannerEditShow"
                                 style="position: absolute;left: 40px;top:10%;right: 0;bottom: 10%;margin:0 30px 0 -10px;background-color:#FFFFff;z-index: 9999;max-height: 370px;overflow: auto">
                                <form action="" class="form-horizontal" style="padding: 20px;">
                                    <ol class="list-group text-left">
                                        <li class="list-group-item" v-for="(banner,index) in banners">


                                            <label :for="index" style="margin-left:20px;"><img :src="banner.src" alt=""
                                                                                               style="max-height: 50px;"></label>
                                            <input :id="index" style="display:none" type="file"
                                                   class="form-control my-form-control-sm"
                                                   style="display: inline" @change="updateFiles" :data-index="index">

                                            <label for="" style="margin-left:20px;">标题:</label>
                                            <input type="text" class="form-control my-form-control-sm"
                                                   v-model="banner.title">

                                            <label for="" style="margin-left:20px;">链接:</label>
                                            <input type="text" class="form-control my-form-control-sm"
                                                   v-model="banner.link">

                                            <label for="" style="margin-left:20px;">描述:</label>
                                            <input type="text" class="form-control my-form-control-sm"
                                                   v-model="banner.describe">

                                            <label for="" style="margin-left:20px;">排序:</label>
                                            <input type="text" class="form-control my-form-control-sm"
                                                   v-model="banner.sort">

                                            <label for="" style="margin-left:20px;">起止时间:</label>
                                            <input type="text" class="time-range-picker form-control my-form-control-sm"
                                                   v-model="banner.time_duration" @focus="addDatePicker"
                                                   :data-index="index">

                                            <input type="button" class="btn btn-success" :value="banner.btn"
                                                   :data-target-uri="banner.dataTargetUri" :data-index="index"
                                                   @click="createOrUpdateBanner" @change="modifyTime"
                                                   :data-method="banner.method">
                                        </li>
                                        <input type="file" class="form-control my-form-control-sm" @change="addFiles">
                                    </ol>
                                </form>
                            </div>
                            <div @click="editShow">
                                <img src="{{ url('uploads/home/banner.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="panel" id="panel-daily">
                        <div class="panel-heading text-center">
                            <h2 class="h3">每日特价</h2>
                        </div>
                        <div class="panel-body text-center">
                            <div class="col-sm-12" style="padding:2rem 0">
                                @foreach($goods as $good)
                                    <div class="col-sm-2">
                                        <img src="{{ $good->main_pic }}" alt="" style="width: 200px;height: 200px;">
                                        <span>{{ $good->good_title }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <input type="button" class="btn btn-lg btn-success" value="添加商品" @click="addGoods">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="home-card">

                <div class="col-xs-12" v-for="(cardData,index) in cardDatas">
                    <div class="panel">
                        <div class="panel-heading clearfix">
                            <h2 class="col-sm-3 h4 pull-left">@{{ cardData.title }}
                                <input class="form-control my-form-control"
                                       type="text"
                                       v-model="cardData.title">
                                <input @click="modifyTitle"
                                       style="margin-left: 10px;border-radius: 15px;" type="button"
                                       class="btn btn-sm btn-primary"
                                       value="编辑" :data-id="cardData.id" :data-index="index"></h2>
                            <h2 class="col-sm-6 h4 pull-right text-right">@{{ cardData.link }}
                                <input class="form-control my-form-control"
                                       type="text"
                                       v-model="cardData.link">
                                <input @click="modifyLink"
                                       style="margin-left: 10px;border-radius: 15px;" type="button"
                                       class="btn btn-sm btn-primary"
                                       value="编辑" :data-id="cardData.id" :data-index="index"></h2>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-3" style="position: relative">
                                <div v-if="cardData.leftImg.show" class="" @click="showCancel" :data-index="index"
                                     style="position: absolute;left: 20px;opacity: 0.6;width: 100%;height: 100%;background-color: #000000;z-index: 9998"></div>
                                <div v-if="cardData.leftImg.show" class=""
                                     style="position: absolute;left: 40px;top:20%;right: 0;bottom: 20%;background-color:#FFFFff;z-index: 9999">
                                    <form action="" class="form-horizontal col-sm-12" style="padding: 50px;">
                                        <div class="form-group">
                                            <label for="">图片上传</label>
                                            <input type="file" class="form-control" @change="uploadLeftImage"
                                                   :data-index="index">
                                        </div>
                                        <div class="form-group">
                                            <label for="">链接地址</label>
                                            <input type="text" class="form-control" v-model="cardData.leftImg.link">
                                        </div>
                                        <div class="text-center">
                                            <input @click="modifyLeftInfo" type="button" class="btn btn-primary"
                                                   value="确定"
                                                   :data-id="cardData.id">
                                            <input type="button" class="btn btn-primary" @click="showCancel" value="取消"
                                                   :data-index="index">
                                        </div>
                                    </form>
                                </div>
                                <div class="image-wrapper col-sm-12" @click="appendChild" :data-index="index">
                                    <img :src="cardData.leftImg.src" alt=""
                                         style="height: 100%;">
                                </div>
                            </div>
                            <div class="col-sm-6" style="margin-left:3em;">
                                <div v-for="(centerData,innerIndex) in cardData.centerImg">
                                    <div v-if="cardData.centerImg.length === 4" class="image-wrapper col-sm-6">
                                        <div v-if="centerData.show" class="" @click="showCancel"
                                             :data-index="index" :data-index-two="innerIndex"
                                             style="position: absolute;left:15px;right: 55px;opacity: 0.6;height: 100%;background-color: #000000;z-index: 9998"></div>
                                        <div v-if="centerData.show" class=""
                                             style="position: absolute;left: 40px;top:10%;right: 40px;bottom: 10%;margin:0 30px 0 -10px;background-color:#FFFFff;z-index: 9999">
                                            <form action="" class="form-horizontal col-sm-12"
                                                  style="padding: 30px;border-radius: 25px;">
                                                <div class="form-group">
                                                    <label for="">图片上传</label>
                                                    <input type="file" class="form-control" @change="uploadCenterImage"
                                                           :data-index="index"
                                                           :data-inner-index="innerIndex">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">路径地址</label>
                                                    <input type="text" class="form-control" v-model="centerData.link">
                                                </div>
                                                <div class="text-center">
                                                    <input @click="modifyCenterInfo" type="button"
                                                           class="btn btn-primary" value="确定" :data-id="cardData.id"
                                                           :data-inner-index="innerIndex">
                                                    <input type="button" class="btn btn-primary" @click="showCancel"
                                                           value="取消"
                                                           :data-index="index" :data-index-two="innerIndex">
                                                </div>
                                            </form>
                                        </div>
                                        <div @click="appendChild" :data-index="index"
                                             :data-index-two="innerIndex">
                                            <img :src="centerData.src" title="" alt=""
                                                 style="height: 100%">
                                        </div>
                                    </div>
                                    <div v-else class="image-wrapper col-sm-12">
                                        <div v-if="centerData.show" class="" @click="showCancel"
                                             :data-index="index" :data-index-two="innerIndex"
                                             style="position: absolute;left:15px;right: 128px;opacity: 0.6;height: 100%;background-color: #000000;z-index: 9998"></div>
                                        <div v-if="centerData.show" class=""
                                             style="position: absolute;left: 40px;top:10%;right: 115px;bottom: 10%;margin:0 30px 0 -10px;background-color:#FFFFff;z-index: 9999">
                                            <form action="" class="form-horizontal col-sm-12"
                                                  style="padding: 30px;border-radius: 25px;">
                                                <div class="form-group">
                                                    <label for="">图片上传</label>
                                                    <input type="file" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">路径地址</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="text-center">
                                                    <input type="button" class="btn btn-primary" value="确定"
                                                           :data-index="index">
                                                    <input type="button" class="btn btn-primary" @click="showCancel"
                                                           value="取消"
                                                           :data-index="index" :data-index-two="innerIndex">
                                                </div>
                                            </form>
                                        </div>
                                        <div @click="appendChild" :data-index="index"
                                             :data-index-two="innerIndex">
                                            <img :src="centerData.src" title="" alt=""
                                                 style="height: 100%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div v-if="cardData.rightImg.show" class="" @click="showCancel" :data-index="index"
                                     style="position: absolute;left: 30px;right:0;opacity: 0.6;width: 100%;height: 100%;background-color: #000000;z-index: 9998"
                                     data-direction="right"></div>
                                <div v-if="cardData.rightImg.show" class=""
                                     style="position: absolute;left: 60px;top:20%;right: 0;bottom: 20%;background-color:#FFFFff;z-index: 9999">
                                    <form action="" class="form-horizontal col-sm-12" style="padding: 50px;">
                                        <div class="form-group">
                                            <label for="">catagory</label>
                                            <select name="" id="select2" class="form-control my-form-control"
                                                    style="width: 120px;">
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                                <option value="">4</option>
                                            </select>
                                        </div>
                                        <input type="button" class="btn btn-primary" value="确定" :data-index="index">
                                        <input type="button" class="btn btn-primary" @click="showCancel" value="取消"
                                               :data-index="index" data-direction="right">
                                    </form>
                                </div>
                                <div class="image-wrapper col-sm-12" @click="appendChild" data-direction="right"
                                     :data-index="index">
                                    <img :src="cardData.rightImg.src" alt=""
                                         style="height: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script src="{{asset('/assets/js/bower_components/axios/dist/axios.min.js')}}"></script>
    <script src="{{asset('/assets/admin/js/vue.min.js')}}"></script>
    <script>
        var panelBanner = new Vue({
            el: '#panel-banner',
            data: {
                bannerEditShow: false,
                banners: [
                        @foreach($banners as $banner)
                    {
                        id: '{{ $banner->id }}',
                        title: '{{ $banner->title }}',
                        src: '{{ $banner->src }}',
                        link: '{{ $banner->link }}',
                        describe: '{{ $banner->describe }}',
                        sort: '{{ $banner->sort }}',
                        type: '{{ $banner->type }}',
                        time_duration: '{{ $banner->start_at."~".$banner->end_at }}',
                        btn: '修改',
                        dataTargetUri: '{{ secure_route('banners.update',['id'=>$banner->id]) }}',
                        _method: 'put'
                    },
                    @endforeach
                ]
            },
            methods: {
                addFiles: function (event) {
                    let _eventEl = event.currentTarget;
                    let index = _eventEl.getAttribute('data-index');
                    let banner = _eventEl.files[0];
                    let formData = new FormData();
                    let src = '';
                    formData.append('banners', banner);
                    formData.append('dir_name', 'banners');
                    let _that = this;
                    axios.post("{{ secure_route('banners.upload') }}", formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(function (res) {
                        if (res.status === 200) {
                            if (res.data.status === 200) {
                                src = res.data.content;
                                _that.banners.push({
                                    id: '',
                                    title: '',
                                    src: src,
                                    link: '',
                                    describe: '',
                                    sort: '',
                                    type: '1',
                                    time_duration: '',
                                    btn: '添加',
                                    dataTargetUri: '{{ secure_route('banners.store') }}',
                                    _method: 'post'
                                });
                            } else {
                                toastr.error('上传失败');
                            }
                        } else {
                            toastr.error('上传失败');
                        }
                    });
                },
                addDatePicker: function (event) {
                    let dataIndex = event.currentTarget.getAttribute('data-index');
                    let _vueEl = this;
                    var locale = {
                        "format": 'YYYY-MM-DD HH:mm:ss',
                        "separator": "~",
                        "applyLabel": "确定",
                        "cancelLabel": "取消",
                        "fromLabel": "起始时间",
                        "toLabel": "结束时间'",
                        "customRangeLabel": "自定义",
                        "weekLabel": "W",
                        "daysOfWeek": ["日", "一", "二", "三", "四", "五", "六"],
                        "monthNames": ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                        "firstDay": 1,
                    };
                    $('.time-range-picker').daterangepicker({
                        "timePicker": true,
                        "autoApply": true,
                        "timePicker24Hour": true,
                        "autoUpdateInput": false,
                        "opens": 'center',
                        locale: locale,
                        ranges: {
                            '今日': [moment(), moment()],
                            '昨日': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            '最近7日': [moment().subtract(6, 'days'), moment()],
                            '最近30日': [moment().subtract(29, 'days'), moment()],
                            '本月': [moment().startOf('month'), moment().endOf('month')],
                            '上月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        }
                    }, function (start, end, label) {
                        _vueEl.banners[dataIndex].time_duration = start.format('YYYY-MM-DD HH:mm:ss') + '~' + end.format('YYYY-MM-DD HH:mm:ss');
                    });
                    $('.daterangepicker').css('z-index', '10000');
                },
                editShow: function () {
                    this.bannerEditShow = true;
                },
                editHide: function () {
                    this.bannerEditShow = false;
                },
                updateFiles: function (event) {
                    let _eventEl = event.currentTarget;
                    let index = _eventEl.getAttribute('data-index');
                    let banner = _eventEl.files[0];
                    let formData = new FormData();
                    let _that = this;
                    formData.append('banners', banner);
                    formData.append('dir_name', 'banners');

                    axios.post("{{ secure_route('banners.upload') }}", formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(function (res) {
                        if (res.status === 200) {

                            if (res.data.status === 200) {
                                _that.banners[index].src = res.data.content;
                            } else {
                                toastr.error(res.data.msg);
                            }
                        }
                    })
                },
                createOrUpdateBanner: function (event) {
                    let _eventEl = event.currentTarget;
                    let index = _eventEl.getAttribute('data-index');
                    let uri = _eventEl.getAttribute('data-target-uri');
                    let successMsg = '';
                    let errorMsg = '';
                    postData = this.banners[index];
                    console.log(postData);
                    if (postData._method === 'post') {
                        successMsg = '添加成功';
                        errorMsg = '添加失败';
                    } else {
                        successMsg = '修改成功';
                        errorMsg = '修改失败';
                    }
                    axios.post(uri, postData).then(function (res) {
                        if (res.status === 200 && res.data.status === 200) {
                            toastr.success(successMsg);
                        } else {
                            toastr.error(errorMsg);
                        }
                    });
                },
                modifyTime: function (event) {
                    console.log(this.banners);
                }
            }
        });
        var panelDaily = new Vue({
            el: '#panel-daily',
            data: {
                checkedProduct: [
                    @foreach($good_ids as $good_id)
                    {{ $good_id }},
                    @endforeach
                ],
            },
            methods: {
                addGoods: function () {
                    let content =
                        '<div style="padding:20px;" id="product-list">' +
                        '<form action="" class="form-horizontal text-left" id="product-search">\n' +
                        '<div class="col-sm-12">' +
                        '<div class="form-group col-sm-4">' +
                        '                                    <label for="good_title">商品名称：</label>\n' +
                        '                                    <input type="text" name="good_title" id="good_title" v-model="goodTitle" class="form-control my-form-control-sm">\n' +
                        '</div>' +
                        '<div class="form-group col-sm-4">' +
                        '                                    <label for="good_id">商品&emsp;ID：</label>\n' +
                        '                                    <input type="text" name="good_id" id="good_id" v-model="goodId" class="form-control my-form-control-sm">\n' +
                        '</div>' +
                        '<div class="form-group col-sm-4">' +
                        '                                    <label for="good_code">商品货号：</label>\n' +
                        '                                    <input type="text" name="good_code" id="good_code" v-model="goodCode" class="form-control my-form-control-sm">\n' +
                        '</div>' +
                        ' <input type="button" class="btn btn-success" @click="resetSearch" value="重置">' +
                        '</div>' +
                        '<div class="col-sm-12">' +
                        '<div class="form-group col-sm-4">' +
                        '                                    <label for="category_one">一级类目：</label>\n' +

                        '                                    <select @click="showCategoryOne" data-ready="no" v-model="categoryOne" name="category_one" id="category_one" class="form-control my-form-control-sm">\n' +
                        '<option value="">请选择</option>' +
                        '                                        <option :value="categoryItem.id" v-for="categoryItem in categoryItems" >@{{ categoryItem.name }}</option>\n' +
                        '                                    </select>\n' +
                        '</div>' +
                        '<div class="form-group col-sm-4">' +
                        '                                    <label for="category_two">二级类目：</label>\n' +
                        '                                    <select @click="showCategoryTwo" v-model="categoryTwo" name="category_two" id="category_two" class="form-control my-form-control-sm">\n' +
                        '<option value="">请选择</option>' +
                        '                                        <option :value="categoryTwoItem.id" v-for="categoryTwoItem in categoryTwoItems" >@{{ categoryTwoItem.name }}</option>\n' +
                        '                                    </select>\n' +
                        '</div>' +
                        '<div class="form-group col-sm-4">' +
                        '                                    <label for="category_three">三级类目：</label>\n' +
                        '                                    <select @click="showCategoryThree" v-model="categoryThree" name="category_three" id="category_three" class="form-control my-form-control-sm">\n' +
                        '<option value="">请选择</option>' +
                        '                                        <option :value="categoryThreeItem.id" v-for="categoryThreeItem in categoryThreeItems" >@{{ categoryThreeItem.name }}</option>\n' +
                        '                                    </select>\n' +
                        '</div>' +
                        ' <input type="button" class="btn btn-success" @click="search" value="查找">' +
                        '</div>' +
                        '                                </form>\n' +
                        '                                <table class="table table-bordered table-hover" style="text-align: center">\n' +
                        '                                    <thead>\n' +
                        '                                    <tr>\n' +
                        '                                        <th>商品图片</th>\n' +
                        '                                        <th>商品信息</th>\n' +
                        '                                        <th>供货价</th>\n' +
                        '                                        <th>售价</th>\n' +
                        '                                        <th>最近30天销量</th>\n' +
                        '                                        <th>库存数量</th>\n' +
                        '                                    </tr>\n' +
                        '                                    </thead>\n' +
                        '                                    <tbody>\n' +
                        '                                    <tr v-for="product in pageData.data">\n' +
                        '                                        <td><input type="checkbox" name="good_id" :value="product.id" v-model="panelDaily.checkedProduct"><img :src="product.main_pic" alt="" style="width:80px;"></td>\n' +
                        '                                        <td>' +
                        ' <p>ID：@{{ product.id }}</p>\n' +
                        ' <p>名称：@{{ product.good_title }}</p>\n' +
                        ' <p>货号：@{{ product.good_code }}</p>\n' +

                        '</td>\n' +
                        '                                        <td>@{{ product.supply_price }}</td>\n' +
                        '                                        <td>@{{ product.price }}</td>\n' +
                        '                                        <td>@{{ product.orders }}</td>\n' +
                        '                                        <td>@{{ product.good_stock }}</td>\n' +
                        '                                    </tr>\n' +
                        '                                    </tbody>\n' +
                        '                                </table>' +
                        '<ul class="pagination pull-right">\n' +
                        '                                    <li><a @click="redirectPage" :data-target-page="pageData.first_page_url" href="javascript:void(0);">首页</a></li>\n' +
                        '                                    <li><a @click="redirectPage" :data-target-page="pageData.prev_page_url" href="javascript:void(0);">上一页</a></li>\n' +
                        '                                    <li><input v-model="pageData.current_page" type="number" class="form-control"\n' +
                        '                                               style="display: inline;width: 50px;float: left"><a @click="redirectNum"\n' +
                        '                                                href="javascript:void(0);" :data-target-num="pageData.current_page">跳转</a></li>\n' +
                        '                                    <li><a @click="redirectPage" :data-target-page="pageData.next_page_url" href="javascript:void(0);">下一页</a></li>\n' +
                        '                                    <li><a @click="redirectPage" :data-target-page="pageData.last_page_url" href="javascript:void(0);">末页</a></li>\n' +
                        '                                </ul>' +
                        '                                <input type="button" @click="confirmChoice" class="btn btn-primary" value="submit">' +

                        '</div>';
                    layer.open({
                        type: 1,
                        skin: 'layui-layer-demo', //样式类名
                        closeBtn: 1, //不显示关闭按钮
                        title: ['添加商品', 'text-align:center'],
                        area: ['1000px', '600px'],
                        shadeClose: true, //开启遮罩关闭
                        content: content
                    });
                    var productList = new Vue({
                        el: '#product-list',
                        data: {
                            goodId: '',
                            goodTitle: '',
                            goodCode: '',
                            categoryOne: '',
                            categoryItems: [],
                            categoryTwo: '',
                            categoryTwoItems: [],
                            categoryThree: '',
                            categoryThreeItems: [],
                            pageData: {}
                        },
                        created: function () {
                            let uri = '{{ secure_route('product.getall') }}' + '?' + $('#product-search').serialize();
                            this.getData(uri);
                        },
                        mounted: function () {
                        },
                        methods: {
                            show: function () {
                            },
                            search: function (event, aaa) {
                                let uri = '{{ secure_route('product.getall') }}' + '?' + $('#product-search').serialize();
                                this.getData(uri);
                            },
                            getData: function (uri) {
                                let _thisVue = this;
                                axios.get(uri).then(function (res) {
                                    _thisVue.pageData = res.data;
                                });
                            },
                            resetSearch: function () {
                                this.goodId = '';
                                this.goodTitle = '';
                                this.goodCode = '';
                                this.categoryOne = '';
                                this.categoryTwo = '';
                                this.categoryThree = '';
                            },
                            redirectPage: function (event) {
                                let uri = event.currentTarget.getAttribute('data-target-page') + '&' + $('#product-search').serialize();
                                this.getData(uri);
                            },
                            redirectNum: function (event) {
                                let uri = '{{ secure_route('product.getall') }}' + '?page=' + event.currentTarget.getAttribute('data-target-num') + '&' + $('#product-search').serialize();
                                this.getData(uri);
                            },
                            showCategoryOne: function (event) {
                                let _thisEl = event.currentTarget;
                                let dataReady = _thisEl.getAttribute('data-ready');
                                if (dataReady !== 'yes') {
                                    this.getCatagories(0, 1);
                                    _thisEl.setAttribute('data-ready', 'yes');
                                }
                            },
                            showCategoryTwo: function () {
                                if (this.categoryOne !== '') {
                                    this.getCatagories(this.categoryOne, 2);
                                }
                            },
                            showCategoryThree: function () {
                                if (this.categoryTwo !== '') {
                                    this.getCatagories(this.categoryTwo, 3);
                                }
                            },
                            getCatagories: function (category_id, el) {
                                let _thisVue = this;
                                axios.post('{{ secure_route('category.nextLevel') }}', {id: category_id}).then(function (res) {
                                    if (res.data.status === 200) {
                                        switch (el) {
                                            case(1):
                                                _thisVue.categoryItems = res.data.content;
                                                console.log(_thisVue.categoryItems);
                                                break;
                                            case(2):
                                                _thisVue.categoryTwoItems = res.data.content;
                                                break;
                                            case(3):
                                                _thisVue.categoryThreeItems = res.data.content;
                                                break;
                                            default:
                                                _thisVue.categoryItems = res.data.content;
                                                break;
                                        }
                                    }
                                });
                            },
                            confirmChoice: function () {
                                let data = {
                                    index: 5,
                                    left: panelDaily.checkedProduct,
                                };
                                axios.post('{{ secure_route('homepage.updateleftimage') }}' + '/5', data).then(function (res) {
                                    layer.closeAll();
                                });
                            }
                        }
                    });
                }
            }

        });
        var homeCard = new Vue({
            el: '#home-card',
            data: {
                cardDatas: [
                        @foreach($cards as $card)

                    {
                        id: '{{ $card->id }}',
                        title: '{{ $card->title }}',
                        link: '{{ $card->link }}',
                        leftImg: JSON.parse('{!! $card->left_image !!}'),
                        centerImg:
                            [
                                    @php($center_images = json_decode($card->center_image))
                                    @foreach($center_images as $center_image)
                                {
                                    show: false,
                                    src: "{{ $center_image->src }}",
                                    link: "{{ $center_image->link }}",
                                },
                                @endforeach
                            ],
                        rightImg: {
                            src: "{{ url('/uploads/home/home/right.png') }}", link: "https://www.tmall.com", show: false
                        }
                    },
                    @endforeach
                ]
            },
            methods: {
                appendChild: function (event) {
                    let _elIndex = event.currentTarget.getAttribute('data-index');
                    let _elIndexTwo = event.currentTarget.getAttribute('data-index-two');
                    let _elDirection = event.currentTarget.getAttribute('data-direction');
                    if (_elIndexTwo) {
                        this.cardDatas[_elIndex].centerImg[_elIndexTwo].show = true;
                    }
                    else if (_elDirection) {
                        this.cardDatas[_elIndex].rightImg.show = true;
                    } else {
                        this.cardDatas[_elIndex].leftImg.show = true;
                    }

                },
                showCancel: function (event) {
                    let _elIndex = event.currentTarget.getAttribute('data-index');
                    let _elIndexTwo = event.currentTarget.getAttribute('data-index-two');
                    let _elDirection = event.currentTarget.getAttribute('data-direction');
                    if (_elIndexTwo) {
                        this.cardDatas[_elIndex].centerImg[_elIndexTwo].show = false;
                    } else if (_elDirection) {
                        this.cardDatas[_elIndex].rightImg.show = false;
                    } else {
                        this.cardDatas[_elIndex].leftImg.show = false;
                    }
                },
                modifyTitle: function (event) {
                    let _thisEl = event.currentTarget;
                    let elId = _thisEl.getAttribute('data-id');
                    let index = _thisEl.getAttribute('data-index');
                    let data = this.cardDatas[index].title;
                    axios.post('{{ secure_route('homepage.update') }}' + '/' + elId, {
                        title: data
                    }).then(function (res) {
                        if (res.data.status === 200) {
                            toastr.options.timeOut = 0.5;
                            toastr.options.onHidden = function () {

                            };
                            toastr.success('modify 成功');
                        } else {
                            toastr.error(res.data.msg);
                        }
                    });
                },
                modifyLink: function (event) {
                    let _thisEl = event.currentTarget;
                    let elId = _thisEl.getAttribute('data-id');
                    let index = _thisEl.getAttribute('data-index');
                    let data = this.cardDatas[index].link;
                    axios.post('{{ secure_route('homepage.update') }}' + '/' + elId, {
                        link: data
                    }).then(function (res) {
                        if (res.data.status === 200) {
                            toastr.options.timeOut = 0.5;
                            toastr.options.onHidden = function () {

                            };
                            toastr.success('modify 成功');
                        } else {
                            toastr.error(res.data.msg);
                        }
                    });
                },
                modifyLeftInfo: function (event) {
                    let _thisEl = event.currentTarget;
                    let elId = _thisEl.getAttribute('data-id');
                    let _thisVue = this;
                    let leftImg = _thisVue.cardDatas[index].leftImg;
                    leftImg.show = false;
                    axios.post('{{ secure_route('homepage.updateleftimage') }}' + '/' + elId, {
                        left: leftImg
                    }).then(function (res) {
                        if (res.data.status === 200) {
                            toastr.options.timeOut = 0.5;
                            toastr.options.onHidden = function () {

                            };
                            toastr.success('modify 成功');
                        } else {
                            toastr.error(res.data.msg);
                        }
                    });
                },
                modifyCenterInfo: function (event) {
                    let _thisEl = event.currentTarget;
                    let elId = _thisEl.getAttribute('data-id');
                    let elInnerIndex = _thisEl.getAttribute('data-inner-index');
                    let _thisVue = this;
                    axios.post('{{ secure_route('homepage.updatecenterimage') }}' + '/' + elId, {
                        index: elId,
                        center_image: _thisVue.cardDatas[elInnerIndex].centerImg
                    }).then(function (res) {
                        if (res.status === 200) {
                            if (res.data.status === 200) {

                                _that.cardDatas[index].leftImg.src = res.data.content;
                                toastr.success('上传 success');
                            } else {
                                toastr.error('上传失败');
                            }
                        } else {
                            toastr.error('上传失败');
                        }
                    });
                },
                uploadLeftImage: function (event) {
                    let _eventEl = event.currentTarget;
                    let index = _eventEl.getAttribute('data-index');
                    let image = _eventEl.files[0];
                    let formData = new FormData();
                    let src = '';
                    formData.append('banners', image);
                    formData.append('dir_name', 'banners');
                    let _that = this;
                    axios.post("{{ secure_route('banners.upload') }}", formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(function (res) {
                        if (res.status === 200) {
                            if (res.data.status === 200) {

                                _that.cardDatas[index].leftImg.src = res.data.content;
                                toastr.success('上传 success');
                            } else {
                                toastr.error('上传失败');
                            }
                        } else {
                            toastr.error('上传失败');
                        }
                    });
                },
                uploadCenterImage: function (event) {
                    let _eventEl = event.currentTarget;
                    let index = _eventEl.getAttribute('data-index');
                    let innerIndex = _eventEl.getAttribute('data-inner-index');
                    let image = _eventEl.files[0];
                    let formData = new FormData();
                    let src = '';
                    formData.append('banners', image);
                    formData.append('dir_name', 'banners');
                    let _that = this;
                    axios.post("{{ secure_route('banners.upload') }}", formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(function (res) {
                        if (res.status === 200) {
                            if (res.data.status === 200) {
                                _that.cardDatas[index].centerImg[innerIndex].src = res.data.content;
                            } else {
                                toastr.error('上传失败');
                            }
                        } else {
                            toastr.error('上传失败');
                        }
                    });
                }
            }
        });
    </script>
@endsection