@extends('layouts.student')

@section('nav')
@include('student.nav.nav')
@endsection

@section('scripts')
	<script src="{{ asset('js/chart.min.js') }}"></script>
@endsection

@section('content')
<div class="container d-flex justify-content-center my-3 py-3">
	<h1>Leaderboards</h1>
</div>

<div class="container d-flex justify-content-center main-list mb-5">
	<table class="table table-striped table-hover">
		<thead>
			<th class="add-del">Rank</th>
			<th>User</th>
			<th>Raw Score</th>
			<th>Modified Score</th>
		</thead>
		<tbody>
			@foreach($students as $s)
			<tr>
				<td>{{$loop->count}}</td>
				<td>{{$s->name}}</td>
				<td>{{$s->raw_score}}</td>
				<td>{{$s->mod_score}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

@endsection