jQuery(document).ready(function($) {
	$('.crispgallery-color').iris();

	$('#crispgallery-update').click(function(e) {
    	e.preventDefault();
    	$('#publish').click();
	});
});