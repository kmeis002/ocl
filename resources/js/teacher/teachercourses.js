//------------------COURSE JQUERY---------------------//

$(document).on('click', '#add-new-course', function(){
	var courseName = $('#new-course-name').val();
	$.post('/api/teacher/create/course', {name : courseName}, function(data){
		location.reload();
	});
});

$(document).on('click', '.delete-course', function(){
	var id = $(this).data('id');
	var courseName = $('#course-'+id).text();
	$.post('/api/teacher/delete/course/'+courseName, {name : courseName}, function(data){
		location.reload();
	});
});

//------------------CLASS JQUERY---------------------//
$(document).on('click', '#add-new-class', function(){
	var courseName = $('#new-class-course').val();
	var teacherName = $('#new-class-teacher').val();
	var bell = $('#new-class-bell').val();

	$.post('/api/teacher/create/class', { course: courseName, teacher : teacherName, bell : bell}, function(data){
		location.reload();
	})
});

$(document).on('click', '.delete-class', function(){
	var id = $(this).data('id');
	$.post('/api/teacher/delete/class/'+id, function(data){
		location.reload();
	});
});



//------------------SELECT JQUERY---------------------//

$(document).ready(function(){
	$.get('/api/teacher/get/courses', function(data){
		makeCourseList(data);
	})
});


$(document).ready(function(){
	$.get('/api/teacher/get/teachers', function(data){
		makeTeacherList(data);
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