# OWNER
## 2017/06/30
* 我重新建了一个库，原本打算用TP做为框架写这个项目的，但是考虑到正在学习laravel框架，就打算用laravel框架来进行项目。
* 服务器使用centos 7系统，laravel5.2框架，php版本为5.6.3，使用mysql数据库。
* 关于laravel的安装
	* 使用官方提供的安装方法，首先安装composer
    ```
    #yum install composer
    ```
    * 使用composer在当前目录下安装laravel(根据你的需要可以替换owner目录，以及5.2的版本号，注意安装目录的权限设置，以及使用composer进行安装需要在非root用户下进行）
    ```
    #composer create-project laravel/laravel owner --prefer-dist "5.2.*"
    ```
	* 可能遇到的问题
		```
		[Symfony\Component\Process\Exception\RuntimeException]                                  
		The Process class relies on proc_open, which is not available on your PHP installation.
		```
		```
		[ErrorException]                                          
		proc_get_status() has been disabled for security reasons 
		```
		* 解决方法：修改php.ini查找disable_functions将里面的`proc_open`以及`proc_get_status()`删除
    * 用浏览器进入localhost/项目根目录/public，如果浏览器出现下面这张图就表示安装成功了
    ![](https://github.com/FYKANG/owner/raw/master/githubIMG/laravelCheck.png)
## 2017/07/01
### laravel的路由使用
* 在根目录下的app/Http/routes.php添加路由，路由的基本请求类型有get,post,put,patch,delete,options.
### 基本的书写格式
```
Route::get('test', function () {
return 'test';
});
```
* 通过访问 `localhost/laravel/public/index.php/test` web页面上会显示test字样。(其中laravel框架的存放目录)
### 路由规则的修改，除去index.php
* 我们可以通过修改apache的配置去修改路由规则，具体如下。
	* 修改apache安装目录下的conf/httpd.conf
		* 将#LoadModule rewrite_module modules/mod_rewrite.so前面的#除去，部分httpd.conf配置文件里面会出现没有这一段情况，我们可以去modules目录下确认一下有无mod_rewrite.so文件，如果有那么我们可以直接在httpd.conf中添加LoadModule rewrite_module modules/mod_rewrite.so.
	* 将AllowOverride None修改为AllowOverride All，可以根据你自己的需要修改相应位置的AllowOverride None，如果你对apache的配置不熟悉你可以将全部的AllowOverride None都修改掉，或者一个个试着去修改。
	* 重启apache服务
		```
		# service httpd restart
		```
		* 这是linux系统下的重启命令，window下可以打开任务管理器，选择服务，找到apache右键重启启动服务
* 现在我们可以通过访问`localhost/laravel/public/test`得到test字样了。
## 2017/07/03
### laravel中关于数据库连接的配置
* 配置文件在`.env`中
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=数据库名
DB_USERNAME=用户名
DB_PASSWORD=密码
```
### 控制器的创建及其使用
#### Controller的创建
* 在./app/Http/Controllers下创建OwnerController.php(注意控制器命名规则~Controller.php)
* 基本的Controller模型
```php
<?php
namespace App\Http\Controllers;	//
class OwnerController extends Controller
{
    public function mysql()
    {
	 return 'Hellow world'
    }
}

```
#### Controller的使用
	* 在./app/Http/routes.php中添加路由
	```php
	Route::any('mysql',[
		'uses'=>'OwnerController@mysql',
		'as'=>'mysql'
		]);
	```
	* 这段代码作用为添加一个名为mysql的路由,使用OwnerController控制器中的mysql方法，为路由起一个msyql的别名
* 当我们访问`http://localhost:/根目录/public/mysql`后就会出现Hellow world.
### Model的创建及使用
#### Model的创建
* 在./app目录下创建search.php
* 基本的Model模型
```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class search extends Model
{
	//指定表名
    protected $table='search';

    //指定主键
    protected $primaryKey='id';

    //设置允许批量赋值的字段
    protected  $fillable=['userName'];
    
    //指定不允许批量赋值的字段
     protected $guarded=[];

    //是否时间自动维护
     public $timestamps=true;

     //将时间变为时间戳
     // protected function getDateFormat(){

     // 	return time();
     // }
     
     //关闭自动格式化时间戳
     // protected function asDateTime($val){
     // 	return $val;
     // }
}
```
#### Model的使用
* 在控制器中为model添加命名空间`use App\Owner;`
* 以下我们会用到DB模型所以需要添加命名空间`use Illuminate\Support\Facades\DB;`
* 在控制器中添加一个方法
```php
public function mysql()
    {
    	//all()获取全部数据
    	//$workout=search::all();

    	//find()根据主键获取数据
    	//$workout=search::find(1);

    	//findOrFail()根据主键查找，如果没有此主键则报错
    	//$workout=search::findOrFail(1);

    	//查询构造器get()获取全部数据
    	// $workout=search::get();
	
	//where查询语句
	//$workout=search::where('id','>=','1')->get();
		

    	/* chunk(num,function($workout){});
    	其中num为需要查询出来的条数，$workout为返回的结果
    	$workout=search::chunk(2,function($search){
    		dd($search);
    	});
    	*/

    	//聚合函数

    	//count()查询结果的条数
    	//$num=search::count();//返回条数

    	//max('字段')获取此字段中最大值并输出所在行
    	//min('字段')获取此字段中最小值并输出所在行


    	//使用模型新增数据
    	// $search=new search();
    	// $search->userName='ormTest2';
    	// $bool=$search->save();返回bool值

    	//使用create方法新增数据
    	// $workout=search::create(
    	// 	['userName'=>'createteset2']
    	// 	);

    	//使用firstOrCreate()，查询指定字段，如果存在则返回实例，如果不存在则新增数据
    	// $workout=search::firstOrCreate(
    	// 	['userName'=>'ok']
    	// 	);

    	//使用firstOrNew(),与firstOrCreate()基本一致但出现不存在时不会自动保存数据需手动使用save();
    	// $workout=search::firstOrNew(
    	// 	['userName'=>'okok']
    	// 	);


    	// //通过模型更新数据
    	// $workout=search::find(17);
    	// $workout->userName='addNews';
    	// $bool=$workout->save();//返回布尔值

    	//批量更新
    	// $workout=search::where('id','>','10')->update(
    	// 	['userName'=>'groupUpdate']
    	// 	);//返回被修改的条数

    	//通过模型删除数据
    	// $workout=search::find(17);
    	// $bool=$workout->delete();//返回bool值

    	//通过主键删除
    	// $num=search::destroy(10);//返回被删的条数，如果失败则报错(可多条删除如destroy([10,9])表示删除主键为10和9的数据)

    	//删除指定条件数据
    	// $num=search::where('userName','=','test')
    	// 	->delete();//返回没删除的条数

    	//将数据转换为数组形式
    	// $arr=$workout->toArray();

	//如果我们想输出数据我们可以这样做
	//$workout=search::where('id','=','1')->get();
	//dd($workout->userName)//userName为字段名
	
	//如果取出多条数据我们可以使用chunk或者使用foreach

    }
```
### view的创建及使用
#### view的创建
* 通常我们会为用到的Controller创建对应的view文件夹，如：在./resources/views下创建一个owner文件夹在里面我们创建一个mysql.blade.php(你也可直接创建mysql.php,使用mysql.blade.php的好处是我们能使用blade模板使用里面的各种标签)
	* 我们在里面写一些简单的html
```html
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>test</title>
	<link rel="stylesheet" href="" type="text/css">
</head>
<body>
<div class="test">
          <p >{{$workout}}</p>
</div>
</body>
</html>	
```
#### view的使用
* 在控制器中的方法中我们添加以下方法
```
 public function mysql()
    {

    	// 向模板中传递数据
    	return view('owner/mysql',[
    		'workout'=>'Hellow World'
		]);
    }
```
* 我们访问`http://localhost:/根目录/public/mysql`就会出现Hellow world
#### view中blade模板的实用标签(循环输出数组)
```php
@foreach($workout as $val)
          <p >{{$val->userName}}</p>
@endforeach
```
### css与js的调用
#### css
* css存放路径`./public/css`
* css的调用
```html
<link rel="stylesheet" href="{{ URL::asset('css/test.css') }}" type="text/css">
```
#### js
* js存放路径`./public/js`
* js的调用
```html
<script src="{{ URL::asset('js/test.js') }}" type="text/javascript" charset="utf-8" async defer></script>
```
## 2017/07/04
### 使用Simple QrCode库进行二维码转换
#### Simple QrCode的安装
* 首先,添加 QrCode 包添加到你的 composer.json 文件的 require 里:
```json
"require": {
    "simplesoftwareio/simple-qrcode": "~1"
}
```
* 然后,运行 
```
# composer update 
```
* 添加 Service Provider(laravel5的注册方法
	* 注册SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class 至 config/app.php 的 providers 数组里.
* 添加 Aliases(laravel5的注册方法
	* 注册'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class 至 config/app.php 的 aliases 数组里.
#### Simple QrCode的使用
* 在blade模型模板中添加以下代码(具体的使用方法可以参考[simple-qrcode官方文档](https://www.simplesoftware.io/docs/simple-qrcode/zh#docs-ideas))
```html
<div class="visible-print text-center">
    {!! QrCode::size(100)->generate(Request::url()); !!}
    <p>Scan me to return to the original page.</p>
</div>
```
## 2017/07/05
### request以及Session
```php
<?php

namespace App\Http\Controllers;	
use App\Owner;		//MOdel的调用
use App\search;		//MOdel的调用
use Illuminate\Support\Facades\DB;	//查询构造器的调用
use Illuminate\Http\Request; 	//调用Request
use Illuminate\Support\Facades\Session;	//调用Session模型
class OwnerController extends Controller
{
    public function mysql(Request $request)
    {

    	//request模型

	    	//取值
	    	//$request->input('key');

	    	//判断是否存在数据
	    	// $request->has('key');

	    	//获取全部参数
	    	// $request->all();

	    	//判断请求类型
	    	// $request->method();

	    	//判断是否为指定类型
	    	// $request->isMethod('GET');

	    	//判断是否为ajax请求
	    	// $request->ajax();

	    	//判断指定请求地址是否正确
	    	//$request->is('mysql');

	    	//获取当前url
	    	//$request->url();
	    	

	    //session操作

	    	//HTTP request session()
	    		//session存值
	    		// $request->session()->put('key','valuesl');
	    		//session取值
	    		// dd($request->session()->get('key4'));

    		//session()辅助函数
	    		//存
	    		// session()->put('key2','lalues2');
	    		//取
	    		// session()->get('key2');

    		//Session模型
	    		//存
	    		// Session::put('key3','values3');
    			// Session::put(['key3'=>'values33']);

	    		// //取
	    		// dd(Session::get('key3'));
    			//添加不存在时的默认值
    			// Session::get('key3','none');

	    		//把数据放入Session的数组中
	    			// Session::push('key4','values41');
	    			// Session::push('key4','values42');


	    		//取后删除
	    			// dd(Session::pull('key4'));

	    		//取出所有值
	    			//Session::all();

	    		//判断是否存在某key
	    			//Session::has('key);

    			//删除某个key
    			//Session::forget('key');

    			//删除全部ksession
    			// Session::flush();

    			//暂存数据访问一次后消失
    			// Session::flash('key','values');
    }

}
```
## 2017/07/06
### Middleware中间件的是使用
#### 创建中间件
* 在/App/Http/Middleware下创建中间件，命名为Time.php
* 基本的中间件模型
	```php
	<?php
	
	namespace App\Http\Middleware;
	
	use Closure;
	
	class Time
	{
	
	    public function handle($request, Closure $next)
	    {
	        if(time()<strtotime('2017-07-06')){
	            return redirect()->route('ready');
	           
	        }
	        else
	            return $next($request);
	    }
	}
	```
* 注册中间件，在/App/Http/Kenmel.php中的$routeMiddleware中注册，示例如下(注意键名time首字母小写)
	```php
	    protected $routeMiddleware = [
	
	        'time' => \App\Http\Middleware\Time::class,
	
	    ];
	```
* 将中间件应用到路由中
	* 创建路由群组(注意'middleware'=>'time'首字母都是小写)
		```php
			Route::any('ready',[
			'uses'=>'OwnerController@ready',
			'as'=>'ready'
			]);
		Route::group(['middleware'=>'time'], function() {
    		Route::any('active',[
			'uses'=>'OwnerController@active',
			'as'=>'active'
			]);
		});
		```
* 当我们访问active控制器时会先去到中间件进行条件判断，示例中如果当前时间在2017-07-06以前则会定向到ready控制器，反之则定向到当前控制器
#### 关于post数据的提交
* 使用post提交数据的时候laravel默认开启了Csrf验证所以我们需要在from表单中添加以下代码
	* 第一种方式
		```html
		<input type="hidden" name="_token"         value="{{ csrf_token() }}"/>
		```
	* 第二种方式
		```html
		{{csrf_field()}}
		```
## 2017/07/07
### 控制器验证
* 基础流程
	* 进入$this->validate()进行字段验证如果通过验证则继续执行后面的代码，如果验证失败则抛出一个全局的$errors对象然后返回上一层路由
* 基本的验证模型
	```php
		public function fromsave(Request $request){

			$this->validate($request,[
				//字段的规则设定
				'test'=>'required|min:1|max:2',
					'test2'=>'required|integer',
				],[
				//错误信息的提示设置
					'required'=>':attribute 必填',
					'integer'=>':attribute 数字',
					'max'=>':attribute 最大为2位数',
					'min'=>':attribute 最小为1位数',
				],[
				//错误字段的名称设置
					'test'=>'测试1',
					'test2'=>'测试2'
				]);
				
		}
	```
* $errors在模型中的基本调用
	```html
	@if(count($errors))
		<ul>
			@foreach($errors->all() as $error)
				<li>{{$error}}</li>
			@endforeach
		</ul>
	@endif
	```
## 2017/07/08
### composer的基础使用
* 配置文件的初始化
	```
	composer init
	```
* search命令的使用
	```
	composer search laravel
	```
* show命令的使用
	```
	composer show --all laravel
	```
* 使用composer.json进行管理	
	* 在生成的composer.json中写入项目的库信息
		```
		  "require": {
			"php": ">=5.5.9",
			"laravel/framework": "5.2.*",
			"simplesoftwareio/simple-qrcode":"~1"
		},
		```
	* 通过`composer update`使配置文件生效
### Artisan的基础使用
* list查看所有可用命令
	```
	php artisan list
	```
* help查看帮助信息(查看make命令帮助)
	```
	php artisan help help make
	```
* make创建(创建一个OwnerControlller控制器)
	```
	php artisan make:controller OwnerControlller
	```
## 2017/07/09
### laravel的缓存使用
* laravel的缓存配置目录config/cache.php
* 缓存的命名空间`use Illuminate\Support\Facades\Cache;	//调用缓存`
* laravel的基本方法使用
	* put('key', $value, $minutes)
	```php
	//添加缓存，不会判断键名是否已存在，无返回值,直接覆盖添加
	Cache::put('key', $value, $minutes);	//(键,值,缓存时间分钟数)
	```
	* add('key',  $value, $minutes)
	```php
	//添加缓存会判断键名是否已存在，有返回值,当键名已存在是返回false，不存在时返回true
	Cache::add('key',  $value, $minutes);	//(键,值,缓存时间分钟数)
	```
	* forever('key', $value)
	```php
	//添加缓存，永久保存
	Cache::forever('key', $value);	//(键,值)
	```
	* has('key')
	```php
	//存在时返回true，不存在返回false
	Cache::has('key');	//(键)
	```
	* get('key', 'default')
	```php
	//获取缓存内容
	Cache::get('key', 'default');	//(键,默认值)
	```
	* Cache::pull('key')
	```php
	//取出后删除
	Cache::pull('key');	//(键)
	```
	* Cache::forget('key');
	```php
	//存在时删除缓存返回true，不存在时返回false
	Cache::forget('key');	//(键)
	```
### Debug模式
* 配置目录config/app(调用.env文件配置默认为`APP_DEBUG=true`)
	* 关闭后只会出现以下信息<br>
	![](https://github.com/FYKANG/owner/raw/master/githubIMG/laravelDebug.png)
## 2017/07/10
### HTTP错误
* abort
	```php
	//抛出异常,抛出到模板503中，路径为`./resources/views/errors/503.blade.php`(可以在当前目录自定义模板)
	abort('503');
	```
* 404错误自动抛出
	* `./resources/views/errors/503.blade.php`中创建`404.blade.php`
### 日志
* 日志模式有
	* single —— 将日志记录到单个文件中。该日志处理器对应Monolog的StreamHandler。
	* daily —— 以日期为单位将日志进行归档，每天创建一个新的日志文件记录日志。该日志处理器 对应Monolog的RotatingFileHandler。
	* syslog —— 将日志记录到syslog中。该日志处理器 对应Monolog的SyslogHandler。
	* errorlog —— 将日志记录到PHP的error_log中。该日志处理器 对应Monolog的ErrorLogHandler。
* 错误级别以及基础使用
	```php
	Log::emergency($error);     //紧急状况，比如系统挂掉
	Log::alert($error);     //需要立即采取行动的问题，比如整站宕掉，数据库异常等，这种状况应该通过短信提醒 
	Log::critical($error);     //严重问题，比如：应用组件无效，意料之外的异常
	Log::error($error);     //运行时错误，不需要立即处理但需要被记录和监控
	Log::warning($error);    //警告但不是错误，比如使用了被废弃的API
	Log::notice($error);     //普通但值得注意的事件
	Log::info($error);     //感兴趣的事件，比如登录、退出
	Log::debug($error);     //详细的调试信息
	```
* 命名空间
	* `use Illuminate\Support\Facades\Log;`
* 日志配置
	* 在./.env中配置(如调用daily模式)
	```php
	APP_LOG=daily
	```
* 查看错误日志
	* 位于`./storage/logs`中
## 2017/07/11
### 关于使用composer遇到的问题
* 更改镜像 
	* 全局更改`composer config -g repositories.packagist composer http://packagist.phpcomposer.com`
	* 项目内更改
		```json
		"repositories": [
        	{"type": "composer", "url": "http://packagist.phpcomposer.com"},
        	{"packagist": false}
    	]
		```
* 更改镜像后无法正常使用提示` Your configuration does not allow connection to http://packagist.phpcompose  r.com. See https://getcomposer.org/doc/06-config.md#secure-http for details.`
	* 错误原因：原地址是需要https，改用镜像后使用的是http
	* 解决方法
		* 方法一
			```json
	  		"config": {  
        		"secure-http": false  
    		} 
			```
		* 方法二
			* 全局设置：
			`composer config -g secure-http false`
## 2017/07/12
### easywechat的使用
* `https://github.com/overtrue/laravel-wechat`
* 遇到的问题
	* 配置如果使用.env方式配置请对应好相关字段
		```
		WECHAT_APPID=开发者ID(AppID)
		WECHAT_SECRET=开发者密码(AppSecret)
		WECHAT_TOKEN=令牌(Token)
		WECHAT_AES_KEY=消息加解密密钥(EncodingAESKey)

		WECHAT_LOG_LEVEL=
		WECHAT_LOG_FILE=

		WECHAT_OAUTH_SCOPES=用户信息机制选择
		WECHAT_OAUTH_CALLBACK=授权回调页面域名

		WECHAT_PAYMENT_MERCHANT_ID=
		WECHAT_PAYMENT_KEY=
		WECHAT_PAYMENT_CERT_PATH=
		WECHAT_PAYMENT_KEY_PATH=
		WECHAT_PAYMENT_DEVICE_INFO=
		WECHAT_PAYMENT_SUB_APP_ID=
		WECHAT_PAYMENT_SUB_MERCHANT_ID=
		WECHAT_ENABLE_MOCK=	
		```
	* 注意微信开发者的url配置为能访问到wechat控制器的路由
	* 在 CSRF 中间件里排除微信相关的路由
		* 具体方法：在./app/Http/Middleware/VerifyCsrfToken.php中的$except添加代码
			```php
			protected $except = [
    			'wechat'
   			 ];
			```
	* 直接访问`http://域名/public/wechat`会出现`BadRequestException in Guard.php line 343:Invalid request.`提示功能在微信端进行回复测试功能正常。目前尚未知原因。
	* 使用中间件的时候用户信息机制选择无法通过`.env`直接配置
		* 方案一:清除缓存
			```
			php artisan config:cache
			```
		* 方案二：直接在路由中配置
			```php
			Route::group(['middleware' => ['web', 'wechat.oauth:snsapi_userinfo']], function () {
			});
			```
	* 别把推送写在配置的url中，监听会导致推送一直重复执行
	* 添加和修改自定义菜单有一定的延迟，可以取消关注后重新关注就能马上看到效果了
## 2017/07/13
### 关于Simple QrCode
* 以下是官方描述
	![](https://github.com/FYKANG/owner/raw/master/githubIMG/qr.png)
	![](https://github.com/FYKANG/owner/raw/master/githubIMG/qrE.png)
	![](https://github.com/FYKANG/owner/raw/master/githubIMG/qrC.png)
* 在实践测试中发现如果不手动添加`errorCorrection('H')`容错率并不能达到H等级，会出现添加logo后无法识别的情况。
## 2017/07/19
### 关于调用easywechat的jssdk模块
* 示例
	```php
	<script type="text/javascript" charset="utf-8">
	    wx.config(<?php echo app('wechat')->js
	    		->config(array(	'chooseImage',
	    				'previewImage',  
	                    		'uploadImage',  
	                    		'downloadImage',
	                    		), true) ?>);
	</script>
	```
* 注意使用laravel的view传入$js的对象无法正常调用模块需。
## 2017/07/29
### 修改http为https
* 证书申请：可以在阿里云申请
* 安装opensll以及mod_ssl模块`yum install openssl mod_ssl -y`
* 修改配置（以Apache为例以下的[apache]为Apache的安装根目录）
	* 添加httpd.conf配置:[apache]/conf/httpd.conf目录下查询以下语句，将前面的#号注释去掉，如果没有则直接添加。注意第二条语句部分配置并不需要。
	```conf
	#LoadModule ssl_module modules/mod_ssl.so
	#Include conf/extra/httpd-ssl.conf
	```
	* 添加ssl.conf配置：[apache]conf/extra/httpd-ssl.conf 文件 (也可能是[apache]conf.d/ssl.conf，与操作系统及安装方式有关）
	```
	# 添加 SSL 协议支持协议，去掉不安全的协议
	SSLProtocol all -SSLv2 -SSLv3
	# 修改加密套件如下，如果该属性开头有 '#'字符，请删除掉
	SSLCipherSuite HIGH:!RC4:!MD5:!aNULL:!eNULL:!NULL:!DH:!EDH:!EXP:+MEDIUM
	SSLHonorCipherOrder on
	# 证书公钥配置(cert/ssl.key根据证书存放位置做出相应改变)
	SSLCertificateFile cert/public.pem
	# 证书私钥配置(cert/ssl.key根据证书存放位置做出相应改变)
	SSLCertificateKeyFile cert/ssl.key
	# 证书链配置，如果该属性开头有 '#'字符，请删除掉(cert/chain.pem根据证书存放位置做出相应改变)
	SSLCertificateChainFile cert/chain.pem
	```
	* 打开443端口：修改apache配置`listen 443`，如果使用了阿里云服务器可进入控制台的安全组添加443端口，在apache处修改可能会报错
* 以上就是https的设置过程
## 2017/07/31
### 引入自定义类
* 在app/Classes创建目录
* 创建自定义类如：
	```php
	<?php  
		namespace App\Classes;

		/**
		* 
		*/
		class ClassA 
		{

			public function testclass()
			{
				echo "自定义类成功加入";
			}
		}
	```
* 在需要引入的控制器中添加
	```php
	use App\Classes\ClassA;
	```
* 在方法中使用
	```php
	$clssA=new ClassA();
	$testclass=$clssA->testclass();
	```
* 修改composer设置，添加自定义类的路径
	```json
	"autoload": {
		"classmap": [
		    "database",
		    "app/Classes"
		],
		"psr-4": {
		    "App\\": "app/"
		}
	    },
	```
* 更新composer
	```
	composer dump-autoload
	```
## 2017/08/07
### 关于自定义常量
* 新建`config/constants.php`
* 在文件中加入以下代码
	```php
	<?php  

	return [

	'DEFINE' => 'define_ok',
	
	];	
	```
* 调用时使用以下代码
	```php
	echo Config::get('constants.DEFINE');
	```
* 注意在服务器中使用的时候需要清理一下缓存
	```
	php artisan config:cache
	```

