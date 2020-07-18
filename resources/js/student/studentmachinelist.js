$(document).ready(function(){
		var radios = $('input[type="radio"]');

		radios.change(function(){
			var osvalue = $('input[name="os-options"]:checked').val().toLowerCase();
			var ptvalue = $('input[name="pt-options"]:checked').val().toLowerCase();
			var svalue = $('input[name="s-options"]:checked').val().toLowerCase();


			if(osvalue == 'all' || ptvalue == 'all' || svalue == 'all'){
 		    	$("#machine-list tr").filter(function() {
		      		$(this).show();
  				});
			}

			if(osvalue != 'all'){
				$("#machine-list tr:visible").filter(function() {
			      	$(this).toggle($(this).find('.os').text().toLowerCase().indexOf(osvalue) > -1);
			    });
			}

			if(ptvalue != 'all'){
				$("#machine-list tr:visible").filter(function() {
			      	$(this).toggle(parseInt($(this).find('.pts').text()) <= parseInt(ptvalue) && parseInt($(this).find('.pts').text()) > parseInt(ptvalue)-10);
			    });
			}

			if(svalue != 'all'){
				$("#machine-list tr:visible").filter(function() {
			      	$(this).toggle($(this).find('.assign').text().toLowerCase().indexOf(svalue) == 0);
			    });
			}
		});

	    $("#name-search").on("keyup", function() {
		    var value = $(this).val().toLowerCase();
		    $("#machine-list tr").filter(function() {
		      $(this).toggle($(this).find('.machine-name').text().toLowerCase().indexOf(value) > -1)
		    });
		  });

});


