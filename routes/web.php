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


Route::group(['middleware' => ['auth', 'web']], function() {
    Route::get('/', ['as' => 'home.dashboard', 'uses' => 'LoginController@dashboard']);

    //个人中心
    Route::group(['prefix' => 'personal', 'namespace' => 'Personal'], function () {
       Route::get('/index', ['as' => 'personal.index', 'uses' => 'PersonalController@index']);
       Route::post('/update', ['as' => 'personal.update', 'uses' => 'PersonalController@update']);
    });

    //类目管理
    Route::group(['prefix' => 'category','namespace' => 'CateAttr'], function(){
        Route::get('/', ['as' => 'category.index', 'uses' => 'CategoryController@index']);
        Route::get('/detail/{category}', ['as' => 'category.detail', 'uses' => 'CategoryController@detail']);
        Route::post('/attribute', ['as' => 'category.attribute', 'uses' => 'CategoryController@getCategoryAttributes']);
        Route::post('/subcategories', ['as' => 'category.subcategories', 'uses' => 'CategoryController@getSubCategories']);
        //更新或添加
        Route::post('/update', ['as' => 'category.update', 'uses' => 'CategoryController@update']);
        Route::get('/current_category_info/{category_id}', ['as' => 'category.current_info', 'uses' => 'CategoryController@currentCategoryInfo']);
    });
    //属性管理
    Route::group(['prefix' => 'attribute', 'namespace' => 'CateAttr'], function(){
        Route::get('/', ['as' => 'attribute.index', 'uses' => 'AttributeController@index']);
        Route::get('/detail/{attribute}', ['as' => 'attribute.detail', 'uses' => 'AttributeController@detail']);
        Route::post('/updateOrInsert', ['as' => 'attribute.update_or_insert', 'uses' => 'AttributeController@updateOrInsert']);
        Route::get('/search', ['as' => 'attribute.search', 'uses' => 'AttributeController@search']);
        Route::post('/delete', ['as' => 'attribute.delete', 'uses' => 'AttributeController@delete']);
    });
    Route::group(['prefix' => 'attrvalue', 'namespace' => 'CateAttr'], function(){
        Route::post('updateOrInsert', ['as' => 'attrvalue.update_or_insert', 'uses' => 'AttrValueController@updateOrInsert']);
        Route::post('/delete', ['as' => 'attrvalue.delete', 'uses' => 'AttrValueController@delete']);
    });

    //商品模块
    Route::group(['prefix' => 'good', 'namespace' => 'Good'], function() {
        Route::get('/',['as' => 'good.index', 'uses' =>'GoodsController@index']);
        Route::get('/audit/{good}', ['as' => 'good.audit', 'uses' => 'GoodsController@audit']);
        Route::post('/auditPass', ['as' => 'good.auditPass', 'uses' => 'GoodsController@auditPass']);
        Route::post('/editPost', ['as' => 'good.edit', 'uses' => 'GoodsController@editPost']);
        Route::post('/auditReturn', ['as' => 'good.auditReturn', 'uses' => 'GoodsController@auditReturn']);
        Route::post('/auditReject', ['as' => 'good.auditReject', 'uses' => 'GoodsController@auditReject']);
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
    });

    //优惠券模块
    Route::group(['prefix' => 'coupon', 'namespace' => 'Coupon'], function () {
        Route::get('/', ['as' => 'coupon.index', 'uses' => 'CouponController@index']);
        Route::post('/create', ['as' => 'coupon.create', 'uses' => 'CouponController@create']);
        Route::post('/update', ['as' => 'coupon.update', 'uses' => 'CouponController@update']);
        Route::get('/edit/{coupon}', ['as' => 'coupon.edit', 'uses' => 'CouponController@edit']);
    });

    //用户订单模块
    Route::group(['prefix' => 'order', 'namespace' => 'Order'], function () {
        Route::get('/', ['as' => 'order.index', 'uses' => 'OrderController@index']);

    });

    //用户管理模块
    Route::group(['namespace' => 'User'], function () {
        Route::resources([
            'users' => 'UsersController',
            'supplierusers' => 'SupplierUserController',
            'adminusers' => 'AdminUserController'
        ]);
    });
});
