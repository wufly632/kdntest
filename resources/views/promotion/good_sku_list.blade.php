@inject('goodPresenter',"App\Presenters\Good\GoodPresenter")
@if(in_array($type, ['limit', 'quantity']))
        @foreach($good_info as $val)
            <?php $displayAttr          = $goodPresenter->displayAttr($val->productSku);?>
        <table class="promotion-goods-list" id="good-list{{$val->id}}" data-stock="{{$val->good_stock}}">
            <tbody>
            <tr>
                <?php $num = $type == 'limit' ? 5 : 6;?>
                <td colspan="{{$displayAttr['attr_num']+$num}}">
                    <div class="clearfix">
                        <div class="fl good-pic">
                            <img src="{{ImgResize($val->main_pic, 100)}}" alt=""/>
                        </div>
                        <div class="fl good-detail" style="">
                            <div class="text-left" style="margin: 30px 0 20px 5px;">名称：{{$val->good_title}}</div>
                            <div class="clearfix" style="margin-left: 5px;">
                                <span class="fl go-id">ID：{{$val->id}}</span>
                                <span class="fl go-num" style="margin-left: 20px;">货号：{{$val->good_code}}</span>
                                <span class="fl go-nunber" style="margin-left: 20px;">最近30天销量</span>
                                <div class="fl clearfix limitnum-container" style="margin-left: 200px;">
                                    <span class="fl">每人限购</span>
                                    <select class="fl promotion-per-num" name="per_num{{$val->id}}">
                                        <option value="0">不限</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="5">5</option>
                                    </select>
                                    <span class="fl">件</span>
                                </div>
                                <button class="btn btn-primary fr" style="margin-left: 30px;" data-toggle="modal" data-target="">一键设置</button>
                            </div>
                        </div>
                    </div>
                </td>
                <td rowspan="{{$val->count()+2}}" style="width: 80px;">
                    <span class="good-delete promotion-goods-delete" data-id="{{$val->id}}" >删除</span>
                </td>
            </tr>
            <tr>
                {!! $displayAttr['sku_th_names'] !!}
                <td>
                    供货价
                    <input type="hidden" name="good_id[]" value="{{$val->id}}"/>
                </td>
                <td>售价</td>
                <?php switch($type){
                    case 'quantity':
                        echo '<td><span class="color-span">* </span>秒杀价</td><td><span class="color-span">* </span>秒杀数量</td>';
                        break;
                    case 'limit':
                        echo '<td><span class="color-span">* </span>限时特价</td>';
                        break;
                }?>
                <td>库存数量</td>
                <td>商家编码</td>
            </tr>
            @foreach($val->productSku as $key => $kv)
            <tr>
                @foreach($kv->skuAttributes as $v)
                    <td class="" data-id="">
                        <div class="text">{{$v->value_name}}</div>
                    </td>
                @endforeach
                <td>
                    <input type="hidden" name="sku_id{{$val->id}}[]" value="{{$kv->id}}"/>
                    <input type="hidden" name="sku_str{{$val->id}}[]" value="{{$kv->value_ids}}"/>
                    {{$kv->supply_price}}
                </td>
                <td data-price="10">
                    10
                </td>
                @if($type == 'quantity')
                    <td>
                        <input class="table-into-input promotion-price" name="price{{$kv->id}}" value="">
                    </td>
                    @if($key == 0)
                        <td rowspan="{{$val->productSku->count()}}">
                            <input class="table-into-input promotion-num" name="num{{$val->id}}" value="">
                        </td>
                    @endif
                @elseif($type == 'limit')
                    <td><input class="table-into-input promotion-price" name="price{{$kv->id}}" value=""></td>
                @endif
                <td>{{$kv->good_stock}}</td>
                <td>{{$kv->supplier_code}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endforeach
    <script type="text/javascript">
        $('.good-sku-set').on('click', function(){
            var id = $(this).data('good');
            var target = $(this).data('target');
            $(target+'-goodid').val(id);
        });
    </script>
@else
    @foreach($good_info as $good)
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
                <div class="promotion-goods-single" data-id="{{$good->id}}" data-toggle="true"><a href="javascript:void(0);">设置优惠</a></div>
            </td>
        </tr>
    @endforeach
@endif
