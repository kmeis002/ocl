$(document).on('click', '#hint-reveal', function(){
	var name=$('#vm-name').text();
	var id=$('#hint-reveal').data('hint-id');

	$.ajax({
		url: '/student/get/hint/lab/'+name,
		type: 'post',
		data: {hint: id},
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
		    $('#ajax-alert').text('Hint!\n ' + data['hint']);
		    $('#hintModal').modal('hide');
		    $('#hint-'+id).attr('class', 'btn btn-warning my-2 hint-modal');
		},
		error: function(data){
		}
	});
});


$(document).on('click', '.hint-modal', function(event){
	if($(this).attr('class').includes('primary')){
		var msg = $(this).data('msg');
		var id = $(this).data('hint-id');
		$('#hintModal').modal('show');
		$('#hintModal').find('.modal-body').text(msg);
		$('#hint-reveal').data('hint-id', id);
	}else{
		var name=$('#vm-name').text();
		//just reveal hint, no message!
		$.ajax({
		url: '/student/get/hint/lab/'+name,
		type: 'post',
		data: {hint: $(this).data('hint-id')},
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
		    $('#ajax-alert').text('Hint!\n ' + data['hint']);
		    $('#hintModal').modal('hide');
		},
		error: function(data){
			console.log(data);
		}
	});
	}
})

$(document).on('show.bs.modal', '#flagModal', function(event){
	var button = $(event.relatedTarget);
	var flagId = button.data('level')
	//set submit data
	$('#submit-flag').data('flag-id', flagId);
});

$(document).on('click', '#submit-flag', function(){
	var name = $('#vm-name').text();
	var flagId = $('#submit-flag').data('flag-id');
	var flag = $('#flag').val();
	var type = $('#submit-flag').data('type');

	$.ajax({
		url: '/student/submit/flag/'+name,
		type: 'post',
		data: {flag: flag, flagId: flagId, type: type},
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			getModel(name);
		},
		error: function(data){
			console.log(data);
		}
	});

	$('#flagModal').modal('hide');
});

$(document).ready(function(){
	$('#hintModal').on('show.bs.modal', function(event){
	     	  var button = $(event.relatedTarget);
			  var msg = button.data('msg');
			  var modal = $(this);
			  modal.find('.modal-body').text(msg);
			  $('#hint-num').val(button.data('hintnum'));
			  $('#is-root').val(button.data('isroot'));
			  $('#hint-reveal').data('hint-id', button.data('hint-id'));

	});

	$('#flagModal').on('show.bs.modal', function(event){
	     	  var button = $(event.relatedTarget);
			  var title = button.data('title');
			  var modal = $(this);
			  modal.find('.modal-header').text(title);
	});
});

$(document).on('click', '.update-model-view', function(){
	var name = $(this).data('name');

	getModel(name);
	
});

function getModel(name){
	$.ajax({
		url: '/student/get/lab/'+name,
		type: 'get',
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			updateMachineInfo(data['machine']);
			populateLevels(data['levels']);
			populateHints(data['hints']);
			updateStudentInfo(data['flags'], data['hintsUsed']);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function updateMachineInfo(machineInfo){
	var iconClasses='fa-7x ';
	$('#vm-icon').attr('class', iconClasses+machineInfo['icon']);
	$('#vm-name').text(machineInfo['name']);
	$('#vm-os').text(machineInfo['os']);
	$('#vm-points').text(machineInfo['points']);
	$('#vm-ip').text(machineInfo['ip']);

	var skills = machineInfo['skills'];
	skillHtml = '';
	for(i=0; i<skills.length; i++){
		skillHtml = skillHtml + skills[i]['skill'];
		if(i < skills.length-1){
			skillHtml = skillHtml + ' - ';
		}
	}

	$('#vm-skills').text(skillHtml);

	var classes = 'fas fa-power-off fa-2x my-auto mx-2';
	if(machineInfo['status']){
		$('#vm-status-icon').attr('class', classes+' text-primary');
	}else{
		$('#vm-status-icon').attr('class', classes+' text-danger');
	}

	$('#vm-description').text(machineInfo['description']);
}


function populateLevels(levels){

	$('#lab-table-body').empty();

	for(i=1; i<=levels; i++){
		html='<tr>\n\
	            <td scope="row">'+i+'</td>\n\
	                <td>\n\
	                    <div class="btn-group btn-group-sm" id="level-hints-'+i+'" role="group" aria-label="Basic example">\n\
	                    </div>\n\
	                </td>\n\
	            	<td><button type="button" id="flag-submit-'+i+'" class="btn btn-danger" data-toggle="modal" data-target="#flagModal" data-level="'+i+'"><i class="fas fa-plus"></i></button></td>\n\
	        </tr>\n'
	    $('#lab-table-body').append(html);
	}
}

function populateHints(hints){
	var count = 1;
	for(i=0; i<hints.length; i++){
		html = '<button type="button" class="btn btn-primary my-2 hint-modal" \
		id="hint-'+hints[i]['id']+'"" data-hint-id="'+hints[i]['id']+'" \
		data-msg="Revealing this hint will reduce your total online score (but not your grade). Do you still want to reveal User Hint #'+(count)+'" \
		data-isroot="false">Hint #'+(count)+'</button><br>'
		count++;
		if(i < (hints.length-1) && hints[i]['level'] != hints[i+1]['level']){
			count = 1;
		}

		$('#level-hints-'+hints[i]['level']).append(html);
	}
}

function updateStudentInfo(flags, hints){

	//Modify flag buttons
	for(i=1; i<=flags.length; i++){
		if(flags[i-1] == 1){
			$('#flag-submit-'+i).attr('class', 'btn btn-primary');
			$('#flag-submit-'+i).prop('disabled', true);
		}
	}
	//modify hint buttons

	for(i=0; i<hints.length; i++){
		$('#hint-'+hints[i]['hint_id']).attr('class', 'btn btn-warning my-2 hint-modal');
	}
}

