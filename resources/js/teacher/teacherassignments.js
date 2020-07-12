$(document).on('click', '.edit-assignment', function(){
	var id = $(this).data('id');
	var type = $(this).data('prefix').toLowerCase();
	makeForm(type, id);
	$.get('/api/teacher/get/all/'+type, function(data){
		populateForm(data, type, id);
	});
});

$(document).on('click', '#edit-assignment', function(){
	var id = $(this).data('id');
	var inputs = $('#edit-container').find(':input');
	var postData = {};
	for(i = 0; i<inputs.length-2; i++){
		var tmpField = $(inputs[i]).attr('id');
		var tmpVal = $(inputs[i]).val();
		postData[tmpField] = tmpVal;
	}
	$.post('/api/teacher/update/assignment/'+id, postData, function(data){
		
	}).fail(function(data){
		
	})
})

$(document).on('click', '#delete-assignment', function(){
	var id = $(this).data('id');

	$.post('/api/teacher/delete/assignment/'+id, function(data){
		location.reload();
	});
})


function makeForm(type, id){
	$('#edit-container').empty();
	html = '<form>\n<label for="model-select">Assign Resource</label> \
		<select class="form-control" name="model-select" id="edit-model-select"></select>\n'

	if(type == 'b2r'){ 
		html= html + '<label for="flag-select" class="my-2">Flags Required</label>\n \
		<select class="form-control" name="flag-select" id="flag-select">\n \
			<option value="both">User and Root</option>\n \
			<option value="root">Root Only</option>\n \
			<option value="user">User Only</option>\n \
		</select>\n'

		
	}else if(type == 'lab'){
		html = html + '<div class="container d-flex justify-content-between my-3">\n \
						<label for="start-flag">Starting Flag</label>\n \
						<input type="number" class="form-control mx-3" name="start-flag" id="start-flag">\n \
						<label for="end-flag">Ending Flag</label>\n \
						<input type="number" class="form-control mx-3" name="end-flag" id="end-flag">\n \
					</div>'
	}
	html = html+'<button type="button" class="btn btn-primary my-2" id="edit-assignment" data-id="'+id+'"><i class="fas fa-save"></i></button>\n \
	 			 <button type="button" class="btn btn-primary my-2" id="delete-assignment" data-id="'+id+'"><i class="fas fa-trash-alt"></i></button>\n \
		</form>';

	$('#edit-container').append(html);
}

function populateForm(data, type, id){
	for(i=0; i<data.length; i++){
		$('#edit-model-select').append('<option value="'+data[i]+'">'+data[i]+'</option>');
	}

	$.get('/api/teacher/get/assignment/modelname/'+id, function(data){
		$('#edit-model-select').val(data['name']);
	});

	if(type == "lab"){
		$.get('/api/teacher/get/assignment/levels/'+id, function(data){
			$('#start-flag').val(data['start']);
			$('#end-flag').val(data['end']);
		})
	}
}

