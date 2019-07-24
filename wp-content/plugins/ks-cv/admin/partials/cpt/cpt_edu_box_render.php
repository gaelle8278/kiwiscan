<?php
/**
 * Display ui for the CPT education metabox.
 */

?>

 	<input type="hidden" name="kscv_edu_box_data_nonce" value="<?php echo wp_create_nonce('kscv_edu_box_data'); ?>" >
    <ul>
    	<li>
     		<label for="kscv_edu_location">Lieu</label>
     		<input type="text" id="kscv_edu_location" name="kscv_edu_location" value="<?php echo $curr_location; ?>">
     	</li>
     	<li>
     		<label for="kscv_edu_startdate">Date de début</label>
     		<input type="text" name="kscv_edu_startdate" id="kscv_edu_startdate" value="<?php echo $curr_startdate; ?>" />
     	</li>
     	<li>
     		<label for="kscv_edu_enddate">Date de fin</label>
     		<input type="text" name="kscv_edu_enddate" id="kscv_edu_enddate" value="<?php echo $curr_enddate; ?>" />
     	</li>
     </ul>