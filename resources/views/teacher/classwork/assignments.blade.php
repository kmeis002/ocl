@extends('layouts.teacher')


@section('scripts')
<script src="{{ asset('js/teacherassignments.js') }}"></script>
@endsection


@section('content')
@include('teacher.errors.validationerrors')
<div class="container justify-content-center my-5">
<h1 class="text-center" id="type-header">Manage Assignments</h1>
</div>

<div class="container main-list double">
	<div class="row">
		<div class="col-lg">
			<h5>Make New Assignment</h5>
			<table class="table">
				<thead>
					<tr>
						<th>Type</th>
						<th class="class">Class</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th class="add-del">Add</th>
					</tr>
				</thead>
				<tbody>
					<div id="list-assignments">
					@foreach($assignments as $a)
						<tr>
							<td>{{$a->prefix}}</td>
							<td class="class">{{$classes->find($a->class_id)->bell}}:{{$classes->find($a->class_id)->course}}</td>
							<td>{{$a->start_date}}</td>
							<td>{{$a->end_date}}</td>
							<td class="add-del"><button type="button" class="btn btn-primary edit-assignment" data-id="{{$a->id}}" data-prefix="{{$a->prefix}}"><i class="fas fa-edit"></i></button></td>
						</tr>
					@endforeach	
					</div>
					<form method="POST" action="/teacher/create/assignment">
						@csrf
					<tr>
						<td><select class="form-control" name="model-select" id="model-select">
							@foreach($types as $type)
							<option value="{{$type}}">{{$type}}</option>
							@endforeach
						</select></td>
						<td><select class="form-control" name="class-select[]" id="class-select" multiple>
							@foreach($classes as $class)
							<option value="{{$class->id}}">{{$class->bell}}: {{$class->course}}</option>
							@endforeach
						</select></td>
						<td><input  type="date" class="form-control" name="start-date" id="start-date"></td>
						<td><input  type="date" class="form-control" name="end-date" id="end-date"></td>
						<td class="add-del"><button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i></button></td>
					</tr>
				</form>
				</tbody>
			</table>
		</div>
		<div class="col-lg">
			<h5>Edit Assignment</h5>
			<div class="container lab-layout bg-primary-trans  py-2" id="edit-container">
			</div>
		</div>
	</div>
</div>

<div class="container d-flex justify-content-center">
	<h2>Assignment Check</h2>
</div>

<div class="container d-flex main-list justify-content-center mb-5">
	<table class="table table-dark table-striped table-hover">
		<thead>
			<tr>
				<th>Student Name</th>
				<th>Outstanding Assignments</th>
				<th>Finished Assignments</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><select class="form-control" name="student-select" id="student-select">
					@foreach($students as $student)
					<option value="{{$student->id}}">{{$student->name}}</option>
					@endforeach
				</select></td>
				<td id="incomplete-assignments"></td>
				<td id="completed-assignments"></td>
			</tr>
		</tbody>
	</table>
</div>

@endsection