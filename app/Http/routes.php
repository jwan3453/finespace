<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//微信注册登录
Route::get('auth/login','Auth\AuthController@getLogin');

Route::post('auth/login','Auth\AuthController@postLogin');

Route::get('auth/register','Auth\AuthController@getRegister');

Route::post('auth/register','Auth\AuthController@postRegister');

Route::get('auth/logout','Auth\AuthController@getLogout');

Route::get('weixin','weixin\homeController@index');

//手机站个人中心

Route::get('weixin/member','weixin\memberController@home');



//手机站产品分类

Route::get('weixin/category','weixin\productController@toCategory');

//手机站产品中心

Route::get('weixin/product/{productId}','weixin\productController@showProduct');



//手机站购物车
Route::get('weixin/cart','weixin\cartController@show');// ['middleware' => '','uses' => ]);
Route::post('weixin/addToCart/', 'weixin\cartController@addToCart');
Route::any('weixin/getCartCookie', 'weixin\cartController@getCartCookie');
Route::post('weixin/deleteCookieProd',  'weixin\cartController@deleteCookieProd');

//手机站结算
Route::get('weixin/checkout','weixin\checkoutController@checkout');




//图片验证码
Route::get('getValidateCode','Service\CommonController@createValidateCode');

//获取手机验证码

Route::any('/sendSmsCode','Service\CommonController@sendSmsCode');


Route::post('/authCheck/checkMobile','Service\AuthCheckController@checkMobile');

//订单
Route::post('/weixin/updatePaymentMethod','weixin\orderController@updatePaymentMethod');
Route::post('/weixin/generateOrder', 'weixin\orderController@generateOrder');

Route::get('/weixin/order/all','weixin\orderController@getAllOrder');
Route::get('/weixin/order/all/{status}','weixin\orderController@getAllOrder');

Route::get('/weixin/order/{orderNo}','weixin\orderController@orderDetail');

