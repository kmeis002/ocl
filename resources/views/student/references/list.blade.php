@extends('layouts.student')

@section('nav')
@include('student.nav.nav')
@endsection


@section('content')

<div class="container d-flex justify-content-center mt-3 mb-5">
	<h3>Quick References</h3>
</div>

<div class="container selector-grid" style="width: 1500px !important; max-width: 1500px !important">
@foreach($ref as $r)
@if($loop->index%5 === 0)
<div class="row justify-content-start">
@endif
	<div class="col">
		<div class="card bg-primary-trans mx-2 mb-3" style="width: 18rem;">
		  <div class="card-body">
		  	<i class="fas fa-book fa-5x card-img-top text-center my-5"></i>
		    <h5 class="card-title">{{$r->name}}</h5>
		    <a href="/student/reference/{{$r->id}}" class="btn btn-primary">Read</a>
		  </div>
		</div>
	</div>
@if($loop->index%5 === 4 || $loop->index === sizeof($ref)-1)
</div>
@endif
@endforeach
</div>

@endsection
