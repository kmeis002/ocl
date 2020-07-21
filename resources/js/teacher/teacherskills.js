$(document).on('click', '.delete-skill', function(){
	var id = $(this).data('id');

	$.ajax({
		url: '/teacher/delete/skill/'+id,
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