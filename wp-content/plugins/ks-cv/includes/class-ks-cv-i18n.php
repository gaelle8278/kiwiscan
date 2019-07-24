<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 *
 * @package    KS_CV
 * @subpackage KS_CV/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    KS_CV
 * @subpackage KS_CV/includes
 * @author     Gaëlle Rauffet <gaelle.rauffet@kiwiscan.net>
 */
class KS_CV_i18n {
    
    
    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain() {
        
        load_plugin_textdomain(
            'ks-cv',
            false,
            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
            );
        
    }
    
    
    
}

