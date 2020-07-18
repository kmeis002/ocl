@extends('layouts.teacher')


@section('scripts')
<script src="{{ asset('js/teacheraccounts.js') }}"></script>
@endsection

@section('content')
@include('teacher.errors.validationerrors')
<div class="container justify-content-center my-5">
<h1 class="text-center" id="type-header">Manage Students</h1>
</div>

<div class="container main-list double mb-5">
	<div class="row">
		<div class="col-lg">
			<div class="container d-flex justify-content-between my-2"><h5>Student Accounts</h5><button type="button" class="btn btn-primary" id="add-new-student"><i class="fas fa-plus"></i></button></div>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Username</th>
						<th>First</th>
						<th>Last</th>
						<th class="add-del">Edit</th>
						<th class="add-del">Delete</th>
					</tr>
				</thead>
				<tbody>
					<div id="list-students">
						@foreach($students as $s)
							<tr>
								<td>{{$s->name}}</td>
								<td>{{$s->first}}</td>
								<td>{{$s->last}}</td>
								<td class="add-del"><button type ="button" class="btn btn-primary edit-student" data-id="{{$s->id}}"><i class="fas fa-edit"></i></button></td>
								<td class="add-del"><button type="button" class="btn btn-primary delete-student" data-id="{{$s->id}}"><i class="fas fa-trash-alt"></i></button></td>
							</tr>
						@endforeach
					</div>
				</tbody>
			</table>
		</div>
		<div class="col-lg">
			<h5>Add/Edit Student</h5>
			<div class="container lab-layout bg-primary-trans py-2" id="edit-container">
				<form action="/teacher/accounts/create/student" method="POST" id="modify-student">
					@csrf
					<h5>Username: <span id="student-name"></span></h5>
					<input type="text" class="form-control my-2" name="name" id="name">
					<label for="password">Password</label>
					<input type="password" name="password" class="form-control" id="password">
					<div class="container d-flex justify-content-between my-4">
						<label for="first" class="mr-2">First Name</label><br>
						<input type="text" name="first" class="form-control" id="first"> 
						<label for="last" class="mx-2">Last Name</label>
						<input type="text" name="last" class="form-control" id="last"> 
					</div>
					<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i></button>
				</form>
			</div>
		</div>
	</div>

</div>
@endsection