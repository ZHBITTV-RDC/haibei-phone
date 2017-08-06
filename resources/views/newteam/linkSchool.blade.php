<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>绑定教务</title>
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
input{
	width: 100%;
	height: 35px;
	border-radius: 5px;
	border: 0px;
	padding-left: 4px;
	margin-top:15px;
	
}
.in{
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
	<div class="title">
		<p><span style="font-size:24px;">WELCOME TO</span>
			<br>
		海贝TV
		</p>
	</div>
	<form action="{{route('linkId')}}" method="POST">
		 {{csrf_field()}}
		<input class="in" type="text" name="jwid" placeholder="学号">
		<input class="in" type="password" name="jwpwd" placeholder="教务密码">
		<input type="submit" value="绑定">
	</form>

	<footer>
		Copy@海贝TV研发部&nbsp;&nbsp;2017
	</footer>
</body>
</html>