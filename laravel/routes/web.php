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
Route::prefix('/')->namespace('App\Http\Controllers')->group(function () {
    Route::get('/' , 'MainController@home')->name('home');
    Route::get('/product/{slug}', 'ProductController@show')->name('product');
    Route::get('/products', 'ProductController@index')->name('products');
    Route::get('/blog/{slug}', 'BlogController@show')->name('blog');
    Route::get('/blogs', 'BlogController@index')->name('blogs');
    Route::get('/cart', 'ProductController@cartShow')->name('cartShow');
    Route::get('/wishlist', 'ProductController@wishList')->name('wishlist');
});

