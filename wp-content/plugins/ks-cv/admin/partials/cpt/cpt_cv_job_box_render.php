<?php
/**
 * Display ui for the metabox "job" of CPT cv.
 *
 */

?>
    
    <div class="wrap">
    	<input type="hidden" name="kscv_cv_job_box_data_nonce" value="<?php echo wp_create_nonce('kscv_cv_job_box_data'); ?>" >
    	<?php if( ! empty($list_cpt_job) ) : ?>
    		<ul>
    		<?php foreach($list_cpt_job as $cpt_job) : ?>
    			<li>
                	<label>
                		<input type="checkbox" value="<?php echo $cpt_job->ID; ?>" <?php checked( in_array( $cpt_job->ID, $curr_jobs ) ); ?> name="kscv_cv_job[]" />
                		<?= $cpt_job->post_title; ?>
                	</label>
               	</li>
    		<?php endforeach; ?>
    		</ul>
    	<?php endif; ?>
    </div>
    
   
    	