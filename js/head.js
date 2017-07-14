 
window.onload = function(){
    var mySwiper = new Swiper ('.swiper-container', {
    direction: 'horizontal',
    loop: true,
    autoplay:5000,
    autoplayDisableOnInteraction : false,
    // 如果需要分页器
    pagination: '.swiper-pagination',
    
   
    
  }) ; 

   la();
}

function la(){
    //自定义指针，指向加载条数
    var next = 0;
    var last = 2;
    // 定义下拉显示数量
    var length = 2;
 //数据加载时期的gif加载图,用于提示用户数据正在加载!  
var loadDiv = '<div class="loading"><div id="l1" class="l"></div><div class="l" id="l2"></div><div class="l" id="l3"></div><div class="l" id="l4"></div></div>'; 
// 测试
   //  alert($(window).height());
   // alert(window.innerHeight);
   // alert($(document).height());
   // alert(document.body.offsetHeight);
 //滚动条在Y轴上的滚动距离

function getScrollTop(){
　　var scrollTop = 0, bodyScrollTop = 0, documentScrollTop = 0;
　　if(document.body){
　　　　bodyScrollTop = document.body.scrollTop;
　　}
　　if(document.documentElement){
　　　　documentScrollTop = document.documentElement.scrollTop;
　　}
　　scrollTop = (bodyScrollTop - documentScrollTop > 0) ? bodyScrollTop : documentScrollTop;
　　return scrollTop;
}
//监听窗口的鼠标滚轮事件  
$(window).scroll(function(){ 
//当滚轮滚动到文档最末位，也就是拉到了最底下  
if( $(window).scrollTop() == $(document).height() - $(window).height() ) { 
    //避免多次滚轮触发事件造成图片的多次追加，加上此判断  
    if($('.lm .loading').length == 0) {  
        //将图片插入到内部的内容最末位  
        $('.lm').append(loadDiv);  
    }  
    //发送ajax请求获取数据  
    $.ajax({  
        type: "POST",  
        url: "data.php",
        data:{n:next,l:last}, 
        success: function(data){  
          //加载成功,移除用于提示用户的动态动画 
          $('.lm .loading').remove();  
          // //追加后端返回的数据
            if(data != null){
                data = eval('('+data+')');
                //alert(data[0].src);
                for(var i=0;i<length+1;i++){
                      //alert(length);
                      var src = data[i].src;
                      var title = data[i].title;
                      var content = data[i].content;
                      var html = '<div class="weui-panel weui-panel_access"><a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg"><div class="weui-media-box__hd"><img class="weui-media-box__thumb" src="'+src+'" alt=""></div><div class="weui-media-box__bd"><h4 class="weui-media-box__title">'+title+'</h4><p class="weui-media-box__desc">'+content+'</p></div></a></div>';
                      
                       $('.lm').append(html);  
                }
            }  
          
        }  
    });
    next +=2;
    last +=2;  
}  
});  
}

