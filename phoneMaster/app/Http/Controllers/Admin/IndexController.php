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

use App\VisitorRegistry;


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
                      
                      //获取视频名称                     
                      if($contents = Storage::disk('upload')->exists('/Temp/videoName.txt') ){

                       $contents = Storage::disk('upload')->get('/Temp/videoName.txt');
                       //清空缓存
                      Storage::disk('upload')->delete('/Temp/videoName.txt');  
                      }
                    
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
                   if (!empty($info['data'])) {
                      $infoData=$info['data'];
                   }else{
                     $infoData='';
                   }
                  $bool= contentModel::insertGetId(
                         ['content_title'=>$info['title'], 'content_class'=>$info['class'],
                          'content_data'=>$infoData , 'content_cover'=>$imagePath ,
                          'content_vedio'=>$contents    , 'content_status'=>1,
                          'content_abstract'=>$info['abstract'] ]
                     );
                      if ( !$bool) {
                         return back()->with('msg','上传失败，请联开发者。');
                           //return response()->json(array('status' =>0,'msg'=>"上传失败，请联开发者。"));
                     }else{
                              $data=contentModel::where('content_id',$bool)->first();         
                               return view('index/preview', ['data'=>$data]);
                      }        
      }

  }
  //分页
  public function pageShow(){

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
    $list = contentModel::where('content_class','1')->paginate(3);
    $total= contentModel::where('content_class','1')->count(); 
     return view('index.list', ['p'=>$list, 'total'=>$total,]);
  }

  //展示2016级
  public function show2016(){
    $list = contentModel::where('content_class','2')->paginate(3);
    $total= contentModel::where('content_class','2')->count(); 
     return view('index.list', ['p'=>$list, 'total'=>$total,]);
  }
  //展示201级
  public function show2017(){
    $list = contentModel::where('content_class','3')->paginate(3);
    $total= contentModel::where('content_class','3')->count(); 
     return view('index.list', ['p'=>$list, 'total'=>$total,]);
  }

  
  public function editList( Request $request){
    //接收url的参数
    $id=$request->route('id'); Session::push('content_Id',$id);
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
    
    $id= Session::get('content_Id');
     $contents = Storage::disk('upload')->get('/Temp/videoName.txt'); $vedioPath =$contents;    
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
                       return back()->with('msg','好像挂了,请联系开发者');
                    }
                } 
        }else{
                $info->content_cover=$request->input('picture');
        }    
                return back()->with('msg','修改成功!');            
     }else{
          return back()->with('msg','修改失败!，请联系开发者');
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

 //详情页
  public function dataShow(Request $request){
    $id=$request->route('id'); 
  //调用访问统计
    $visitors=Visitor::log($id); $n=new contentModel(); $v=$n->visitors();
    $info=contentModel::where('content_id',$id)->first(); $contentId=$info['content_id'];
  //将访问数存入content表
    $info->content_visitors=$visitors; $info->save();
 //封装返回详情页数据
     $data = array('data' => $info->content_data, 'videoUrl'=>$info->content_vedio,  'vs'=>$v,
     'content_id'=>$contentId);  
      
     return view('index/preview')->with('data',$data);

  }

  public function welcome(){
    return view('index/charts');
 }
 
 public function returnJson(){   

   //获得当前时间戳
    $t = time();
    $time= date("Y-m-d-H-i-s",$t);
    //1天前
   $time1=date("Y-m-d-H-i-s", strtotime("-1 day"));
    //2天前
   $time2=date("Y-m-d-H-i-s", strtotime("-2 day"));
     //3天前
   $time3=date("Y-m-d-H-i-s", strtotime("-3 day"));
     //4天前
   $time4=date("Y-m-d-H-i-s", strtotime("-4 day"));
     //5天前
   $time5=date("Y-m-d-H-i-s", strtotime("-5 day"));
     //6天前
   $time6=date("Y-m-d-H-i-s", strtotime("-6 day"));
     //7天前
   $time7=date("Y-m-d-H-i-s", strtotime("-7 day"));
    

    //=========== 1天前数据===============================================================================

    $visitors_I=contentModel::where('content_class',1)->whereBetween('updated_at', [$time1, $time] )->get();
    $visitors_II=contentModel::where('content_class',2)->whereBetween('updated_at', [$time1, $time] )->get();
    $visitors_III=contentModel::where('content_class',3)->whereBetween('updated_at', [$time1, $time] )->get();

    $vsI   = 0;
    $vsII  = 0;
    $vsIII = 0;

    foreach ($visitors_I as $key => $value) {
      $vsI= $value->content_visitors + $vsI; 
    }
    
     foreach ($visitors_II as $key => $value) {
      $vsII= $value->content_visitors + $vsII; 
    }

     foreach ($visitors_III as $key => $value) {
      $vsIII= $value->content_visitors + $vsIII; 
    }
    //=========================================================================================================


    //=========== 2天前数据===============================================================================

    $visitors_I_data2=contentModel::where('content_class',1)->whereBetween('updated_at', [$time2, $time1] )->get();
    $visitors_II_data2=contentModel::where('content_class',2)->whereBetween('updated_at', [$time2, $time1] )->get();
    $visitors_III_data2=contentModel::where('content_class',3)->whereBetween('updated_at', [$time2, $time1] )->get();

    $vsI_data2   = 0;
    $vsII_data2  = 0;
    $vsIII_data2 = 0;

    foreach ($visitors_I_data2 as $key => $value) {
      $vsI_data2= $value->content_visitors + $vsI_data2; 
    }
    
     foreach ($visitors_II_data2 as $key => $value) {
      $vsII_data2= $value->content_visitors + $vsII_data2; 
    }

     foreach ($visitors_III_data2 as $key => $value) {
      $vsIII_data2= $value->content_visitors + $vsIII_data2; 
    }
    //=========================================================================================================


    //=========== 3天前数据===============================================================================

    $visitors_I_data3=contentModel::where('content_class',1)->whereBetween('updated_at', [$time3, $time2] )->get();
    $visitors_II_data3=contentModel::where('content_class',2)->whereBetween('updated_at', [$time3, $time2] )->get();
    $visitors_III_data3=contentModel::where('content_class',3)->whereBetween('updated_at', [$time3, $time2] )->get();

    $vsI_data3   = 0;
    $vsII_data3  = 0;
    $vsIII_data3 = 0;

    foreach ($visitors_I_data3 as $key => $value) {
      $vsI_data3= $value->content_visitors + $vsI_data3; 
    }
    
     foreach ($visitors_II_data3 as $key => $value) {
      $vsII_data3= $value->content_visitors + $vsII_data3; 
    }

     foreach ($visitors_III_data3 as $key => $value) {
      $vsIII_data3= $value->content_visitors + $vsIII_data3; 
    }
    //=========================================================================================================

    //=========== 4天前数据===============================================================================

    $visitors_I_data4=contentModel::where('content_class',1)->whereBetween('updated_at', [$time4, $time3] )->get();
    $visitors_II_data4=contentModel::where('content_class',2)->whereBetween('updated_at', [$time4, $time3] )->get();
    $visitors_III_data4=contentModel::where('content_class',3)->whereBetween('updated_at', [$time4, $time3] )->get();

    $vsI_data4   = 0;
    $vsII_data4  = 0;
    $vsIII_data4 = 0;

    foreach ($visitors_I_data4 as $key => $value) {
      $vsI_data4= $value->content_visitors + $vsI_data4; 
    }
    
     foreach ($visitors_II_data4 as $key => $value) {
      $vsII_data4= $value->content_visitors + $vsII_data4; 
    }

     foreach ($visitors_III_data4 as $key => $value) {
      $vsIII_data4= $value->content_visitors + $vsIII_data4; 
    }
    //=========================================================================================================


     //=========== 5天前数据===============================================================================

    $visitors_I_data5=contentModel::where('content_class',1)->whereBetween('updated_at', [$time5, $time4] )->get();
    $visitors_II_data5=contentModel::where('content_class',2)->whereBetween('updated_at', [$time5, $time4] )->get();
    $visitors_III_data5=contentModel::where('content_class',3)->whereBetween('updated_at', [$time5, $time4] )->get();

    $vsI_data5   = 0;
    $vsII_data5  = 0;
    $vsIII_data5 = 0;

    foreach ($visitors_I_data5 as $key => $value) {
      $vsI_data5= $value->content_visitors + $vsI_data5; 
    }
    
     foreach ($visitors_II_data5 as $key => $value) {
      $vsII_data5= $value->content_visitors + $vsII_data5; 
    }

     foreach ($visitors_III_data5 as $key => $value) {
      $vsIII_data5= $value->content_visitors + $vsIII_data5; 
    }
    //=========================================================================================================

     //=========== 6天前数据===============================================================================

    $visitors_I_data6=contentModel::where('content_class',1)->whereBetween('updated_at', [$time6, $time5] )->get();
    $visitors_II_data6=contentModel::where('content_class',2)->whereBetween('updated_at', [$time6, $time5] )->get();
    $visitors_III_data6=contentModel::where('content_class',3)->whereBetween('updated_at', [$time6, $time5] )->get();

    $vsI_data6   = 0;
    $vsII_data6  = 0;
    $vsIII_data6 = 0;

    foreach ($visitors_I_data6 as $key => $value) {
      $vsI_data6= $value->content_visitors + $vsI_data6; 
    }
    
     foreach ($visitors_II_data6 as $key => $value) {
      $vsII_data6= $value->content_visitors + $vsII_data6; 
    }

     foreach ($visitors_III_data6 as $key => $value) {
      $vsIII_data6= $value->content_visitors + $vsIII_data6; 
    }
    //=========================================================================================================

     //=========== 7天前数据===============================================================================

    $visitors_I_data7=contentModel::where('content_class',1)->whereBetween('updated_at', [$time7, $time6] )->get();
    $visitors_II_data7=contentModel::where('content_class',2)->whereBetween('updated_at', [$time7, $time6] )->get();
    $visitors_III_data7=contentModel::where('content_class',3)->whereBetween('updated_at', [$time7, $time6] )->get();

    $vsI_data7   = 0;
    $vsII_data7  = 0;
    $vsIII_data7 = 0;

    foreach ($visitors_I_data7 as $key => $value) {
      $vsI_data7= $value->content_visitors + $vsI_data7; 
    }
    
     foreach ($visitors_II_data7 as $key => $value) {
      $vsII_data7= $value->content_visitors + $vsII_data7; 
    }

     foreach ($visitors_III_data7 as $key => $value) {
      $vsIII_data7= $value->content_visitors + $vsIII_data7; 
    }
    //=========================================================================================================
    
    $data = array(
      'date_1'=>array('vsI' =>$vsI , 'vsII'=>$vsII, 'vsIII'=>$vsIII ),
      'date_2'=>array('vsI' =>$vsI_data2 , 'vsII'=>$vsII_data2, 'vsIII'=>$vsIII_data2 ),
      'date_3'=>array('vsI' =>$vsI_data3 , 'vsII'=>$vsII_data3, 'vsIII'=>$vsIII_data3 ),
      'date_4'=>array('vsI' =>$vsI_data4 , 'vsII'=>$vsII_data4, 'vsIII'=>$vsIII_data4 ),
      'date_5'=>array('vsI' =>$vsI_data5 , 'vsII'=>$vsII_data5, 'vsIII'=>$vsIII_data5 ),
      'date_6'=>array('vsI' =>$vsI_data6,  'vsII'=>$vsII_data6, 'vsIII'=>$vsIII_data6 ),
      'date_7'=>array('vsI' =>$vsI_data7 , 'vsII'=>$vsII_data7, 'vsIII'=>$vsIII_data7 ),
      'msg'=>'数据载入失败' );

     return response()->json($data);
     

 }

  public function showVisitor(){
   

     Visitor::log(84);
     $visitors= contentModel::


     dd($visitors);
  }
  

 

}
