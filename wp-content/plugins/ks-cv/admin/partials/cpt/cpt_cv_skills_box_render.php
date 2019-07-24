<?php 
/**
 * Display ui for the metabox "skills" of CPT cv.
 *
 */
?>

	<div class="wrap">
		
		<input type="hidden" name="kscv_cv_skills_box_data_nonce" value="<?php echo wp_create_nonce('kscv_cv_skills_box_data'); ?>" >
		<input type="button" class="repeatable-add button"  value="Ajouter un savoir-faire">
    	<ul class="custom_field_repeatable">
    	<?php if( ! empty($curr_skills) ) : ?>
    	    <?php foreach($curr_skills as $skill_value) : ?>
    	   		<li>
     				<input type="text" class="regular-text" name="kscv_cv_skills[]" value="<?php echo $skill_value; ?>" />
     				<button type="button" class="repeatable-remove button">Supprimer</button>
     			</li>
    		<?php endforeach; 
    	else : ?>
    		<li>
     			<input type="text" class="regular-text" name="kscv_cv_skills[]" value="" />
     			<button type="button" class="repeatable-remove button">Supprimer</button>
     		</li>
    	<?php endif; ?>
    	</ul>
    	
    </div>