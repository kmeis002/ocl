<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Press+Start+2P">
</head>
<body>
	@include('teacher.errors.validationerrors')
	<div class="container ml-0">
		<div class='welcome'><p>Welcome to</p></div>
		<div class='ascii'> 
 ▄▄▄▄    ▄▄▄       ▄████▄   ██ ▄█▀▓█████▄  ▒█████   ▒█████   ██▀███  
▓█████▄ ▒████▄    ▒██▀ ▀█   ██▄█▒ ▒██▀ ██▌▒██▒  ██▒▒██▒  ██▒▓██ ▒ ██▒
▒██▒ ▄██▒██  ▀█▄  ▒▓█    ▄ ▓███▄░ ░██   █▌▒██░  ██▒▒██░  ██▒▓██ ░▄█ ▒
▒██░█▀  ░██▄▄▄▄██ ▒▓▓▄ ▄██▒▓██ █▄ ░▓█▄   ▌▒██   ██░▒██   ██░▒██▀▀█▄  
░▓█  ▀█▓ ▓█   ▓██▒▒ ▓███▀ ░▒██▒ █▄░▒████▓ ░ ████▓▒░░ ████▓▒░░██▓ ▒██▒
░▒▓███▀▒ ▒▒   ▓▒█░░ ░▒ ▒  ░▒ ▒▒ ▓▒ ▒▒▓  ▒ ░ ▒░▒░▒░ ░ ▒░▒░▒░ ░ ▒▓ ░▒▓░
▒░▒   ░   ▒   ▒▒ ░  ░  ▒   ░ ░▒ ▒░ ░ ▒  ▒   ░ ▒ ▒░   ░ ▒ ▒░   ░▒ ░ ▒░
 ░    ░   ░   ▒   ░        ░ ░░ ░  ░ ░  ░ ░ ░ ░ ▒  ░ ░ ░ ▒    ░░   ░ 
 ░            ░  ░░ ░      ░  ░      ░        ░ ░      ░ ░     ░     
      ░           ░                ░                                           
		</div>
		<div class='date'><p>{{ date('Y-m-d H:i:s') }}</p></div>
		<div class='kernel'><p>Kernel 0.1.0-1-default (tty1)</p></div>
		<form method="POST" action="{{ route('teacher.login') }}">
		@csrf
			<div>
				<p class="kernel my-3">Username: <input type="text" class="form-control input border-top-0 border-left-0  border-right-0" name="email"></p>
			</div>
			<div>
				<p class="kernel my-3">Password: <input type="password" class="form-control input border-top-0 border-left-0  border-right-0" name="password"></p>
			</div>
			<div class="container d-flex justify-content-end">
			<button type="submit" class="btn btn-primary">Login</button>
		</div>
		</form>
	</div>

@include('ascii.crashoverride')
</body>
	
</html>