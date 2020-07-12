$(document).on('click', '#hint-reveal', function(){
	var name=$('#vm-name').text();


	$.ajax({
		url: '/student/get/hint/lab/'+name,
		type: 'post',
		data: {hint: $('#hint-reveal').data('hint-id')},
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			console.log(data);
		    $('#ajax-alert').text('Hint!\n ' + data['hint']);
		    $('#hintModal').modal('hide');
		},
		error: function(data){
			console.log(data);
		}
	});
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
	$.get('/student/get/lab/'+name, function(data){
		updateMachineInfo(data['machine']);
		populateLevels(data['levels']);
		populateHints(data['hints']);

	});
});



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
	            	<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#flagModal"><i class="fas fa-plus"></i></button></td>\n\
	        </tr>\n'
	    $('#lab-table-body').append(html);
	}
}

function populateHints(hints){
	var count = 1;
	for(i=0; i<hints.length; i++){
		html = '<button type="button" class="btn btn-primary my-2" \
		id="user-hint-n" data-toggle="modal" data-target="#hintModal" data-hint-id="'+hints[i]['id']+'" \
		data-msg="Revealing this hint will reduce your total online score (but not your grade). Do you still want to reveal User Hint #'+(count)+'" \
		data-isroot="false">Hint #'+(count)+'</button><br>'
		count++;
		if(i < (hints.length-1) && hints[i]['level'] != hints[i+1]['level']){
			count = 1;
		}

		$('#level-hints-'+hints[i]['level']).append(html);
	}


}

