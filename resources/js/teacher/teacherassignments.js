$(document).on('click', '.edit-assignment', function(){
	var id = $(this).data('id');
	var type = $(this).data('prefix').toLowerCase();
	makeForm(type, id);

	$.ajax({
		url: '/teacher/get/all/'+type,
		type: 'get',
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			populateForm(data, type, id);
		},
		error: function(data){
			console.log(data);
		}
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

	$.ajax({
		url: '/teacher/update/assignment/'+id,
		type: 'post',
		data: postData,
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			
		},
		error: function(data){
			console.log(data);
		}
	});
})

$(document).on('click', '#delete-assignment', function(){
	var id = $(this).data('id');

	$.ajax({
		url: '/teacher/delete/assignment/'+id,
		type: 'post',
		data: postData,
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			location.reload();
		},
		error: function(data){
			console.log(data);
		}
	});
})

$(document).on('change', '#student-select', function(){
	var id = $(this).val();
	$.ajax({
		url: '/teacher/get/student/'+id+'/assignments/completed',
		type: 'get',
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			populateComplete(data);
		},
		error: function(data){
			console.log(data);
		}
	});

	$.ajax({
		url: '/teacher/get/student/'+id+'/assignments/incomplete',
		type: 'get',
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			populateIncomplete(data);
		},
		error: function(data){
			console.log(data);
		}
	});
});

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

	$.ajax({
		url: '/teacher/get/assignment/modelname/'+id,
		type: 'get',
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			$('#edit-model-select').val(data['name']);
		},
		error: function(data){
			console.log(data);
		}
	});	


	if(type == "lab"){
		$.ajax({
			url: '/teacher/get/assignment/levels/'+id,
			type: 'get',
			headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(data){
				$('#start-flag').val(data['start']);
				$('#end-flag').val(data['end']);
			},
			error: function(data){
				console.log(data);
			}
		});	
	}
}

function populateComplete(assignments){
	$('#completed-assignments').empty();
	for(i=0; i < assignments.length; i++){
		var type = assignments[i]['prefix'].toLowerCase();
		var info = assignments[i][type];
		if(type == 'lab'){
			html='<p>'+assignments[i]['prefix']+': '+info[type+'_name'] + ' Levels:'+info['start_level']+'-'+info['end_level'] + '</p>';
		}else if(type == 'b2r'){
			flag=''
			if(info['user'] == 1){
				flag = flag+"|user"
			}
			if(info['root'] == 1){
				flag = flag + " |root"
			}
			flag = flag + "|"
			html='<p>'+assignments[i]['prefix']+': '+info[type+'_name'] + '\r\n Flag(s):' + flag + '</p>';
		}else{
			html='<p>'+assignments[i]['prefix']+': '+info[type+'_name'] + '</p>';
		}

		$('#completed-assignments').append(html);
	}
}

function populateIncomplete(assignments){
	$('#incomplete-assignments').empty();
	for(i=0; i < assignments.length; i++){
		var type = assignments[i]['prefix'].toLowerCase();
		var info = assignments[i][type];
		if(type == 'lab'){
			html='<p>'+assignments[i]['prefix']+': '+info[type+'_name'] + ' Levels:'+info['start_level']+'-'+info['end_level'] + '</p>';
		}else if(type == 'b2r'){
			flag=''
			if(info['user'] == 1){
				flag = flag+"|user"
			}
			if(info['root'] == 1){
				flag = flag + " |root"
			}
			flag = flag + "|"
			html='<p>'+assignments[i]['prefix']+': '+info[type+'_name'] + '\r\n Flag(s):' + flag + '</p>';
		}else{
			html='<p>'+assignments[i]['prefix']+': '+info[type+'_name'] + '</p>';
		}
		$('#incomplete-assignments').append(html);
	}
}
