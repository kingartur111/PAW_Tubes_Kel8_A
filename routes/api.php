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

Route::post('register', 'Api\AuthController@register')->name('login');
Route::post('login', 'Api\AuthController@login');

Route::group(['middleware' => 'auth:api'], function () {
    // Route::get('product', 'Api\ProductController@index');
    // Route::get('product/{id}', 'Api\ProductController@show');
    // Route::post('product', 'Api\ProductController@store');
    // Route::put('product/{id}', 'Api\ProductController@update');
    // Route::delete('product/{id}', 'Api\ProductController@destroy');

    // Route::get('customer', 'Api\CustomerController@index');
    // Route::get('customer/{id}', 'Api\CustomerController@show');
    // Route::post('customer', 'Api\CustomerController@store');
    // Route::put('customer/{id}', 'Api\CustomerController@update');
    // Route::delete('customer/{id}', 'Api\CustomerController@destroy');

    Route::post('logout', 'Api\AuthController@logout');
    Route::put('update_user/{id}', 'Api\AuthController@update');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
