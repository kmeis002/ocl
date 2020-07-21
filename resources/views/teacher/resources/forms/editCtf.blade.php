<form id="edit-ctf" action="/teacher/edit/{{$type}}/" method="POST">
	@csrf
	<h5 class="mx-3">Name: <span id="ctf-name"></span></h5>

    <p class="mx-3">ZIP File: <span id="edit-file-name"></span><button type="button" class="btn btn-primary mx-4" id="delete-zip"><i class="fas fa-trash-alt"></i></button></p>

	<div class="container d-flex justify-content-between">
		<label for='edit-pts' class="mr-2">Points</label>
		<input class="form-control" id="edit-pts" name="edit-pts" type="number">
		<label class="mx-2" for="icon-picker mx-2">Icon</label>
	    <input type="text" class="form-control mx-2 icon-picker" id="edit-icon-picker" name='edit-icon-picker' placeholder="Pick one from the list or select directly" style="width:50%">
	    <button type="button" class="btn-primary mx-2 picker-button">Select</button><span class="demo-icon"></span>
	</div>
	<label for="description" class="mx-2 my-2">Description</label>
    <textarea id="edit-description" class="form-control mx-2"  name='edit-description' rows="7"></textarea>
    <label for="category" class="my-2 mx-2">Category</label>
    <input class="form-control mx-2" name="edit-category" id="edit-category" type="text">
    <label for="flag" class="my-2 mx-2">Flag</label>
    <input class="form-control mx-2" name="edit-flag" id="edit-flag" type="text">
    <input type="submit" class="update-machine btn-primary mt-2" value="Update Machine">
</form>

 @include('teacher.resources.modal.icon')