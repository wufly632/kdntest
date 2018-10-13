<p class="text-center add-coupon-title">添加优惠券</p>
<table class="table table-hover table-striped table-bordered text-center">
    <thead>
    <tr>
        <th class="re-input">
            <input type="checkbox" id="coupon-checkAll">
        </th>
        <th class="ac-id">ID</th>
        <th class="ac-name">名称</th>
        <th class="ac-position">面额</th>
        <th class="ac-valid">使用有效期</th>
        <th class="ac-time">发放时间</th>
    </tr>
    </thead>
    <tbody>
    @foreach($coupons as $coupon)
        <tr>
            <td>
                <input class="coupon-check" type="checkbox" name="coupon-ids" value="{{$coupon->id}}" data-price="{{$coupon->coupon_price}}">
            </td>
            <td>{{$coupon->id}}</td>
            <td>{{$coupon->coupon_name}}</td>
            <td>{{$coupon->coupon_price}}（满{{$coupon->coupon_use_price}}）</td>
            <td>{{$coupon->coupon_use_startdate.'~'.$coupon->coupon_use_enddate}}</td>
            <td>{{$coupon->coupon_grant_startdate.'~'.$coupon->coupon_grant_enddate}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="container-row clearfix lastRow">
    <button type="submit"  class="save btn btn-primary" id="add_coupon">确认选择</button>
</div>
<script type="text/javascript">
    $(function(){
        $("#coupon-checkAll").change(function(){
            $(".coupon-check").prop("checked", $(this).prop("checked"));
        });
    });
</script>