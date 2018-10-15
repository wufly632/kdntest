<div class="modal-dialog" style="width: 1000px;">
    <div class="modal-content">
        <div class="modal-body col-sm-12">
            <h2 class="text-center" style="margin: 20px;">添加商品</h2>
            <form action="" class="form-inline">
                <div class="form-group col-sm-3">
                    <label for="" style="float: left;">商品名称：</label>
                    <input type="text" class="col-sm-8">
                </div>
                <div class="form-group col-sm-3">
                    <label for="" style="float: left;">商品ID：</label>
                    <input type="text" class="col-sm-8" id="">
                </div>
                <div class="form-group col-sm-3">
                    <label for="" style="float: left;">商品货号：</label>
                    <input type="text" class="col-sm-8" id="">
                </div>
                <div class="form-group col-sm-3 text-right">
                    <button type="button" class="btn btn-success">查找</button>
                </div>
            </form>
            <table
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
                @foreach($goods as $product)
                    <tr>
                        <td><input type="checkbox" value="{{$product->id}}" class="good-id"></td>
                        <td>
                            <img src="{{ImgResize($product->main_pic, 100)}}" alt="" width="100px" height="100px">
                        </td>
                        <td style="width: 200px;">
                            <div>
                                <div class="text-right" style="width:30%;float: left;">ID：</div>
                                <div class="text-left" style="width: 70%;float: left">{{$product->id}}</div>
                            </div>
                            <div style="clear: both;">
                                <div class="text-right" style="width:30%;float: left">名称：</div>
                                <div class="text-left" style="width: 70%;float: left">{{$product->good_title}}</div>
                            </div>
                            <div style="clear: both;">
                                <div class="text-right" style="width:30%;float: left">货号：</div>
                                <div class="text-left" style="width: 70%;float: left">{{$product->good_code}}</div>
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
            <div class="text-right">
                {{$goods->appends(Request::all())->links()}}
            </div>
            <div style="margin-top: 20px;">
                <button class="btn btn-success submit pull-right">确认添加</button>
                <button class="btn btn-danger pull-right" style="margin-right: 30px;" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>