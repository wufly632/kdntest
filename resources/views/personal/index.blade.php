@extends('layouts.blank')
@section('css')
    <style>
        #personer-edit div.form-group{
            margin: 30px;
        }
    </style>
@endsection
@section('content')
    <div class="modal-content">
        <div class="modal-body">
            <form id="personer-edit" method="post" class="form-horizontal">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="">
                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label class="col-xs-2 control-label">
                        用户名:
                    </label>
                    <div class="col-xs-7">
                        {{\Auth::user()->name}}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label for="coupon_name" class="col-xs-2 control-label">
                        邮箱：
                    </label>
                    <div class="col-xs-7">
                        {{\Auth::user()->email}}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label for="coupon_name" class="col-xs-2 control-label">
                        姓名：
                    </label>
                    <div class="col-xs-7">
                        {{\Auth::user()->realname}}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label for="" class="col-xs-2 control-label">
                        新密码：
                    </label>
                    <div class="col-xs-7">
                        <input type="password" class="form-control" name="password" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label for="coupon_name" class="col-xs-2 control-label">
                        确认密码：
                    </label>
                    <div class="col-xs-7">
                        <input type="password" class="form-control" name="repassword" value="">
                    </div>
                </div>
                <div>
                    <button type="button" class="btn btn-success col-xs-offset-3 save">保存</button>
                    <button type="button" class="btn btn-danger col-xs-offset-4 cancel">取消</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#personer-edit').on('click', '.save', function () {
            var _index = $(this);
            $.ajax({
                type: 'post',
                url: "{{secure_route('personal.update')}}",
                data: $('#personer-edit').serialize(),
                beforeSend: function () {
                    _index.attr('disabled', true);
                    _index.html('保存中...');
                },
                success: function (data) {
                    if (data.status == 200) {
                        toastr.success(data.content);
                        parent.location.reload();
                    } else {
                        toastr.error(data.msg);
                        _index.attr('disabled', false);
                        _index.html('保存');
                    }
                },
                error: function (data) {
                    var json = eval("(" + data.responseText + ")");
                    toastr.error(json.msg);
                    _index.attr('disabled', false);
                    _index.html('保存');
                },
            });
        });
    </script>
@endsection