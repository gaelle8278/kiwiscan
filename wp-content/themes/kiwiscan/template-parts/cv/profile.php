<?php 
/**
 * Display presentation in CV template page
 */
?>

<div class="effect-container">
    <div class="effect-cell">
    	<hr>
    </div>
    <div class="main-cell">
    	<div><h1 class="cv-main-title"><?php echo get_the_title(); ?></h1></div>
    </div>
    <div class="effect-cell">
    	<hr>
    </div>
</div>

<p class="about-me text-center"><?php echo get_the_content(); ?></p>