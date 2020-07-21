$('.edit-ctf').click(function(){
	window.getModelInfo($('#type-header').data('model-type'), $(this).data('name'));
})

$(document).on('click', '#delete-zip', function(){
	var name = $('#ctf-name').text();
	console.log(name);
	$.ajax({
		url: '/teacher/delete/ctf/zip/' + name,
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
