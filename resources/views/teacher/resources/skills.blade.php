@extends('layouts.teacher')

@section('scripts')
<script src="{{ asset('js/teacherskills.js') }}"></script>
@endsection

@section('content')
<h1 class="text-center my-2">Manage Skills</h1>

<div class="container d-flex justify-content-center main-list mb-5">
	<table class="table table-dark table-borderless table-striped table-hover" style="width:500px">
		<thead>
			<tr>
				<th class='add-del'>ID</th>
				<th>Skill</th>
				<th class='add-del'>Add/Del</th>
			</tr>
		</thead>
		<tbody>
			@foreach($skills as $skill)
			<tr>
				<td class='add-del'>{{$skill->id}}</td>
				<td>{{$skill->name}}</td>
				<td class='add-del'><button type="button" class="btn btn-primary delete-skill" data-id="{{$skill->id}}"><i class="fas fa-trash-alt"></i></button></td>
			</tr>
			@endforeach
			<tr>
				<form id="add-new-skill" action="/teacher/create/skill" method="POST">
				@csrf
				<td>New</td>
				<td><input type="text" class="form-control" id="skill-name" name="skill-name"></td>
				<td><button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i></button></td>
				</form>
			</tr>
		</tbody>
	</table>

</div>


@endsection