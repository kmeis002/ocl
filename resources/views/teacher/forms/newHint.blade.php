<form id="add-new-hint-form" data-levels="">
	<div class="modal-hints" id="modal-hints">
		<table class="table table-dark table-striped table-borderless" id="new-modal-hint-table"">
			<thead>
				<th scope="col">Hint</th>
				@if($type === 'b2r')
				<th scope="col">Is It A Root Hint?</th>
				@elseif($type === 'lab')
				<th scope="col">Level</th>
				@endif
			</thead>
			<tbody id="new-hint-table">
				<tr>
					<td><textarea id="new-hint" class="form-control" row="3" name="hint"></textarea></td>
					@if($type === 'b2r')
					<td><input type="checkbox" class="form-control" id="is-root" name="is-root"></td>
					@elseif($type === 'lab')
					<td><select class="form-control" id="new-level" name="level">
					</select></td>
					@endif
				</tr>
			</tbody>
		</table>
	</div>
		<button type="button" class="btn-primary btn btn-sm" id="create-hint">Add Hint</button>

</form>