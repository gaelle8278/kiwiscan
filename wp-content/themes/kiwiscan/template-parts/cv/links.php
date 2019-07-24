<?php
/**
 * Display links in CV template page
 */

$links_url = apply_filters('kscv_get_links_cv_to_display', array(), get_the_ID());
if( ! empty( $links_url ) ) {
    ?> 
    <ul class="list-container filled">
        <?php
        foreach( $links_url as $link ) {
            ?>
            <li class="list-item">
            	<div class="cell-icon"><i class="<?php echo $link['class_icon']; ?>"></i></div>
            	<div><a href="<?php echo $link['url'] ?>" title="" target="_blank"><?php echo $link['url'] ?></a></div>
            </li>
            <?php 
        }
        ?> 
    </ul> 
    <?php 
}


?>