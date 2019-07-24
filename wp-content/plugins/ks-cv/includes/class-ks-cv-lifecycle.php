<?php
/**
 * Fired during plugin lifecycle : activation, deactivation
 * 
 * @since      1.0.0
 * 
 * @package    KS_CV
 * @subpackage KS_CV/includes
 *
 */

/**
 * Fired during plugin lifecycle.
 *
 * This class defines all code necessary to run during the plugin's lifecycle.
 *
 * @since      1.0.0
 * @package    KS_CV
 * @subpackage KS_CV/includes
 * @author     Gaëlle Rauffet <gaelle.rauffet@kiwiscan.net>
 */
class KS_CV_Lifecycle {
    
    /**
     * Fired during plugin activation
     *
     * [Long Description]
     */
    public static function activation() {
        flush_rewrite_rules();
        
    }
    
    /**
     * Fired during plugin deactivation
     *
     * [Long Description]
     */
    public static function deactivation() {
        flush_rewrite_rules();
    }
}