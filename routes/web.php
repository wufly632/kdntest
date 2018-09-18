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


    //商品模块
    Route::group(['prefix' => 'good', 'namespace' => 'Good'], function() {
        Route::get('/',['as' => 'good.index', 'uses' =>'GoodsController@index']);
        Route::get('/audit/{id}', ['as' => 'good.audit', 'uses' => 'GoodsController@audit']);
    });
});
