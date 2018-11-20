@section('css')
    <style>
        #banner-table > tbody > tr > td, #banner-table > thead > tr > th {
            text-align: center;
            vertical-align: middle;
        }

        .my-form-control {
            display: inline;
            width: 200px;
        }

        .my-form-control-sm {
            display: inline;
            width: 150px;
        }

        .select2-container {
            z-index: 10000;
        }
    </style>
@endsection
@extends('layouts.default')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                H5首页
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
                <div class="col-xs-12">
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
                                                   v-model="banner.title" style="width: 100px;">

                                            <label for="" style="margin-left:20px;"></label>
                                            <select class="form-control my-form-control-sm"
                                                    v-model="banner.currency_code">
                                                <option :value="currency.currency_code" v-for="currency in currencys">
                                                    @{{
                                                    currency.symbol + currency.name }}
                                                </option>
                                            </select>

                                            <label for="" style="margin-left:20px;">链接:</label>
                                            <input type="text" class="form-control my-form-control-sm"
                                                   v-model="banner.link">

                                            <label for="" style="margin-left:20px;">描述:</label>
                                            <input type="text" class="form-control my-form-control-sm"
                                                   v-model="banner.describe">

                                            <label for="" style="margin-left:20px;">排序:</label>
                                            <input type="number" min="0" class="form-control my-form-control-sm"
                                                   v-model="banner.sort" style="width: 60px;">


                                            <label for="" style="margin-left:20px;">起止时间:</label>
                                            <input type="text" class="time-range-picker form-control my-form-control-sm"
                                                   v-model="banner.time_duration" @focus="addDatePicker"
                                                   :data-index="index" data-location="left">

                                            <input type="button" class="btn btn-success" :value="banner.btn"
                                                   :data-target-uri="banner.dataTargetUri" :data-index="index"
                                                   @click="createOrUpdateBanner"
                                                   :data-method="banner.method">
                                            <input type="button" class="btn btn-danger" value="删除" :data-index="index"
                                                   @click="deleteBanner" :data-id="banner.id">
                                        </li>
                                        <input type="file" class="form-control my-form-control-sm" @change="addFiles">
                                    </ol>
                                </form>
                            </div>
                            <div @click="editShow">
                                <img :src="bannerPlaceholder"
                                     alt="">
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-body" id="panel-icon">
                            <template v-for="(icon,index) in icons">
                                <div class="image-wrapper col-sm-3 text-center">
                                    <div v-show="icon.show" class="" @click="showCancel" :data-index="index"
                                         style="position: absolute;left:0;right: 0;opacity: 0.6;height: 100%;background-color: #000000;z-index: 9998"></div>
                                    <div v-show="icon.show" class=""
                                         style="position: absolute;left: 40px;top:2%;right: 40px;bottom: 2%;background-color:#FFFFff;z-index: 9999">
                                        <form action="" class="form-horizontal col-sm-12"
                                              style="padding: 30px;border-radius: 25px;">
                                            <div class="form-group">
                                                <label for="" class="col-sm-4 control-label">标题</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" v-model="icon.title">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-4 control-label">图片上传</label>
                                                <div class="col-sm-8">
                                                    <input type="file" class="form-control" :data-index="index"
                                                           @change="updateFiles">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="col-sm-4 control-label">类目</label>
                                                <div class="col-sm-8">
                                                    <select name="" id="" v-model="icon.category_id"
                                                            class="select2 form-control my-form-control-sm"
                                                            @change="changeCate" :data-index="index">
                                                        <template v-for="category in categorys">
                                                            <option :value="category.id">@{{ category.name }}</option>
                                                        </template>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-4 control-label">起止时间</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control time-range-picker"
                                                           v-model="icon.time_duration"
                                                           @focus="addDatePicker"
                                                           :data-index="index"
                                                           :data-location="icon.direction">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-4 control-label">排序</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" v-model="icon.sort">
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <input type="button"
                                                       class="btn btn-primary" value="确定" :data-id="icon.id"
                                                       @click="formSubmit"
                                                       :data-index="index">
                                                <input type="button" class="btn btn-primary" @click="showCancel"
                                                       value="取消" :data-index="index">
                                            </div>
                                        </form>
                                    </div>
                                    <div @click="appendChild" :data-index="index">
                                        <img :src="icon.src" title="" alt=""
                                             style="height: 300px;">
                                    </div>
                                    <h2 style="margin: 20px;">@{{ icon.title }}</h2>
                                </div>
                            </template>
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
                bannerPlaceholder: 'http://weiweimao-image.oss-ap-south-1.aliyuncs.com/product/000001000218/5bd6fce70a64d.png',
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
                        _method: 'put',
                        currency_code: '{{ $banner->currency_code }}'
                    },
                    @endforeach
                ],
                currencys:{!! $currencys !!}
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
                                    type: '2',
                                    time_duration: '',
                                    btn: '添加',
                                    dataTargetUri: '{{ secure_route('banners.store') }}',
                                    _method: 'post',
                                    currency_code: ''
                                });
                            } else {
                                toastr.error('上传失败');
                            }
                        } else {
                            toastr.error('上传失败');
                        }
                    });
                },
                dateRangePicker: function (elLocate, callback) {
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
                        "opens": elLocate,
                        locale: locale,
                        ranges: {
                            '今日': [moment().format('YYYY-MM-DD 00:00:00'), moment().format('YYYY-MM-DD 23:59:59')],
                            '昨日': [moment().subtract(1, 'days').format('YYYY-MM-DD 00:00:00'), moment().subtract(1, 'days').format('YYYY-MM-DD 23:59:59')],
                            '最近7日': [moment().subtract(6, 'days').format('YYYY-MM-DD 00:00:00'), moment().format('YYYY-MM-DD 23:59:59')],
                            '最近30日': [moment().subtract(29, 'days').format('YYYY-MM-DD 00:00:00'), moment().format('YYYY-MM-DD 23:59:59')],
                            '本月': [moment().startOf('month').format('YYYY-MM-DD 00:00:00'), moment().endOf('month').format('YYYY-MM-DD 23:59:59')],
                            '上月': [moment().subtract(1, 'month').startOf('month').format('YYYY-MM-DD 00:00:00'), moment().subtract(1, 'month').endOf('month').format('YYYY-MM-DD 23:59:59')]
                        }
                    }, function (start, end, label) {
                        callback(start, end, label);
                    });
                    $('.daterangepicker').css('z-index', '10000');

                },
                addDatePicker: function (event) {
                    let _thisEl = event.currentTarget;
                    let dataIndex = _thisEl.getAttribute('data-index');
                    let _elLocate = _thisEl.getAttribute('data-location');
                    let _vueEl = this;
                    this.dateRangePicker(_elLocate, function (start, end, label) {
                        _vueEl.banners[dataIndex].time_duration = start.format('YYYY-MM-DD HH:mm:ss') + '~' + end.format('YYYY-MM-DD HH:mm:ss');
                    });
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
                    let _thisVue = this;
                    postData = this.banners[index];
                    if (this.banners[index].title === '') {
                        toastr.error('标题不能为空');
                        return;
                    }
                    if (this.banners[index].src === '') {
                        toastr.error('图片不能为空');
                        return;
                    }
                    if (this.banners[index].link === '') {
                        toastr.error('链接不能为空');
                        return;
                    }
                    if (this.banners[index].sort === '') {
                        toastr.error('排序不能为空');
                        return;
                    }
                    if (this.banners[index].time_duration === '') {
                        toastr.error('时间不能为空');
                        return;
                    }
                    if (postData._method === 'post') {
                        successMsg = '添加成功';
                        errorMsg = '添加失败';
                    } else {
                        successMsg = '修改成功';
                        errorMsg = '修改失败';
                    }
                    axios.post(uri, postData).then(function (res) {
                        if (res.status === 200 && res.data.status === 200) {
                            if (postData._method === 'post') {
                                _thisVue.banners[index].id = res.data.content.id;
                                _thisVue.banners[index].btn = '修改';
                            }
                            toastr.success(successMsg);
                        } else {
                            toastr.error(errorMsg);
                        }
                    });
                },
                deleteBanner: function (event) {
                    let _eventEl = event.currentTarget;
                    let index = _eventEl.getAttribute('data-index');
                    let id = _eventEl.getAttribute('data-id');

                    if (!id) {
                        panelBanner.banners.splice(index, 1);
                        toastr.success('删除成功');
                        return;
                    }

                    axios.delete('{{ secure_route('banners.destroy',['id'=>1]) }}'.replace(1, id)).then(function (res) {
                        if (res.status === 200 && res.data.status === 200) {
                            panelBanner.banners.splice(index, 1);
                            toastr.success('删除成功');
                        } else {
                            toastr.error('删除失败');
                        }
                    });
                }
            }
        });
        var panelIcon = new Vue({
            el: '#panel-icon',
            data: {
                icons: [
                        @foreach($icons as $key=>$icon)
                    {
                        id: '{{ $icon->id }}',
                        show: false,
                        title: '{{ $icon->title }}',
                        src: '{{ $icon->src }}',
                        category_id: '{{ $icon->category_id }}',
                        time_duration: '{{ $icon->start_at.'~'.$icon->end_at }}',
                        sort: '{{ $icon->sort }}',
                        @if(($key+1)%4==0)
                        direction: 'right',
                        @else
                        direction: 'center',
                        @endif
                    },
                    @endforeach
                ],
                categorys:{!! json_encode($categorys) !!}
            },
            methods: {
                appendChild: function (event) {
                    let _elIndex = event.currentTarget.getAttribute('data-index');
                    this.icons[_elIndex].show = true;
                },
                showCancel: function (event) {
                    let _elIndex = event.currentTarget.getAttribute('data-index');
                    this.icons[_elIndex].show = false;
                },
                updateFiles: function (event) {
                    let _eventEl = event.currentTarget;
                    let index = _eventEl.getAttribute('data-index');
                    let banner = _eventEl.files[0];
                    let formData = new FormData();
                    let _that = this;
                    formData.append('icons', banner);
                    formData.append('dir_name', 'icons');

                    axios.post("{{ secure_route('banners.upload') }}", formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(function (res) {
                        if (res.status === 200) {

                            if (res.data.status === 200) {
                                _that.icons[index].src = res.data.content;
                            } else {
                                toastr.error(res.data.msg);
                            }
                        }
                    })
                },
                addDatePicker: function (event) {
                    let _thisEl = event.currentTarget;
                    let dataIndex = _thisEl.getAttribute('data-index');
                    let _elLocate = _thisEl.getAttribute('data-location');
                    let _vueEl = this;
                    panelBanner.dateRangePicker(_elLocate, function (start, end, label) {
                        _vueEl.icons[dataIndex].time_duration = start.format('YYYY-MM-DD HH:mm:ss') + '~' + end.format('YYYY-MM-DD HH:mm:ss');
                    });
                },
                changeCate: function (event) {
                    console.log(_thisEl.value);
                    return;
                    let _thisEl = event.currentTarget;
                    let index = _thisEl.getAttribute('data-index');
                    this.icons[index].category_id = _thisEl.value;
                },
                formSubmit: function (event) {
                    let that = this;
                    let bannerModify = $('#banner-modify');
                    let postUri;
                    let errorMsg;
                    let successMsg;
                    let requestMethod;
                    let _thisEl = event.currentTarget;
                    let index = _thisEl.getAttribute('data-index');
                    let id = _thisEl.getAttribute('data-id');
                    if (id !== '') {
                        postUri = "{{ secure_route('icons.update',['id'=>1]) }}".replace(1, id);
                        errorMsg = '修改失败';
                        successMsg = '修改成功';
                        requestMethod = 'put';
                    } else {
                        postUri = "{{ secure_route('icons.store') }}";
                        errorMsg = '添加失败';
                        successMsg = '添加成功';
                        requestMethod = 'post';
                    }
                    let postData = this.icons[index];
                    postData._method = requestMethod;
                    console.log(this.icons[index]);
                    bannerModify.attr('disable', true);
                    bannerModify.html('保存中');
                    axios.post(postUri, postData).then(function (res) {
                        if (res.status === 200 && res.data.status === 200) {
                            toastr.success(successMsg);
                        } else {
                            bannerModify.attr('disable', false);
                            bannerModify.html('保存');
                            toastr.error(errorMsg);
                        }
                    });
                }
            }
        });
        $('.select2').on('change', function () {
            let index = $(this).attr('data-index');
            panelIcon.icons[index].category_id = $(this).val();
        })
    </script>
@endsection