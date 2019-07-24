<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Kiwiscan
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function kiwiscan_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class of no-sidebar for some specific template page
	if ( is_page_template( 'page-templates/cv.php' ) ) {
	    $classes[] = 'no-sidebar';
	}
	return $classes;
}
add_filter( 'body_class', 'kiwiscan_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function kiwiscan_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'kiwiscan_pingback_header' );

// Remove p tag in the description
remove_filter( 'term_description', 'wpautop' );
