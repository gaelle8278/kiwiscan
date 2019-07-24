<?php
/**
* Display the content of the kscv plugin Options page
* 
**/
?>
<div class="wrap">
    <!-- Add the icon to the page -->
    <div id="icon-themes" class="icon32"></div>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	
	<!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
    <?php settings_errors(); ?>
    
    <!--  tabbed navigation -->
    <?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'contact_options'; ?>
    <h2 class="nav-tab-wrapper">
    	<a href="?post_type=kscv_cv&page=kscv_options_page&tab=contact_options" class="nav-tab  <?php echo $active_tab == 'contact_options' ? 'nav-tab-active' : ''; ?>">Contact</a>
    	<a href="?post_type=kscv_cv&page=kscv_options_page&tab=links_options" class="nav-tab <?php echo $active_tab == 'links_options' ? 'nav-tab-active' : ''; ?>">Liens</a>
	</h2>
        
 	<form action="options.php" method="post">
 		<?php
 		if( $active_tab == 'contact_options' ) {
 		    // output security fields for the registered contact section options
 		    settings_fields( 'kscv_contact_fields' );
 		    // output settings sections about contact stuff
 		    do_settings_sections( 'kscv_contact_options' );
 		} elseif( $active_tab == 'links_options' ) {
            // output security fields for the registered links section options 
     		settings_fields( 'kscv_links_fields' );
             // output settings sections about links stuff
            do_settings_sections( 'kscv_links_options' );
 		}
        
        // output save settings button
        submit_button( 'Sauvegarder' );
        ?>
 	</form>
 </div>