$(document).ready(function(){
	//management buttons
	$('.edit-b2r').click(function(){
		//edit form action
		/*
		var baseAction = $('#edit-b2r').attr('action');
		baseAction = '/'+ baseAction.split("/")[1] +'/'+ baseAction.split("/")[2] +'/'+ baseAction.split("/")[3] + '/';
		$('#edit-b2r').attr('action', baseAction+$(this).data('name'));*/
		window.getModelInfo($('#type-header').data('model-type'), $(this).data('name'));
	})



	//manual flags for creating VM
	$('#manual-flags').change(function(){
		if(($(this).val() == "Manual")){
			$('#flags').show();
		}else{
			$('#flags').hide();
		}
	});




});