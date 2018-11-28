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
                                                   @change="updateFiles" :data-index="index">

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
                                     alt="" style="width: 100%;max-width: 1440px;min-height: 300px;min-width: 1440px;">
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-body" id="panel-icon" style="position: relative;height: 400px;">
                            <div v-if="show" class="" @click="showCancel"
                                 style="position: absolute;left:0;right: 0;opacity: 0.6;height: 100%;background-color: #000000;z-index: 9998"></div>
                            <div v-if="show" class=""
                                 style="position: absolute;left: 40px;top:2%;right: 40px;bottom: 2%;background-color:#FFFFff;z-index: 9999;overflow-y: scroll">


                                <form action="" class="form-horizontal"
                                      style="padding: 30px;border-radius: 25px;">
                                    <ol class="list-group">
                                        <template v-for="(icon,index) in icons">
                                            <li class="list-group-item">
                                                <label :for="'src'+index"><img :src="icon.src" alt=""
                                                                               style="max-height: 50px;"></label>
                                                <input :id="'src'+index" type="file"
                                                       class="form-control my-form-control-sm"
                                                       @change="updateFiles($event,index)" style="display: none">
                                                <label for="">标题</label>
                                                <input type="text" class="form-control my-form-control-sm"
                                                       v-model="icon.title">
                                                <label for="">类目</label>
                                                <select name="" :id="'myselect'+index" v-model="icon.category_id"
                                                        class="myselect2 form-control my-form-control-sm"
                                                        :data-index="index" @mouseover="registSelect2">
                                                    <template v-for="category in categorys">
                                                        <option :value="category.id">@{{ category.name }}
                                                        </option>
                                                    </template>
                                                </select>
                                                <label for="">起止时间</label>
                                                <input type="text"
                                                       class="form-control my-form-control-sm time-range-picker"
                                                       v-model="icon.time_duration"
                                                       @focus="addDatePicker"
                                                       :data-index="index"
                                                       :data-location="icon.direction">
                                                <label for="">排序</label>
                                                <input type="number" class="form-control my-form-control-sm"
                                                       v-model="icon.sort">
                                                <input type="button"
                                                       class="btn btn-success" :value="icon.btn"
                                                       @click="iconModify(index,icon.id)"
                                                       :data-index="index">
                                                <input type="button" class="btn btn-danger"
                                                       @click="iconDelete(index,icon.id)"
                                                       value="删除">
                                            </li>
                                        </template>
                                        <input type="file" class="form-control my-form-control-sm"
                                               @change="updateFiles($event)">
                                    </ol>
                                </form>
                            </div>
                            <div @click="appendChild">
                                <img :src="iconPlaceholder" title="" alt="" style="width: 100%">
                            </div>

                        </div>
                    </div>
                    <div id="fash-sale">
                        <template v-for="(item,index) in anything">
                            <div class="panel" id="">
                                <template v-if="item.type===3">
                                    <div class="panel-body" style="position: relative">
                                        <template v-for="(detail,innerIndex) in item.content">
                                            <div class="col-sm-4" v-if="innerIndex===0">
                                                <div>
                                                    <template v-if="detail.show">
                                                        <div @click="shadowHidden(index,innerIndex)"
                                                             style="position: absolute;top: 0;left:0;right: 0;bottom:0;opacity: 0.6;height: 100%;background-color: #000000;z-index: 9998">
                                                        </div>
                                                        <div style="position: absolute;left: 40px;top:10%;right: 0;bottom: 10%;margin:0 30px 0 -10px;background-color:#FFFFff;z-index: 9999;max-height: 370px;overflow: auto">
                                                            <form action="" class="form-horizontal"
                                                                  style="padding: 20px;">
                                                                <div class="form-group">
                                                                    <label class="col-sm-2 control-label"
                                                                           for="">图片:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="file" class="form-control"
                                                                               @change="updateFiles($event,index,innerIndex)">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-sm-2"
                                                                           for="">标题:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control"
                                                                               v-model="detail.title">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-sm-2"
                                                                           for="">链接:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control"
                                                                               v-model="detail.link">
                                                                    </div>
                                                                </div>
                                                                <div class="text-center">
                                                                    <input type="button" class="btn btn-success"
                                                                           value="保存"
                                                                           @click="confirmBtn($event,index,item.id,innerIndex)">
                                                                    <input type="button" class="btn btn-danger"
                                                                           value="取消"
                                                                           @click="shadowHidden(index,innerIndex)">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </template>
                                                    <div>
                                                        <img :src="detail.src"
                                                             alt=""
                                                             style="width: 100%;height: 600px;min-width: 300px;min-height: 300px;"
                                                             @click="showBannerEdit(index,innerIndex)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-8" v-else>
                                                <div style="position: relative">
                                                    <template v-if="detail.show">
                                                        <div @click="shadowHidden(index,innerIndex)"
                                                             style="position: absolute;top: 0;left:0;right: 0;bottom:0;opacity: 0.6;height: 100%;background-color: #000000;z-index: 9998">
                                                        </div>
                                                        <div style="position: absolute;left: 40px;top:10%;right: 0;bottom: 10%;margin:0 30px 0 -10px;background-color:#FFFFff;z-index: 9999;max-height: 370px;overflow: auto">
                                                            <form action="" class="form-horizontal">
                                                                <div class="form-group" style="margin:15px 0;">
                                                                    <label class="col-sm-2 control-label"
                                                                           for="">图片:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="file" class="form-control"
                                                                               @change="updateFiles($event,index,innerIndex)">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" style="margin:15px 0;">
                                                                    <label class="col-sm-2 control-label"
                                                                           for="">标题:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control"
                                                                               v-model="detail.title">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" style="margin:15px 0;">
                                                                    <label class="col-sm-2 control-label"
                                                                           for="">链接:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control"
                                                                               v-model="detail.link">
                                                                    </div>
                                                                </div>
                                                                <div class="text-center">
                                                                    <input type="button" class="btn btn-success"
                                                                           value="保存"
                                                                           @click="confirmBtn($event,index,item.id,innerIndex)">
                                                                    <input type="button" class="btn btn-danger"
                                                                           value="取消"
                                                                           @click="shadowHidden(index,innerIndex)">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </template>
                                                    <div>
                                                        <img :src="detail.src"
                                                             alt=""
                                                             style="width: 100%;height: 300px;min-height: 300px;min-width: 300px;"
                                                             @click="showBannerEdit(index,innerIndex)">
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                <template v-else-if="item.type===1">
                                    <div class="panel-body" style="position: relative">
                                        <div class="">
                                            <div>
                                                <template v-for="(detail,innerIndex) in item.content">
                                                    <template v-if="detail.show">
                                                        <div @click="shadowHidden(index,innerIndex)"
                                                             style="position: absolute;top: 0;left:0;right: 0;bottom:0;opacity: 0.6;height: 100%;background-color: #000000;z-index: 9998">
                                                        </div>
                                                        <div style="position: absolute;left: 40px;top:10%;right: 0;bottom: 10%;margin:0 30px 0 -10px;background-color:#FFFFff;z-index: 9999;max-height: 370px;overflow: auto">
                                                            <form action="" class="form-horizontal"
                                                                  style="margin-top: 50px;">
                                                                <div class="form-group" style="margin:15px 0;">
                                                                    <label class="col-sm-2 control-label"
                                                                           for="">图片:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="file" class="form-control"
                                                                               @change="updateFiles($event,index,innerIndex)">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" style="margin:15px 0;">
                                                                    <label class="control-label col-sm-2"
                                                                           for="">标题:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control"
                                                                               v-model="detail.title">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" style="margin:15px 0;">
                                                                    <label class="control-label col-sm-2"
                                                                           for="">链接:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control"
                                                                               v-model="detail.link">
                                                                    </div>
                                                                </div>
                                                                <div class="text-center">
                                                                    <input type="button" class="btn btn-success"
                                                                           value="保存"
                                                                           @click="confirmBtn($event,index,item.id,innerIndex)">
                                                                    <input type="button" class="btn btn-danger"
                                                                           value="取消"
                                                                           @click="shadowHidden(index,innerIndex)">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </template>
                                                    <div>
                                                        <img :src="detail.src"
                                                             alt=""
                                                             style="width: 100%;height: 600px;min-height: 300px;min-width: 800px;"
                                                             @click="showBannerEdit(index,innerIndex)">
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script src="{{asset('/assets/js/bower_components/axios/dist/axios.min.js')}}"></script>
    <script src="{{asset('/assets/admin/js/vue.min.js')}}"></script>
    <script type="text/x-template" id="form-block">
        <div>
            <label for="" style="margin-left:20px;">@{{ anything }}标题:</label>
            <input type="text" class="form-control my-form-control-sm"
                   style="width: 100px;" v-model="anything.title">
            <label for="" style="margin-left:20px;">链接:</label>
            <input type="text" class="form-control my-form-control-sm">
        </div>
    </script>
    <script>
        var panelBanner = new Vue({
            el: '#panel-banner',
            data: {
                bannerPlaceholder: "{{ url('images/bannerplaceholder.png') }}",
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
                show: false,
                iconPlaceholder: '{{ url('/images/iconplaceholder.png') }}',
                icons: [
                        @foreach($icons as $key=>$icon)
                    {
                        id: '{{ $icon->id }}',
                        title: '{{ $icon->title }}',
                        src: '{{ $icon->src }}',
                        category_id: '{{ $icon->category_id }}',
                        time_duration: '{{ $icon->start_at.'~'.$icon->end_at }}',
                        sort: '{{ $icon->sort }}',
                        direction: 'center',
                        btn: '修改',
                    },
                    @endforeach
                ],
                categorys:{!! json_encode($categorys) !!}
            },
            methods: {
                appendChild: function () {
                    this.show = true;
                },
                showCancel: function () {
                    this.show = false;
                },
                updateFiles: function (event, index) {
                    let _eventEl = event.currentTarget;
                    let banner = _eventEl.files[0];
                    let formData = new FormData();
                    let _that = this;
                    formData.append('icons', banner);
                    formData.append('dir_name', 'icons');

                    axios.post("{{ secure_route('banners.upload') }}", formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(function (res) {
                        if (res.status === 200) {

                            if (res.data.status === 200) {
                                if (index !== undefined) {
                                    _that.icons[index].src = res.data.content;
                                } else {
                                    _that.icons.push({
                                        id: '',
                                        title: '',
                                        src: res.data.content,
                                        category_id: '',
                                        time_duration: '',
                                        sort: 1,
                                        direction: 'center',
                                        btn: '增加',
                                    })
                                }
                            } else {
                                toastr.error(res.data.msg);
                            }
                        }
                    })
                },
                iconModify: function (index, id) {
                    let _thisVue = this;
                    if (id !== '') {
                        axios.put("{{ secure_route('iconsmanage.update',['id'=>1]) }}".replace(1, id), this.icons[index]).then(function (res) {
                            if (res.data.status === 200) {
                                toastr.success('修改成功');
                            } else {
                                toastr.error('修改失败');
                            }
                        });
                    } else {
                        axios.post("{{ secure_route('iconsmanage.store') }}", this.icons[index]).then(function (res) {
                            if (res.data.status === 200) {
                                toastr.success('添加成功');
                                _thisVue.icons[index].id = res.data.content;
                                _thisVue.icons[index].btn = '修改';
                            } else {
                                toastr.error('添加失败');
                            }
                        })
                    }
                },
                iconDelete: function (index, id) {
                    let _this = this;
                    if (id === '') {
                        this.icons.splice(index, 1);
                        toastr.success('删除成功');
                    } else {
                        axios.delete("{{ secure_route('iconsmanage.destroy',['id'=>1]) }}".replace(1, id)).then(function (res) {
                            if (res.status === 200) {
                                _this.icons.splice(index, 1);
                                toastr.success('删除成功');
                            } else {
                                toastr.success('删除失败');
                            }
                        }).catch(function (error) {
                            toastr.success('删除失败');
                        });
                    }
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
                registSelect2: function (event) {
                    $(event.currentTarget).select2();
                    $('#panel-icon .myselect2').on('change', function () {
                        let index = $(this).attr('data-index');
                        panelIcon.icons[index].category_id = $(this).val();
                    });
                }
            }
        });

        var fashSale = new Vue({
            el: '#fash-sale',
            data: {
                bannerEditShow: false,
                bannerPlaceholder: 'https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png',
                anything: {!! $mobileCards !!}
            },
            created: function () {
                if (this.anything.length !== 3) {
                    let defult_anything = [
                        {
                            id: '',
                            type: 3,
                            content:
                                [
                                    {
                                        "src": "{{ url('images/activity1.png') }}",
                                        "link": "http:\/\/www.waiwaimall.com",
                                        "show": false,
                                        "title": "waiwaimall"
                                    },
                                    {
                                        "src": "{{ url('images/activity2.png') }}",
                                        "link": "http:\/\/www.waiwaimall.com",
                                        "show": false,
                                        "title": "waiwaimall"
                                    },
                                    {
                                        "src": "{{ url('images/activity3.png') }}",
                                        "link": "http:\/\/www.waiwaimall.com",
                                        "show": false,
                                        "title": "waiwaimall"
                                    }
                                ]
                        },
                        {
                            id: '',
                            type: 1,
                            content:
                                [
                                    {
                                        "src": "{{ url('images/activity4.png') }}",
                                        "link": "http:\/\/www.waiwaimall.com",
                                        "show": false,
                                        "title": "waiwaimall"
                                    }
                                ]
                        }
                        ,
                        {
                            id: '',
                            type: 1,
                            content:
                                [
                                    {
                                        "src": "{{ url('images/activity4.png') }}",
                                        "link": "http:\/\/www.waiwaimall.com",
                                        "show": false,
                                        "title": "waiwaimall"
                                    }
                                ]

                        }

                    ];
                    if (this.anything.length === 1) {
                        this.anything.push(defult_anything[1]);
                        this.anything.push(defult_anything[2]);
                    } else if (this.anything.length === 2) {
                        this.anything.push(defult_anything[2]);
                    } else if (this.anything.length === 0) {
                        this.anything.push(defult_anything[1]);
                        this.anything.push(defult_anything[2]);
                        this.anything.push(defult_anything[3]);
                    }else{
                        
                    }
                }
                this.anything.forEach(function (item, index) {
                    item.content.forEach(function (rightItem, rightIndex) {
                        rightItem.show = false;
                    })
                });
            },
            methods: {
                showBannerEdit: function (index, innerIndex) {
                    this.anything[index].content[innerIndex].show = true;

                },
                shadowHidden: function (index, innerIndex) {
                    this.anything[index].content[innerIndex].show = false;

                },
                updateFiles: function (event, index, innerIndex) {
                    let _eventEl = event.currentTarget;
                    let banner = _eventEl.files[0];
                    let formData = new FormData();
                    let _that = this;
                    formData.append('banners', banner);
                    formData.append('dir_name', 'banners');
                    axios.post("{{ secure_route('banners.upload') }}", formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(function (res) {
                        if (res.status === 200) {
                            if (res.data.status === 200) {
                                _that.anything[index].content[innerIndex].src = res.data.content;
                            } else {
                                toastr.error(res.data.msg);
                            }
                        }
                    })
                },
                confirmBtn: function (event, index, id, innerIndex) {
                    data = {type: this.anything[index].type, content: this.anything[index].content};

                    let _thisVue = this;
                    let uri = '';
                    if (this.anything[index].id !== '') {
                        uri = "{{ secure_route('mobile.homecard.update',['id'=>1]) }}".replace(1, id);
                        data._method = 'put';
                    } else {
                        uri = "{{ secure_route('mobile.homecard.store') }}";
                    }
                    axios.post(uri, data).then(function (res) {
                        if (res.data.status === 200) {
                            _thisVue.anything[index].content[innerIndex].show = false;
                            toastr.success('保存成功');
                        } else {
                            toastr.error(res.data.msg);
                        }
                    });
                }
            }
        })
    </script>
@endsection