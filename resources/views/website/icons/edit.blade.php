@extends('layouts.blank')
@section('css')
    <link rel="stylesheet"
          href="{{ asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/admin/css/select2.min.css') }}">
@endsection
@section('content')
    <div class="container" id="banner-box">
        <form class="form-horizontal"
              id="banner-form">
            <div class="h3 text-center" style="padding: 10px;">@if(isset($icon->id))ICON修改@else ICON创建@endif</div>
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label text-right">标题</label>
                <div class="col-sm-8">
                    <input type="text" name="title" id="title" class="form-control"
                           value="@if(isset($icon->title)){{ $icon->title }}@endif">
                </div>
            </div>
            <div class="form-group">
                <label for="src" class="col-sm-2 control-label text-right">图片</label>
                <div class="col-sm-8">
                    <input type="file" name="src" id="src" class="form-control" @change="uploadImg">
                </div>
            </div>
            <div class="form-group">
                <label for="category_id" class="col-sm-2 control-label text-right">类目</label>
                <div class="col-sm-8">
                    <select name="category_id" id="category_id" class="form-control">
                        @foreach($categorys as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="time_duration" class="col-sm-2 control-label text-right">起止时间</label>
                <div class="col-sm-8">
                    <input autocomplete="off" type="text" name="time_duration" id="time_duration" class="form-control"
                           value="@if(isset($icon->start_at)){{ $icon->start_at.'~'.$icon->end_at }}@endif">
                </div>
            </div>
            <div class="form-group">
                <label for="sort" class="col-sm-2 control-label text-right">排序</label>
                <div class="col-sm-8">
                    <input type="number" min="0" name="sort" id="sort" class="form-control"
                           value="@if(isset($icon->sort)){{ $icon->sort }}@endif">
                </div>
            </div>
            <div style="padding-top: 20px;">
                <input type="button" class="btn btn-warning col-sm-offset-2" @click="closeWindow" value="取消">
                <input type="button" id="banner-modify" class="btn btn-success col-sm-offset-4" @click="formSubmit"
                       value="@if(isset($icon->id))修改@else添加@endif">
            </div>
        </form>
    </div>
@stop
@section('script')
    <script src="{{ asset('/assets/admin-lte/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('/assets/js/plugincommon.js') }}"></script>
    <script src="{{ asset('/assets/js/bower_components/axios/dist/axios.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/vue.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/select2.min.js') }}"></script>
    <script>
        var index = parent.layer.getFrameIndex(window.name);
        var bannerBox = new Vue({
            el: '#banner-box',
            data: {
                src: '@if(isset($icon->src)){{ $icon->src }}@endif'
            },
            created: function () {
                @if(isset($icon->type))
                $('#type').val({{ $icon->type }});
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

                    @if(isset($icon->id))
                        postUri = "{{ secure_route('icons.update',['id'=>$icon->id]) }}";
                    errorMsg = '修改失败';
                    successMsg = '修改成功';
                    requestMethod = 'put';
                    @else
                        postUri = "{{ secure_route('icons.store') }}";
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
                    formData.append('icons', src);
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('dir_name', 'icons');

                    axios.post("{{ secure_route('banners.upload') }}", formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(function (res) {
                        if (res.status === 200) {

                            if (res.data.status === 200) {
                                that.src = res.data.content;
                            } else {
                                toastr.error(res.data.msg);
                            }
                        }
                    })
                }
            }
        });
        $('#category_id').select2();
        addDateRangePicker($('#time_duration'));
    </script>
@endsection
