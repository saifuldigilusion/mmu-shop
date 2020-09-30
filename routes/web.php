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

/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', 'Shop@show')->name('main');
Route::get('/shop', 'Shop@show')->name('shop');
Route::get('/category/{category}', 'Shop@showCategory')->name('shop_category');
Route::get('/product/{productId}', 'Shop@productDetail')->name('product-detail');

Route::get('/cart', 'ShoppingCart@show')->name('cart_show');
Route::get('/cart/add', 'ShoppingCart@add')->name('cart_add');
Route::post('/cart/update', 'ShoppingCart@update')->name('cart_update');
Route::get('/cart/list', 'ShoppingCart@list')->name('cart_list');
Route::get('/cart/clear', 'ShoppingCart@clear')->name('cart_clear');
Route::get('/cart/remove', 'ShoppingCart@remove')->name('cart_remove');
Route::post('/cart/checkoutconfirm', 'ShoppingCart@checkoutConfirm')->name('cart_checkout_confirm');
Route::post('/cart/checkout', 'ShoppingCart@checkout')->name('cart_checkout');

Route::get('/payment/senangpay/return', 'SenangPayPayment@return_')->name('senangpay_return');
Route::get('/payment/senangpay/callback', 'SenangPayPayment@callback')->name('senangpay_callback');

Route::get('/reservation/byorder/{orderId}', 'Booking@bookByOrder')->name('book_byorder');
Route::post('/reservation/update/byorder', 'Booking@bookSubmitByOrder')->name('book_submit_byorder');

Route::get('/test/senangpay/552153622504722', 'ShoppingCart@senangpay')->name('test_senangpay');
Route::get('/test/sendmail', 'Test@sendmail')->name('test_mail');
//Auth::routes(['register' => false]);
Auth::routes();

Route::redirect('/admin', '/login');
Route::prefix('admin')->group(function () {
    Route::group(['middleware' => ['web', 'auth']], function () {
        Route::get('/dashboard', 'Admin\\DashboardController@index')->name('dashboard');
        
        Route::match(array('GET','POST'), '/order/list', 'Admin\\OrderController@list')->name('order_list');
        Route::match(array('GET','POST'), '/order/itemlist', 'Admin\\OrderController@itemList')->name('orderitem_list');
        Route::match(array('GET','POST'), '/order/detail/{orderId}', 'Admin\\OrderController@detail')->name('order_detail');
        Route::post('/order/edit', 'Admin\\OrderController@edit')->name('order_edit');

        Route::get('/media', 'Admin\\MediaManagerController@index')->name('media');
        
        Route::match(array('GET','POST'), '/carousel/list', 'Admin\\CarouselController@list')->name('carousel_list');
        Route::match(array('GET','POST'), '/carousel/add', 'Admin\\CarouselController@add')->name('carousel_add');
        Route::match(array('GET','POST'), '/carousel/edit/{id}', 'Admin\\CarouselController@edit')->name('carousel_edit');
        Route::post('/carousel/delete', 'Admin\\CarouselController@delete')->name('carousel_delete');

        Route::match(array('GET','POST'), '/category/list', 'Admin\\CategoryController@list')->name('category_list');
        Route::match(array('GET','POST'), '/category/add', 'Admin\\CategoryController@add')->name('category_add');
        Route::match(array('GET','POST'), '/category/edit/{id}', 'Admin\\CategoryController@edit')->name('category_edit');
        Route::post('/category/delete', 'Admin\\CategoryController@delete')->name('category_delete');

        Route::match(array('GET','POST'), '/booking/list', 'Admin\\BookingController@list')->name('booking_list');

        Route::match(array('GET','POST'), '/product/list', 'Admin\\ProductController@list')->name('product_list');
        Route::match(array('GET','POST'), '/product/add', 'Admin\\ProductController@add')->name('product_add');
        Route::match(array('GET','POST'), '/product/edit/{id}', 'Admin\\ProductController@edit')->name('product_edit');
        Route::post('/product/delete', 'Admin\\ProductController@delete')->name('product_delete');

        Route::match(array('GET','POST'), '/schedule/list', 'Admin\\ScheduleController@list')->name('schedule_list');
        Route::match(array('GET','POST'), '/schedule/add', 'Admin\\ScheduleController@add')->name('schedule_add');
        Route::match(array('GET','POST'), '/schedule/detail/{scheduleId}', 'Admin\\ScheduleController@detail')->name('schedule_detail');
        Route::post('/schedule/delete', 'Admin\\ScheduleController@delete')->name('schedule_delete');
        
        Route::match(array('GET','POST'), '/scheduleslot/add/{scheduleId}/{scheduleSlotId}', 'Admin\\ScheduleController@addSlot')->name('scheduleslot_add');
        Route::post('/scheduleslot/delete', 'Admin\\ScheduleController@deleteSlot')->name('scheduleslot_delete');
    });
});

//Route::get('/home', 'HomeController@index')->name('home');
