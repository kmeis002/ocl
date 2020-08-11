<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Press+Start+2P">
</head>
<body>
	@include('student.errors.validationerrors')
	<div class="container ml-0">
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
		<form method="POST" action="{{ route('student.login') }}">
		@csrf
			<div>
				<p class="kernel my-3">Username: <input type="text" class="form-control input border-top-0 border-left-0  border-right-0" name="name"></p>
			</div>
			<div>
				<p class="kernel my-3">Password: <input type="password" class="form-control input border-top-0 border-left-0  border-right-0" name="password"></p>
			</div>
			<div class="container d-flex justify-content-end">
			<button type="submit" class="btn btn-primary">Login</button>
		</div>
		</form>
	</div>
</body>
	
</html>