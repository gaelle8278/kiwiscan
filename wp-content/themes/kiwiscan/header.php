<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Kiwiscan
 */

?>
<!doctype html>
<!--[if (lte IE 7)&!(IEMobile)]> <html <?php language_attributes(); ?>> <![endif]-->
<!--[if (IE 8)&!(IEMobile)]> <html <?php language_attributes(); ?>> <![endif]-->
<!--[if (gt IE 8)&!(IEMobile)]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php

        wp_title( '|', true, 'right' );
 
        // Add the blog name.
        bloginfo( 'name' );
    ?></title>
	<link rel="profile" href="https://gmpg.org/xfn/11">
	
	<!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'kiwiscan' ); ?></a>

	<header id="masthead" class="site-header" role ="banner">
		<div class="site-branding">
			
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<!--  <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'kiwiscan' ); ?></button> -->
			<?php
			/*wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );*/
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
		<div class="site-container">
