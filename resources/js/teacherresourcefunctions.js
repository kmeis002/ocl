
//--------------------------Delete Model JQUERY--------------------------------//
$(document).on('click', '.delete-model', function(){
	var name = $(this).data('name');
	var type = $(this).data('type');

	$.post('/api/teacher/delete/'+type+'/'+name, function(data){
		location.reload();
	});

});


//--------------------------Skills JQUERY--------------------------------//
//collapse skills
$(document).on('click', '#collapse-skills', function(){
	if($('#collapse-skills-icon').attr('class').includes('compress')){
		$('#edit-skills').hide();
		$('#collapse-skills-icon').attr('class', 'fas fa-expand-arrows-alt');
	}else{
		$('#edit-skills').show();
		$('#collapse-skills-icon').attr('class', 'fas fa-compress-arrows-alt');
	}
});

//Add new VM Skill
$(document).on('click', '#add-new-skill', function(){
	modeltype = $('#type-header').data('model-type');
	name= $('#edit-vm-name').text();
	skill = $('#new-skill').val();
	$.post('/api/teacher/create/vmskill/'+name, {skill: skill}, function(data){
		window.getModelInfo(modeltype, name);
	});
});

//Delete VM Skill
$(document).on('click', '.delete-skill', function(){
	modeltype = $('#type-header').data('model-type');
	name= $('#edit-vm-name').text();
	skill = $('#new-skill').val();
	skillId = $(this).attr('id').split('-')[2];
	$.post('/api/teacher/delete/vmskill/' + name, {id: skillId}, function(){
		window.getModelInfo(modeltype, name);
	})
});



//--------------------------OVA JQUERY--------------------------------//
//OVA Upload
$(document).on('show.bs.modal', '#uploadOvaModal', function(event){
	var button = $(event.relatedTarget);
	var name = window.convertName(button.data('name'));
	$('#ova-file').attr('onchange', 'window.selectorScript(\'http://www.ocl.dev/api/teacher/upload/chunkupload\',\''+name+'\')');
});

//OVA Delete
$(document).on('click', '#delete-ova', function(){
	var name = window.convertName($('#edit-vm-name').text());
	$.post('/api/teacher/delete/vm/file/' + name, function(data){
		console.log(data);
		$('#edit-file-name').text('');
	}).fail(function(data){
		console.log(data);
	});
});


//--------------------------VM Management JQUERY----------------------//
//manage vm Modal
$(document).on('click', '.vmmanage-modal', function(event){
	var button = $(this);
	var name = button.data('name');
	var modal = $('#vmManageModal');
	modal.modal('show');
	modal.find('.modal-title').text('Manage ' + name + ' Virtual Machine');
	modal.data('name', name);
	$.get('/api/teacher/get/vbox/interfaces', function(data){
		$('#vm-bridged-adapter').empty();
		for(i = 0; i < data.length; i++){
			$('#vm-bridged-adapter').append('<option value='+data[i]+'>'+data[i]+'</option.');
		}
	});
	updateVMManage(name);
});

//Reload page for status changes on management close.
$(document).on('hide.bs.modal', '#vmManageModal', function(){
	location.reload();
});

//Change VM Network Mode
$(document).on('click', '#modify-network-mode', function(){
	var name = $('#vmManageModal').data('name');
	var mode = $('#vm-network-mode').val();
	$.post('/api/teacher/set/vbox/network/'+window.convertName(name), {'vm-network-mode' : mode}, function(data){
		alert(data['message']);
		updateVMManage(name);
	});
});

//Change VM Bridged Adapter
$(document).on('click', '#modify-bridged-adapter', function(){
	var name = $('#vmManageModal').data('name');
	var device = $('#vm-bridged-adapter').val();
	$.post('/api/teacher/set/vbox/bridged/'+window.convertName(name), {'vm-bridged-adapter' : device}, function(data){
		alert(data['message']);
		updateVMManage(name);
	});
});

//Toggle Power Button
$(document).on('click', '#vm-power-toggle', function(){
	var name = $('#vmManageModal').data('name');
	//set status to indicate awaiting repsonse
	makeSpinner('vm-status');
	$.post('/api/teacher/set/vbox/power/' + window.convertName(name), function(data){
		makeStatus(data['status']);
	}).fail(function(data){
		json = data['responseJSON'];
		makeStatus(json['status']);
	});
});

