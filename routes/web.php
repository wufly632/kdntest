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

    //类目管理
    Route::group(['prefix' => 'category','namespace' => 'CateAttr'], function(){
        Route::get('/', ['as' => 'category.index', 'uses' => 'CategoryController@index']);
        Route::post('/update', ['as' => 'category.update', 'uses' => 'CategoryController@update']);
        Route::post('/value', ['as' => 'category.value', 'uses' => 'CategoryController@value']);
        Route::post('/search', ['as' => 'category.search', 'uses' => 'CategoryController@search']);
        Route::post('/create', ['as' => 'category.create', 'uses' => 'CategoryController@create']);
    });
    //属性管理
    Route::group(['prefix' => 'attribute', 'namespace' => 'CateAttr'], function(){
        Route::get('/', ['as' => 'attribute.index', 'uses' => 'AttributeController@index']);
        Route::post('/search', ['as' => 'attribute.search', 'uses' => 'AttributeController@search']);
        Route::post('/create', ['as' => 'attribute.create', 'uses' => 'AttributeController@create']);
        Route::post('/update', ['as' => 'attribute.update', 'uses' => 'AttributeController@update']);
        Route::post('/attr', ['as' => 'attribute.attr', 'uses' => 'AttributeController@attr']);
        Route::post('/delete', ['as' => 'attribute.delete', 'uses' => 'AttributeController@delete']);
        Route::get('/all', ['as' => 'attribute.all', 'uses' => 'AttributeController@all']);
    });
    Route::group(['prefix' => 'attrvalue', 'namespace' => 'CateAttr'], function(){
        Route::post('/detail', ['as' => 'attrvalue.detail', 'uses' => 'AttrvalueController@detail']);
        Route::post('/create', ['as' => 'attrvalue.create', 'uses' => 'AttrvalueController@create']);
        Route::post('/update', ['as' => 'attrvalue.update', 'uses' => 'AttrvalueController@update']);
        Route::post('/search', ['as' => 'attrvalue.search', 'uses' => 'AttrvalueController@search']);
    });

    //商品模块
    Route::group(['prefix' => 'good', 'namespace' => 'Good'], function() {
        Route::get('/',['as' => 'good.index', 'uses' =>'GoodsController@index']);
        Route::get('/audit/{good}', ['as' => 'good.audit', 'uses' => 'GoodsController@audit']);
    });

    //促销活动模块
    Route::group(['prefix' => 'promotion', 'namespace' => 'Promotion'], function () {
       Route::get('/', ['as' => 'promotion.index', 'uses' => 'PromotionController@index']);
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
});
