$(document).ready(function(){
		var radios = $('input[type="radio"]');

		radios.change(function(){
			var catvalue = $('input[name="cat-options"]:checked').val().toLowerCase();
			var ptvalue = $('input[name="pt-options"]:checked').val().toLowerCase();
			var svalue = $('input[name="s-options"]:checked').val().toLowerCase();


			if(catvalue == 'all' || ptvalue == 'all' || svalue == 'all'){
 		    	$("#ctf-list tr").filter(function() {
		      		$(this).show();
  				});
			}

			if(catvalue != 'all'){
				$("#ctf-list tr:visible").filter(function() {
			      	$(this).toggle($(this).find('.cat').text().toLowerCase().indexOf(catvalue) > -1);
			    });
			}

			if(ptvalue != 'all'){
				$("#ctf-list tr:visible").filter(function() {
			      	$(this).toggle(parseInt($(this).find('.pts').text()) <= parseInt(ptvalue) && parseInt($(this).find('.pts').text()) > parseInt(ptvalue)-10);
			    });
			}

			if(svalue != 'all'){
				$("#ctf-list tr:visible").filter(function() {
			      	$(this).toggle($(this).find('.assigned').text().toLowerCase().indexOf(svalue) > -1);
			    });
			}

		});


	    $("#name-search").on("keyup", function() {
		    var value = $(this).val().toLowerCase();
		    $("#ctf-list tr").filter(function() {
		      $(this).toggle($(this).find('.ctf-name').text().toLowerCase().indexOf(value) > -1)
		    });
		  });


	   	$('#descriptionModal').on('show.bs.modal', function(event){
	     	  var button = $(event.relatedTarget);
			  var title = button.data('title');
			  var msg = button.data('msg');
			  var modal = $(this);
			  modal.find('.modal-header').text(title);
			  modal.find('.modal-body').text(msg);
	     });

	    $('#flagModal').on('show.bs.modal', function(event){
	     	  var button = $(event.relatedTarget);
			  var title = button.data('title');
			  var modal = $(this);
			  modal.find('.modal-header').text('Submit ' + title + ' Flag');
	     });
});

$(document).on('show.bs.modal', '#flagModal', function(event){
	var button = $(event.relatedTarget);
	var flagId = button.data('title')
	//set submit data
	$('#submit-flag').data('flag-id', flagId);
});

$(document).on('click', '#submit-flag', function(){
	var name = $('#submit-flag').data('flagId');
	var type = $('#submit-flag').data('type');
	var flag = $('#flag').val();

	$.ajax({
		url: '/student/submit/flag/'+name,
		type: 'post',
		data: {type: type, flag: flag},
		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success: function(data){
			location.reload();
		},
		error: function(data){
			console.log(data);
		}
	});

});


function updateCtfRow(){

}

