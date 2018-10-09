@extends('layouts.blank')
@section('css')
    <style>
        #personer-edit div.form-group {
            margin: 30px;
        }
    </style>
@endsection
@section('content')
    <div class="modal-content">
        <div class="modal-body">
            <form id="supplier_user_edit" method="post" class="form-horizontal">
                {!! csrf_field() !!}
                @if(isset($user->id))<input type="hidden" name="id" value="">@endif
                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label class="col-xs-2 control-label">
                        用户名:
                    </label>
                    <div class="col-xs-7">
                        @if(isset($user->name)){{ $user->name }}@endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label for="coupon_name" class="col-xs-2 control-label">
                        手机号：
                    </label>
                    <div class="col-xs-7">
                        @if(isset($user->mobile)){{ $user->mobile }}@endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label for="coupon_name" class="col-xs-2 control-label">
                        邮箱：
                    </label>
                    <div class="col-xs-7">
                        @if(isset($user->email)){{ $user->email }}@endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label for="password" class="col-xs-2 control-label">
                        新密码：
                    </label>
                    <div class="col-xs-7">
                        <input type="password" id="password" class="form-control" name="password" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label for="password_confirm" class="col-xs-2 control-label">
                        确认密码：
                    </label>
                    <div class="col-xs-7">
                        <input type="password" id="password_confirm" class="form-control" name="repassword" value="">
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
        $('#supplier_user_edit').on('click', '.save', function () {
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