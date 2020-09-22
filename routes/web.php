<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cart', 'ShoppingCart@show')->name('cart_show');
Route::get('/cart/add', 'ShoppingCart@add')->name('cart_add');
Route::post('/cart/update', 'ShoppingCart@update')->name('cart_update');
Route::get('/cart/list', 'ShoppingCart@list')->name('cart_list');
Route::get('/cart/clear', 'ShoppingCart@clear')->name('cart_clear');
Route::get('/cart/remove', 'ShoppingCart@remove')->name('cart_remove');
Route::post('/cart/checkout', 'ShoppingCart@checkout')->name('cart_checkout');

Route::get('/shop', 'Shop@show')->name('shop');

Route::get('/payment/senangpay/return', 'SenangPayPayment@return_')->name('senangpay_return');
Route::get('/payment/senangpay/callback', 'SenangPayPayment@callback')->name('senangpay_callback');

Route::get('/test/senangpay', 'ShoppingCart@senangpay')->name('test_senangpay');