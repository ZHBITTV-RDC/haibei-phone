<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>test</title>
	<link rel="stylesheet" href="{{ URL::asset('css/test.css') }}" type="text/css">
	<script src="{{ URL::asset('js/jquery-2.1.1.min.js') }}" type="text/javascript" charset="utf-8"></script>
	



</head>
<body>
<div class="test">

<div class="visible-print text-center">
@foreach ($discerns as $discern)
    <img src="{{ URL::asset('qrcodes/'.$discern.'.png') }}" alt="">
    <p>Scan me to return to the original page.</p>
    
@endforeach
	
</div>



</div>
	
</body>
</html>
