<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

	<link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Press+Start+2P">
</head>
<body>
	<div class='welcome'><p>Welcome to</p></div>
	<div class='ascii'> 
8"""88                     8""""8                              8                        
8    8 eeeee eeee eeeee    8    " e    e eeeee  eeee eeeee     8     eeeee eeeee  eeeee 
8    8 8   8 8    8   8    8e     8    8 8   8  8    8   8     8e    8   8 8   8  8   " 
8    8 8eee8 8eee 8e  8    88     8eeee8 8eee8e 8eee 8eee8e    88    8eee8 8eee8e 8eeee 
8    8 88    88   88  8    88   e   88   88   8 88   88   8    88    88  8 88   8    88 
8eeee8 88    88ee 88  8    88eee8   88   88eee8 88ee 88   8    88eee 88  8 88eee8 8ee88 
                                                                                        
	</div>
	<div class='date'><p>{{ date('Y-m-d H:i:s') }}</p></div>
	<div class='kernel'><p>Kernel 0.1.0-1-default (tty1)</p></div>
</body>
	
</html>