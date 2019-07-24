<?php 
/**
 * Display formations part of cv template page
 */

//get taxo formations
$formations = apply_filters('kscv_get_formations_taxo_cv_to_display', array(), get_the_ID());
if( ! empty( $formations ) ) :
    ?>
    <section class="column">
        <h1><span>Formations</span></h1>
        <ul class="cv-list">
        <?php foreach( $formations as $fname ) :?>
        	<li><?php echo  $fname; ?></li>
       	<?php endforeach; ?>
       	</ul>
    </section>
    <?php
endif;