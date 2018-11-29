@inject('goodPresenter',"App\Presenters\Good\GoodPresenter")
<?php $displayAttr          = $goodPresenter->displayAttr($goodSkus);?>

<tr>
    <td colspan="7" class="add_Table">
        <table class="_goodDetail">
            <tbody>
            <tr>
                {!! $displayAttr['sku_th_names'] !!}
                <td class="detail_sale">供应价</td>
                <td class="detail_price">售价</td>
                <td class="detail_favour"><span>*</span>优惠价</td>
                <td class="detail_num">优惠数量</td>
                <td class="detail_store">库存数量</td>
                <td class="detail_code">商家编码</td>
                <td rowspan="11" class="detail_last_row">
                    <div class="clear promotion-goods-single-clear">清空</div>
                </td>
            </tr>
            @foreach($goodSkus as $key => $goodSku)
                <tr>
                    @foreach($goodSku->skuAttributes as $v)
                        <td class="" data-id="">
                            {{$v->value_name}}
                        </td>
                    @endforeach
                    <td>
                        {{$goodSku->supply_price ?? '0.00'}}
                        <input type="hidden" name="sku_id{{$goodSku->good_id}}[]" value="{{$goodSku->id}}"/>
                        <input type="hidden" name="sku_str{{$goodSku->good_id}}[]" value="{{$goodSku->value_ids}}"/>
                    </td>
                    <td>
                        {{$goodSku->price ?? '0.00'}}
                    </td>
                    <td>
                        <input class="table-into-input promotion-price" name="price{{$goodSku->id}}"
                               value="{{$activityGoodSkus[$goodSku->id]['price'] ?? ''}}">
                    </td>
                    @if($key == 0)
                    <td class="store_num" rowspan="{{$goodSku->count()}}">
                        <div>优惠限量
                            <input type="text" name="num{{$goodSku->good_id}}">件
                        </div>
                        <div>每人限购
                            <select name="per_num{{$goodSku->good_id}}">
                                <option value="0">不限</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="5">5</option>
                            </select>件
                        </div>
                    </td>
                    @endif
                    <td>
                        {{$goodSku->good_stock}}
                    </td>
                    <td>
                        {{$goodSku->supplier_code}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </td>
</tr>