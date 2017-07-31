<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\lecture;
use App\web_bangding;
use App\Classes\ClassA;

class NewteamController extends Controller
{
    //
     public function head(){

    	return view('newteam.head');
    }

    public function linkSchool(){

        $user = session('wechat.oauth_user'); // 拿到授权用户资料
        $useropid =$user->getId();
        $clssA=new ClassA();
        $clssA=$clssA->testclass();
        //对比opid是否绑定入库
        // $workout=web_bangding::where('id','=',$useropid)->get();
        // if($workout->isEmpty()){

        // }

        // return view('newteam.linkSchool');

    }

    public function application_One(){

    	return view('newteam.application_One');
    }

    public function application_Two(){


        // $work=lecture::find(1);

        $user = session('wechat.oauth_user'); // 拿到授权用户资料
        $user =$user->getId();

        return view('newteam.application_Two',[
                    'user'=>$user
                ]);

    	

    }

    public function application_Three(){

    	return view('newteam.application_Three');
    	
    }

    public function application_Four(){

    	return view('newteam.application_Four');
    	
    }

   
}
