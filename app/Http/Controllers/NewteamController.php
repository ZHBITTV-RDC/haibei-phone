<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\lecture;
use App\web_bangding;
use App\Classes\ClassA;
use App\Classes\JwWechat;
use Redirect;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session; 

class NewteamController extends Controller
{
    //
     public function head(){

    	return view('newteam.head');
    }

    public function linkSchool(Request $request){

      

        // $clssA=new ClassA();
        // $clssA=$clssA->testclass();
        //对比opid是否绑定入库
        // $workout=web_bangding::where('id','=',$useropid)->get();
        // if($workout->isEmpty()){

        // }

        return view('newteam.linkSchool');

    }

    public function linkId(Request $request){

        $user=session('wechat.oauth_user'); // 拿到授权用户资料
        $useropid=$user->getId();
        $date['jwid']=$request->input('jwid');
        $date['jwpwd']=$request->input('jwpwd');//密码
        $date['openid']=$useropid;

        $JwWechat=new JwWechat();
        $bangding=$JwWechat->bangding($date);

        if($bangding==1){
            echo "已绑定";
           return Redirect::route('head');
        }
        else{

            if ($bangding==2) {
                echo "绑定成功";
            }
            else{
                echo "账号或密码错误";
            }
        }
            
            

    }

    public function levelE(Request $request){


        if($request->isMethod('post')){
                 
            $name=$request->input('name');
            $id=$request->input('id');
            $select=$request->input('select');


            $ks_data= array(
            "ks_xm"=> $name,
            "ks_sfz"=> $id,
            "jb"=> $select
            );

            $postdata = array(
            "action"=> "",
            "params"=> json_encode($ks_data)
            );
             

        $url='http://app.cet.edu.cn:7066/baas/app/setuser.do?method=UserVerify';

       //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($curl,CURLOPT_REFERER,"http://app.cet.edu.cn:7066/baas/app/setuser.do?method=UserVerify");
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据

        $obj=json_decode($data);
   
        //设置空数组接收对象
        $result=array();
        $i=0;
        foreach ($obj as $key => $value) {
            $result[$i]=$value;
             $i++;
        }


            return view('newteam.workout',
                [   
                    'name'=>$name,
                    'zkz'=>$result[0],

                ]);
           
        }else{
            return view('newteam.cx');
        }




   
       //  $url='http://app.cet.edu.cn:7066/baas/app/setuser.do?method=UserVerify';

       // //初始化
       //  $curl = curl_init();
       //  //设置抓取的url
       //  curl_setopt($curl, CURLOPT_URL, $url);
       //  //设置头文件的信息作为数据流输出
       //  curl_setopt($curl, CURLOPT_HEADER, 0);
       //  //设置获取的信息以文件流的形式返回，而不是直接输出。
       //  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
       //  //设置post方式提交
       //  curl_setopt($curl, CURLOPT_POST, 1);
       //  //设置post数据
       //  curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
       //  curl_setopt($curl,CURLOPT_REFERER,"http://app.cet.edu.cn:7066/baas/app/setuser.do?method=UserVerify");
       //  //执行命令
       //  $data = curl_exec($curl);
       //  //关闭URL请求
       //  curl_close($curl);
       //  //显示获得的数据
       //  // json_decode($data);
       //  $obj=json_decode($data);
       //  // var_dump($obj);
       //  // // echo $obj->$ks_bh;
       //  // // //设置空数组接收对象
       //  // // $result=array();
       //  // //  $i=0;

       //  foreach ($obj as $key => $value) {
       //      $result[$i]=$value;
       //       $i++;
       //  }

        
        
    }



    public function application_One(Request $request){
        $select=$request->input('select');
        if($select!=null){
            if ($select=='getGrade') {
                return Redirect::route('getGrade');
            }
            else{
                echo "getGradeTime";
            }
        }else{
            return view('newteam.application_One');
        }

    	
    }

    public function getGrade(){

        $user = session('wechat.oauth_user'); // 拿到授权用户资料
        $openid=$user->getId();

        $JwWechat=new JwWechat();
        

        $userMessage=web_bangding::where('opid','=',$openid)->get()->first();

        if($userMessage){

            $school_id=$userMessage->school_id;
            $school_pass=$userMessage->school_pass;
            echo $school_id;
            echo $school_pass;
            $getGrade=$JwWechat->getGrade($school_id,$school_pass);

            
           var_dump($getGrade);

           
            

        }else{
            return back()->with('workout','请进行绑定');
        }

    }

    public function application_Two(){


        // $work=lecture::find(1);

        $user = session('wechat.oauth_user'); // 拿到授权用户资料
        $user =$user->getId();

        return view('newteam.application_Two',[
                    'user'=>$user
                ]);

    	

    }

    public function lecture(Request $request)
    {
        $user = session('wechat.oauth_user'); // 拿到授权用户资料
        $openid=$user->getId();
        $web_bangding=web_bangding::where('opid','=',$openid)->get()->first();
        if($web_bangding){

            $lecture=lecture::where('StudentNO','=',$web_bangding->school_id)->get();
            dd($lecture);

        }else{
            return back()->with('workout','请进行绑定');
        }
    }



    public function application_Three(){

    	return view('newteam.application_Three');
    	
    }

    public function application_Four(){

    	return view('newteam.application_Four');
    	
    }

   
}
