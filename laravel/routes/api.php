<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::prefix('/')->namespace('App\Http\Controllers')->group(function () {
    Route::get('/getProduct' , 'ProductController@getProduct');
    Route::get('/getProducts' , 'ProductController@getProducts');
    Route::post('/addCart/{product}' , 'ProductController@addCart');
    Route::get('/addWish/{product}' , 'ProductController@addWish');
    Route::get('/getSizes' , 'ProductController@getSizes');
    Route::post('/sendRate' , 'ProductController@sendRate');
    Route::post('/getCart' , 'MainController@getCart');
    Route::post('/deleteCart' , 'MainController@deleteCart');
    Route::get('/getCategories' , 'MainController@getCategories');
    Route::get('/searchProduct' , 'ProductController@searchProduct');
});