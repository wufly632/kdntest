@section('css')
    <style>
        #banner-table > tbody > tr > td, #banner-table > thead > tr > th {
            text-align: center;
            vertical-align: middle;
        }
    </style>
@endsection
@extends('layouts.default')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                banner列表
                <small>banner</small>
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
                    <div class="box box-info">
                        <div class="box-header" style="padding: 20px 10px;" id="search-box">
                            <form action="{{ secure_route('banners.index') }}" class="form-horizontal">
                                <div class="form-group col-sm-3">
                                    <label for="title" class="control-label col-sm-2">标题</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="col-sm-3 form-control" name="title" id="title">
                                    </div>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="type" class="control-label col-sm-4">类型</label>
                                    <div class="col-sm-8">
                                        <select name="type" v-model="type" id="type" class="form-control">
                                            <option value="1">PC</option>
                                            <option value="2">移动设备</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="daterange" class="control-label col-sm-4">起止时间</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control time_duration" id="daterange"
                                               name="daterange">
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <input type="submit" class="btn-sm btn-info" value="查找">
                                </div>
                                <div class="col-sm-1">
                                    <input type="button" class="btn-sm btn-primary" value="创建" @click="createBanner">
                                </div>
                            </form>
                        </div>
                        <hr>
                        <div class="box-body">
                            <table class="table table-bordered table-hover table-striped" id="banner-table">
                                <thead>
                                <tr>
                                    <th>标题 <span class="fa fa-unsorted pull-right"></span></th>
                                    <th>图片<span class="fa fa-unsorted pull-right"></span></th>
                                    <th>描述<span class="fa fa-unsorted pull-right"></span></th>
                                    <th>类型<span class="fa fa-unsorted pull-right"></span></th>
                                    <th>货币<span class="fa fa-unsorted pull-right"></span></th>
                                    <th>开始时间<span class="fa fa-unsorted pull-right"></span></th>
                                    <th>结束时间<span class="fa fa-unsorted pull-right"></span></th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="banner in banners">
                                    <td>@{{ banner.title }}</td>
                                    <td><img v-lazy="banner.src" :alt="banner.title"
                                             :title="banner.title" width="150px;">
                                    </td>
                                    <td>@{{ banner.describe }}</td>
                                    <td>@{{ banner.type==1 ? 'PC':'移动设备' }}
                                    </td>
                                    <td>@{{ banner.currency_code }}</td>
                                    <td>
                                        @{{ banner.start_at }}
                                    </td>
                                    <td>
                                        @{{ banner.end_at }}
                                    </td>
                                    <td>
                                        <div class="btn-group-sm">
                                            <button class="btn btn-warning order-modify"
                                                    :data-id="banner.id" @click="modifyBanner">
                                                修改
                                            </button>
                                            <button class="btn btn-danger order-delete banner-delete"
                                                    :data-id="banner.id">
                                                删除
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="pull-right">
                                {{ $banners->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script src="{{ asset('/assets/js/bower_components/axios/dist/axios.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/vue.min.js') }}"></script>
    <script src="https://unpkg.com/vue-lazyload/vue-lazyload.js"></script>
    <script>
        Vue.use(VueLazyload);
        var searchBox = new Vue({
            el: '#search-box',
            data: {
                type: '{{ old('type') }}'
            },
            methods: {
                createBanner: function () {
                    showInfo('banner创建', "{{ secure_route('banners.create') }}", "800px;",'600px')
                }
            }
        });
        var bannerTable = new Vue({
            el: '#banner-table',
            data: {
                banners: JSON.parse('{!! json_encode($banners) !!}').data,
            },
            methods: {
                modifyBanner: function (event) {
                    let _thisEl = event.currentTarget;
                    showInfo('banner修改', "{{ secure_route('banners.edit',['id'=>1]) }}".replace(1, _thisEl.getAttribute('data-id')), "800px",'600px')
                }
            }
        });
        $('.banner-delete').click(function () {
            let _clickEle = $(this);
            layer.confirm('确定删除', {
                btn: ['删除', '取消'] //按钮
            }, function () {
                axios.delete(_clickEle.attr('data-target-uri')).then(function (res) {
                    if (res.status === 200) {
                        toastr.options.timeOut = 0.5;
                        toastr.options.onHidden = function () {
                            location.reload();
                        };
                        layer.closeAll();
                        toastr.success('删除成功');
                    } else {
                        toastr.success('删除失败');
                    }
                }).catch(function (error) {
                    toastr.success('删除失败');
                });
            }, function () {

            })
        });
    </script>
@endsection