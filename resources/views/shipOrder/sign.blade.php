@extends('layouts.blank')
@section('css')

@endsection
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success">
                    <div class="box-body table-responsive">
                        <form id="signShipOrder">
                            {!! csrf_field() !!}
                            <input type="hidden" name="ship_order_id" value="{{$ship_order_id}}">
                            <table class="table table-hover darkborder-table">
                                <tbody>
                                <tr style="background-color: #f9f9f9;">
                                    <th>SKU ID</th>
                                    <th>商家SKU编码</th>
                                    <th>图片</th>
                                    <th>订单需求量</th>
                                    <th>实际发货数量</th>
                                    <th>到货数量</th>
                                </tr>
                                @foreach($ship_order_items as $item)
                                    <?php $sku = $item->getSku;?>
                                    <tr>
                                        <td>
                                            {{$item->sku_id}}
                                        </td>
                                        <td>
                                            {{$sku->supplier_code}}
                                        </td>
                                        <td>
                                            <div class="col-sm-3">
                                                <a class="fancybox" rel="gallery" href="{{$sku->icon}}" title="{{$item->good_id}} - 新款数码条纹圆领长袖宽松纽扣装饰T恤女">
                                                    <img src="{{ImgResize($sku->icon, 100)}}" width="64" height="64">
                                                </a>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$item->getProduct->good_title}}<br>
                                                <span class="label label-info">颜色:浅粉,女装尺码:L</span>
                                            </div>
                                        </td>
                                        <td>{{$item->num}}</td>
                                        <td>{{$item->released}}</td>
                                        <td>
                                            <input type="number" class="sign_num" data-sku_id="{{$item->sku_id}}" name="sku_num[{{$item->sku_id}}]">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 text-right">
                <button class="btn btn-success sign">签收</button>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        $(function () {
            $('.sign').click(function () {
                var _index = $(this);
                var err = false;
                $('.sign_num').each(function () {
                    if($(this).val() === '') {
                        toastr.warning('请填写sku_id-'+$(this).data('sku_id')+'的签收数量');
                        err = true;
                        return false;
                    }
                });
                if (err) {
                    return false;
                }
                $.ajax({
                    type:'post',
                    url:"{{secure_route('shipOrder.signPost')}}",
                    data:$('#signShipOrder').serialize(),
                    beforeSend:function() {
                        _index.attr('disabled', true);
                        _index.html('签收中...');
                    },
                    success:function(data){
                        if (data.status == 200) {
                            toastr.success(data.content);
                            parent.location.reload();
                        } else {
                            toastr.error(data.msg);
                            _index.attr('disabled', false);
                            _index.html('签收');
                        }
                    },
                    error:function(data){
                        var json=eval("("+data.responseText+")");
                        toastr.error(json.msg);
                        _index.attr('disabled', false);
                        _index.html('签收');
                    }
                })
            })
        })
    </script>
@stop