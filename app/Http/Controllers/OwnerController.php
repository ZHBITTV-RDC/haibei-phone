<?php

namespace App\Http\Controllers;	
use Config;
use App\Owner;			//MOdel的调用
use App\search;			//MOdel的调用
use App\user_info;		//MOdel的调用
use App\owner_info;		//MOdel的调用
use App\owner_qrcode;	//MOdel的调用
use App\move_owner;		//MOdel的调用
use Illuminate\Support\Facades\DB;	//查询构造器的调用
use Illuminate\Http\Request; 	//调用Request
use Illuminate\Support\Facades\Session;	//调用Session模型
use Illuminate\Support\Facades\Cache;	//调用缓存
use Illuminate\Support\Facades\Log; 	//调用错误日志
use EasyWeChat\Foundation\Application;	//实例化easywechat
use Overtrue\LaravelWechat\Events\WeChatUserAuthorized;	//wechat授权
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Redirect;	//调用redirect类		
use EasyWeChat\Broadcast\Broadcast;	//调用Broadcast
use App\Http\Requests\fromRequest;	//from表单验证




class OwnerController extends Controller
{
    public function mysql(Request $request,Application $wechat)
    {	

    	// $response = $auth->oauth->scopes(['snsapi_userinfo'])
     //                      ->setRequest($request)
     //                      ->redirect();
     //                      return $response;
    	// $user = session('wechat.oauth_user');
    	//获取easywechat二维码实例
    	$qrcode = $wechat->qrcode;

  //   	$result = $qrcode->forever(56);// 或者 $qrcode->forever("foo");
		// $ticket = $result->ticket; // 或者 $result['ticket']
		// $url = $result->url;
	   	
	   	// $result = $qrcode->temporary(time(), 10);
	   	// $ticket = $result->ticket;
	   	// $expireSeconds = $result->expire_seconds;
	  	$time=time();
	   	// $url=$qrcode->url($ticket);
	   	// dd($qrcode);
	   	for($i=1;$i<=10;$i++){

	   		$discerns[$i]=md5($time.$i.rand(1,999));
	   		$add=owner_qrcode::create(
    			[
    				'discern'=>$discerns[$i],
                    'kind'=>'qrcode',
    			]);
	   		$url='http://www.passowner.club/owner/public/from?discern='.$discerns[$i];
	   		QrCode::format('png')->size(300)->errorCorrection('Q')->merge('/public/qrcodes/log.png',.2)->generate($url,'../public/qrcodes/'.$discerns[$i].'.png');
	   	}
	  	
	    return view('owner.mysql',
	    		[
	    			'discerns'=>$discerns,
                    
	    		]);


    }


    //微信二维码

    public function getWechatQrcode(Application $wechat){
        $public=public_path();
        $time=time();
        $qrcode = $wechat->qrcode;
        for($i=1;$i<=10;$i++){
        $discerns[$i]=md5($time.$i.rand(1,999));
        $result = $qrcode->temporary($discerns[$i], 6 * 24 * 3600);
        $ticket = $result->ticket;// 或者 $result['ticket']
        $url = $qrcode->url($ticket);
        $content = file_get_contents($url);
        file_put_contents($public.'/wechatqrcode'.'/'.$discerns[$i].'.jpg',$content);

        $add=owner_qrcode::create(
                [
                    'discern'=>$discerns[$i],
                    'kind'=>'wechat',
                ]);  
        }
       
    }
    //模板回复
    public function notice(Request $request,Application $wechat){
    
        $notice = $wechat->notice;
 
         $userId = 'oLiRv1HwbBzQL5NHNr3VB8Ru-1uA';
                            $templateId = '5efyr7xL256QR-5LBJQDiavtcVpImq1mKYXeBIJHTO0';
                            $url = route('person');
                            $data = array(
                                     "first"  => "谢谢你的热心帮助！",
                                     "name"   => 'test',
                                     "wechat"  => 'test',
                                     "phone" => 'test',
                                     "remark" =>'test',
                                    );
                            $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();

    }
    public function test(){

 		$user = session('wechat.oauth_user');

	    return view('owner.test',[
	    	'user'=> $user,
	    	]);    	
    }




    public function session(Request $request){
    	//获取缓存内容
		//Cache::get('key', 'default');	//(键,默认值)

		//取出后删除
		//Cache::pull('key');	//(键)

		//存在时删除缓存返回true，不存在时返回false
		//Cache::forget('key');	//(键)
    }

