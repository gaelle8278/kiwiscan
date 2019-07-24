<?php
/**
 * Display ui for the  metabox "contact" of CPT cv.
 * 
 */
?>
<div class="wrap">
	<input type="hidden" name="kscv_cv_contact_box_data_nonce" value="<?php echo wp_create_nonce('kscv_cv_contact_box_data'); ?>" >
	<label for="kscv_cv_contact_choice">
    	<input type="checkbox" value="1" <?php checked( $curr_contact_choice, 1 ); ?> name="kscv_cv_contact_choice" id="kscv_cv_contact_choice" />
        Inclure une section contact dans le CV
    </label>
    				
</div>