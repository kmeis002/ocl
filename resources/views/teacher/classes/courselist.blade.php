@extends('layouts.teacher')


@section('scripts')
<script src="{{ asset('js/teacherclasses.js') }}"></script>
@endsection

@section('content')
<div class="container justify-content-center my-5">
<h1 class="text-center" id="type-header" data-model-type="{{$type}}">Manage {{ucfirst($type)}}s</h1>
</div>

<div class="container main-list double">
	<div class="row">
		<div class="col-lg">
			<table class="table table-striped table-primary" id="courses-table">
				<thead>
					<th class="id">#</th>
					<th>Course Name</th>
					<th class="add-del">Add/Del</th>
				</thead>
				<tbody>
					@foreach($courseList as $course)
					<tr>
						<td class="id" >{{$loop->index + 1}}</td>
						<td id="course-{{$loop->index + 1}}">{{$course->name}}</td>
						<td class="add-del"><button type="button" class="btn btn-primary my-1 delete-course" data-id="{{$loop->index + 1}}"><i class="fas fa-trash-alt"></i></button></td>
					</tr>
					@endforeach
					
					<tr id="new-course-row">
						<td class="id"></td>
						<td><input type="text" class="form-control" id="new-course-name"></td>
						<td class="add-del"><button type="button" class="btn btn-primary my-1" id="add-new-course"><i class="fas fa-plus"></i></button></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="col-lg">
			<table class="table table-striped table-primary" id="classes-table">
				<thead>
					<th class="id">#</th>
					<th>Course</th>
					<th>Teacher</th>
					<th class="bell">Bell</th>
					<th class="add-del">Add/Del</th>

				</thead>
				<tbody>
					@foreach($classList as $class)
					<tr>
						<td class="id" id="class-id">{{$class->id}}</td>
						<td>{{$class->course}}</td>
						<td>{{$class->teacher}}</td>
						<td class="bell">{{$class->bell}}</td>
						<td class="add-del"><button type="button" class="btn btn-primary my-1 delete-class" data-id="{{$class->id}}"><i class="fas fa-trash-alt"></i></button></td>
					</tr>
					@endforeach
					<tr id="new-class-row">
						<td class="id"></td>
						<td><select class="form-control" name="new-class-course" id="new-class-course">
						</select></td>
						<td><select class="form-control" name="new-class-teacher" id="new-class-teacher">
						</select></td>
						<td><input type="number" class="form-control" id="new-class-bell"></td>
						<td class="add-del"><button type="button" class="btn btn-primary my-1" id="add-new-class"><i class="fas fa-plus"></i></button></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection