<?php

namespace App\Http\Controllers;	
use Config;
use App\Owner;		//MOdel的调用
use App\search;		//MOdel的调用
use Illuminate\Support\Facades\DB;	//查询构造器的调用
use Illuminate\Http\Request; 	//调用Request
use Illuminate\Support\Facades\Session;	//调用Session模型
use Illuminate\Support\Facades\Cache;	//调用缓存
use Illuminate\Support\Facades\Log; 	//调用错误日志
use EasyWeChat\Foundation\Application;	//实例化easywechat
use Overtrue\LaravelWechat\Events\WeChatUserAuthorized	//wechat授权
class OwnerController extends Controller
{
    public function mysql(Request $request,Application $wechat)
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


    		



    	//数据库的CURD操作

	    	//all()获取全部数据
	    	//$workout=search::all();

	    	//find()根据主键获取数据
	    	//$workout=search::find(1);

	    	//findOrFail()根据主键查找，如果没有此主键则报错
	    	//$workout=search::findOrFail(1);

	    	//查询构造器get()查询全部数据
	    	// $workout=search::get();

	    	 // $workout=search::where('id','>=','1')->get();
			

	    	/* chunk(num,function($workout){})
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

	    	// 向模板中传递数据
	    	// return view('owner/mysql',[
	    	// 	'workout'=>$workout
	    	// 	]);

	    	//响应json
	    	// $date=[
	    	// 	'err'=>'falut',
	    	// 	'errMgs'=>'su'

	    	// ];
	    	// return response()->json($date);

	    //重定向
	    	// return redirect('session');

	    	//附带信息(数据为暂存数据)
	    	// return redirect('session')->with('mgs','mgs');

	    	//action方法
	    	// return redirect()->action('OwnerController@session')->with('mgs','mgs');

	    	//route()方法使用别名
	    	// return redirect()->route('session')->with('mgs','mgs');

	    	//放回上一个页面
	    	// return require()->back();

	    	//键,值,缓存时间分钟数(不会判断键名是否已存在，无返回值,直接覆盖添加)
			//Cache::put('key', $value, $minutes);

	    	//键,值,缓存时间分钟数(会判断键名是否已存在，有返回值,当键名已存在是返回false，不存在时返回true)
			//Cache::add('key',  $value, $minutes);

			//添加缓存，永久保存
			//Cache::forever('key', $value);	//(键,值)

			//存在时返回true，不存在返回false
			//Cache::has('key');	//(键)
	    	
	    	// Log::info('info日志');

	    	$openId='oLiRv1HwbBzQL5NHNr3VB8Ru-1uA';
	    	$userService = $wechat->user;
	    	$user = $userService->get($openId);
			echo $user->nickname; // or $user['nickname']


	    	// return view('owner.from');


    }
    public function session(Request $request){
    	//获取缓存内容
		//Cache::get('key', 'default');	//(键,默认值)

		//取出后删除
		//Cache::pull('key');	//(键)

		//存在时删除缓存返回true，不存在时返回false
		//Cache::forget('key');	//(键)
    }

    public function from(Application $wechat){
 		
    	 $notice = $wechat->notice;


    $userId = 'oLiRv1HwbBzQL5NHNr3VB8Ru-1uA';
    $templateId = 'GlpcaxZK5rscHnXcNdtYE8rTAGwtbkWFuWr22_RTxS4';
    $url = route('mysql');
    $data = array(
         "first"  => "bilibili",
         "name"   => "b站",
         "addr"  => "https://www.baidu.com/",
         "time"	=>date('Y-m-d H:i:s', time()),
         "remark" => "welcome！",
        );
    $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
    var_dump($result);
    // {
    //      "errcode":0,
    //      "errmsg":"ok",
    //      "msgid":200228332
    //  }
    }

    public function fromsave(Request $request){
    	$mgs=$request->all();
    	// echo $mgs['test'];
    	// echo $mgs['test2'];
    	// $this->validate($request,[
    	// 		'test'=>'required|min:1|max:2',
    	// 		'test2'=>'required|integer',
    	// 	],[
    	// 		'required'=>':attribute 必填',
    	// 		'integer'=>':attribute 数字',
    	// 		'max'=>':attribute 最大为2位数',
    	// 		'min'=>':attribute 最小为1位数',
    	// 	],[
    	// 		'test'=>'测试1',
    	// 		'test2'=>'测试2'
    	// 	]);

    }

}