    //寻物信息页面
    public function serach_message(Request $request,Application $wechat){

    	$discern=$request->all();
		$mgs=owner_info::where('discern','=',$discern)->first();

 	//  	$time=date("Y-m-d H:i:s",time());
 	// 	$openId=$owner->opid;
 	// 	$name=$owner->name;
 	// 	$openId1='123123okl';
 	// 	$message=$time.'-'.$name.'被扫描';
 	// 	$messageType = Broadcast::MSG_TYPE_TEXT;
		// $broadcast = $wechat->broadcast;
		// $broadcast->send($messageType, $message, [$openId, $openId1]);	

        
    	
    	if($mgs->statu!=1){
    		$mgs->name='未公开';
    		$mgs->phone='未公开';
    		$mgs->wechat='未公开';
    		$mgs->message='未公开';
    		$mgs->img='null';
    		$mgs->img2='null';
    	}
    	
    	return view('owner.owner_message',
    		[
    			'name'=>$mgs->name,
    			'phone'=>$mgs->phone,
    			'wechat'=>$mgs->wechat, 
    			'message'=>$mgs->message,
    			'img'=>$mgs->img,
    			'img2'=>$mgs->img2
    		]);
    }

    //个人页面
    public function person(){
    	$user = session('wechat.oauth_user');
    	$Nickname=$user->getNickname();
    	$Avatar=$user->getAvatar();//头像地址
    	$opid=$user->getId();
    	$owners=owner_info::where('opid','=',$opid)->get();

  
    	return view('owner.person',
    		[
    			'Nickname'=>$Nickname,
    			'Avatar'=>$Avatar,
    			'owners'=>$owners,
    		
    		]);
    }





    //表单
    public function from(Request $request,Application $wechat){
    	//获取get信息
    	$mgs=$request->input('discern');
    	//对比数据库
 		$discern=owner_qrcode::where('discern','=',$mgs)->first();
 		if($discern==null){
 			echo "无效二维码";
 		}
 		elseif($request->method()=='GET'&&$discern->statu==0&&$mgs!=null){
 			$user = session('wechat.oauth_user');
 			$js= $wechat->js;
    		return view('owner.from',
    			[	
    				'opid'=>$user->getId(),
    				'nickname'=>$user->getNickname(),
    				'js'=>$js,
    				'discern'=>$mgs,

    			]);
 		}else{

 	
		$owner=owner_info::where('discern','=',$mgs)->first();
 	 	$time=date("Y-m-d H:i:s",time());
 		$openId=$owner->opid;
 		$name=$owner->name;
 		$openId1='123123okl';
 		$message=$time.'-'.$name.'被扫描';
 		$messageType = Broadcast::MSG_TYPE_TEXT;
		$broadcast = $wechat->broadcast;
		$broadcast->send($messageType, $message, [$openId, $openId1]);	

 			return Redirect::route('serach_message',array('discern'=>$mgs));
 		}
 	
    }

    //上传表单
    public function fromsave(fromRequest $request,Application $wechat){
    	//数据验证
    // 	$this->validate($request,[
 			// 	//字段的规则设定
 			// 	'wechat'=>'required',
 			// 	'phone'=>'required|digits:11',
 			// 	'name'=>'required|max:11',
 			// 	'message'=>'required|min:1|max:200',
 			// ],[
 			// //错误信息的提示设置
 			// 	'required'=>':attribute 必填',
 			// 	'integer'=>':attribute 数字',
 			// 	'max'=>':attribute 超过最大限制',
 			// 	'min'=>':attribute 未达到最小要求',
 			// ],[
 			// //错误字段的名称设置
 			// 	'wechat'=>'微信',
 			// 	'phone'=>'手机',
 			// 	'name'=>'名称',
 			// 	'message'=>'留言',
 			// ]);
    	//获取表单数据
    	$mgs=$request->all();
    	//easywechat微信素材的实例化
    	$temporary = $wechat->material_temporary;
    	//获取public的绝对地址
    	$path = public_path();
    	//时间戳的处理
    	$time=date("Y-m-d H:i:s",time());

    	//下载素材
    	if(array_key_exists('media_id',$mgs)){
    		if(count($mgs['media_id'])!=2){
    			foreach ($mgs['media_id'] as $key => $value) {
    				if($key==0){
    					$mgs['media_id'][1]='null';
    					$temporary->download($mgs['media_id'][0], "$path/img/", $time.$mgs['media_id'][0]);
    					$mgs['media_id'][0]=$time.$mgs['media_id'][0];
    				}else{
    					$mgs['media_id'][0]='null';
    					$temporary->download($mgs['media_id'][1], "$path/img/", $time.$mgs['media_id'][1]);
    					$mgs['media_id'][1]=$time.$mgs['media_id'][1];
    				}		
    			}
    		}else{
    			
    			$temporary->download($mgs['media_id'][0], "$path/img/", $time.$mgs['media_id'][0]);
    			$temporary->download($mgs['media_id'][1], "$path/img/", $time.$mgs['media_id'][1]);
    			$mgs['media_id'][0]=$time.$mgs['media_id'][0];
    			$mgs['media_id'][1]=$time.$mgs['media_id'][1];
    		}
    	
    	}else{
    		$mgs['media_id'][0]='null';
    		$mgs['media_id'][1]='null';
    	}

    	

    	//使用create方法新增数据
    	$workout=owner_info::create(
    		[	'opid'=>$mgs['opid'],
    			'nickname'=>$mgs['nickname'],
    			'name'=>$mgs['name'],
    			'wechat'=>$mgs['wechat'],
    			'discern'=>$mgs['discern'],
    			'phone'=>$mgs['phone'],
    			'phone_date'=>$mgs['phone_date'],
    			'message'=>$mgs['message'],
    			'statu'=>$mgs['radio1'],
    			'img'=>$mgs['media_id'][0],
    			'img2'=>$mgs['media_id'][1],

    		]);
    	//修改二维码状态
    	$qrcode=owner_qrcode::where('discern','=',$mgs['discern'])->first();
    	$qrcode->statu=$mgs['radio1'];
    	if($bool=$qrcode->save()&&$workout!=null){
    		return Redirect::route('showInfo');
    	}
    }


