$(document).ready(function(){
	     $('#hintModal').on('show.bs.modal', function(event){
	     	  var button = $(event.relatedTarget);
			  var msg = button.data('msg');
			  var modal = $(this);
			  modal.find('.modal-body').text(msg);
			  $('#hint-num').val(button.data('hintnum'));
			  $('#is-root').val(button.data('isroot'));
	     });

	    $('#flagModal').on('show.bs.modal', function(event){
	     	  var button = $(event.relatedTarget);
			  var title = button.data('title');
			  var modal = $(this);
			  modal.find('.modal-header').text(title);
	     });

	  	$('#reveal').click(function(){
	     	$.post("/api/hints/b2r",
	     		{
	     			b2r_name: $('#vm-name').text(),
	     			is_root: $('#is-root').val(),
	     			hint: $('#hint-num').val(),
	     		},
	     		function(data, status){
	     			$('#ajax-alert').text('Machine ' + $('#vm-name').text() + ' Hint #' + (parseInt($('#hint-num').val()) + 1) + ':\n ' + data['hint']);
	     			$('#hintModal').modal('hide');
	     		});
	     });

	  	setInterval(function() {
	    	if($('#status-icon').hasClass('text-danger')){
	    		vm_status = 'off';
	    	}else if ($('#status-icon').hasClass('text-primary')){
	    		vm_status = 'on';
	    	}
	    	$.post("/api/vms/status", 
   			 {
   			 	known_status: vm_status,
   			 	vm_name: $('#vm-name').text(),
   			 },
   			 function(data, status){
   			 	if(data['status'] != vm_status){
   			 		$('#ajax-alert').text(data['msg']);
   			 		$('#status-icon').toggleClass('text-danger');
   			 		$('#status-icon').toggleClass('text-primary');
   			 	}
   			 });
		},10000); 
});