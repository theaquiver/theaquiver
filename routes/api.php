<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('wallet')->group(function () {

    Route::get('check', 'WalletController@check');

    Route::get('claim', 'WalletController@claim');

    Route::get('withdraw', 'WalletController@withdraw');

});

Route::prefix('satoshi')->group(function () {

    Route::get('get_token', 'SatoshiController@getToken');

    Route::get('check_token', 'SatoshiController@checkToken');

});

Route::prefix('admin')->group(function () {

    Route::post('login', 'AdminController@login');

    Route::post('paid', 'AdminController@paid');

});