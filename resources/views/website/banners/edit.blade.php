@extends('layouts.blank')
@section('css')

@endsection
@section('content')
    <div class="container" id="banner-box">
        <div class="col-sm-6" style="padding-top: 76px;">
            <img :src="src" alt="" width="100%">
        </div>
        <form action="{{ secure_route('banners.update',['id'=>$banner->id]) }}" class="form-horizontal col-sm-6"
              id="banner-form">
            <div class="h3 text-center" style="padding: 10px;">banner修改</div>
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label text-right">标题</label>
                <div class="col-sm-8">
                    <input type="text" name="title" id="title" class="form-control" value="{{ $banner->title }}">
                </div>
            </div>
            <div class="form-group">
                <label for="src" class="col-sm-2 control-label text-right">图片</label>
                <div class="col-sm-8">
                    <input type="file" name="src" id="src" class="form-control" @change="uploadImg">
                </div>
            </div>
            <div class="form-group">
                <label for="link" class="col-sm-2 control-label text-right">链接</label>
                <div class="col-sm-8">
                    <input type="text" name="link" id="link" class="form-control" value="{{ $banner->link }}">
                </div>
            </div>
            <div class="form-group">
                <label for="describe" class="col-sm-2 control-label text-right">描述</label>
                <div class="col-sm-8">
                    <input type="text" name="describe" id="describe" class="form-control"
                           value="{{ $banner->describe }}">
                </div>
            </div>
            <div class="form-group">
                <label for="sort" class="col-sm-2 control-label text-right">排序</label>
                <div class="col-sm-8">
                    <input type="text" name="sort" id="sort" class="form-control" value="{{ $banner->sort }}">
                </div>
            </div>
            <div style="padding-top: 20px;">
                <input type="button" class="btn btn-warning col-sm-offset-2" @click="closeWindow" value="取消">
                <input type="button" class="btn btn-success col-sm-offset-4" @click="formSubmit" value="修改">
            </div>
        </form>
    </div>
@stop
@section('script')
    <script src="{{asset('/assets/js/bower_components/axios/dist/axios.min.js')}}"></script>
    <script src="{{asset('/assets/js/bower_components/vue/dist/vue.min.js')}}"></script>
    <script>

        console.log($('#banner-form').serialize());
        var index = parent.layer.getFrameIndex(window.name);
        {{--$('#send-confirm').on('click', function () {--}}
        {{--var toastrMsg;--}}
        {{--var _index = $(this);--}}
        {{--$.ajax({--}}
        {{--type: 'post',--}}
        {{--data: $('#send-confirm-form').serialize(),--}}
        {{--url: "{{ secure_route('orders.sendconfirm',['id'=>1]) }}",--}}
        {{--dataType: 'json',--}}
        {{--beforeSend: function () {--}}
        {{--_index.attr('disabled', true);--}}
        {{--_index.html('保存中...');--}}
        {{--console.log('发送中')--}}
        {{--},--}}
        {{--success: function (res) {--}}
        {{--console.log(res);--}}
        {{--if (res.status === 200) {--}}
        {{--toastr.options.timeOut = 0.5;--}}
        {{--toastr.options.onHidden = function () {--}}
        {{--top.location.reload();--}}
        {{--};--}}
        {{--toastr.success('确认成功');--}}
        {{--} else {--}}
        {{--toastr.error(res.msg);--}}
        {{--_index.attr('disabled', false);--}}
        {{--_index.html('保存');--}}
        {{--}--}}
        {{--},--}}
        {{--error: function (error) {--}}
        {{--_index.attr('disabled', false);--}}
        {{--_index.html('保存');--}}
        {{--}--}}
        {{--});--}}
        {{--});--}}
        $('#send-cancle').click(function () {
            parent.layer.close(index);
        });
        // let that = this;
        // let imgFile = $(this.$el).find('#imgLocal')[0].files[0];//取到上传的图片
        // console.log($(this.$el).find('#imgLocal')[0].files);//由打印的可以看到，图片    信息就在files[0]里面
        // let formData = new FormData();//通过formdata上传
        // formData.append('file', imgFile);
        // this.$http.post('图片上传接口', formData, {
        //     method: 'post',
        //     headers: {'Content-Type': 'multipart/form-data'}
        // }).then(function (res) {
        //     console.log(res.data);//
        // }).catch(function (error) {
        //     console.log(error);
        // });
        var bannerBox = new Vue({
            el: '#banner-box',
            data: {
                src: '{{ $banner->src }}'
            },
            methods: {
                closeWindow: function (event) {
                    parent.layer.close(index);
                }, formSubmit: function (event) {

                    console.log(src);
                }, uploadImg: function (event) {
                    let that = this;
                    let src = $('#src')[0].files[0];
                    let formData = new FormData();
                    formData.append('banner', src);
                    axios.post('')
                }
            }
        });
    </script>
@endsection
