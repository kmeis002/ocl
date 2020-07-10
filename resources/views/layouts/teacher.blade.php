<html>
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">

	    <!-- CSRF Token -->
	    <meta name="csrf-token" content="{{ csrf_token() }}">

	    <title>{{ config('app.name', 'Laravel') }}</title>

	    <!-- Fonts -->
	    <link rel="dns-prefetch" href="//fonts.gstatic.com">
	    <link href="https://fonts.googleapis.com/css?family=PT Mono" rel="stylesheet">


	    <!-- Styles -->
	    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

		@yield('modal-scripts')


		

	</head>


	<body class='main-bg'>
		@include('teacher.nav.nav')

		@include('teacher.nav.sidebar')
		<div class='main'>
			@yield('content')
		</div>
		<div class="container footer">
			<p>p</p>
		</div>
	</body>

	@yield('modals')

	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('js/sidebar.js') }}"></script>
	<script src="{{ asset('js/three.min.js') }}"></script>
	
	@yield('scripts')

</html>
