$(document).on('click', '#hint-reveal', function(){
	var name=$('#vm-name').text();

	$.ajax({
		url: '/student/get/hint/b2r/'+name,
		type: 'post',
		data: {hint: $('#hint-reveal').data('hint-id')},
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			console.log(data);
		    $('#ajax-alert').text('Hint!\n ' + data['hint']);
		    $('#hintModal').modal('hide');
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

$(document).on('show.bs.modal', '#flagModal', function(event){
	var button = $(event.relatedTarget);
	var flagId = button.data('flag')
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
			//refresh data
		},
		error: function(data){
		}
	});

});


$(document).on('click', '.update-model-view', function(){
	var name = $(this).data('name');
	$.get('/student/get/b2r/'+name, function(data){
		updateMachineInfo(data['machine']);
		populateUserHints(data['userHints']);
		populateRootHints(data['rootHints']);
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

function populateUserHints(userHints){
	$('#user-hints').empty();

	for(i=0; i<userHints.length; i++){
		html = '<button type="button" class="btn btn-primary my-2" \
		id="user-hint-n" data-toggle="modal" data-target="#hintModal" data-hint-id="'+userHints[i]['id']+'" \
		data-msg="Revealing this hint will reduce your total online score (but not your grade). Do you still want to reveal User Hint #'+(i+1)+'" \
		data-isroot="false">Hint #'+(i+1)+'</button><br>'

		$('#user-hints').append(html);
	}


}

function populateRootHints(rootHints){
	$('#root-hints').empty();

	for(i=0; i<rootHints.length; i++){
		html = '<button type="button" class="btn btn-primary my-2" \
		id="user-hint-n" data-toggle="modal" data-target="#hintModal" data-hint-id="'+rootHints[i]['id']+'" \
		data-msg="Revealing this hint will reduce your total online score (but not your grade). Do you still want to reveal Root Hint #'+(i+1)+'" \
		data-isroot="false">Hint #'+(i+1)+'</button><br>'

		$('#root-hints').append(html);
	}
}