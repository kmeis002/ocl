$(document).ready(function() {
	$('#menu-trigger').on('click', function () {
		$(this).toggleClass('menu-clicked');
		$('#side').toggleClass('slide-in');
		$('#main').toggleClass('slide-content');
	});
}); 