<?php
/**
 * Display a job in cv template page
 */


$job_id = get_the_ID();

$startdate = esc_html( get_post_meta( $job_id, '_kscv_job_startdate', true ) );
$enddate = esc_html( get_post_meta( $job_id, '_kscv_job_enddate', true ) );
$curr_org = esc_html(get_post_meta($job_id, '_kscv_job_org', true));
$keywords = apply_filters('kscv_get_keywords_taxo_job_to_display', array(), $job_id);
?>
<div class="cv-row">
	<div class="cv-row-aside cv-row-highlight">
		<?php
		if( $startdate ) {
		    if( $enddate ) {
                echo date_i18n( "m/Y", $startdate )." à ".date_i18n( "m/Y", $enddate );
		    } else {
                echo "Depuis ".date_i18n( "m/Y", $startdate );
		    }
		}
        ?>    
    </div>
    <div class="cv-row-main">
    	<h2>
        	<?php    
            if( $curr_org ) :
                ?>
                <span class="highlight"><?php echo $curr_org; ?></span> -
                <?php
            endif;
            
            ?>
            <?php the_title(); ?>
        </h2>
        
       	<?php the_content(); ?>
       	
       	<?php 
       	if( ! empty( $keywords ) ) :
       	    ?>
       	    <div> 
           	    <?php 
           	    foreach( $keywords as $keyword ) :
               	    ?>
               		<div class="tag"><?php echo $keyword; ?></div>
               		<?php 
           		endforeach;
           		?>
       		</div> 
        <?php endif; ?>
    </div>
</div>