    //更新数据表单
    public function fromchange(Request $request,Application $wechat){
    	$js= $wechat->js;
    	$discern=$request->all();
    	$mgs=owner_info::where('discern','=',$discern)->first();
    	return view('owner.fromchange',
    			[
    				'name'=>$mgs->name,
    				'phone'=>$mgs->phone,
    				'wechat'=>$mgs->wechat, 
    				'message'=>$mgs->message,
    				'img'=>$mgs->img,
    				'img2'=>$mgs->img2,
    				'opid'=>$mgs->opid,
    				'discern'=>$mgs->discern,
    				'js'=>$js,
    				'statu'=>$mgs->statu,

    			]);
    }   

    //更新数据
    public function fromchangesave(fromRequest $request,Application $wechat){

    	//获取表单数据
    	$mgs=$request->all();
    	//easywechat微信素材的实例化
    	$temporary = $wechat->material_temporary;
    	//获取public的绝对地址
    	$path = public_path();
    	//时间戳的处理
    	$time=date("Y-m-d H:i:s",time());
    	//批量更新
    	$update=owner_info::where('discern','=',$mgs['discern'])->first();
    	$update->update(
	    		[
	    			'name'=>$mgs['name'],
	    			'wechat'=>$mgs['wechat'],
	    			'discern'=>$mgs['discern'],
	    			'phone'=>$mgs['phone'],
	    			'phone_date'=>$mgs['phone_date'],
	    			'message'=>$mgs['message'],
	    			'statu'=>$mgs['radio1'],
	    		]);//返回被修改的条数
    	if(array_key_exists('media_id',$mgs)){
    			if(count($mgs['media_id'])!=2){
    			foreach ($mgs['media_id'] as $key => $value) {
    				if($key==0){
    					$mgs['media_id'][1]='null';
    					$temporary->download($mgs['media_id'][0], "$path/img/", $time.$mgs['media_id'][0]);
    					$mgs['media_id'][0]=$time.$mgs['media_id'][0];
    					$update->update(
    						[
    							'img'=>$mgs['media_id'][0],
    						]);
    				}else{
    					$mgs['media_id'][0]='null';
    					$temporary->download($mgs['media_id'][1], "$path/img/", $time.$mgs['media_id'][1]);
    					$mgs['media_id'][1]=$time.$mgs['media_id'][1];
    					$update->update(
    						[
    							'img2'=>$mgs['media_id'][1],
    						]);
    				}		
    			}
    		}else{
    			
    			$temporary->download($mgs['media_id'][0], "$path/img/", $time.$mgs['media_id'][0]);
    			$temporary->download($mgs['media_id'][1], "$path/img/", $time.$mgs['media_id'][1]);
    			$mgs['media_id'][0]=$time.$mgs['media_id'][0];
    			$mgs['media_id'][1]=$time.$mgs['media_id'][1];
    			$update->update(
    						[
    							'img'=>$mgs['media_id'][0],
    							'img2'=>$mgs['media_id'][1],
    						]);
    		}
    	}

    	return Redirect::route('person');

    }


    //二维码展示
    public function showInfo(){

    	return view('owner.connection');

    }
    //解除绑定
    public function move(Request $request){

    	$discern=$request->all();
    	$mgs=owner_info::where('discern','=',$discern)->first();
    	$move=move_owner::create(
    		[
    			'opid'=>$mgs->opid,
    			'nickname'=>$mgs->nickname,
    			'name'=>$mgs->name,
    			'discern'=>$mgs->discern,
    		]);
    	$num=owner_info::destroy($mgs->id);
    	if($num>0){
    		return Redirect::route('person');
    	}else{
    		$erro="删除失败";
    		echo $erro;
    		Log::debug($error); 
    	}

    }
}