//Reset Button
$(document).on('click', '#vm-reset', function(){
	var name = $('#vmManageModal').data('name');
	//set status to indicate awaiting repsonse
	makeSpinner('vm-status');
	$.post('/api/teacher/set/vbox/reset/' + window.convertName(name), function(data){
		console.log(data);
		makeStatus(data['status']);
	}).fail(function(data){
		json = data['responseJSON'];
		makeStatus(json['status']);
	});
});

//Unregister Button
$(document).on('click', '#unregister-vm', function(){
	var name = $('#vmManageModal').data('name');
	$.post('/api/teacher/set/vbox/unregister/'+window.convertName(name), function(data){
		alert(data['message']);
		location.reload();
	}).fail(function(data){
		json = data['responseJSON'];
		alert(json['message']);
		location.reload();
	});
});

//Register Button
$(document).on('click', '#register-vm', function(){
	var name = $('#vmManageModal').data('name');
	$.post('/api/teacher/set/vbox/register/'+window.convertName(name), function(data){
		location.reload();
	}).fail(function(data){
		console.log(data);
	});
});




//--------------------------Functions-------------------------------//
function updateVMManage(name){
	$.get('/api/teacher/get/vbox/vminfo/'+window.convertName(name), function(data){
		makeStatus(data['status']);
		if(data['registered']){
			$('#vm-register-state').text('Machine is Registered.');
			$('#register-vm').hide();
			$('#unregister-vm').show();
			$('#vm-network-table').show();
			$('#vm-power').show();
			if(data['NIC 1'].includes('Bridged')){
				$('#vm-network-mode').val('Bridged');
				$('.vm-bridged').show();
				$('#vm-bridged-adapter').val(data['NIC 1'].split('\'')[1]);
			}else if(data['NIC 1'].includes('NAT')){
				$('#vm-network-mode').val('NAT');
				$('.vm-bridged').hide();
			}
		}else{
			$('#vm-register-state').text('Machine is not yet registered.');
			$('#unregister-vm').hide();
			$('#register-vm').show();
			$('#vm-network-table').hide();
			$('#vm-power').hide();
		}
	});
}


window.getModelInfo = function(modeltype, name, page=0){
	if(!modeltype.includes('hints')){
		var baseAction = $('#edit-'+modeltype).attr('action');
		baseAction = '/'+ baseAction.split("/")[1] +'/'+ baseAction.split("/")[2] +'/'+ baseAction.split("/")[3] + '/'
		$('#edit-'+modeltype).attr('action', baseAction+name);
	}
	var url = '/api/teacher/get/'+modeltype+'/'+name;
	var output;
	$.get( url , {'page':page}, function( data ) {
		if(!modeltype.includes('hints')){
	  		window.updateModelView(modeltype, data);
	  	}else if(modeltype.includes('b2r')){
	  		window.updateB2RHintModal(data, name);
	  	}else if(modeltype.includes('lab')){
	  		$('#add-new-hint-form').attr('data-levels', data['levels']);
	  		window.updateLabHintModal(data['hints'], name, data['levels']);

	  	}
	});
}

window.updateModelView = function(modeltype, ajaxdata){
	if(modeltype == 'b2r' || modeltype == 'lab'){

		vm = ajaxdata[modeltype];
		$('#edit-vm-name').text(vm['name']);
		$('#edit-pts').val(vm['points']);
		$('#edit-ip').val(vm['ip']);
		$('#edit-file-name').text(vm['file']);
		$('#edit-os-select').val(vm['os']);
		$('#edit-icon-picker').val(vm['icon']);
		$('#edit-description').val(vm['description']);

		if(modeltype == 'b2r'){
			$('#edit-root-flag').val(vm['flags']['root_flag']);
			$('#edit-user-flag').val(vm['flags']['user_flag']);
		}


		if(modeltype == 'lab'){
			window.clearLevelFlags();
			var flags = ajaxdata[modeltype]['flags'];
			flags.forEach(function(item, index, array){
				window.makeLevelLineItem(item['level'], item['id'], index == array.length-1);
				$('#level-flag-'+item['level']).val(item['flag']);
			});
		}

		//make and update skill items for vm
		window.makeSkillLineItems(ajaxdata[modeltype]['skills']);
		window.updateSkillItems(ajaxdata[modeltype]['skills']);
	}
}



