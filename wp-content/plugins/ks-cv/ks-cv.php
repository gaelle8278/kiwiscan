<?php
/**
 * Plugin Name: Kiwiscan CV
 * Description: Plugin qui gère la construction et l'affichage d'un CV
 * Version: 1.0.0
 * Author: Gaëlle Rauffet
 * Text Domain: ks_cv  
 * Domain Path: /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * File that manages code during plugin lifecycle
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-ks-cv-lifecycle.php';

/**
 * File that manages plugin logic based on Plugin API
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ks-cv.php';

/**
 * Currently plugin version.
 * Updated at each new versions.
 * Used to manage stylesheet cache.
 */
define( 'KS_CV_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 */
function activate_ks_cv() {
    KS_CV_Lifecycle::activation();
}
register_activation_hook( __FILE__, 'activate_ks_cv' );

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_ks_cv() {
    KS_CV_Lifecycle::deactivation();
}
register_deactivation_hook( __FILE__, 'deactivate_ks_cv' );

/**
 * Execution of the plugin
 */
$plugin = new KS_CV();
$plugin->run();


