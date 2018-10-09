@foreach(goods as $good)
<tr class="table-level-one">
    <td>
        <img src="{{ImgResize($good->main_pic, 100)}}" alt="">
    </td>
    <td style="width: 200px;">
        <div>
            <div class="col-xs-5 text-right">ID：</div>
            <div class="col-xs-7 text-left">{{$good->id}}</div>
        </div>
        <div>
            <div class="col-xs-5 text-right">名称：</div>
            <div class="col-xs-7 text-left">{{$good->good_title}}</div>
        </div>
        <div>
            <div class="col-xs-5 text-right">货号：</div>
            <div class="col-xs-7 text-left">{{$good->good_code}}</div>
        </div>
    </td>
    <td>{{$good->stock_price}}起</td>
    <td>¥{{$good->supply_price}}起</td>
    <td>{{$good->orders}}</td>
    <td>{{$good->good_stock}}</td>
    <td>
        <div><a href="javascript:void(0);" class="promotion-goods-delete" data-id="{{$good->id}}">删除</a></div>
        <div class="set_promotion"><a href="javascript:void(0);">设置优惠</a></div>
    </td>
</tr>
@endforeach