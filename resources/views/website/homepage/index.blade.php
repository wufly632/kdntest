@section('css')
    <style>
        .my-form-control {
            display: inline;
            width: 200px;
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
            <div class="row" id="home-card">
                <div class="col-sm-12">
                    <div class="panel">
                        <div class="panel-body text-center" style="position: relative">
                            <div class=""
                                 style="position: absolute;left:0;right: 0;bottom:0;opacity: 0.6;height: 100%;background-color: #000000;z-index: 9998">
                            </div>
                            <div class=""
                                 style="position: absolute;left: 40px;top:10%;right: 0;bottom: 10%;margin:0 30px 0 -10px;background-color:#FFFFff;z-index: 9999">
                                <div class="row">
                                    <form action="" class="form-horizontal">
                                        <ol class="list-group">
                                            <li class="list-group-item">图片</li>
                                        </ol>
                                        <input type="file" class="form-control">
                                    </form>
                                </div>
                            </div>
                            <div>
                                <img src="{{ url('uploads/home/banner.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-body text-center">
                            <input type="button" class="btn btn-lg btn-success" value="添加商品">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12" v-for="(cardData,index) in cardDatas">
                    <div class="panel">
                        <div class="panel-heading clearfix">
                            <h2 class="col-sm-3 h4 pull-left">@{{ cardData.title }}
                                <input class="form-control my-form-control"
                                       type="text"
                                       v-model="cardData.title">
                                <input
                                        style="margin-left: 10px;border-radius: 15px;" type="button"
                                        class="btn btn-sm btn-primary"
                                        value="编辑"></h2>
                            <h2 class="col-sm-6 h4 pull-right text-right">@{{ cardData.link }}
                                <input class="form-control my-form-control"
                                       type="text"
                                       v-model="cardData.link">
                                <input
                                        style="margin-left: 10px;border-radius: 15px;" type="button"
                                        class="btn btn-sm btn-primary"
                                        value="编辑"></h2>
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
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">路径地址</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="text-center">
                                            <input type="button" class="btn btn-primary" value="确定" :data-index="index">
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
                                     style="position: absolute;left: 20px;opacity: 0.6;width: 100%;height: 100%;background-color: #000000;z-index: 9998"></div>
                                <div v-if="cardData.rightImg.show" class=""
                                     style="position: absolute;left: 40px;top:20%;right: 0;bottom: 20%;background-color:#FFFFff;z-index: 9999">
                                    <form action="" class="form-horizontal col-sm-12" style="padding: 50px;">
                                        <div class="form-group">
                                            <label for="">图片上传</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">路径地址</label>
                                            <select name="" id="select2">
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                                <option value="">4</option>
                                            </select>
                                            <input type="text" class="form-control">
                                        </div>
                                        <input type="button" class="btn btn-primary" value="确定" :data-index="index">
                                        <input type="button" class="btn btn-primary" @click="showCancel" value="取消"
                                               :data-index="index">
                                    </form>
                                </div>
                                <div class="image-wrapper col-sm-12" @click="appendChild">
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
        var homeCard = new Vue({
            el: '#home-card',
            data: {
                cardDatas: [
                        @foreach($cards as $card)

                    {
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
                    if (_elIndexTwo) {
                        this.cardDatas[_elIndex].centerImg[_elIndexTwo].show = true;
                    } else {
                        this.cardDatas[_elIndex].leftImg.show = true;
                    }

                },
                showCancel: function (event) {
                    let _elIndex = event.currentTarget.getAttribute('data-index');
                    let _elIndexTwo = event.currentTarget.getAttribute('data-index-two');
                    if (_elIndexTwo) {
                        this.cardDatas[_elIndex].centerImg[_elIndexTwo].show = false;
                    } else {
                        this.cardDatas[_elIndex].leftImg.show = false;
                    }
                }
            }
        });
        var myAfter = Vue.extend({
            template: '<p>after</p>'
        })
    </script>
@endsection