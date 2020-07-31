
@extends('layouts.teacher')

@section('nav')
@include('teacher.nav.nav')
@endsection

@section('sidebar')
@include('teacher.nav.sidebar')
@endsection

@section('scripts')
<script src="{{ asset('js/vendor/summernote.min.js') }}"></script>
<link href="{{ asset('css/vendor/summernote.min.css')}}"" rel="stylesheet">
<script src="{{ asset('js/teacherreferences.js') }}"></script>

@endsection

@section('content')
<div class="container d-flex justify-content-center mb-3 mt-5">
	<h3>Manage Quick References</h3>
</div>

<div class="container main-list pl-0 ml-5 mb-5">
	<div class="row justify-content-start">
		<div class="col">
			<table class="table table-striped table-dark table-hover">
				<thead>
					<th class="id">Id</th>
					<th>Name</th>
					<th class="edit"></th>
				</thead>
				<tbody>
					@foreach($refs as $r)
					<tr>
						<td class="id">{{$r->id}}</td>
						<td>{{$r->name}}</td>
						<td class="edit"><button type="button" class="btn btn-primary edit-ref" data-id="{{$r->id}}" data-name="{{$r->name}}"><i class="fas fa-edit"></i></button><button type="button" class="btn btn-primary delete-ref" data-id="{{$r->id}}"><i class="fas fa-trash-alt"></i></button></td>
					</tr>
					@endforeach
					<tr>
						<td></td>
						<td><input type="text" class="form-control" id="new-ref-name"></td>
						<td><button type="button" class="btn btn-primary" id="add-new-ref"><i class="fas fa-plus"></i></button></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col">
			<div class="container">
				<h5>Quick Reference: <span id="edit-id"></span> - <span id="edit-name"></span></h5>
				<select class="form-control mb-3" name="section-select" id="section-select">
					<option value="" disabled selected>Select Section</option>
				</select>
			</div>
			<form method="post" action="" enctype="multipart/form-data">
			<table class="table table-striped table-dark table-hover" style="width:1000px">
				<thead>
					<th class="name">Section Name</th>
					<th class="ref-section">Section Content</th>
				</thead>
				<tbody>
					<form>
						@csrf
						<tr>
							<td class="name"><input type="text" class="form-control" id="section-name"></td>
							<td class="ref-section"><textarea class="ck-editor form-control" id="section-content" name="editor1"></textarea></td>
							<input type="hidden" id="section-id" value="">
						</tr>
					</form>
				</tbody>
			</table>
			<button type="button" class="btn btn-primary" id="new-section"><i class="fas fa-plus"></i></button><button type="button" class="btn btn-primary" id="save-section"><i class="fas fa-save"></i></button><button type="button" class="btn btn-primary" id="delete-section"><i class="fas fa-trash-alt"></i></button>
			</form>
			<table class="table my-5" id="skills-table">
				<thead>
					<th>Skill Name</th>
					<th class="edit"></th>
				</thead>
				<form>
				@csrf
				<tbody id="skills-list">
					<tr>
						<td>
							<select class="form-control" name="skill-select" id="skill-select">
								<option value="" disabled selected>Add Skill</option>
								@foreach($skills as $s)
								<option value="{{$s->name}}">{{$s->name}}</option>
								@endforeach
							</select>
						</td>
						<td><button type="button" class="btn btn-primary" id="add-new-skill" data-ref=""><i class="fas fa-plus"></i></button></td>
					</tr>
				</form>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection

