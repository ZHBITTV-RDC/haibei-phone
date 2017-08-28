<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CheckValRequest;
use App\Http\Requests\cgpwRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use Session;
use DB;
use App\adminModel;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class loginController extends Controller
{
    
    public function index(){
        return view('./loginView/login');
    }

   //实现登录
    public function login( CheckValRequest $request ){
       //获取输入信息
        $info=$request->input();
       
       //封装输入信息
        $data=['name'=>$info['adminName'], 'pwd'=>$info['adminPassword'] ,'captcha'=>$info['captcha']];
       
       //验证验证码
        
        if (Session::get('milkcaptcha')!=$data['captcha']) {
          
          //返回当前页面，通过session 传回参数msg。
             return back()->with('msg','验证码错误');  
        }else{

             //验证账户密码
            if ( $Admin = adminModel::where( 'Admin_Name',$data['name'] )->first() ) {                 
                     $pwd=$Admin->Admin_password;
                       try{
                           $decrypted = Crypt::decrypt($pwd);
                        } catch (DecryptException $e) {
                             return back()->with('msg','系统错误请联系管理员'); 
                          }

                  if ( $decrypted == $data['pwd']){
                    Session::push('adminName', $data['name']);
                    Session::push('adminId', $Admin->Admin_id);
                     return  redirect('admin/index');    
                        
                  }else{
             
                       //return response()->json(['msg' => '用户名或者密码错误', 'status' => '0']);
                          //返回当前页面，通过session 传回参数msg。
                          return back()->with('msg','用户名或者密码错误');      
                   }
            }else{
                  //return response()->json(['msg' => '', 'status' => '0']);
                 //返回当前页面，通过session 传回参数msg。
                 return back()->with('msg','用户名不存在');  
             }
       
       }

    }


   //生成验证码
    public function captcha($temp){
       
      //建立验证码对象

      $build=new CaptchaBuilder;
      
      //创建验证码 设置长宽高
      $build->build($width = 130, $height = 50, $font = null);
      
      //获得验证码内容
      $phrase = $build->getPhrase();
     
      //把验证码内容存到Session 一次性数据
       Session::flash('milkcaptcha', $phrase);
      
       //输出验证码
       header('Content-type: image/jpeg');
       $build->output();

    }
    //退出
    public function outLine(){
      Session::forget('adminName');
       return redirect('admin/login');
    }

    public function changePwd(){
       return view('loginView/changePwd');
    }

    //修改密码
   public function change( cgpwRequest $request ){
       //获取输入信息 
        $info=$request->input();
       
       //封装输入信息
        $data=['password'=>$info['password'], 'newPassword'=>$info['newPassword'] ,'checkNewPassword'=>$info['checkNewPassword']];

        //获取当前用户信息
        $user=Session::get('adminName');
        $userId=Session::get('adminId');
        $userInfo= adminModel::where('Admin_Name',$user)->first();
        $pwd=$userInfo->Admin_password;

         try{
                $decrypted = Crypt::decrypt($pwd);
        } catch (DecryptException $e) {
                return back()->with('msg','系统错误请联系管理员'); 
          }
        
        if ($data['password']==$decrypted) {
          
           if ($data['newPassword']==$data['checkNewPassword']) {
               try{
                      $crypted = Crypt::encrypt($data['newPassword']);
                } catch (DecryptException $e) {
                     return back()->with('msg','系统错误请联系管理员'); 
                 }
                $post=adminModel::find($userId)->first();
                 $post->Admin_password=$crypted;
                  $bool=$post->save();                      
                if ($bool) {   
                  Session::forget('adminName'); 
                  return view('loginView/login');
                }else{
                   //return back()->with('msg','修改失败,请联系开发者');
                   var_dump($bool);
                }
           }else{
               return back()->with('msg','确认密码不一致');
           }
          
        }else{
          return back()->with('msg','原始密码错误');
        }

   }

}
