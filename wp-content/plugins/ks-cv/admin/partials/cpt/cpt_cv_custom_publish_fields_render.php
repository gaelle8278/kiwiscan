<?php 
/**
 * 
 */
?>

<div class="misc-pub-section">
	<input type="hidden" name="kscv_cv_publish_box_data_nonce" value="<?php echo wp_create_nonce('kscv_cv_publish_box_data'); ?>" >
	<label for="ks_cv_sticky_post_action">
    	<input type="checkbox" value="1" <?php checked( $value_sticky, 1 ); ?> name="ks_cv_sticky_post_action" id="ks_cv_sticky_post_action"/>
        Mettre en avant
    </label>
	
</div>