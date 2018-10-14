@extends('layouts.blank')
@section('css')

@endsection
@section('content')
    <div class="container">
        <form class="form-horizontal" method="post" id="send-confirm-form">
            {{ csrf_field() }}
            <h1 class="h3 text-center">请填写运单信息</h1>
            <div class="form-group">
                <label class="col-sm-3 control-label">订单号:</label>
                <div class="col-sm-8" style="padding: 5px 15px;">{{ $order->order_id }}</div>
            </div>
            <div class="form-group">
                <label for="waybill_id" class="col-sm-3 control-label">运单号:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control waybill_id" id="waybill_id" name="waybill_id" required
                           placeholder="请输入运单号" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <label for="shipper-code" class="col-sm-3 control-label">选择快递公司:</label>
                <div class="col-sm-8">
                    <select name="shipper_code" id="shipper-code" class="form-control" required>
                        <option value="1">百世</option>
                        <option value="2">圆通</option>
                        <option value="3">中通</option>
                        <option value="4">汇通</option>
                        <option value="5">顺丰</option>
                        <option value="6">韵达</option>
                    </select>
                </div>
            </div>
            <input type="button" class="btn btn-success col-sm-offset-3 send-confirm" id="send-confirm" value="确认">
            <input type="button" class="btn btn-danger col-sm-offset-4 send-cancle" id="send-cancle" value="取消">
        </form>
    </div>
@stop
@section('script')
    <script>
        var index = parent.layer.getFrameIndex(window.name);
        $('#send-confirm').on('click', function () {
            var toastrMsg;
            var _index = $(this);
            $.ajax({
                type: 'post',
                data: $('#send-confirm-form').serialize(),
                url: "{{ secure_route('orders.sendconfirm',['id'=>$order->id]) }}",
                dataType: 'json',
                beforeSend: function () {
                    _index.attr('disabled', true);
                    _index.html('保存中...');
                    console.log('发送中')
                },
                success: function (res) {
                    console.log(res);
                    if (res.status === 200) {
                        toastr.options.timeOut = 0.5;
                        toastr.options.onHidden = function () {
                            top.location.reload();
                        };
                        toastr.success('确认成功');
                    } else {
                        toastr.error(res.msg);
                        _index.attr('disabled', false);
                        _index.html('保存');
                    }
                },
                error: function (error) {
                    _index.attr('disabled', false);
                    _index.html('保存');
                }
            });
        });
        $('#send-cancle').click(function () {
            parent.layer.close(index);
        });
    </script>
@endsection
