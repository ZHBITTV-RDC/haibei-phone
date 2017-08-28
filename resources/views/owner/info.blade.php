<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>test</title>
	<link rel="stylesheet" href="">
</head>
<body>
@foreach($workout as $val)
		<img src="info.blade.php" alt="no">
          <p>{{$val->userName}}</p>
 @endforeach
</body>
</html>