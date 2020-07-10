@extends('layouts.teacher')


@section('scripts')
<script src="{{ asset('js/teacherenroll.js') }}"></script>
@endsection

@section('content')
<div class="container justify-content-center my-5">
<h1 class="text-center" id="type-header" data-model-type="{{$type}}">Manage Enrollment</h1>
</div>

<div class="container main-list double">
	<div class="row">
		<div class="col-lg">
			<table class="table">
				<thead>
					<tr>
						<th>Select Class</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><select class="form-control" name="class-select" id="class-select"></select></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-lg">
			<table class="table">
				<thead>
					<tr>
						<th>Course</th>
						<th class="bell">Bell</th>
						<th>Enrolled Students</th>
					</tr>
				</thead>
				<tbody>
					<tr id="class-row" data-id="">
						<td id="class-row-course"></td>
						<td id="class-row-bell"></td>
						<td id="class-row-roster"></td>
					</tr>
					<tr>
						<td><select class="form-control" name="enroll-student-select" id="enroll-student-select">
							
						</select></td>
						<td class="bell"><button type="button" class="btn btn-primary" id="enroll-student"><i class="fas fa-plus"></i></button></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection