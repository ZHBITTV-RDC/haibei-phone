// 计时器
       window.onload = function(){
       	var t = 5;
       	  setInterval(function(){
       	  	t--;
       	  	if(t>5){
       	  		t==5;
       	  	}
              var time = document.getElementById('time');
              time.innerHTML = '跳过广告：'+t+'s';
       	  },1000);
       }
