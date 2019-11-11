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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');



// Frontend Routes ...........................................................
Route::get('/', 'HomeController@index')->name('home');
Route::get('/product/{slug}', 'HomeController@product')->name('product.show');


// Cart Route ................................................................
Route::get('/cart', 'CartController@index')->name('cart.index');
Route::get('/cart/{id}', 'CartController@add')->name('cart.add');
Route::get('/cart/increase/{id}', 'CartController@increase')->name('cart.increase');
Route::get('/cart/decrease/{id}', 'CartController@decrease')->name('cart.decrease');
Route::get('/cart/remove/{id}', 'CartController@remove')->name('cart.remove');


// Chechout Routes ............................................................ 
Route::group(['middleware' => ['auth']], function() {
    Route::get('/checkout', 'CheckoutController@index')->name('checkout.index');
    Route::post('/place-order', 'CheckoutController@store')->name('checkout.store');
    Route::get('/order-confirmation', 'CheckoutController@orderConfirm')->name('order.confirm');
});

// User Routes ...............................................................
Route::group(['as' => 'user.', 'middleware' => ['auth'], 'namespace' => 'User'], function() {
    Route::get('user', 'DashboardController@index')->name('dashboard');
});



// Backend Routes .............................................................. 
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth', 'admin'], 'namespace' => 'Admin'], function() {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
});
