
$(document).ready(function () {
    $('#section-content').summernote();

});

$(document).on('click', '.edit-ref', function(event){
	var id = $(this).data('id');
	$('#edit-id').text(id);
	$('#edit-name').text($(this).data('name'));
	$('#add-new-skill').attr('data-ref', id);
	updateSectionList(id);
	updateSkillList(id);
})

$(document).on('click', '#new-section', function(event){
	$('#section-name').val('');
	$('#section-content').summernote('code', '');
	$('#section-id').attr('value', '');
})

$(document).on('click', '#add-new-skill', function(){
	var skill = $('#skill-select').val();
	var refId = $('#edit-id').text();
	if(refId != ''){
		$.ajax({
			url: '/teacher/create/reference/skill/'+refId,
			type: 'post',
			data: {skill: skill},
			headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(data){
				updateSkillList(refId);
			},
			error: function(data){
				console.log(data);
			}
		});
	}
});

$(document).on('click', '.delete-skill', function(){
	var skill = $(this).data('name');
	var refId = $('#edit-id').text();

	$.ajax({
		url: '/teacher/delete/reference/skills/'+refId,
		type: 'post',
		data: {skill: skill},
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			updateSkillList(refId);
		},
		error: function(data){
			console.log(data);
		}
	});

});

$(document).on('change', '#section-select', function(){
	var id = $(this).val();
	updateSection(id);
});

$(document).on('click', '#save-section', function(){
	var ref_id = $('#edit-id').text();
	var name = $('#section-name').val();
	var content = $('#section-content').val();

	if($('#section-id').attr('value') == ''){
		$.ajax({
			url: '/teacher/create/section/'+ref_id,
			type: 'post',
			data: {name: name, content: content},
			headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(data){
				updateSectionList(ref_id);
			},
			error: function(data){
				console.log(data);
			}
		});
	}else{
		var id = $('#section-id').attr('value')
		$.ajax({
			url: '/teacher/update/section/'+id,
			type: 'post',
			data: {name: name, content: content},
			headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(data){
				updateSectionList(ref_id);
			},
			error: function(data){
				console.log(data);
			}
		});
	}
})

$(document).on('click', '#delete-section', function(event){
	var id = $('#section-id').attr('value')

	if(id != ''){
		var ref_id = $('#edit-id').text();
		$.ajax({
			url: '/teacher/delete/section/'+id,
			type: 'post',
			headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(data){
				updateSectionList(ref_id);
				$('#section-name').val('');
				$('#section-content').summernote('code', '');
				$('#section-id').attr('value', '');
			},
			error: function(data){
				console.log(data);
			}
		});
	}
});

$(document).on('click', '.delete-ref', function(){
	var id = $(this).data('id');
	$.ajax({
		url: '/teacher/delete/reference/'+id,
		type: 'post',
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			location.reload();
		},
		error: function(data){
			console.log(data);
		}
	});

})

$(document).on('click', '#add-new-ref', function(){
	var name = $('#new-ref-name').val();
	console.log(name);
	$.ajax({
		url: '/teacher/create/reference',
		type: 'post',
		data: {name: name},
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			location.reload();
		},
		error: function(data){
			console.log(data);
		}
	});
});

function updateSectionList(id){
	$.ajax({
		url: '/teacher/get/sections/name/'+id,
		type: 'get',
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			populateSectionList(data);

		},
		error: function(data){
			console.log(data);
		}
	});
}

function populateSectionList(data){
	$('#section-select option:gt(0)').remove();
	for(i=0; i<data.length; i++){
		html = '<option value="' + data[i]['id'] + '">Section '+ (i+1) + ': '+data[i]['name']+'</option>';
		$('#section-select').append(html);
	}
}

function updateSection(id){
	$.ajax({
		url: '/teacher/get/section/'+id,
		type: 'get',
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			$('#section-name').val(data['name']);
			$('#section-content').summernote('code', data.content);
			$('#section-id').attr('value', data.id);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function updateSkillList(id){
	$.ajax({
		url: '/teacher/get/reference/skills/'+id,
		type: 'get',
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			$("#skills-table tr").not(':last').not(':first').remove();
			for(i=0; i<data.length; i++){
				html = '<tr>\n<td>'+data[i]['skill_name']+'</td>\n<td><button type="button" class="btn btn-primary delete-skill" data-name="'+data[i]['skill_name']+'"><i class="fas fa-trash-alt"></i></button></td>\n</tr>'
				$('#skills-list').prepend(html);
			}
		},
		error: function(data){
			console.log(data);
		}
	});
}