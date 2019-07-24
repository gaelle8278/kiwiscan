<?php 
/**
 * Display language part of cv template page
 */


//get taxo lang
$langs = apply_filters('kscv_get_lang_taxo_cv_to_display', array(), get_the_ID());
if( ! empty( $langs ) ) :
    ?>
    <section class="column">
        <h1><span>Langues</span></h1>
        <ul class="cv-list">
            <?php 
            foreach ( $langs as $l ) :
                ?> 
                <li><?php echo $l['name']; ?> : 
                	<?php echo $l['level']." - " ; ?>
                	<?php echo $l['desc']; ?>
                </li>
                <?php
            endforeach;
            ?>
    	</ul>
    	</section>
	<?php
endif;