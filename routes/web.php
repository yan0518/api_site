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

Route::get('/', function () {
    return view('welcome');
});

Route::get('user/register/{docId}', 'RegisterController@index');
Route::get('user/register_succeed', 'RegisterController@succeed');


Route::post('user/register', 'RegisterController@save');