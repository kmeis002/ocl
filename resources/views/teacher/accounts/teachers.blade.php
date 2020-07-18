@extends('layouts.teacher')


@section('scripts')
<script src="{{ asset('js/teacheraccounts.js') }}"></script>
@endsection

@section('content')
@include('teacher.errors.validationerrors')
<div class="container justify-content-center my-5">
<h1 class="text-center" id="type-header">Manage Teachers</h1>
</div>

<div class="container main-list double mb-5">
	<div class="row">
		<div class="col-lg">
			<div class="container d-flex justify-content-between my-2"><h5>Teacher Accounts</h5><button type="button" class="btn btn-primary" id="add-new-teacher"><i class="fas fa-plus"></i></button></div>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Username</th>
						<th>Email</th>
						<th class="add-del">Edit</th>
						<th class="add-del">Delete</th>
					</tr>
				</thead>
				<tbody>
					<div id="list-teachers">
						@foreach($teachers as $t)
							<tr>
								<td>{{$t->name}}</td>
								<td>{{$t->email}}</td>
								<td class="add-del"><button type ="button" class="btn btn-primary edit-teacher" data-id="{{$t->id}}"><i class="fas fa-edit"></i></button></td>
								<td class="add-del"><button type="button" class="btn btn-primary delete-teacher" data-id="{{$t->id}}"><i class="fas fa-trash-alt"></i></button></td>
							</tr>
						@endforeach
					</div>
				</tbody>
			</table>
		</div>
		<div class="col-lg">
			<h5>Add/Edit Teacher</h5>
			<div class="container lab-layout bg-primary-trans py-2" id="edit-container">
				<form action="/teacher/accounts/create/teacher" method="POST" id="modify-teacher">
					@csrf
					<h5>Username: <span id="teacher-name"></span></h5>
					<input type="text" class="form-control my-2" name="name" id="name">
					<label for="password">Password</label>
					<input type="password" name="password" class="form-control" id="password">
					<h5 class="my-2">Email: <span id="teacher-email"></span></h5>
					<input type="text" class="form-control my-2" name="email" id="email">
					<label for="last" class="mx-2">API Token</label>
					<div class="container d-flex justify-content-between">
						<input type="password" name="api-token" class="form-control" id="api-token">
						<button type="button" class="btn btn-primary mx-2" id="api-regen" data-id=""><i class="fas fa-redo" ></i></button>
						<button type="button" class="btn btn-primary mx-2" id="api-reveal"><i class="fas fa-eye"></i></button>
					</div>

					<button type="submit" class="btn btn-primary my-2"><i class="fas fa-save"></i></button>
				</form>
			</div>
		</div>
	</div>

</div>
@endsection