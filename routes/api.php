<?php

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

Route::group(['namespace' => 'OAuth', 'middleware' => ['log']], function () {
    Route::post('oauth/access_token', 'LoginController@login')->name('oauth.token');
    Route::post('oauth/refresh_token', 'LoginController@login')->name('oauth.token');
    Route::get('oauth/logout', 'LoginController@logout')->middleware('auth:api');
    Route::post('oauth/forgotpwd', 'ForgotPwdController@forgetpwd');
});

Route::group(['prefix' => 'v1', 'namespace' => 'v1', 'middleware' => ['smartapp', 'log', 'auth:api']], function(){
    Route::get('user/info', 'FUsersController@info');
    Route::get('farm/info', 'FFarmsController@info');
    Route::get('house/{id}', 'FHousesController@info');
    Route::get('house/samples/{id}/{crop_id}', 'FHousesController@samples');
    Route::get('house/crops/{id}', 'FHousesController@crops');
    Route::get('house/tasks/{id}/{crop_id}', 'FHousesController@tasks');
    Route::post('scan/code', 'FScanController@scan');
    Route::post('image/upload', 'FImagesController@upload');
});