<?php 
/**
 * Display hobbies part of cv template page
 */

//get taxo hobbies
$hobbies = apply_filters('kscv_get_hobbies_taxo_cv_to_display', array(), get_the_ID());
if( ! empty( $hobbies ) ) :
    ?>
    <section class="column divided-part">
    	<h1><span>Centres d'intérêt</span></h1>
    	<?php 
        foreach( $hobbies as $hobby ) :
            ?>
            <div>
            	<div><?php echo $hobby['icon_element']; ?></div>
            	<div>
            		<p><?php echo $hobby['name']; ?><br>
            		<span class="complementary-text"><?php echo $hobby['desc']; ?></span></p>
            	</div>
            </div>
            
            
        <?php
        endforeach;
        ?>
        
    </section>
    <?php 
endif;