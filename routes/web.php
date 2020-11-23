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
//admin grop routes
Auth::routes();

require 'admin.php';

Route::view('/', 'site.pages.homepage');
//for categories
Route::get('/category/{slug}', 'App\Http\Controllers\Site\CategoryController@show')->name('category.show');
//for products
Route::get('/product/{slug}', 'App\Http\Controllers\Site\ProductController@show')->name('product.show');
//add cart functionality
Route::post('/product/add/cart', 'App\Http\Controllers\Site\ProductController@addToCart')->name('product.add.cart');
//card get,remove and clear
Route::get('/cart', 'App\Http\Controllers\Site\CartController@getCart')->name('checkout.cart');
Route::get('/cart/item/{id}/remove', 'App\Http\Controllers\Site\CartController@removeItem')->name('checkout.cart.remove');
Route::get('/cart/clear', 'App\Http\Controllers\Site\CartController@clearCart')->name('checkout.cart.clear');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/checkout', 'App\Http\Controllers\Site\CheckoutController@getCheckout')->name('checkout.index');
    Route::post('/checkout/order', 'App\Http\Controllers\Site\CheckoutController@placeOrder')->name('checkout.place.order');
});