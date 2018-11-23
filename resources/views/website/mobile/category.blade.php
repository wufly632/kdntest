@section('css')
    <style>
        #banner-table > tbody > tr > td, #banner-table > thead > tr > th {
            text-align: center;
            vertical-align: middle;
        }

        .list-group-unbordered > .list-group-item {
            border-bottom: 0;
            border-top: 0;
        }

        .my-form-contrl {
            display: inline;
            width: 140px;
        }

        .btn-mine {
            width: 8em;
            padding: 2px 0;
        }

        .pt-1 {
            padding-top: 7px;
        }

        .reduce-btn {
            font-size: 24px;
            color: red;
            cursor: pointer
        }

        .plus-btn {
            font-size: 24px;
            margin-left: 10px;
            cursor: pointer
        }
    </style>
@endsection
@extends('layouts.default')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                网站设置
                <small>H5分类</small>
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
                <div class="col-xs-12" id="accordion">
                    <button class="btn btn-mine btn-primary" @click="add" style="margin-bottom: 10px;">添加栏目</button>
                    <div class="box-group">
                        <template v-for="(item,index) in items">
                            <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="col-sm-2">
                                        <label for="" class="pt-1 col-sm-4">名称:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control my-form-contrl" v-model="item.name">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="" class="pt-1 col-sm-4">icon:</label>
                                        <input type="text" class="form-control my-form-contrl"
                                               placeholder="请输入ICON图标库图标编码" v-model="item.icon">
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="" class="pt-1 col-sm-4">排序:</label>
                                        <input type="text" class="form-control my-form-contrl" v-model="item.sort">
                                    </div>
                                    <a class="btn btn-sm btn-primary pull-right" @click="showChild(index)">
                                        <span class="fa fa-angle-double-up" v-if="item.show"></span>
                                        <span class="fa fa-angle-double-down" v-else></span>
                                    </a>
                                </div>
                                <template v-if="item.show">
                                    <div class="box-body">
                                        <ul class="list-group list-group-unbordered">
                                            <template v-for="(child,childIndex) in item.child">
                                                <li class="list-group-item clearfix">
                                                    <div class="col-sm-2 col-sm-offset-1">
                                                        <label class="col-sm-4 pt-1" for="">名称</label>
                                                        <div class="col-sm-8">
                                                            <input type="text"
                                                                   class="form-control my-form-contrl"
                                                                   v-model="child.name">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class="col-sm-4 pt-1" for="">icon</label>
                                                        <div class="col-sm-8">
                                                            <input type="file" class="form-control my-form-contrl"
                                                                   @change="uploadImg(event, index, childIndex)">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class="col-sm-4 pt-1" for="">分类ID</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control my-form-contrl"
                                                                   v-model="child.category_id">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class="col-sm-4 pt-1" for="">排序</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control my-form-contrl"
                                                                   v-model="child.sort">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <span class="fa fa-minus-circle reduce-btn pt-1"
                                                              @click="removeChild(index, childIndex, child.id)"></span>

                                                    </div>
                                                </li>

                                            </template>
                                        </ul>
                                        <div class="col-sm-offset-1">
                                            <button class="btn btn-mine btn-primary" @click="save(index)">保存</button>
                                            <button class="btn btn-mine btn-primary" @click="deleteItem(item.id,index)">
                                                删除本条
                                            </button>
                                            <button class="btn btn-mine btn-primary" @click="addChild(index)">新建
                                            </button>
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
    <script>
        var accordion = new Vue({
            el: '#accordion',
            data: {
                items: {!! json_encode($categorys) !!}
            },
            methods: {
                add: function () {
                    this.items.unshift({
                        category_id: 0,
                        child: [],
                        removed: [],
                        icon: '',
                        id: '',
                        image: '',
                        name: '',
                        parent_id: 0,
                        show: false,
                        sort: 1
                    });
                },
                showChild: function (index) {
                    this.items[index].show = !this.items[index].show;
                },
                addChild: function (index) {
                    this.items[index].child.push({
                        category_id: '',
                        icon: '',
                        id: '',
                        image: '',
                        name: '',
                        parent_id: '',
                        sort: '',
                    });
                },
                uploadImg: function (event, index, innerIndex) {
                    let _eventEl = event.currentTarget;
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
                                _that.items[index].child[innerIndex].image = src;
                                toastr.success('上传成功');
                            } else {
                                toastr.error('上传失败');
                            }
                        } else {
                            toastr.error('上传失败');
                        }
                    });
                },
                removeChild: function (index, childIndex, id) {

                    if (id !== '') {
                        this.items[index].removed.push(id);
                    }
                    this.items[index].child.splice(childIndex, 1);
                    console.log(this.items[index].removed);
                },
                save: function (index) {
                    let _thisVue = this;
                    axios.post('{{ secure_route("mobile.categorys.store") }}', {item: this.items[index]}).then(function (res) {
                        if (res.data.status === 200) {
                            _thisVue.items[index] = res.data.content;
                            toastr.success('保存成功');
                        } else {
                            toastr.error('保存失败');
                        }
                    });
                },
                deleteItem: function (id, index) {
                    let _thisVue = this;
                    console.log(id);
                    layer.confirm('确定删除', {
                        btn: ['删除', '取消'] //按钮
                    }, function () {
                        axios.delete('{{ secure_route("mobile.categorys.delete",['id'=>1]) }}'.replace(1, id)).then(function (res) {
                            if (res.status === 200) {
                                _thisVue.items.splice(index, 1);
                                layer.closeAll();
                                toastr.success('删除成功');
                            } else {
                                toastr.error('删除失败');
                            }
                        }).catch(function (error) {
                            toastr.error('删除失败');
                        });
                    }, function () {

                    })
                }
            }
        })
    </script>
@endsection