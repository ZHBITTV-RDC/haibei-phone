<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function() {
    return 'test2';
});

Route::get('basic1', function () {
    return 'welcome';
});

Route::any('move',[
	'uses'=>'OwnerController@move',
	'as'=>'move'

	]);


Route::any('getWechatQrcode',[
	'uses'=>'OwnerController@getWechatQrcode',
	'as'=>'getWechatQrcode'

	]);

Route::any('notice',[
	'uses'=>'OwnerController@notice',
	'as'=>'notice'

	]);
// Route::any('mysql',[
// 	'uses'=>'OwnerController@mysql',
// 	'as'=>'mysql'

// 	]);


Route::any('fromsave',[
	'uses'=>'OwnerController@fromsave',
	'as'=>'fromsave'

	]);
   
Route::any('fromchangesave',[
	'uses'=>'OwnerController@fromchangesave',
	'as'=>'fromchangesave'

	]);

Route::any('session', [
	'uses'=>'OwnerController@session',
	'as'=>'session',
	]);
Route::auth();

Route::get('/home', [
	'uses'=>'HomeController@index',
	'as'=>'home',
	]);

Route::any('/wechat', [
	'uses'=>'WechatController@serve',
	'as'=>'wechat',
	]);

Route::any('/demo', [
	'uses'=>'WechatController@demo',
	'as'=>'demo',
	]);


Route::any('/mysql',[
 	'uses'=>'OwnerController@mysql',
    'as'=>'mysql',
    ]);


Route::group(['middleware' => ['web', 'wechat.oauth:snsapi_userinfo']], function () {
    Route::any('test',[
    	'uses'=>'OwnerController@test',
    	'as'=>'test',
    	]);
    Route::any('person',[
    	'uses'=>'OwnerController@person',
    	'as'=>'person',
    	]);
    Route::any('showInfo',[
    	'uses'=>'OwnerController@showInfo',
    	'as'=>'showInfo',
    	]);
    Route::any('from', [
		'uses'=>'OwnerController@from',
		'as'=>'from',
	]);
    Route::any('fromchange', [
		'uses'=>'OwnerController@fromchange',
		'as'=>'fromchange',
	]);
});

Route::any('serach_message', [
	'uses'=>'OwnerController@serach_message',
	'as'=>'serach_message',
	]);