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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//微信JSSDK
Route::get('/weixin/sdk/jsSdk','Sdk\SdkController@jsSdk');

//获取access_token
Route::get('/access','VX\VXController@getAccessToken');

//临时二维码带参数
Route::get('/ticket','VX\VXController@ticket');
