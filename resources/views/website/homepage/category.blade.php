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
            margin: 20px 0;
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

        .del-btn {
            color: #000;
            background-color: #EEEEEE;
            border: 1px solid #aaa;
        }

        .mine-border-left {
            border-left: 5px solid #3c8dbc;
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
                <small>PC分类</small>
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
                    <div class="box box-primary">
                        <div class="box-body">
                            <button class="btn btn-mine btn-primary" @click="add">添加栏目
                            </button>
                            <div class="box-group">
                                <template v-for="(item,index) in items">
                                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                    <div class="box" style="border-top: 1px solid #EEEEEE;margin-bottom: 0">
                                        <div class="box-header with-border mine-border-left">
                                            <div class="col-sm-2">
                                                <label for="" class="pt-1 col-sm-4">名称:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control my-form-contrl"
                                                           v-model="item.name">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <label for="" class="pt-1 col-sm-4">分类ID:</label>
                                                <input type="text" class="form-control my-form-contrl"
                                                       v-model="item.category_id">
                                            </div>
                                            <div class="col-sm-2">
                                                <label for="" class="pt-1 col-sm-4">排序:</label>
                                                <input type="text" class="form-control my-form-contrl"
                                                       v-model="item.sort">
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
                                                                <label class="col-sm-4 pt-1" for="">分类ID</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text"
                                                                           class="form-control my-form-contrl"
                                                                           v-model="child.category_id">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label class="col-sm-4 pt-1" for="">排序</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text"
                                                                           class="form-control my-form-contrl"
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
                                                    <button class="btn btn-mine btn-primary" @click="save(index)">保存
                                                    </button>
                                                    <button class="btn btn-mine del-btn"
                                                            @click="deleteItem(item.id,index)">
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
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script src="{{cdn_asset('/assets/js/bower_components/axios/dist/axios.min.js')}}"></script>
    <script src="{{cdn_asset('/assets/admin/js/vue.min.js')}}"></script>
    <script>
        var accordion = new Vue({
            el: '#accordion',
            data: {
                items: {!! json_encode($categorys) !!}
            },
            created: function () {
                console.log(this.items);
            },
            methods: {
                add: function () {
                    this.items.unshift({
                        category_id: 0,
                        child: [],
                        id: '',
                        name: '',
                        parent_id: 0,
                        removed: [],
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
                        id: '',
                        name: '',
                        parent_id: '',
                        sort: 1,
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
                    axios.post('{{ secure_route("pc.categorys.store") }}', {item: this.items[index]}).then(function (res) {
                        if (res.data.status === 200) {
                            _thisVue.items[index] = res.data.content;
                            toastr.success('保存成功');
                            location.reload();
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
                        axios.delete('{{ secure_route("pc.categorys.delete",['id'=>1]) }}'.replace(1, id)).then(function (res) {
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