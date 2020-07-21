//------------------COURSE JQUERY---------------------//

$(document).on('click', '#add-new-course', function(){
	var courseName = $('#new-course-name').val();

	$.ajax({
		url: '/teacher/create/course',
		type: 'post',
		data: {name: courseName},
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			location.reload();
		},
		error: function(data){
			console.log(data);
		}
	});	
});

$(document).on('click', '.delete-course', function(){
	var id = $(this).data('id');
	var courseName = $('#course-'+id).text();

	$.ajax({
		url: '/teacher/delete/course/' + courseName,
		type: 'post',
		data: {name: courseName},
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			location.reload();
		},
		error: function(data){
			console.log(data);
		}
	});	
});

//------------------CLASS JQUERY---------------------//
$(document).on('click', '#add-new-class', function(){
	var courseName = $('#new-class-course').val();
	var teacherName = $('#new-class-teacher').val();
	var bell = $('#new-class-bell').val();

	$.ajax({
		url: '/teacher/create/class',
		type: 'post',
		data: { course: courseName, teacher : teacherName, bell : bell},
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			location.reload();
		},
		error: function(data){
			console.log(data);
		}
	});
});

$(document).on('click', '.delete-class', function(){
	var id = $(this).data('id');
	$.ajax({
		url: '/teacher/delete/class/'+id,
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



//------------------SELECT JQUERY---------------------//

$(document).ready(function(){
	$.ajax({
		url: '/teacher/get/courses',
		type: 'get',
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			makeCourseList(data);
		},
		error: function(data){
			console.log(data);
		}
	});
});


$(document).ready(function(){
	$.ajax({
		url: '/teacher/get/teachers',
		type: 'get',
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			makeTeacherList(data);
		},
		error: function(data){
			console.log(data);
		}
	});
})





function makeCourseList(courses){
	$('#new-class-course').empty();
	for(i=0; i<courses.length; i++){
		html = '<option value = "' + courses[i]['name'] + '">'+ courses[i]['name'] + '</option>\n';
		$('#new-class-course').append(html);
	}
}

function makeTeacherList(teachers){
	$('#new-class-teacher').empty();
	for(i=0; i<teachers.length; i++){
		html = '<option value = "' + teachers[i] + '">'+ teachers[i] + '</option>\n';
		$('#new-class-teacher').append(html);
	}
}