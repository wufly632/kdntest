@extends('layouts.blank')
@section('css')

@endsection
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-1">备注:</div>
                <textarea name="reject_note" class="col-xs-11" rows="8"></textarea>
            </div>

            <div class="col-xs-12" style="margin-top: 20px;">
                <button type="button" class="btn btn-danger col-xs-offset-3 submit" data-type="reject">拒绝</button>
                <button type="button" class="btn btn-success col-xs-offset-4 submit" data-type="pass">通过</button>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        $(function () {
            $('.submit').click(function () {
                var type = $(this).data('type');
                var reject_note = $('input[name=reject_note]').val();
                var _index = $(this);
                $.ajax({
                    type:'post',
                    url:"{{secure_route('shipOrder.postLackAudit')}}",
                    data:{_token:"{{csrf_token()}}",type:type,reject_note:reject_note,id:"{{$lack->id}}"},
                    beforeSend:function() {
                        _index.attr('disabled', true);
                        _index.html('提交中...');
                    },
                    success:function(data){
                        if (data.status == 200) {
                            toastr.success(data.content);
                            parent.location.reload();
                        } else {
                            toastr.error(data.msg);
                            _index.attr('disabled', false);
                            if (type == 'pass') {
                                _index.html('通过');
                            } else {
                                _index.html('拒绝');
                            }

                        }
                    },
                    error:function(data){
                        var json=eval("("+data.responseText+")");
                        toastr.error(json.msg);
                        _index.attr('disabled', false);
                        if (type == 'pass') {
                            _index.html('通过');
                        } else {
                            _index.html('拒绝');
                        }
                    },
                })
            })
        })
    </script>
@stop