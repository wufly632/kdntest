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
            width: 200px;
        }
    </style>
@endsection
@extends('layouts.default')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                H5分类
                <small>H5</small>
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
                    <div class="box-group" id="accordion">
                        <template v-for="(item,index) in items">
                            <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                            <div class="panel box">
                                <div class="box-header with-border">
                                    <div class="col-sm-4">
                                        标题:
                                        <input type="text" class="form-control my-form-contrl" :value="item.name">
                                    </div>
                                    <div class="col-sm-4">
                                        icon:
                                        <input type="text" class="form-control my-form-contrl">
                                    </div>
                                    <a data-toggle="collapse" data-parent="#accordion" :href="'#collapse'+index"
                                       aria-expanded="true" class="btn btn-sm btn-primary pull-right">
                                        <span class="fa fa-angle-double-down"></span>
                                    </a>
                                </div>
                                <div :id="'collapse'+index" class="panel-collapse collapse" aria-expanded="false"
                                     style="height: 0">
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">item</li>
                                        <li class="list-group-item">item</li>
                                        <li class="list-group-item">item</li>
                                        <li class="list-group-item">item</li>
                                        <li class="list-group-item">item</li>
                                    </ul>
                                </div>
                            </div>
                        </template>
                        <button class="btn" @click="add">添加</button>
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
                items: [
                    {id: 1, name: "a"},
                    {id: 2, name: "b"},
                    {id: 3, name: "c"},
                    {id: 4, name: "d"},
                    {id: 5, name: "e"},
                    {id: 6, name: "f"}
                ]
            },
            methods: {
                add: function () {
                    this.items.push({id: '', name: 'g'});
                }
            }
        })
    </script>
@endsection