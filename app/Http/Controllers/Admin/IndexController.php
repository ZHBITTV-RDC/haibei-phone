<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Session;

use Storage;

use App\ContentModel;

use DB;

use App\Http\Requests\checkFormRequest;

use Visitor;

class IndexController extends Controller
{
    public function adminindex(){
    	
    	 $adminName=Session::get('adminName');
    	  return view('index/index',compact('adminName'));
    	   Session::forget('adminName');
    	 
    }

    public function tableList() {
    	return view('index/list');
    }

    public function ListAdd() {
    	return view('index/add');
    }

   //写入新数据
   public function Add( checkFormRequest $request ){
     
    //判断是否为Post请求 
     if ($request->isMethod('POST')) {
      
              if (  $file = $request->file('picture') ) {
                
                    //判断是否上传成功
                if ($file->isValid()) {
                 //获取文件相关信息
                  $originaName = $file->getClientOriginalName(); //文件原名
                  $ext = $file-> getClientOriginalExtension();  //文件扩展名
                  $realPath = $file->getRealPath();      //临时文件的绝对路径
                  $type = $file -> getClientMimeType(); //文件类型          
           
                 $allowType= ['jpg','png','bmp','jpeg']; //允许上传文件类型  
                 //判断是否为图片
                   if (in_array($ext, $allowType) ) {               
                       //上传文件
                      $filename = date('Y-m-d-H-i-s').'-'.uniqid().'.'.$ext;  //拼接文件名
                      //使用新建立的uploads本次存储目
                      $bool= Storage::disk('uploads')->put($filename, file_get_contents($realPath));    
                      $imagePath = '/uploads/image/'.$filename;
                      $contents = Storage::disk('upload')->get('/Temp/videoName.txt');
                      $vedioPath ='/uploads/vedio/'.$contents;        
                   }else{                   
                       return back()->with('msg','视频封面请上传图片');
                        //return response()->json(array('status' =>0,'msg'=>"视频请上传图片"));
                    }
                } 

              }else{
                      return back()->with('msg','请上传视频封面');
                       //return response()->json(array('status' =>0,'msg'=>"请上传封面"));
               }
                   //写入表单数据
                  $info=$request->input();
                  $bool= contentModel::insert(
                         ['content_title'=>$info['title'], 'content_class'=>$info['class'],
                          'content_data'=>$info['data']  , 'content_cover'=>$imagePath ,
                          'content_vedio'=>$vedioPath    , 'content_status'=>1,
                          'content_abstract'=>$info['abstract'] ]
                     );
                      if ( !$bool) {
                         return back()->with('msg','上传失败，请联开发者。');
                           //return response()->json(array('status' =>0,'msg'=>"上传失败，请联开发者。"));
                     }else{
                           //return back()->with('msg','上传成功!');
                             //return response()->json(array('status' =>1, 'msg'=>"上传成功"));
                               return view('index/preview', ['data'=>$info]);
                      }        
      }

  }
  //分页
  public function pageShow(){
     $status=1;
     $list = contentModel::paginate(5);
      $total= contentModel::count();
      $data=[
          'total'=>$total,
           'p'=>$list,
      ] ;

      return view('index.list',$data);
     
  }
  //展示2015级
  public function show2015(){
    $list = contentModel::where('content_class','1')->paginate(5);
     $total= contentModel::where('content_class','1')->count();

      $data=[
          'total'=>$total,
           'p'=>$list,
      ] ;

     return view('index.list',$data);
  }

  //展示2016级
  public function show2016(){
    $list = contentModel::where('content_class','2')->paginate(5);
     $total= contentModel::where('content_class','2')->count();

      $data=[
          'total'=>$total,
           'p'=>$list,
      ] ;

     return view('index.list',$data);
  }
  //展示201级
  public function show2017(){
    $list = contentModel::where('content_class','2')->paginate(5);
     $total= contentModel::where('content_class','2')->count();

      $data=[
          'total'=>$total,
           'p'=>$list,
      ] ;

     return view('index.list',$data);
  }

  
  public function editList( Request $request){
    //接收url的参数
    $id=$request->route('id'); Session::push('contentId',$id);
     $info=contentModel::where('content_id',$id)->first();
     switch ($info->content_class) {
      case '1':
         $className="2015级视频";
         break;
      case '2':
        $className="2016级视频";
         break;
      case '3':
        $className="2017级视频";
         break;
     }
       $data=['title'=>$info->content_title,
               'data'=>$info->content_data,
               'class' =>$info->content_class,
               'className'=>$className,
               'cover'=>$info->content_cover,
               'abstract'=>$info->content_abstract
       ];
       return view('index/edit',$data);
 
  }

