jQuery(document).ready( function () {
	'use strict';
	
	/* repetable meta field */
	jQuery('.repeatable-add').click(function() {
		var field = jQuery(this).closest('.wrap').find('.custom_field_repeatable li:last').clone(true);
		var fieldLocation = jQuery(this).closest('.wrap').find('.custom_field_repeatable li:last');
		jQuery('input', field).val('');
		field.insertAfter(fieldLocation);		    
	})
	
	jQuery('.repeatable-remove').click(function() {
	    jQuery(this).parent().remove();
	    return false;
	});
	
	//media uploader associated to meta field of post or term
	////////////////
	// Instantiates the variable that holds the media library frame.
	var metaImageFrame;
	
	jQuery( 'body' ).click(function(e) {
		// Get the btn
		var btn = e.target;

		// Check if it's the upload button
		if ( !btn || !jQuery( btn ).attr( 'data-media-uploader-target' ) ) return;
		
		// Get the field target
		var field = jQuery( btn ).data( 'media-uploader-target' );
		
		// Prevents the default action from occuring.
		e.preventDefault();
		
		// Sets up the media library frame
		metaImageFrame = wp.media.frames.metaImageFrame = wp.media({
			title: 'Choisir une icone',
			button: { text:  'Utiliser ce fichier' },
		});
		
		// Runs when an image is selected.
		metaImageFrame.on('select', function() {

			// Grabs the attachment selection and creates a JSON representation of the model.
			var media_attachment = metaImageFrame.state().get('selection').first().toJSON();

			// Sends the attachment URL to our custom image input field.
			jQuery( field ).val(media_attachment.id);

		});

		// Opens the media library frame.
		metaImageFrame.open();
	})
})




	
