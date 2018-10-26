@extends('layouts.blank')
@section('css')

@endsection
@section('content')
    <div class="modal-content">
        <div class="modal-body">
            <form id="rebate" method="post" class="form-horizontal">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="{{$product->id}}">
                <div class="form-group">
                    <label for="coupon_count" class="col-xs-4 control-label text-right">
                        一级分销：
                    </label>
                    <div class="col-xs-6">
                        <div class="input-group">
                            <input type="text" id="rebate_level_one" class="form-control" name="rebate_level_one" value="{{$product->rebate_level_one}}">
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="coupon_count" class="col-xs-4 control-label text-right">
                        二级分销：
                    </label>
                    <div class="col-xs-6">
                        <div class="input-group">
                            <input type="text" id="rebate_level_two" class="form-control" name="rebate_level_two" value="{{$product->rebate_level_two}}">
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="coupon_count" class="col-xs-4 control-label text-right">
                        三级分销：
                    </label>
                    <div class="col-xs-6">
                        <div class="input-group">
                            <input type="text" id="rebate_level_three" class="form-control" name="rebate_level_three" value="{{$product->rebate_level_three}}">
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                </div>

                <div>
                    <button type="button" class="btn btn-danger col-xs-offset-4 cancel">取消</button>
                    <button type="button" class="btn btn-success col-xs-offset-3 save">保存</button>
                </div>
            </form>
        </div>
    </div>
@stop
@section('script')
    <script>
        $('.save').on('click', function () {
            var _index = $(this);
            $.ajax({
                type:'post',
                url:"{{secure_route('product.onshelf')}}",
                data:$('#rebate').serialize(),
                beforeSend:function() {
                    _index.attr('disabled', true);
                },
                success:function(data){
                    if (data.status == 200) {
                        toastr.success(data.content);
                        parent.location.reload();
                    } else {
                        toastr.error(data.msg);
                        _index.attr('disabled', false);
                    }
                },
                error:function(data){
                    var json=eval("("+data.responseText+")");
                    toastr.error(json.msg);
                    _index.attr('disabled', false);
                    _index.html('保存');
                },
            });
        });
        $('.cancel').on('click', function () {
            parent.location.reload();
        })
    </script>
@stop