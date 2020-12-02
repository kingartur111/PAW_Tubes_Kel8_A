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
// Login Register
Route::post('register', 'Api\AuthController@register')->name('login');
Route::post('login', 'Api\AuthController@login');


Route::group(['middleware' => 'auth:api'], function () {
    // User
    Route::get('userall', 'Api\AuthController@index');
    Route::delete('user/{id}', 'Api\AuthController@destroy');
    Route::put('user/{id}', 'Api\AuthController@update');
    Route::get('user/{id}', 'Api\AuthController@getUser');

    // Request Peminjaman
    Route::get('request', 'Api\RequestController@index');
    Route::get('request/{id}', 'Api\RequestController@show');
    Route::post('request', 'Api\RequestController@store');
    Route::delete('request/{id}', 'Api\RequestController@destroy');
    Route::post('requestBuku', 'Api\RequestController@requestBuku');

    // Peminjaman
    Route::get('peminjaman', 'Api\PeminjamanController@index');
    Route::get('peminjaman/{id}', 'Api\PeminjamanController@show');
    Route::post('peminjaman', 'Api\PeminjamanController@store');
    Route::put('peminjaman/{id}', 'Api\PeminjamanController@update');
    Route::delete('peminjaman/{id}', 'Api\PeminjamanController@destroy');

    // Buku
    Route::get('buku', 'Api\BukuController@index');
    Route::get('buku/{id}', 'Api\BukuController@show');
    Route::post('buku', 'Api\BukuController@store');
    Route::put('buku/{id}', 'Api\BukuController@update');
    Route::delete('buku/{id}', 'Api\BukuController@destroy');
    Route::get('isbn', 'Api\BukuController@getISBN');

    // Pegawai
    Route::get('pegawai', 'Api\PegawaiController@index');
    Route::get('pegawai/{id}', 'Api\PegawaiController@show');
    Route::post('pegawai', 'Api\PegawaiController@store');
    Route::put('pegawai/{id}', 'Api\PegawaiController@update');
    Route::delete('pegawai/{id}', 'Api\PegawaiController@destroy');

    // Anggota
    Route::get('anggota', 'Api\AnggotaController@index');
    Route::get('anggota/{id}', 'Api\AnggotaController@show');
    Route::post('anggota', 'Api\AnggotaController@store');
    Route::put('anggota/{id}', 'Api\AnggotaController@update');

    // Logout
    Route::post('logout', 'Api\AuthController@logout');

    Route::post('email/verify/{id}', 'Api\VerifyController@verify')->name('verification.verify');
    Route::post('email/resend', 'Api\VerifyController@resend')->name('verification.resend');
});

// get CurrentUser
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('buku', 'Api\BukuController@index');
Route::post('email', 'Api\AuthController@sendEmail');
Route::post('verify/{email}/{token}', 'Api\AuthController@verify');
