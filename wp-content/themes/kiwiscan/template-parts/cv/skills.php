<?php 
/**
 * Displays skills part of a CV
 */

$cv_id= get_the_ID();

//get post meta skills
$skills = apply_filters('kscv_get_skills_meta_cv_to_display', array(), $cv_id);
if( ! empty( $skills ) ) :
    ?>
    <section class="column">
    	<h1 class="text-center"><span>Savoir-faire</span></h1>
    	<ul class="fa-ul">
        	<?php 
        	foreach ( $skills as $skill ) :
        	    ?>
        	    <li><span class="fa-li"><i class="fas fa-cogs"></i></span><?php echo $skill; ?></li>
        	    <?php 
        	endforeach;
        	?>
    	</ul>
    </section>
    <?php 
endif;

//get taxo skills
$skills_tech = apply_filters('kscv_get_skills_taxo_cv_to_display', array(), $cv_id);
if( ! empty( $skills_tech ) ) :
    ?>
    <section class="column">
    	<h1 class="text-center"><span>Compétences</span></h1>
    	<?php 
    	foreach( $skills_tech as $skill ) :
    	    ?>
        	<div class="skillbar clearfix" data-percent="<?php echo $skill['level']; ?>">
    			<div class="skillbar-title"><span><?php echo $skill['name']; ?></span></div>
    			<div class="skillbar-bar"></div>
    			<div class="skill-bar-percent"><?php echo $skill['level']; ?>%</div>
    		</div>
    	<?php 
    	endforeach;
        ?>
    </section>
    <?php
endif;
?>

