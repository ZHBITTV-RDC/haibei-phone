<!doctype html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <title>寻物tip</title>
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-theme.min.css') }}">
 
  <style>

	/* 定义辅助CSS来美化简历头部 */
	body{
	  font-family: 'microsoft yahei',Arial,sans-serif;
	}

	.cvheader{
	  border-bottom: 1px solid #DFDFDF;
	  padding-top:30px;
	  padding-bottom:20px;
	}

	.cvheader h1{
	  margin:0;
	}

	.address{
	  background: #efb73e;
	  color: #fff;
	  padding: 10px 0;
	}

	/* 定义辅助CSS来美化简历主体 */

	.cvbody{
	  padding-top: 50px; 
	}

	.cbox{
	  margin-bottom: 30px;
	  color: #FFF;
	  padding: 50px;
	}

	/* 定义cbox颜色 */
	.green{
	  background: #2ecc71;
	}

	.orange{
	  background: orange;
	}

	.red{
	  background: #dd4814;
	}

	.bbox{
	  border: 1px solid #DFDFDF;
	  border-radius: 5px;
	  margin-bottom:30px;
	  padding: 50px;
	}

	.footer{
	  margin: 30px 0 30px;
	  padding: 50px;
	  background: #CCC;
	  color: #FFF;
	}
</style>
</head>
<body>
  <!-- 定义简历的头部 //-->

<div class="container">
  <div class="row cvheader">
    <div class="col-lg-7 col-md-7 col-xs-12">
      <!--  添加颜色//-->
      <h1 class="text-primary">owenr</h1>
      <!--  添加图标 //-->
      <p><span class="glyphicon glyphicon-paperclip"></span> 关注公众号获得及时消息 </p>
    </div>
    
    <div class="col-lg-2 col-md-2 col-xs-12">
      <p>
        <!-- 这里定义图片为响应式，并且添加圆角效果，以便保证图片在不同设备上都可以完美显示 //-->
        <img data-toggle="tooltip" data-placement="left" id="avatar" title="owner" class="img-responsive img-rounded" src="img/ewm.png" alt="">
       </p>
    </div>
  </div>
</div>

<!-- 定义简历的主体部分 //-->



<!-- 定义简历页底 //-->


<!-- 引入jQuery类库和Bootstrap3的Javascript类库 //-->
<script src="{{ URL::asset('js/jquery-3.2.1.min.js') }}" type="text/javascript" charset="utf-8" async defer></script>
<script src="{{ URL::asset('js/bootstrap.min.js') }}" type="text/javascript" charset="utf-8" async defer></script>
</body>
</html>