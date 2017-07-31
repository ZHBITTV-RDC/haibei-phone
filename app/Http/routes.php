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

Route::get('/head', [
		'uses'=>'NewteamController@head',
		'as'=>'head'
	]);

Route::any('/application_One', [
		'uses'=>'NewteamController@application_One',
		'as'=>'application_One'
	]);



Route::any('/application_Three', [
		'uses'=>'NewteamController@application_Three',
		'as'=>'application_Three'
	]);

Route::any('/application_Four', [
		'uses'=>'NewteamController@application_Four',
		'as'=>'application_Four'
	]);



Route::group(['middleware' => ['web', 'wechat.oauth:snsapi_base']], function () {

	Route::any('/linkSchool', [
		'uses'=>'NewteamController@linkSchool',
		'as'=>'linkSchool'
	]);

	Route::any('/application_Two', [
		'uses'=>'NewteamController@application_Two',
		'as'=>'application_Two'
	]);

});