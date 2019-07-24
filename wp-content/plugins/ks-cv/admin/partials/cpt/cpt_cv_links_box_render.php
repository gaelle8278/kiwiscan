<?php
/**
 * Display ui for the metabox "links" of CPT cv.
 * 
 */

?>
    <div class="wrap">
		<input type="hidden" name="kscv_cv_links_box_data_nonce" value="<?php echo wp_create_nonce('kscv_cv_links_box_data'); ?>" >
		
		<?php if( ! empty($list_links) ) :
		          foreach($list_links as $link_id => $link_value) : ?>
              		<p>
                  		<label>
                        	<input type="checkbox" value="<?php echo $link_id; ?>" <?php checked( in_array( $link_id, $curr_links ) ); ?> name="kscv_cv_links[]" />
                        	<?php echo  $links_name[$link_id]; ?>
                        </label>
                    </p>
    		<?php endforeach; ?>
    	<?php endif; ?>
    </div>