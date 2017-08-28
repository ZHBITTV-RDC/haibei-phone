<!DOCTYPE html>
<html>
<head>
	<title>personal</title>
  <meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <script src="{{ URL::asset('js/jquery-3.2.1.min.js') }}" type="text/javascript" charset="utf-8" async defer></script>
 <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
 <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}">
 <link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet" >
</head>
<style type="text/css">
  *{
    margin: 0px;
    padding: 0px;
    width: 100%;
  }
  body{
    display: block;
  }
  
</style>
<body>
      <div ><img class="background-image" src="img/log.jpg"></div>
      <div style="width:65px; height: 65px;" class="head-image "><img src="{{$Avatar}}" class="img-circle center-block"></div>
      <div class="name"><p class="text-center" style="font-size: 17px;">{{$Nickname}}</p></div>
      <div class="row"></div>


      <div class="personal-nav">
      <ul>
        <li><p class="text-center" style="color: #34495e;width:50%;margin:auto;" >我的物品</p></li>

      </ul>
       
      </div>


@foreach($owners as $owner)

 <div class="cnt" id="cnt_1" >
   <a href="{{route('serach_message')}}?discern={{$owner->discern}}"><div class="bs-callout bs-callout-danger" id="callout-input-needs-type">
<div class="goods"><img src="img/{{$owner->img}}.jpg" class="img-rounded pull-left"></div>
    <strong class="pull-left" style="width:10%;">{{$owner->name}}</strong><p class="text-right">{{$owner->wechat}}</p></a>
    <p>{{$owner->message}}</p>
     <a href="{{route('move')}}?discern={{$owner->discern}}" onclick="return show_confirm()"><button class="btn btn-primary pull-right" style="width:30%;margin-left:3px;" >解除绑定</button></a>
      <a href="{{route('fromchange')}}?discern={{$owner->discern}}"><button class="btn btn-primary pull-right" style="width:20%;">修改</button></a>
  </div></div>


@endforeach

     



  


 <script src="{{ URL::asset('js/bootstrap.min.js') }}" type="text/javascript" charset="utf-8" async defer></script>
 <script type="text/javascript">
  function show_confirm()
  {
  var r=confirm("确认解除绑定!");
  if (r==true)
    {
    return true;
    }
  else
    {
    return false;
    }
  }
</script>
</body>
</html>