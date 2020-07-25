@extends('layouts.student')

@section('nav')
@include('student.nav.nav')
@endsection

@section('scripts')
    @if($progress)
    {!! $progress->script() !!}

    <script src="{{ asset('js/chart.min.js') }}"></script>
    @endif
@endsection


@section('content')

<div class="container d-flex justify-content-center mt-3 mb-5">
	<h3>Student Dashboard</h3>
</div>

		<div class="container">
			<div class="progress">
				<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{(Auth::user()->raw_score / $total)*100 }}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Completed</div>
			</div>
		</div>

<div class="container d-flex justify-content-end progress-chart my-3 py-3">
		<div class="col">
			<div style="width: 100%">
			    {!! $progress->container() !!}
			</div>
		</div>
		<div class="col">
			<div class="container">
				<h5>Newest owns:</h5>
				@if(count($history) > 0)
				@foreach($history as $h)
				<div class="container">
					<div class="alert alert-success">
						{{$h->points}} point(s): {{$h->description}} @ {{$h->created_at->format('M-d-Y H:i:s')}}
					</div>
				</div>
				@endforeach
				@else
				<div class="alert alert-warning">
					No flags captured yet.
				</div>
				@endif
			</div>
		</div>
</div>



@include('student.dashboard.assignments.list')
@endsection
