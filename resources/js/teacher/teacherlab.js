$(document).ready(function(){

	$('.edit-lab').click(function(){
		window.getModelInfo($('#type-header').data('model-type'), $(this).data('name'));
	})


	//collapse level flags
	$('#collapse-flags').click(function(){
		if($('#collapse-flags-icon').attr('class').includes('compress')){
			$('#level-flags').hide();
			$('#collapse-flags-icon').attr('class', 'fas fa-expand-arrows-alt');
		}else{
			$('#level-flags').show();
			$('#collapse-flags-icon').attr('class', 'fas fa-compress-arrows-alt');
		}
	});


	//collapse skills


	//add new level, api creates random flag to be updated by user
	$('#new-lab-level').click(function(){
		name=$('#edit-vm-name').text();
		if(name == ''){
			alert('Please select a machine before adding a level');
		}else{
			$.ajax({
				url: '/teacher/create/lab/'+name+'/level',
				type: 'post',
				headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				success: function(data){
				    window.getModelInfo($('#type-header').data('model-type'), name);
				},
				error: function(data){
					console.log(data);
				}
			});
		}
	});




	//manual flags for creating VM Modal
	$('#manual-flags').change(function(){
		if(($(this).val() == "Manual")){
			$('#flags').show();
		}else{
			$('#flags').hide();
		}
	});

	$('#level-count').keyup(function(event){
		makeLevelFlagItem($(this).val());
	});


	//Remove lab levels
	$(document).on('click', '.delete-level', function(event){
		id = $(this).data('id');
		name=$('#edit-vm-name').text();

		$.ajax({
			url: '/api/teacher/delete/lab/'+name+'/level/'+id,
			type: 'post',
			headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(data){
				window.getModelInfo($('#type-header').data('model-type'), name);
			},
			error: function(data){
				console.log(data);
			}
		});
	});

	function makeLevelFlagItem(levels){
		$('#flags').empty();
		for(i = 1; i<=levels; i++){
			var tmpId = 'level-flag-'+i;
			var line = '<label for="'+tmpId+'">Level #'+i+' Flag</label>\n';
			line = line + '<input type="text" id="'+tmpId+'" name="'+tmpId+'" class="form-control">\n';
			$('#flags').append(line);
		}
	}

	//collapse flags for labs 




});