window.updateB2RHintModal = function (ajaxdata, name){
	levels = 0;
	ajaxdata.forEach(function(item, index){
		window.makeHintRow(item,index, 'b2r', levels);
		window.populateHintRow(item, 'b2r', index);
	});
}

window.updateLabHintModal = function (ajaxdata, name, levels){
	$('#edit-hints-table').empty();

	window.makePagination(ajaxdata['last_page']);
	data=ajaxdata['data'];
	currentPage = ajaxdata['current_page']
	//set current page for refresh
	$('#hint-page-nav').attr('data-current', currentPage);
	data.forEach(function(item, index){
		window.makeHintRow(item,index, 'lab', levels );
		window.populateHintRow(item, 'lab', index);
	});
	$('#hint-page-'+currentPage).attr('class', 'page-item active');

}

window.updateLevelItem = function(item, index){
	window.makeLevelLineItem(item['level'], item['id']);
	$('#level-flag-'+item['level']).val(item['flag']);
}

window.clearLevelFlags = function(){
	$('#level-flags-body').empty();
}

window.makeLevelLineItem = function (level, id, lastElement=false){
	idLabel = 'level-flag-'+level;
	html = '<tr><td><label for="'+idLabel+'" class="my-1">Level ' + level + ' Flag</label>\n'
	html = html+'<input type="text" class="form-control" id="'+idLabel+'" name="flag-'+level+'"></td>\n'
	if(lastElement){
		html = html+'<td><button type="button" class="btn btn-primary my-4 delete-level" data-id="'+id+'"><i class="fas fa-trash-alt"></i></button></td></tr>';
	}else{
		html = html+'<td></td></tr>';
	}
	$('#level-flags-body').append(html);
}

window.makeSkillLineItems= function(data){
	$('#skills-body').empty();
	skillSelect = makeSkillsList();
	for(i=1; i<=data.length; i++){
		html = '<tr><td><label class="my-2">Skill #'+(i)+'</label>\n'
		html = html + '<select name="skill-'+data[i-1]['id']+'" id="skill-'+data[i-1]['id']+'" class="form-control mx-1">\n'
		html = html+ skillSelect;
		html = html + '</select></td><td class="align-bottom">\n<button type="button" class="mx-2 btn btn-primary delete-skill" id="delete-skill-'+data[i-1]['id']+'"><i class="fas fa-trash-alt"></i></button>\n</td>\n</tr>';
		$('#skills-body').append(html);
	}	

	html = '<tr><td ><label class="my-2">Add New Skill</label>\n<select name="new-skill" id="new-skill" class="form-control mx-1">\n';
	html = html + skillSelect;
	html = html + '</select></td>\n<td class="align-bottom">\n<button type="button" class="mx-2 btn btn-primary align-middle" id="add-new-skill"><i class="fas fa-plus"></i></button>\n</td>\n</tr>'
	$('#skills-body').append(html);
}

window.updateSkillItems= function(data){
	data.forEach(function(item, index){
		$('#skill-'+item['id']).val(item['skill']);
	});
}



window.convertName= function (name){
	return name.toLowerCase().replace(/ /g, '_');
}

function makeSkillsList(){
	$.ajax({
    url: '/api/teacher/get/skills',
    success: function(data) {
      skills = data;
    },
    async:false
  });
	html = '';
	skills.forEach(function(item, index){
		html = html+'<option value="'+item['name']+'">'+item['name']+'</option>\n';
	});
	return html;

}

function makeSpinner(id){
	$('#'+id).empty();
	spinner='<div class="spinner-border text-primary" role="status"><span class="sr-only"></span></div>';
	$('#'+id).append(spinner);
}1

function makeStatus(status){
	$('#vm-status').empty();
	if(status){
		$('#vm-status').append('<i class="fas fa-power-off fa-2x text-primary"></i>');
	}else{
		$('#vm-status').append('<i class="fas fa-power-off  fa-2x text-danger"></i>');
	}
}