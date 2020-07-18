$(document).on('click', '.edit-student', function(event) {
	var id = $(this).data('id');
	$.ajax({
		url: '/teacher/accounts/edit/student/'+id,
		type: 'get',
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
		    populateTeacherForm(data);
		},
		error: function(data){
			console.log(data);
		}
	});
});

$(document).on('click', '.edit-teacher', function(event) {
	var id = $(this).data('id');
	$.ajax({
		url: '/teacher/accounts/edit/teacher/'+id,
		type: 'get',
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
		    populateTeacherForm(data);
		},
		error: function(data){
			console.log(data);
		}
	});
});


$(document).on('click', '.delete-student', function(){
	var id = $(this).data('id');
		$.ajax({
		url: '/teacher/accounts/delete/student/'+id,
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

$(document).on('click', '.delete-teacher', function(){
	var id = $(this).data('id');
		$.ajax({
		url: '/teacher/accounts/delete/teacher/'+id,
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


$(document).on('click', '#add-new-student', function(){
	var action = '/teacher/accounts/create/student';
	$('#modify-student').attr('action', action);
	$('#name').show();
	$('#student-name').text('');
	$('#first').val('');
	$('#last').val('');

});

$(document).on('click', '#add-new-teacher', function(){
	var action = '/teacher/accounts/create/teacher';
	$('#modify-teacher').attr('action', action);
	$('#name').show();
	$('#teacher-name').text('');
	$('#first').val('');
	$('#last').val('');

});

$(document).on('click', '#api-reveal', function(){
	$('#api-token').attr('type', 'text');
});

$(document).on('click', '#api-regen', function(){
	var id = $(this).data('id');
	console.log(id);
	$.ajax({
		url: '/teacher/accounts/teacher/api_regen/'+id,
		type: 'post',
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
		    location.reload();
		},
		error: function(data){
			console.log(data);
		}
	});
});

function populateStudentForm(student){
	$('#student-name').text(student['name']);
	$('#first').val(student['first']);
	$('#last').val(student['last']);
	$('#name').hide();
	var action = '/teacher/accounts/edit/student/'+student['id'];

	$('#modify-student').attr('action', action);
}

function populateTeacherForm(teacher){
	$('#api-regen').data('id', teacher['id']);
	$('#api-token').attr('type', 'password');
	$('#api-token').attr('type', 'password');
	$('#teacher-name').text(teacher['name']);
	$('#email').val(teacher['email']);
	$('#api-token').val(teacher['api_token']);
	$('#name').hide();

	var action = '/teacher/accounts/edit/teacher/'+teacher['id'];

	$('#modify-teacher').attr('action', action);
}