  public function edit( checkFormRequest $request){
    
    $id= Session::get('contentId');
     $contents = Storage::disk('upload')->get('/Temp/videoName.txt'); $vedioPath ='/uploads/vedio/'.$contents;    
       //更新数据
       $info = contentModel::find($id)->first();
       $info->content_title  = $request->input('title');
       $info->content_class = $request->input('class');
       $info->content_data  = $request->input('data');
       $info->content_abstract  = $request->input('abstract');
       $info->content_vedio = $vedioPath;
       $bool=$info->save();
        if ($bool) {

          if (  $file = $request->file('picture') ) {                
                //判断是否上传成功
                if ($file->isValid()) {
                 //获取文件相关信息
                  $originaName = $file->getClientOriginalName(); //文件原名
                  $ext = $file-> getClientOriginalExtension();  //文件扩展名
                  $realPath = $file->getRealPath();      //临时文件的绝对路径
                  $type = $file -> getClientMimeType(); //文件类型          
          
                  $allowType= ['jpg','png','bmp','jpeg']; //允许上传文件类型  
                 //判断是否为图片
                   if (in_array($ext, $allowType) ) {               
                       //上传文件
                      $filename = date('Y-m-d-H-i-s').'-'.uniqid().'.'.$ext;  //拼接文件名
                      //使用新建立的uploads本次存储目
                      $bool= Storage::disk('uploads')->put($filename, file_get_contents($realPath));    
                      $imagePath = '/uploads/image/'.$filename;  
                      //更新数据
                      $info->content_cover=$imagePath;
                      $bool=$info->save();
                   }else{                   
                       return back()->with('msg','视频封面请上传图片');
                        return response()->json(array('status' =>0,'msg'=>"视频封面请上传图片"));
                    }
                } 
        }else{
                $info->content_cover=$request->input('picture');
        }
                return back()->with('msg','修改成功!');
                 return response()->json(array('status' =>1,'msg'=>"修改成功"));

     }else{
          return back()->with('msg','修改失败!，请联系开发者');
           return response()->json(array('status' =>0,'msg'=>"修改失败，请联系开发者"));
      }



  }

  public function coverEdit(checkFormRequest $request){

       if (  $file = $request->file('picture') ) {
                
                //判断是否上传成功
                if ($file->isValid()) {
                 //获取文件相关信息
                  $originaName = $file->getClientOriginalName(); //文件原名
                  $ext = $file-> getClientOriginalExtension();  //文件扩展名
                  $realPath = $file->getRealPath();      //临时文件的绝对路径
                  $type = $file -> getClientMimeType(); //文件类型          
           
                 $allowType= ['jpg','png','bmp','jpeg']; //允许上传文件类型  
                 //判断是否为图片
                   if (in_array($ext, $allowType) ) {               
                       //上传文件
                      $filename = date('Y-m-d-H-i-s').'-'.uniqid().'.'.$ext;  //拼接文件名
                      //使用新建立的uploads本次存储目
                      $bool= Storage::disk('uploads')->put($filename, file_get_contents($realPath));    
                      $imagePath = '/uploads/image/'.$filename;  
                   }else{                   
                       return back()->with('msg','视频封面请上传图片');
                        return response()->json(array('status' =>0,'msg'=>"视频封面请上传图片"));
                    }
                } 
    
       }else{
            return back()->with('msg','您还没有上传封面');
            
             return response()->json(array('status' =>0,'msg'=>"您还没有上传封面"));

       }
       //更新数据
          $info->content_cover=$imagePath;

 }
 //数据删除 
 public function delete( Request $request ){
    
    $id=$request->input('id'); 
     if (!($bool = contentModel::where('content_id',$id)->delete()) ) {
        return response()->json(array('status' =>0,'msg' =>"删除失败"));
      }else{
           return response()->json(array('status' =>1,'msg'=>"删除成功"));
      }

 }
 /*批量删除*/
 public function datadel(Request $request ){
   //获取复选框数据
   $data=$request->input('id'); 
    $id=explode(",", $data);
  // Session::forget('id');
  // Session::push('id',$id);
    
    foreach ($id  as  $value) {
      $bool = contentModel::whereIn('content_id',$id)->delete();
     }
       if (!$bool ) {
        return response()->json(array('status' =>0,'msg' =>"删除失败"));
       }else{
           return response()->json(array('status' =>1,'msg'=>"删除成功"));
      }

 }

 public function test(Request $request){
   
  $info=$request->input();
   Session::push('$info',$info);
      return response()->json(array('status' =>1,'msg'=>"成功"));
 }

 
 public function check(Request $request){
   
   $info=Session::get('$info');
    $nm=Visitor::log();
    dd($nm);

 }

 
  //下架
  public function down(Request $request){
     
     $id=$request->input('id'); 
       $info=contentModel::find($id)->first();
        $info->content_status=0;
         $bool=$info->save();

     if (!$bool) {
        return response()->json(array('status' =>0,'msg' =>"操作失败"));
      
      }else{
           return response()->json(array('status' =>1,'msg'=>"已下架！"));
         
      }
  }

    //发布
  public function up(Request $request){
     
     $id=$request->input('id'); 
       $info=contentModel::find($id)->first();
        $info->content_status=1;
         $bool=$info->save();

     if (!$bool) {
        return response()->json(array('status' =>0,'msg' =>"操作失败"));
      
      }else{
           return response()->json(array('status' =>1,'msg'=>"已发布！"));
         
      }
  }

  public function dataShow(Request $request){
  $id=$request->route('id'); $nm=Visitor::log();
    $info=contentModel::where('content_id',$id)->first();
     $data = array('data' => $info->content_data, 'videoUrl'=>'/phoneMaster/public'.$info->content_vedio, 'nm'=>$nm);  
       return view('index/preview')->with('data',$data);

  }

  public function welcome(){
     return view('index/charts');
  }
 

}
