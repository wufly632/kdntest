@extends('layouts.blank')
@section('css')

@endsection
@section('content')
    @inject('goodPresenter',"App\Presenters\Good\GoodPresenter")
    <div class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success">
                    <div class="box-body table-responsive">
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
                            @foreach($shipOrderItems as $item)
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
                                            <a class="fancybox" rel="gallery" href="{{$sku->icon}}" title="{{$item->good_id}} - {{$item->getProduct->good_title}}">
                                                <img src="{{ImgResize($sku->icon, 100)}}" width="64" height="64">
                                            </a>
                                        </div>
                                        <div class="col-sm-9">
                                            {{$item->getProduct->good_title}}<br>
                                            <span class="label label-info">{{$goodPresenter->displaySkuAttr($sku->value_ids)}}</span>
                                        </div>
                                    </td>
                                    <td>{{$item->num}}</td>
                                    <td>{{$item->released}}</td>
                                    <td>{{$item->received}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>

    </script>
@stop