@extends('layouts.blank')
@section('css')

@endsection
@section('content')
    <div class="container" id="banner-box">
        <form class="form-horizontal"
              id="banner-form">
            <div class="h3 text-center" style="padding: 10px;">@if(isset($banner->id))banner修改@else banner新建@endif</div>
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label text-right">标题<span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" name="title" id="title" class="form-control"
                           value="@if(isset($banner->title)){{ $banner->title }}@endif">
                </div>
            </div>
            <div class="form-group">
                <label for="src" class="col-sm-2 control-label text-right">图片<span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="file" name="src" id="src" class="form-control" @change="uploadImg">
                </div>
            </div>
            <div class="form-group">
                <label for="link" class="col-sm-2 control-label text-right">链接<span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" name="link" id="link" class="form-control"
                           value="@if(isset($banner->link)){{ $banner->link }}@endif">
                </div>
            </div>
            <div class="form-group">
                <label for="describe" class="col-sm-2 control-label text-right">描述</label>
                <div class="col-sm-8">
                    <input type="text" name="describe" id="describe" class="form-control"
                           value="@if(isset($banner->describe)){{ $banner->describe }}@endif">
                </div>
            </div>
            <div class="form-group">
                <label for="daterange2" class="col-sm-2 control-label text-right">起止时间<span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input autocomplete="off" type="text" name="time_duration" id="daterange2" class="form-control"
                           value="@if(isset($banner->start_at)){{ $banner->start_at.'~'.$banner->end_at }}@endif">
                </div>
            </div>
            <div class="form-group">
                <label for="sort" class="col-sm-2 control-label text-right">排序<span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="number" min="0" name="sort" id="sort" class="form-control"
                           value="@if(isset($banner->sort)){{ $banner->sort }}@endif">
                </div>
            </div>
            <div class="form-group">
                <label for="type" class="col-sm-2 control-label">类型<span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="type" id="type" class="form-control">
                        <option value="1">ＰＣ</option>
                        <option value="2">移动设备</option>
                    </select>
                </div>
            </div>
            <div style="padding-top: 20px;">
                <input type="button" class="btn btn-warning col-sm-offset-2" @click="closeWindow" value="取消">
                <input type="button" id="banner-modify" class="btn btn-success col-sm-offset-4" @click="formSubmit"
                       value="@if(isset($banner->id))修改@else添加@endif">
            </div>
        </form>
    </div>
@stop
@section('script')
    <script src="{{asset('/assets/js/bower_components/axios/dist/axios.min.js')}}"></script>
    <script src="{{asset('/assets/js/aliyun-oss-sdk.js')}}"></script>
    <script src="{{asset('/assets/admin/js/vue.min.js')}}"></script>
    <script>
        var index = parent.layer.getFrameIndex(window.name);
        var bannerBox = new Vue({
            el: '#banner-box',
            data: {
                src: '@if(isset($banner->src)){{ $banner->src }}@endif'
            },
            created: function () {
                @if(isset($banner->type))
                $('#type').val({{ $banner->type }});
                @endif
            },
            methods: {
                closeWindow: function (event) {
                    parent.layer.close(index);
                }, formSubmit: function (event) {
                    let that = this;
                    let bannerModify = $('#banner-modify');
                    let postUri;
                    let errorMsg;
                    let successMsg;
                    let requestMethod;

                    @if(isset($banner->id))
                        postUri = "{{ secure_route('banners.update',['id'=>$banner->id]) }}";
                    errorMsg = '修改失败';
                    successMsg = '修改成功';
                    requestMethod = 'put';
                    @else
                        postUri = "{{ secure_route('banners.store') }}";
                    errorMsg = '添加失败';
                    successMsg = '添加成功';
                    requestMethod = 'post';
                            @endif
                    let postData = $('#banner-form').serialize() + '&_method=' + requestMethod + '&src=' + this.src + '&_token=' + '{{ csrf_token() }}';
                    bannerModify.attr('disable', true);
                    bannerModify.html('保存中');
                    axios.post(postUri, postData).then(function (res) {
                        if (res.status === 200 && res.data.status === 200) {
                            toastr.options.timeOut = 0.5;
                            toastr.options.onHidden = function () {
                                top.location.reload();
                            };
                            toastr.success(successMsg);
                        } else {
                            bannerModify.attr('disable', false);
                            bannerModify.html('保存');
                            toastr.error(errorMsg);
                        }
                    });
                }, uploadImg: function (event) {
                    let that = this;
                    let elSrc = $('#src');
                    let src = elSrc[0].files[0];
                    let formData = new FormData();
                    formData.append('banners', src);
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('dir_name', 'banners');

                    axios.post("{{ secure_route('banners.upload') }}", formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(function (res) {
                        if (res.status === 200) {
                            if (res.data.status === 200) {
                                that.src = res.data.content;
                            } else {
                                toastr.error(res.data.msg);
                            }
                        }
                    });
                }
            }
        });
        @if(isset($banner->type))
        $('#type').val('{{ $banner->type }}');
        @endif
        @if(!Auth::check())
        top.reload();
        @endif
    </script>
@endsection
