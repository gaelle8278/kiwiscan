<?php 
/**
 * Display contact part of a cv
 */

$contact_infos = apply_filters('kscv_get_contact_cv_to_display', array(), get_the_ID());
if(  ! empty( $contact_infos ) ) :
    ?>
        <h1 class="cv-header-title"><?php echo $contact_infos['name']; ?></h1>
        <ul class="list-container bordered">
        	<li class="list-item">
        		<div class="cell-icon"><i class="fas fa-mobile-alt"></i></div>
        		<div><?php echo $contact_infos['phone']; ?></div>
        	</li>
        	<li class="list-item">
        		<div class="cell-icon"><i class="fas fa-envelope"></i></div>
        		<div><?php echo $contact_infos['email']; ?></div>
        	</li>
        	<li class="list-item">
        		<div class="cell-icon"><i class="fas fa-map-marker-alt"></i></div>
        		<div><?php echo $contact_infos['address']; ?></div>
        	</li>
        </ul>
    <?php
endif;