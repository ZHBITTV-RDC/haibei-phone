<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            html,body{
                height:100%;
                width:100%;
                padding:0;
                margin:0;
            }
            #preview{
                width:380px;
                height:600px;
                padding:0;
                margin:auto;
                margin-left: 500px;
                border: double;
                border-width: 2px;
                border-radius: 10px;
                border-color: blue;

            }

            #preview *{font-family:sans-serif;font-size:16px;}
        </style>
        <script type="text/javascript" src="../internal.js"></script>
        <script src="../../ueditor.parse.js"></script>
        <title></title>
    </head>
    <body class="view">
        <span>   这是在手机看到的效果哦，如果排版不太满意就好好修改下图片尺寸什么的~ </span> 
        <br>
         <span>浏览：</span>{{count($data['vs'])}}
       <a href="{{ URL('admin/editList') }}/{{ $data['content_id'] }}">点击编辑 </a>
       <br>
      
 <div style="width=100%">   
    <div id="preview">
              <?php 
              if(!empty($data['data'])){
                 echo $data['data'];
              }
             ?>
  
    <video width="100%" height="240px" controls="controls" >
        <source src="{{URL::asset('public/uploads/video')}}/{{$data['videoUrl']}}" type="video/mp4"></source>
        你的浏览器不支持
    </video>
</div>
</div> 

</body>
    <script>
        document.getElementById('preview').innerHTML = editor.getContent();
        uParse('#preview',{
            rootPath : '../../',
            chartContainerHeight:500
        })
        dialog.oncancel = function(){
            document.getElementById('preview').innerHTML = '';
        }
    </script>
</html>