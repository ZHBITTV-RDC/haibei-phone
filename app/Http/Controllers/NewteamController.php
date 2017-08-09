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

    public function application_One(){

    	return view('newteam.application_One');
    }

    public function getGrade(){

        $user = session('wechat.oauth_user'); // 拿到授权用户资料
        $openid=$user->getId();

        $JwWechat=new JwWechat();
        

        $userMessage=web_bangding::where('opid','=',$openid)->get()->first();

        if($userMessage){

            $school_id=$userMessage->school_id;
            $school_pass=$userMessage->school_pass;
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
