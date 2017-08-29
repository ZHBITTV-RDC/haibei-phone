<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5shiv.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<![endif]-->
<link href="{{URL::asset('public/static/h-ui/css/H-ui.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('public/static/h-ui.admin/css/H-ui.login.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('public/static/h-ui.admin/css/style.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('publicc/lib/Hui-iconfont/1.0.8/iconfont.css')}}" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>后台登录</title>
<body>
<input type="hidden" id="TenantId" name="TenantId" value="" />
<div class="header"></div>
<div class="loginWraper">
  <div id="loginform" class="loginBox">
    <form class="form form-horizontal" action="{{ URL('admin/Adminlogin') }}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
        <div class="formControls col-xs-8">
          <input id="" name="adminName" type="text" placeholder="账户" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
        <div class="formControls col-xs-8">
          <input id="" name="adminPassword" type="password" placeholder="密码" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input class="input-text size-L" name="captcha" type="text" placeholder="验证码" onblur="if(this.value==''){this.value='验证码:'}" onclick="if(this.value=='验证码:'){this.value='';}" value="验证码:" style="width:150px;">
          <img src="{{URL('captcha/2')}}" id="verify"> <a id="kanbuq" class="v" href="javascript:;"  onclick="refreshimg();">看不清，换一张</a> </div>
      </div>
    <div class="row cl">

        <div class="formControls col-xs-8 col-xs-offset-3">
          <label for="online">
            
           <div class=error style="color:red;">
              @if( session('msg') )
               {{ Session::get('msg') }}
              @endif

               @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                               {{ $error }}
                             @endforeach
                 @endif
       </div>  
     </div>
 </div>

      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
          <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
        </div>
      </div>
    </form>
  </div>
</div>

<div class="footer">Copyright 海贝Tv by研发部</div>
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="static/h-ui/js/H-ui.min.js"></script>

<script type="text/javascript">
  
 //刷新验证码 
function refreshimg() {  
    $url="{{ URL('captcha')}}";
     $url= $url+"/"+Math.random();
    document.getElementById('verify').src=$url;  
   
} 
</script>

<script type="text/javascript">
   
   $("form").submit(function() {
    var self = $(this);
    $.post(self.attr("action"), self.serialize(), function(data) {
        if (data.status==1) {
            window.location.href = data.url;
        } else {
            self.find(".error").text(data.msg);
            //刷新验证码
             $(".v").click();
        }
    }, "json");
    return false;
});


</script>

</body>
</html>