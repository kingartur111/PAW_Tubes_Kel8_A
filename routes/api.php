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
    // Peminjaman


    // Buku
    Route::get('buku', 'Api\BukuController@index');
    Route::get('buku/{id}', 'Api\BukuController@show');
    Route::post('buku', 'Api\BukuController@store');
    Route::put('buku/{id}', 'Api\BukuController@update');
    Route::delete('buku/{id}', 'Api\BukuController@destroy');

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
    Route::delete('anggota/{id}', 'Api\AnggotaController@destroy');

    // Update Profil User
    Route::put('user/{id}', 'Api\AuthController@update');

    // Logout
    Route::post('logout', 'Api\AuthController@logout');
});

// get CurrentUser
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
