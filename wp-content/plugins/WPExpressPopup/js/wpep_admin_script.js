jQuery(function(){

	jQuery('input[name="wpep_type"]').on('click', function() {
	    
	    jQuery('.wpep_type').fadeOut();
	    jQuery('.'+jQuery(this).attr('id')).fadeIn(500);

	});

	jQuery('input[name="wpep_show_on"]').on('click', function() {
	    
	    jQuery('.wpep_show_on').fadeOut();
	    jQuery('.'+jQuery(this).attr('id')).fadeIn(500);

	});
});