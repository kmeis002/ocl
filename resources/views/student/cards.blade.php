@extends('layouts.student')

@section('scripts')
<script src={{ asset('js/list-scripts.js') }}></script>
@endsection

@section('nav')
@include('student.nav.nav')
@endsection


@section('content')

<div class="container  d-flex my-3 justify-content-center text-center">
	<label for="name-search my-3">Search by name: </label><input class="search mx-1" type="text" id='name-search' label="Search by name:">
</div>

 <div class='container d-flex flex-row my-3 justify-content-start selector-grid' style="max-width: 1500px; flex-wrap: wrap">
 	<div class="row shuffler">
 		@foreach($list as $item)
  		<div class="col my-5 mx-auto shuffler-item" data-groups='["{{$item->os}}"]' data-title='["{{$item->name}}"]'>
  			<a href="/presenter/{{$type}}/{{$item->name}}">
            <div class="card bg-primary-trans overlay" id="{{$item->name}}" style="width: 15rem; height: 18rem;">
            		 <div class="card-header bg-primary-trans">
            		 	<p class="text-center my-1">{{ $item->name}}</p>
            		 </div>
            		 <div class="card-body">
               			 <i class="{{$item->icon}} fa-3x card-img-top text-center my-4"></i>
               		</div>
               		<div class="card-footer bg-primary-trans">
               			@if(isset($item->os))
               			<p class="text-center my-1">OS:{{$item->os}}</p>
               			@endif
               			<p class="text-center my-1">Points:{{$item->points}}</p>
               		</div>
 			</div></a>
 		</div>
 		@if(($loop->index+1) % 6 == 0)
 		<div class="w-100"></div>
 		@endif
 		@endforeach
 		</div>
 		
 </div>
@endsection