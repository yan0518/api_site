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
Route::any('wechat', 'WeChatController@serve');

Route::get('/', function () {
    return view('welcome');
});

Route::get('user/register/{docId}', 'RegisterController@index');
Route::get('user/register_succeed', 'RegisterController@succeed');


Route::post('user/register', 'RegisterController@save');


// 获取微信二维码
Route::get('wechat/qrcode/{uuid}', 'WeChatController@qrcode');