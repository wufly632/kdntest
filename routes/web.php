<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', ['as' => 'login', 'uses' => 'LoginController@login']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);
Route::post('/loginPost', ['as' => 'login.post', 'uses' => 'LoginController@postLogin']);
//验证码
Route::get('/captcha', ['as' => 'captcha', 'uses' => 'LoginController@captcha']);


Route::group(['middleware' => ['auth', 'web']], function () {
    Route::get('/', ['as' => 'home.dashboard', 'uses' => 'LoginController@dashboard']);

    //个人中心
    Route::group(['prefix' => 'personal', 'namespace' => 'Personal'], function () {
        Route::get('/index', ['as' => 'personal.index', 'uses' => 'PersonalController@index']);
        Route::post('/update', ['as' => 'personal.update', 'uses' => 'PersonalController@update']);
    });

    //类目管理
    Route::group(['prefix' => 'category', 'namespace' => 'CateAttr'], function () {
        Route::get('/', ['as' => 'category.index', 'uses' => 'CategoryController@index']);
        Route::get('/detail/{category}', ['as' => 'category.detail', 'uses' => 'CategoryController@detail']);
        Route::post('/attribute', ['as' => 'category.attribute', 'uses' => 'CategoryController@getCategoryAttributes']);
        Route::post('/subcategories', ['as' => 'category.subcategories', 'uses' => 'CategoryController@getSubCategories']);
        //更新或添加
        Route::post('/update', ['as' => 'category.update', 'uses' => 'CategoryController@update']);
        Route::get('/current_category_info/{category_id}', ['as' => 'category.current_info', 'uses' => 'CategoryController@currentCategoryInfo']);
        Route::get('/{category_id}/attribute/{attribute_id}/detail', ['as' => 'category.category.attribute', 'uses' => 'CategoryController@getCategoryAttributeDetail']);
        Route::post('/attribute/update', ['as' => 'category.attribute.update', 'uses' => 'CategoryController@updateCategoryAttribute']);
        Route::get('/existCategoryPicAttribute', ['as' => 'category.exist.picAttribute', 'uses' => 'CategoryController@existCategoryPicAttribute']);
        Route::post('/next_level', ['as' => 'category.nextLevel', 'uses' => 'CategoryController@getNextLevel']);
    });
    //属性管理
    Route::group(['prefix' => 'attribute', 'namespace' => 'CateAttr'], function () {
        Route::get('/', ['as' => 'attribute.index', 'uses' => 'AttributeController@index']);
        Route::get('/detail/{attribute}', ['as' => 'attribute.detail', 'uses' => 'AttributeController@detail']);
        Route::post('/updateOrInsert', ['as' => 'attribute.update_or_insert', 'uses' => 'AttributeController@updateOrInsert']);
        Route::get('/search', ['as' => 'attribute.search', 'uses' => 'AttributeController@search']);
        Route::post('/delete', ['as' => 'attribute.delete', 'uses' => 'AttributeController@delete']);
        Route::get('/all', ['as' => 'attribute.all', 'uses' => 'AttributeController@getAllAttributes']);
    });
    Route::group(['prefix' => 'attrvalue', 'namespace' => 'CateAttr'], function () {
        Route::post('updateOrInsert', ['as' => 'attrvalue.update_or_insert', 'uses' => 'AttrvalueController@updateOrInsert']);
        Route::post('/delete', ['as' => 'attrvalue.delete', 'uses' => 'AttrvalueController@delete']);
    });

    //商品模块
    Route::group(['prefix' => 'good', 'namespace' => 'Good'], function () {
        Route::get('/', ['as' => 'good.index', 'uses' => 'GoodsController@index']);
        Route::get('/audit/{good}', ['as' => 'good.audit', 'uses' => 'GoodsController@audit']);
        Route::post('/auditPass', ['as' => 'good.auditPass', 'uses' => 'GoodsController@auditPass']);
        Route::post('/editPost', ['as' => 'good.edit', 'uses' => 'GoodsController@editPost']);
        Route::post('/auditReturn', ['as' => 'good.auditReturn', 'uses' => 'GoodsController@auditReturn']);
        Route::post('/auditReject', ['as' => 'good.auditReject', 'uses' => 'GoodsController@auditReject']);
        Route::post('/sort', ['as' => 'good.sort', 'uses' => 'GoodsController@sort']);
    });

    Route::group(['prefix' => 'product', 'namespace' => 'Product'], function () {
        Route::post('/onshelf', ['as' => 'product.onshelf', 'uses' => 'ProductController@onshelf']);
        Route::post('/offshelf', ['as' => 'product.offshelf', 'uses' => 'ProductController@offshelf']);
        Route::get('/rebate/{product}', ['as' => 'product.rebate', 'uses' => 'ProductController@rebate']);
    });

    //促销活动模块
    Route::group(['prefix' => 'promotion', 'namespace' => 'Promotion'], function () {
        Route::get('/', ['as' => 'promotion.index', 'uses' => 'PromotionController@index']);
        Route::post('/addPost', ['as' => 'promotion.addPost', 'uses' => 'PromotionController@addPost']);
        Route::get('/edit/{promotion}', ['as' => 'promotion.edit', 'uses' => 'PromotionController@edit']);
        Route::post('/editPost', ['as' => 'promotion.editPost', 'uses' => 'PromotionController@editPost']);
        //添加促销商品
        Route::get('/getGoods', ['as' => 'promotion.getGoods', 'uses' => 'PromotionController@getGoods']);
        Route::get('/addGood', ['as' => 'promotion.add.good', 'uses' => 'PromotionController@addGood']);
        Route::post('/addGoodPost', ['as' => 'promotion.add.goodPost', 'uses' => 'PromotionController@addGoodPost']);
        Route::post('/delGood', ['as' => 'promotion.good.delete', 'uses' => 'PromotionController@delGoodPost']);
        Route::post('/getSingleSkuHtml', ['as' => 'promotion.getSingleSkuHtml', 'uses' => 'PromotionController@getSingleSkuHtml']);
        Route::post('/delete', ['as' => 'promotion.delete', 'uses' => 'PromotionController@delete']);
        Route::post('/imgUpload', ['as' => 'promotion.imgUpload', 'uses' => 'PromotionController@imgUpload']);
    });

    //优惠券模块
    Route::group(['prefix' => 'coupon', 'namespace' => 'Coupon'], function () {
        Route::get('/', ['as' => 'coupon.index', 'uses' => 'CouponController@index']);
        Route::post('/create', ['as' => 'coupon.create', 'uses' => 'CouponController@create']);
        Route::post('/update', ['as' => 'coupon.update', 'uses' => 'CouponController@update']);
        Route::get('/edit/{coupon}', ['as' => 'coupon.edit', 'uses' => 'CouponController@edit']);
    });

    //用户订单模块
    Route::group(['namespace' => 'Order'], function () {
        Route::get('/orders/send/{id}', 'OrderController@send')->name('orders.send');
        Route::post('/orders/sendconfirm/{id}', 'OrderController@sendConfirm')->name('orders.sendconfirm');
        Route::post('/orders/orders.cancel/{id}', 'OrderController@orderCancel')->name('orders.cancel');
        Route::resources(['orders' => 'OrderController']);
    });
    //物流信息
    Route::group(['namespace' => 'TrackingMore'], function () {
        Route::get('/trackingmore/getcarriers', 'OrderTrackingMoreController@getCarriers')->name('trackingmore.getcarriers');
        Route::get('/trackingmore/getstream/{id}/{shipper_code}/{waybill_id}', 'OrderTrackingMoreController@getStream')->name('trackingmore.getstream');///{shipper_code}/{waybill_id}
        Route::get('/trackingmore/createtracking/{shipper_code}/{waybill_id}', 'OrderTrackingMoreController@createTracking')->name('trackingmore.createtracking');
        Route::get('/trackingmore/detectcarrier/{waybill_id}', 'OrderTrackingMoreController@detectCarrier')->name('trackingmore.detectcarrier');
    });

    //用户管理模块
    Route::group(['namespace' => 'User'], function () {
        Route::resources([
            'users' => 'UsersController',
            'supplierusers' => 'SupplierUserController',
            'adminusers' => 'AdminUserController'
        ]);
    });

    //网站设置
    Route::group(['namespace' => 'Website'], function () {
        Route::post('banners.uploadImages', 'BannerController@uploadImages')->name('banners.upload');
        Route::resources([
            'banners' => 'BannerController',
            'icons' => 'IconController'
        ]);
    });

    //发货管理
    Route::group(['namespace' => 'ShipOrder', 'prefix' => 'shipOrder'], function(){
       Route::get('/preList', ['as' => 'shipOrder.prelist', 'uses' => 'ShipOrderController@preIndex']);
       Route::get('/list', ['as' => 'shipOrder.list', 'uses' => 'ShipOrderController@index']);
       Route::get('/detail/{shipOrder}', ['as' => 'shipOrder.detail', 'uses' => 'ShipOrderController@shipOrderDetail']);
       Route::get('/lacklist', ['as' => 'shipOrder.lacklist', 'uses' => 'ShipOrderController@lackList']);
       Route::get('/lackAudit/{lack}', ['as' => 'shipOrder.lackAudit', 'uses' => 'ShipOrderController@lackAudit']);
       Route::post('/lackAudit', ['as' => 'shipOrder.postLackAudit', 'uses' => 'ShipOrderController@postLackAudit']);
       Route::post('/addNote', ['as' => 'shipOrder.addNote', 'uses' => 'ShipOrderController@addNote']);
       Route::get('/sign/{ship_order}', ['as' => 'shipOrder.sign', 'uses' => 'ShipOrderController@sign']);
       Route::post('/signPost', ['as' => 'shipOrder.signPost', 'uses' => 'ShipOrderController@signPost']);
    });
});
