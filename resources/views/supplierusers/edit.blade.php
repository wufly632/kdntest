@extends('layouts.blank')
@section('css')
    <style>
        #personer-edit div.form-group {
            margin: 30px;
        }

        .form-content {
            margin-top: 50px;
        }
    </style>
@endsection
@section('content')
    <div class="form-title">
        <h1 class="h2 text-center">@if(isset($user->id))编辑商家@else添加商家@endif</h1>
    </div>
    <div class="form-content">
        <form id="supplier_user_edit" method="post"
              class="form-horizontal">
            {!! csrf_field() !!}
            @if(isset($user->id))<input type="hidden" name="id"
                                        value="{{ $user->id }}">{{ method_field('PUT') }}@endif
            <div class="form-group">
                <div class="col-xs-1"></div>
                <label class="col-xs-2 control-label" for="name">
                    用户名:
                </label>
                <div class="col-xs-7">
                    <input type="text" id="name" autofocus name="name"
                           class="form-control"
                           value="@if(isset($user->name)){{ $user->name }}@endif">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-1"></div>
                <label class="col-xs-2 control-label" for="name">
                    公司名称:
                </label>
                <div class="col-xs-7">
                    <input type="text" id="name" autofocus name="company_name"
                           class="form-control"
                           value="@if(isset($user->company_name)){{ $user->company_name }}@endif">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-1"></div>
                <label for="coupon_name" class="col-xs-2 control-label" for="mobile">
                    手机号：
                </label>
                <div class="col-xs-7">
                    <input type="text" id="mobile" name="mobile"
                           class="form-control"
                           value="@if(isset($user->mobile)){{ $user->mobile }}@endif">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-1"></div>
                <label for="coupon_name" class="col-xs-2 control-label" for="email">
                    邮箱：
                </label>
                <div class="col-xs-7">
                    <input type="email" id="email" name="email"
                           class="form-control"
                           value="@if(isset($user->email)){{ $user->email }}@endif">
                </div>
            </div>
            @if(isset($user->id))
                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label for="password" class="col-xs-2 control-label">
                        新密码：
                    </label>
                    <div class="col-xs-7">
                        <input type="password" id="password" class="form-control" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-1"></div>
                    <label for="password_confirmation" class="col-xs-2 control-label">
                        确认密码：
                    </label>
                    <div class="col-xs-7">
                        <input type="password" id="password_confirmation" class="form-control" name="password_confirmation">
                    </div>
                </div>
            @endif
            <div>
                <button type="button" class="btn btn-danger col-xs-offset-3 cancel">取消</button>
                <button type="button" class="btn btn-success col-xs-offset-4 save">保存</button>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script src="{{ cdn_asset('/assets/js/bower_components/axios/dist/axios.min.js') }}"></script>
    <script>
        var index = parent.layer.getFrameIndex(window.name);

        $('#supplier_user_edit').on('click', '.save', function () {
            var toastrMsg;
            var _index = $(this);
            $.ajax({
                type: 'post',
                data: $('#supplier_user_edit').serialize(),
                url: '123',
                dataType: 'json',
                beforeSend: function () {
                    _index.attr('disabled', true);
                    _index.html('保存中...');
                    @if(isset($user->id))
                        toastrMsg = '修改成功';
                        this.url = "{{ secure_route('supplierusers.update',['id'=>$user->id]) }}";
                    this.data._method = 'PUT';
                    @else
                        this.url = "{{ secure_route('supplierusers.store') }}";
                    toastrMsg = '添加成功';
                    @endif
                },
                success: function (res) {
                    if (res.status === 200) {
                        toastr.options.timeOut = 0.5;
                        toastr.options.onHidden = function () {
                            top.location.reload();
                        };
                        toastr.success(toastrMsg);
                    } else {
                        toastr.error(res.msg);
                        _index.attr('disabled', false);
                        _index.html('保存');
                    }
                },
                error: function (error) {
                    var json = eval("(" + error.responseText + ")");
                    for (index in json.errors) {
                        toastr.error(json.errors[index][0]);
                        break;
                    }
                    _index.attr('disabled', false);
                    _index.html('保存');
                }
            });
        });
        $('.cancel').click(function () {
            parent.layer.close(index);
        });

    </script>
@endsection