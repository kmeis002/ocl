@extends('layouts.student')

@section('nav')
@include('student.nav.nav')
@endsection


@section('content')

<div class="container d-flex justify-content-center mt-3 mb-5">
	<h3>{{$reference->name}}</h3>
</div>

<div class="container d-flex justify-content-center" style="width: 1500px;">
	<div class="container">
		<nav id="reference-nav" class="navbar navbar-dark bg-dark">
		  <ul class="nav nav-pills">
		  	@foreach($reference["sections"] as $s)
		    <li class="nav-item">
		      <a class="nav-link" href="#{{$s->name}}">{{$s->name}}</a>
		    </li>
			@endforeach
		  </ul>
		</nav>
		<div data-spy="scroll" data-target="#reference-nav" data-offset="0">
		  @foreach($reference["sections"] as $s)
		  <h4 class="my-2" id="{{$s->name}}">{{$s->name}}</h4>
		  {!! $s->content !!}
		  @endforeach
		</div>
	</div>
</div>

@endsection
