
<form id="edit-hints" method="POST" action="/teacher/edit/{{$type}}/hints/" data-type="{{$type}}" data-name="test">
	@csrf
	<div class="modal-hints" id="modal-hints">
		<table class="table table-dark table-striped table-borderless" id="modal-hints-table">
			<thead>
				<th scope="col"></th>
				<th scope="col"></th>
				<th scope="col"></th>
			</thead>
			<tbody id="edit-hints-table">
			</tbody>
		</table>
		@if($type === 'lab')
		<nav aria-label="..." id="hint-page-nav" class="bg-dark" data-current="">
			  <ul class="pagination" id='hint-pagination'>
			  </ul>
		</nav>
		@endif
	</div>
	<div>
		<button type="button" class="btn btn-primary" id='add-new-hint' data-toggle="modal" data-target="#newHintModal"><i class="fas fa-plus"></i></button>
		<button type="button" class="btn btn-primary btn-sm" id="update-hints">Update Hints</button>
	</div>
</form>

@include('teacher.resources.modal.newHint')