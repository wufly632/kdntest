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
                    @if(isset($user->name)){{ $user->name }}@else <input type="text" id="name" autofocus name="name"
                                                                         class="form-control"
                                                                         value="{{ old('name') }}">@endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-1"></div>
                <label for="coupon_name" class="col-xs-2 control-label" for="mobile">
                    手机号：
                </label>
                <div class="col-xs-7">
                    @if(isset($user->mobile)){{ $user->mobile }}@else <input type="text" id="mobile" name="mobile"
                                                                             class="form-control"
                                                                             value="{{ old('mobile') }}">@endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-1"></div>
                <label for="coupon_name" class="col-xs-2 control-label" for="email">
                    邮箱：
                </label>
                <div class="col-xs-7">
                    @if(isset($user->email)){{ $user->email }}@else <input type="email" id="email" name="email"
                                                                           class="form-control"
                                                                           value="{{ old('email') }}">@endif
                </div>
            </div>
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
            <div>
                <button type="button" class="btn btn-danger col-xs-offset-3 cancel">取消</button>
                <button type="button" class="btn btn-success col-xs-offset-4 save">保存</button>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script src="{{ asset('/assets/js/bower_components/axios/dist/axios.min.js') }}"></script>
    <script>
        var index = parent.layer.getFrameIndex(window.name);
        $('#supplier_user_edit').on('click', '.save', function () {
            var _index = $(this);
            var postdata = {
                _token: '{{ csrf_token() }}',
                name: $('#name').val(),
                email: $('#email').val(),
                mobile: $('#mobile').val(),
                password: $('#password').val(),
                password_confirmation: $('#password_confirmation').val()
            };
            _index.attr('disable', true);
            @if(isset($user->id))
            axios.put("{{ secure_route('supplierusers.update',['id'=>$user->id]) }}", postdata).then(function (response) {
                if (response.data.status === 200) {
                    toastr.options.timeOut = 0.5;
                    toastr.options.onHidden = function () {
                        parent.layer.close(index);
                    };
                    toastr.success('修改成功');
                } else {
                    toastr.error(response.data.msg);
                }
            });
            @else
            axios.post("{{ secure_route('supplierusers.store') }}", postdata).then(function (response) {
                if (response.data.status === 200) {
                    toastr.options.onHidden = function () {
                        parent.layer.close(index);
                    };
                    toastr.success('修改成功');
                } else {
                    toastr.options.timeOut = 0.5;
                    toastr.error(response.data.msg);
                }
            });
            @endif
        });
        $('.cancel').click(function () {
            parent.layer.close(index);
        });

    </script>
@endsection