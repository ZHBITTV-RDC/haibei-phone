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

//============================登录页面====================

//登录
Route::get('admin/login','Admin\loginController@index');

Route::get('captcha/{temp}','Admin\loginController@captcha');

Route::post('admin/Adminlogin','Admin\loginController@login');

//修改密码

 Route::post('admin/cg','Admin\loginController@change');

//后台路由群
Route::group(['namespace' => 'Admin','prefix'=> 'admin', 'middleware'=>['web','Admin.Login' ] ],function(){
    
 Route::get('index','IndexController@adminindex');

 Route::get('outline','loginController@outLine');

 Route::get('cgpwd','loginController@changePwd');

//============================登录页面====================
  

   
 });

//===============================后台页面=======================================

Route::group(['namespace' => 'Admin','prefix'=> 'admin', 'middleware'=>['web','Admin.Login' ] ],function(){
    
 //首页面

  Route::get('welcome','IndexController@welcome');

  Route::get('rj','IndexController@returnJson');

  //添加页面
  Route::get('listAdd','IndexController@listAdd');
  //展示页
  Route::get('list','IndexController@tableList');
  //分页
  Route::get('page','IndexController@pageShow');
  //编辑页面
  Route::get('editList/{id}','IndexController@editList');
  //删除
  Route::post('delete','IndexController@delete');
 
  Route::post('datadel','IndexController@datadel');
 
  //下架
  Route::post('down','IndexController@down');
  //发布
  Route::post('up','IndexController@up');
  //展示
  Route::get('dataShow/{id}','IndexController@dataShow');

  Route::get('show2015','IndexController@show2015');

  Route::get('show2016','IndexController@show2016');

  Route::get('show2017','IndexController@show2017');
  
   Route::get('sv','IndexController@showVisitor');


  
 });

//添加
 Route::post('add','Admin\IndexController@Add');

 Route::post('uploads','Admin\IndexController@uploads');


//编辑部分
Route::post('edit','Admin\IndexController@edit');

Route::post('coverEdit','Admin\IndexController@coverEdit');



//===============================后台页面=======================================

//===============================前台页面================================

Route::group(['namespace' => 'Home','prefix'=> 'home',  ],function(){
    
 //首页面

  Route::get('welcome','IndexController@welcome');

  Route::get('head','IndexController@index');

 //详情页面
 Route::get('data/{id}','IndexController@data');




  
 });