<!DOCTYPE html>  
<html>  
<head>  
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
<title>海贝TV</title>  
<script src="js/jquery.min.js"></script>
<script src="js/head.js"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/swiper.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/weui.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/head.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}">
</head>
<style type="text/css">
    .page__bd{
        box-shadow: 0px 0px 7px 0px;
        position: fixed;
        z-index: 999;
        width: 100%;
    }
    .pi{
        opacity: 0.9;
    }
    .ri{
        padding-top: 8px;
        margin-left: -6px;
    }
    nav{
        right: 10px;
        bottom: 10px;
        position: fixed;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #0DB2F7;
        text-align: center;
        line-height: 40px;
        color: white;
        display: none;
    }
</style>  
<body>
<script src="{{ URL::asset('js/jquery-1.10.2.min.js') }}"></script>
<script src="{{ URL::asset('js/swiper.jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/head.js') }}"></script>
     <!-- 返回栏 -->
   <div class="page__bd" >
        <div class="weui-cells__title ri">
            <span style="margin-top:3px;" class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>返回
            
        </div>
    </div>
     <!-- 轮播效果各部门介绍 -->
     <div class="swiper-container">
      <div class="swiper-wrapper">
          <div class="swiper-slide"><p style="position:absolute;color:#fff;padding:40%;">宣传部</p><img src="img/xuanc.jpg"></div>
          <div class="swiper-slide"><p style="position:absolute;color:#fff;padding:40%;">摄影部</p><img src="img/shiy.jpg"></div>
          <div class="swiper-slide"><p style="position:absolute;color:#fff;padding:40%;">演艺部</p><img src="img/yany.jpg"></div>
           <div class="swiper-slide"><p style="position:absolute;color:#fff;padding:40%;">研发部</p><img src="img/yanf.jpg"></div>
          <div class="swiper-slide"><p style="position:absolute;color:#fff;padding:40%;">人力部</p><img src="img/renl.jpg"></div>
          <div class="swiper-slide"><p style="position:absolute;color:#fff;padding:40%;">影视部</p><img src="img/yins.jpg"></div>
           <div class="swiper-slide"><p style="position:absolute;color:#fff;padding:40%;">策划部</p><img src="img/ceh.jpg"></div>
          <div class="swiper-slide"><p style="position:absolute;color:#fff;padding:40%;">采编部</p><img src="img/caip.jpg"></div>
          <div class="swiper-slide"><p style="position:absolute;color:#fff;padding:40%;">外联部</p><img src="img/wail.jpg"></div>
      </div>
       <!-- 如果需要分页器 -->
      <div class="swiper-pagination"></div>
  </div>
    <!-- 功能区 -->
<div class="page">
    <div class="page__hd">
        <p class="page__desc">海贝功能</p>
    </div>
    <div style="background-color:snow;" class="weui-grids">
        <a href="{{route('application_One')}}" style="border:0px;width:50%;" class="weui-grid">
            <div class="weui-grid__icon">
                <img  src="img/grade.png" alt="">
            </div>
            <p class="weui-grid__label">查询成绩</p>
        </a>
        <a href="{{route('application_Two')}}" style="border-left:1px solid #ECECEC;width:50%;" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="img/speech.png" alt="">
            </div>
            <p class="weui-grid__label">讲座查询</p>
        </a>
        <a href="{{route('application_Three')}}" style="border:1px solid #ECECEC;border-left:0px;width:50%;" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="img/phonenumber.png" alt="">
            </div>
            <p class="weui-grid__label">校内电话</p>
        </a>
        <a href="{{route('application_Four')}}" style="border:1px solid #ECECEC;width:50%;" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="img/school.png" alt="">
            </div>
            <p class="weui-grid__label">校园3D图</p>
        </a>
        
    </div>
</div>
  <!-- 栏目介绍-->
  <div class="lm">
   <div class="page__hd">
<div class="weui-panel weui-panel_access">
    <!-- 第一个栏目 -->
    <div class="weui-panel__hd" style="border-bottom:1px solid #ECECEC">海贝栏目</div>
    <div class="weui-panel__bd">
        <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" src="img/index.png" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title">视频一</h4>
                <p class="weui-media-box__desc">海贝宣传片</p>
            </div>
        </a>
        <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" src="img/index.png" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title">视频二</h4>
                <p class="weui-media-box__desc">北理珠宣传片</p>
            </div>
        </a>
    </div>
    <!-- 第二个栏目 -->
     <div class="weui-panel weui-panel_access">
        <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" src="img/index.png" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title">视频一</h4>
                <p class="weui-media-box__desc">海贝宣传片</p>
            </div>
        </a>
        <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" src="img/index.png" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title">视频二</h4>
                <p class="weui-media-box__desc">北理珠宣传片</p>
            </div>
        </a>
    </div>
    <!-- 第三个 -->
     <div class="weui-panel weui-panel_access">
        <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" src="img/index.png" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title">视频一</h4>
                <p class="weui-media-box__desc">海贝宣传片</p>
            </div>
        </a>
        <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" src="img/index.png" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title">视频二</h4>
                <p class="weui-media-box__desc">北理珠宣传片</p>
            </div>
        </a>
    </div>
    <!-- 第四个栏目 -->
     <div class="weui-panel weui-panel_access">
        <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" src="img/index.png" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title">视频一</h4>
                <p class="weui-media-box__desc">海贝宣传片</p>
            </div>
        </a>
        <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" src="img/index.png" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title">视频二</h4>
                <p class="weui-media-box__desc">北理珠宣传片</p>
            </div>
        </a>
    </div>
    <!-- 第四个栏目 -->
     <div class="weui-panel weui-panel_access">
        <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" src="img/index.png" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title">视频一</h4>
                <p class="weui-media-box__desc">海贝宣传片</p>
            </div>
        </a>
        <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" src="img/index.png" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title">视频二</h4>
                <p class="weui-media-box__desc">北理珠宣传片</p>
            </div>
        </a>
    </div>
</div>
</div>
<!-- 复制代码模块,直到有滚动条出现为止,为了达到测试目的 -->  

<!-- 返回顶部 -->
<nav>
    <span class="glyphicon glyphicon-magnet" aria-hidden="true"></span>
</nav>
<!-- 返回顶部end -->
</div>  
</body>  
</html>  
<script type="text/javascript">
window.onscroll = function(){
   var t = document.documentElement.scrollTop||document.body.scrollTop;
    if(t >= 100){
        $('nav').fadeIn();
        // alert($(window).scrollTop());
        $('.page__bd').addClass('pi');
    }else{
        $('nav').fadeOut();
         $('.page__bd').removeClass('pi');
    }
};
 $('nav').click(function(){
       $('body,html').animate({'scrollTop':0},500);     
});
    
</script>