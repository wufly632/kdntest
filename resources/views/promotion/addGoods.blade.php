<div class="modal-dialog" style="width: 1000px;">
    <div class="modal-content">
        <div class="modal-body">
            <h2 class="text-center">添加商品</h2>
            <form action="" class="form-inline">
                <div class="form-group">
                    <label for="">商品名称：</label>
                    <input type="text" class="form-control" id="">
                </div>
                <div class="form-group">
                    <label for="">商品ID：</label>
                    <input type="text" class="form-control" id="">
                </div>
                <div class="form-group">
                    <label for="">商品货号：</label>
                    <input type="text" class="form-control" id="">
                </div>
                <input type="button" class="btn pull-right" value="查找">
            </form>
            <table id="select_coupon_table"
                   class="table table-hover table-striped table-bordered text-center">
                <thead>
                <tr>
                    <td class="text-left"><input type="checkbox"></td>
                    <td>商品图片</td>
                    <td>商品信息</td>
                    <td>供货价</td>
                    <td>售价</td>
                    <td>最近30天销量</td>
                    <td>库存数量</td>
                </tr>
                </thead>
                <tbody>
                @foreach($promotion_products as $product)
                    <tr>
                        <td><input type="checkbox" value="{{$product->id}}" class="good-id"></td>
                        <td>
                            <img src="{{ImgResize($product->main_pic, 100)}}" alt="" width="100px" height="100px">
                        </td>
                        <td style="width: 200px;">
                            <div>
                                <div class="col-xs-5 text-right">ID：</div>
                                <div class="col-xs-7 text-left">{{$product->id}}</div>
                            </div>
                            <div>
                                <div class="col-xs-5 text-right">名称：</div>
                                <div class="col-xs-7 text-left">{{$product->good_title}}</div>
                            </div>
                            <div>
                                <div class="col-xs-5 text-right">货号：</div>
                                <div class="col-xs-7 text-left">{{$product->good_code}}</div>
                            </div>
                        </td>
                        <td>{{$product->supply_price}}</td>
                        <td>{{$product->stock_price}}</td>
                        <td>{{$product->orders}}</td>
                        <td>{{$product->good_stock}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <hr>
            <div>
                <input type="button" class="btn btn-success" value="添加店铺所有商品">
                <input type="button" class="btn btn-danger pull-right" value="取消">
                <input type="button" class="btn btn-success pull-right submit" value="确认添加">
            </div>
        </div>
    </div>
</div>