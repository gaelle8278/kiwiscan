<?php
/**
* Display ui for the metabox "education" of CPT cv.
*
*/

?>

	<div class="wrap">
		<input type="hidden" name="kscv_cv_edu_box_data_nonce" value="<?php echo wp_create_nonce('kscv_cv_edu_box_data'); ?>" >
    	<?php if( ! empty($list_cpt_education) ) : ?>
    		<ul>
    	    <?php foreach($list_cpt_education as $cpt_edu) : ?>
    	   		<li>
              		<label>
                    	<input type="checkbox" value="<?php echo $cpt_edu->ID; ?>" <?php checked( in_array( $cpt_edu->ID, $curr_educations ) ); ?> name="kscv_cv_edu[]" />
                    	<?= $cpt_edu->post_title; ?>
                    </label>
                </li>
    		<?php endforeach; ?>
    		</ul>
    	<?php endif; ?>
    </div>
