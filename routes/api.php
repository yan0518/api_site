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

Route::group(['namespace' => 'OAuth', 'middleware' => 'cors'], function () {
    Route::post('oauth/access_token', 'LoginController@login')->name('oauth.token');
    Route::post('oauth/refresh_token', 'LoginController@login')->name('oauth.token');
    Route::get('oauth/logout', 'LoginController@logout')->middleware('auth:api');
});

Route::group(['middleware' => ['auth:api', 'cors']], function(){
    // 管理员账号信息
    Route::get('user/info', 'UsersController@info');

    // 医生管理
    Route::get('doctor', 'DoctorController@list');
    Route::get('doctor/{id}', 'DoctorController@info');
    Route::post('doctor/create', 'DoctorController@create');
    Route::post('doctor/edit', 'DoctorController@update');
    Route::post('doctor/delete/{id}', 'DoctorController@delete');
    Route::get('doctor/{id}', 'DoctorController@info');

    // 用户一览
    Route::get('patient/list', 'PatientController@list');

    // 获取微信二维码
    Route::get('wechat/qrcode/{id}', 'WeChatController@qrcode');

    // 管理员管理
    Route::get('user', 'UsersController@list');
    Route::post('user/create', 'UsersController@create');
    Route::post('user/edit', 'UsersController@update');
    Route::post('user/delete/{id}', 'UsersController@delete');
    Route::get('user/{id}', 'UsersController@get');
});

Route::post('sms/send', 'SmsController@send');
Route::post('sms/validate', 'SmsController@verify');


