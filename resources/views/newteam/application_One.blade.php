<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="js/jquery.min.js"></script>
	<title>成绩查询</title>
</head>
<style type="text/css">
	*{
		margin: 0px;
		padding: 0px;
		width: 100%;
	}
	body{
		width: 100%;
		height: 850px;
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
		margin-top: 10%;
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
	<form action="{{route('application_One')}}"  method="POST">
		{{csrf_field()}}
		<select id="select" name="select">
			<option value="getGrade" >成绩</option>
			<option value="getGradeTime">考试时间</option>
		</select>

		<!-- 隐藏部分查询显示 --><br><br>
		@if($getGrades!==null)
		查询成绩如下：
			<div id="grade">
			@foreach($getGrades as $getGrade)
			科目名称：
			成绩：
			学分：
			@endforeach
			</div>
		@endif

		
		
			科目名称：高数<br>
			成绩：32<br>
			学分：6分<br>
		

		<!-- 隐藏部分 -->

		<!-- 查询不到 时显示提示-->
		对不起，你当前查询不到相关成绩！请认真核对信息是否选择正确。
	</form>
	
	<footer>
		Copy@海贝TV研发部&nbsp;&nbsp;2017
	</footer>
</body>
</html>