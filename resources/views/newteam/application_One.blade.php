<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>成绩查询</title>
</head>
<style type="text/css">
		*{
		margin: 0px;
		padding: 0px;
		width: 100%;
		/*height: 100%;*/
	}
	body{
		width: 100%;
		height: 450px;
	}
.title{
	width: 60%;
	text-align: center;
	color: #E5E9F4;
	margin:auto;
	margin-top:40%;
	font:30px/1.5;
}
form{
	margin:auto;
	width: 80%;
	margin-top: 10%;
}
select,input{
	width: 100%;
	height: 35px;
	border-radius: 5px;
	border: 0px;
	padding-left: 4px;
	margin-top:15px;
	
}
select{
	background-color:#90A2B2;
}
footer{
	width: 80%;
	margin:auto;
	color:#033467;
	margin-top: 34%;
	text-align: center;
}
</style>
<body style="background:-webkit-linear-gradient(top,#014E9E,#01448B,gray);">
	<!-- 先判断是否绑定教务系统，如何没有绑定则跳转绑定 -->
	<div class="title">
		<p><span style="font-size:24px;">WELCOME TO</span>
			<br>
		海贝TV 
		</p>
	</div>
	<form action="" method="POST">
		<select id="select">
			<option value="">成绩</option>
			<option value="">考试时间</option>
		</select>
		<select id="selectTime">
			<option value="">2017年第一学期</option>
			<option value="">2016年第一学期</option>
		</select>
		<input type="submit" value="查询">
	</form>

	<footer>
		Copy@海贝TV研发部&nbsp;&nbsp;2017
	</footer>
</body>
</html>