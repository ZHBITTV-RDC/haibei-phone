<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>owner</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="{{ URL::asset('js/jquery-3.2.1.min.js') }}" type="text/javascript" charset="utf-8" async defer></script>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/weui.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}">
</head>
<body style="margin:2px 2px 2px 2px;">
<img src="img/log.jpg" class="img-responsive" alt="Responsive image">
 @if(count($errors))
 	<ul>
 		@foreach($errors->all() as $error)
 			<li>{{$error}}</li>
 		@endforeach
 	</ul>
 @endif
<form action="{{route('fromchangesave')}}" method="post" accept-charset="utf-8">
 {{csrf_field()}}
    <input type="hidden" name="change" value="change">
	<input type="hidden" name="discern" value="{{$discern}}">
   <div class="weui-cell">
	                <div class="weui-cell__hd"><label class="weui-label">名称</label></div>
	                <div class="weui-cell__bd">
	                    <input class="weui-input" type="text" placeholder="请输入名称" name='name' required="required" id="Name" value="{{$name}}" onClick="if (this.value=='{{$name}}'){this.value=''}"/>
	                </div>
	    </div> 






	   <div class="weui-cell">
	                <div class="weui-cell__hd"><label class="weui-label">微信号</label></div>
	                <div class="weui-cell__bd">
	                    <input class="weui-input" placeholder="请输入微信号" name="wechat" required="required" value="{{$wechat}}" onClick="if (this.value=='{{$wechat}}'){this.value=''}"/>
	                </div>
	    </div> 


  <div class="weui-cells">

            <div class="weui-cell weui-cell_select weui-cell_select-before">
                <div class="weui-cell__hd">
                    <select class="weui-select" name="phone_date">
                        <option value="86">+86</option>
                        <option value="80">+80</option>
                        <option value="84">+84</option>
                        <option value="87">+87</option>
                    </select>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="number" pattern="[0-9]*" placeholder="请输入号码" name="phone" required="required" id="phone" value="{{$phone}}" onClick="if (this.value=='{{$phone}}'){this.value=''}"/>
                </div>
            </div>
        </div>



   <div class="weui-cell">留言</div>
        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <textarea class="weui-textarea" placeholder="请输入你想要的留言" rows="3" name="message" required="required" id="data">{{$message}}</textarea>
                    <div class="weui-textarea-counter" id="numCheck" ><span>0</span>/200</div>
                </div>
            </div>
        </div>




  			<div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <div class="weui-uploader">
                        <div class="weui-uploader__hd">
                            <p class="weui-uploader__title">图片上传</p>
                            <div class="weui-uploader__info" id="imgCheck">0/2</div>
                        </div>
                        <div class="weui-uploader__bd">
                     
                            <div class="weui-uploader__input-box" id="img0" >
                                    @if($img!='null')
                                    <img src="img/{{$img.'.jpg'}}" style="height: 100%;width: 100%;position:absolute;z-index:1;">
                                    @endif
                                   
                             
                            </div>
                            <div class="weui-uploader__input-box" id="img1">
                                @if($img2!='null')
                                    <img src="img/{{$img2.'.jpg'}}" style="height: 100%;width: 100%;position:absolute;z-index:1;">
                                @endif
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="weui-cells weui-cells_radio">
            <label class="weui-cell weui-check__label" for="x11">
                <div class="weui-cell__bd">
                    <p>保存并公开</p>
                </div>
                <div class="weui-cell__ft">
                    <input type="radio" class="weui-check" name="radio1" id="x11" @if($statu==1) checked="checked" @endif  value="1" />
                    <span class="weui-icon-checked"></span>
                </div>
            </label>
            <label class="weui-cell weui-check__label" for="x12">

                <div class="weui-cell__bd">
                    <p>保存暂不公开</p>
                </div>
                <div class="weui-cell__ft">
                    <input type="radio" name="radio1" class="weui-check" id="x12" value="2" @if($statu!=1) checked="checked" @endif />
                    <span class="weui-icon-checked"></span>
                </div>
            </label>
     
        </div>


    <button class="weui-btn weui-btn_plain-primary" >提交</button>

  
</form>





	





	
<script src="{{ URL::asset('js/bootstrap.min.js') }}" type="text/javascript" charset="utf-8" async defer></script>
<script src="{{ URL::asset('js/contentCheck.js') }}" type="text/javascript" charset="utf-8" async defer></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    wx.config(<?php echo app('wechat')->js
    		->config(array(	'chooseImage',
    						'previewImage',  
                    		'uploadImage',  
                    		'downloadImage',
                    		)) ?>);
    wx.ready(function(){
    // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
    });

var imgNum=1;
function upload(map){
    wx.chooseImage({
    count: 1, // 默认9
    sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
    success: function (res) {
        var localIds= res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
        setTimeout(function(){
          wx.uploadImage({
          localId: localIds.toString(), // 需要上传的图片的本地ID，由chooseImage接口获得
          isShowProgressTips: 1, // 默认为1，显示进度提示
          success: function (res) {
          var serverId = res.serverId; // 返回图片的服务器端ID
          $('#img'+map).html('<input type="hidden" name="media_id['+map+']" value="'+serverId+'">'+'<img src="'+localIds+'" style="height: 100%;width: 100%;position:absolute;z-index:1;">');

          if(imgNum<=2){
              
               $('#imgCheck').html(imgNum+'/2');
               imgNum++;
          }
          }
        })},100);
    }
});
}
  $('#img0').click(function() { 
    upload(0);
   });
   $('#img1').click(function() { 
    upload(1);
   });

</script>

</body>
</html>