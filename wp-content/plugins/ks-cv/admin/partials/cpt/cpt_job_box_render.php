<?php
/**
* Display ui for the CPT job experience metabox.
* 
*/

?>
    <input type="hidden" name="kscv_job_box_data_nonce" value="<?php echo wp_create_nonce('kscv_job_box_data'); ?>" >
    <ul>
    	<li>
     		<label for="kscv_job_location">Lieu</label>
     		<input type="text" id="kscv_job_location" name="kscv_job_location" value="<?php echo $curr_location; ?>">
     	</li>
     	<li>
     		<label for="kscv_job_startdate">Date de début</label>
     		<input type="text" name="kscv_job_startdate" id="kscv_job_startdate" value="<?php echo $curr_startdate; ?>" />
     	</li>
     	<li>
     		<label for="kscv_job_enddate">Date de fin</label>
     		<input type="text" name="kscv_job_enddate" id="kscv_job_enddate" value="<?php echo $curr_enddate; ?>" />
     	</li>
     	<li>
     		<label for="kscv_job_org">Entreprise</label>
            <input type="text" name="kscv_job_org" id="kscv_job_org" value="<?php echo $curr_org; ?>" />
     	<li>
     	<li>
     		<label for="kscv_job_contrat">Contrat</label>
            <input type="text" name="kscv_job_contrat" id="kscv_job_contrat" value="<?php echo $curr_contrat; ?>" />
     	<li>
     </ul>
    
