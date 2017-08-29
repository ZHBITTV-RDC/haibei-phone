<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\ContentModel;

class IndexController extends Controller
{
   //首页面
  public function index(){
    
    //获取数据
     $status=1;
     $list = contentModel::where('content_status',$status)->paginate(5);
     $total= contentModel::count();
     $data=[
          'total'=>$total,
           'p'=>$list,
      ] ;
      return view('haibei/head',$data);
    }
    
    

    //欢迎页面
   public function welcome(){
    	return view('haibei/index');
    }

    //详情页面

   public function data( Request $request ){
      $id=$request->route('id'); 
       $info= contentModel::where('content_id',$id)->first();
        return view('haibei/vedio',['data'=>$info]);
    }

 
}
