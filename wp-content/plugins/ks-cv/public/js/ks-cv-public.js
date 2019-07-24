jQuery(document).ready(function( ) {
	'use strict';
	
	jQuery('.skillbar').each(function() {
		jQuery(this).find('.skillbar-bar').css('width', jQuery(this).attr('data-percent')+"%");
	});

});

