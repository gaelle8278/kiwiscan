<?php
/**
 * Display an education in cv template page
 */

$edu_id = get_the_ID();
$enddate = esc_html( get_post_meta( $edu_id, '_kscv_edu_enddate', true ) );
$location = esc_html(get_post_meta($edu_id, '_kscv_edu_location', true));
?>

<div class="cv-row">
	<div class="cv-row-aside">
    	<?php 
    	if( $enddate ) :
            ?>
            <span><?php echo date_i18n( "F Y", $enddate ); ?></span>
        <?php endif; ?>
    </div>
    <div class="cv-row-main">
		<h2><?php the_title(); ?></h2>
		<p><?php echo $location; ?></p>
	</div>
</div>
