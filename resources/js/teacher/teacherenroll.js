$(document).ready(function(){

	$.ajax({
		url: '/teacher/get/students',
		type: 'get',
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			populateStudentList(data);
		},
		error: function(data){
			console.log(data);
		}
	});

	$.ajax({
		url: '/teacher/get/classes',
		type: 'get',
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
		populateClassList(data);
			var classSelect = $('#class-select');
			var id = classSelect.val();
			var bell = classSelect.find('[value="'+id+'"').data('bell');
			var course = classSelect.find('[value="'+id+'"').data('course');
			changeClass(id, bell, course);
			populateEnrolledList(id);
		},
		error: function(data){
			console.log(data);
		}
	});
});

$(document).on('change', '#class-select', function(event){
	var id = $(this).val();
	var bell = $(this).find('[value="'+id+'"').data('bell');
	var course = $(this).find('[value="'+id+'"').data('course');

	changeClass(id, bell, course);
	populateEnrolledList(id);
});

$(document).on('click', '#enroll-student', function(){
	var student = $('#enroll-student-select').val();
	var classId = $('#class-row').attr('data-id');

	$.ajax({
		url: '/teacher/enroll/'+classId,
		type: 'post',
		data: {student : student},
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
		populateClassList(data);
			console.log(data);
			populateEnrolledList(classId);
		},
		error: function(data){
			console.log(data);
		}
	});
});

$(document).on('click', '.unenroll', function(event){
	var student = $(this).data('name');
	var classId = $('#class-row').attr('data-id');


	$.ajax({
		url: '/teacher/unenroll/' + classId,
		type: 'post',
		data: { studentName: student },
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			populateEnrolledList(classId);
		},
		error: function(data){
			console.log(data);
		}
	});
});


function populateStudentList(students){
	$('#enroll-student-select').empty();
	for(i = 0; i<students.length; i++){
		html = '<option value="'+students[i]['name']+'">'+students[i]['last']+', '+students[i]['first']+'</option>\n';
		$('#enroll-student-select').append(html);
	}
}

function populateClassList(classes){
	$('#class-select').empty();
	for(i = 0; i<classes.length; i++){
		html = '<option value="'+classes[i]['id']+'"" data-bell="'+classes[i]['bell']+'" data-course="'+classes[i]['course']+'">'+'Bell: '+classes[i]['bell']+' Course: '+classes[i]['course']+'</option>\n';
		$('#class-select').append(html);
	}
}

function changeClass(id, bell, course){
	$('#class-row').attr("data-id", id);
	$('#class-row-bell').text(bell);
	$('#class-row-course').text(course);
}

function populateEnrolledList(classId){
	$('#class-row-roster').empty();
	$.ajax({
		url: '/teacher/get/enrolled/'+classId,
		type: 'get',
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			for(i = 0; i < data.length; i++){
				html = '<p>'+data[i][0]['last'] + ', ' + data[i][0]['first'] + '<button type="button" class="btn btn-primary unenroll mx-2" data-name="'+data[i][0]['name']+'"><i class="fas fa-trash-alt"></i></button></p>';
				$('#class-row-roster').append(html);
			}
		},
		error: function(data){
			console.log(data);
		}
	});
}