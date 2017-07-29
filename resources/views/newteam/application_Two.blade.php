<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>查询讲座</title>
	<link rel="stylesheet" type="text/css" href="./css/application_Two.css">
</head>
<body style="background:-webkit-linear-gradient(top,#014E9E,#01448B,gray);">
	<!-- 先判断是否绑定教务系统，如何没有绑定则跳转绑定 -->
	<div class="title">
		<p><span style="font-size:24px;">HELLO xxx童鞋</span>
		</p>
	</div>
	<form action="" method="POST">
		<!-- 隐藏菜单 -->
		<!-- 对应学生学号 -->
		<input type="text" name="stuNumber" hidden value="">
		<!-- 对应学生密码 -->
		<input type="text" hidden name="psd" value="">
		<input type="submit" value="一键查询讲座">
	</form>

	<footer>
		Copy@海贝TV研发部&nbsp;&nbsp;2017
	</footer>
</body>
</html>