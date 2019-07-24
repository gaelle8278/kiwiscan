<?php

/**
 * The file that defines the core plugin class.
 * 
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 * 
 * @since      1.0.0
 * @package    KS_CV
 * @subpackage KS_CV/includes
 * @author     Gaëlle Rauffet <gaelle.rauffet@kiwiscan.net>
 *
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 * 
 * @since      1.0.0
 * @package    KS_CV
 * @subpackage KS_CV/includes
 * @author     Gaëlle Rauffet <gaelle.rauffet@kiwiscan.net>
 *
 */
class KS_CV {
    
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Plugin_Name_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;
    
    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;
    
    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;
    
    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if ( defined( 'KS_CV_VERSION' ) ) {
            $this->version = KS_CV_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'ks-cv';
        
        $this->load_dependencies();
        $this->loader = new KS_CV_Loader();
        
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        
    }
    
    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
     * - KS_CV_i18n. Defines internationalization functionality.
     * - KS_CV_Admin. Defines all hooks for the admin area.
     * - KS_CV_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {
        
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ks-cv-loader.php';
        
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ks-cv-i18n.php';
        
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ks-cv-admin.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ks-cv-cpt.php';
        
        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ks-cv-public.php';
        
        
    }
    
    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the KS_CV_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {
        
        $plugin_i18n = new KS_CV_i18n();
        
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
        
    }
    
    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {
        
        $plugin_admin = new KS_CV_Admin( $this->get_plugin_name(), $this->get_version() );
        $plugin_cpt = new KS_CV_CPT( $this->get_plugin_name(), $this->get_version() );
        
        //add styles and scripts for administration
        //////////////////////////////////////////////////
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        
        // add custom image size
        $this->loader->add_action('init', $plugin_admin, 'add_custom_image_size');
        
        // add and configure custom post type
        ////////////////////////////////////////////
        // add usefull CPT
        $this->loader->add_action('init', $plugin_cpt, 'add_custom_cpt');
        // manage columns of CPT job
        $this->loader->add_filter('manage_edit-kscv_job_columns', $plugin_cpt, 'edit_cpt_job_columns');
        $this->loader->add_action('manage_kscv_job_posts_custom_column', $plugin_cpt, 'manage_cpt_job_columns', 10, 2);
        
        // define custom taxonomies for CPT
        $this->loader->add_action('init', $plugin_cpt, 'register_taxonomies_cpt');
        // add custom meta for the custom taxonomy "kscv_cv_lang_taxo"
        $this->loader->add_action('kscv_cv_lang_taxo_add_form_fields', $plugin_cpt, 'add_meta_custom_lang_taxo');
        // edit custom meta for the custom taxonomy "kscv_cv_lang_taxo"
        $this->loader->add_action('kscv_cv_lang_taxo_edit_form_fields', $plugin_cpt, 'edit_meta_custom_lang_taxo');
        // save custom meta for the custom taxonomy "kscv_cv_lang_taxo"
        $this->loader->add_action('edited_kscv_cv_lang_taxo', $plugin_cpt, 'save_meta_custom_lang_taxo');
        $this->loader->add_action('create_kscv_cv_lang_taxo', $plugin_cpt, 'save_meta_custom_lang_taxo');
        // add custom meta for the custom taxonomy "kscv_cv_skill_taxo"
        $this->loader->add_action('kscv_cv_skill_taxo_add_form_fields', $plugin_cpt, 'add_meta_custom_skill_taxo');
        // edit custom meta for the custom taxonomy "kscv_cv_skill_taxo"
        $this->loader->add_action('kscv_cv_skill_taxo_edit_form_fields', $plugin_cpt, 'edit_meta_custom_skill_taxo');
        // save custom meta for the custom taxonomy "kscv_cv_skill_taxo"
        $this->loader->add_action('edited_kscv_cv_skill_taxo', $plugin_cpt, 'save_meta_custom_skill_taxo');
        $this->loader->add_action('create_kscv_cv_skill_taxo', $plugin_cpt, 'save_meta_custom_skill_taxo');
        // add custom meta for the custom taxonomy "kscv_cv_hobby_taxo"
        $this->loader->add_action('kscv_cv_hobby_taxo_add_form_fields', $plugin_cpt, 'add_meta_custom_hobby_taxo');
        // edit custom meta for the custom taxonomy "kscv_cv_hobby_taxo"
        $this->loader->add_action('kscv_cv_hobby_taxo_edit_form_fields', $plugin_cpt, 'edit_meta_custom_hobby_taxo');
        // save custom meta for the custom taxonomy "kscv_cv_hobby_taxo"
        $this->loader->add_action('edited_kscv_cv_hobby_taxo', $plugin_cpt, 'save_meta_custom_hobby_taxo');
        $this->loader->add_action('create_kscv_cv_hobby_taxo', $plugin_cpt, 'save_meta_custom_hobby_taxo');
        
        // add field to post Admin 'Publish' Meta Box
        $this->loader->add_action('post_submitbox_misc_actions', $plugin_cpt, 'add_publish_meta_fields');
        // add metabox to different CPT 
        $this->loader->add_action('add_meta_boxes', $plugin_cpt, 'add_custom_box_cpt');
        // save fields added to 'Publish' Meta Box
        $this->loader->add_action('save_post', $plugin_cpt, 'save_publish_meta_fields');
        // save metabox fields of CPT job experience
        $this->loader->add_action('save_post', $plugin_cpt, 'save_box_cpt_job');
        // save metabox fields of CPT cv
        $this->loader->add_action('save_post', $plugin_cpt, 'save_job_box_cpt_cv');
        $this->loader->add_action('save_post', $plugin_cpt, 'save_edu_box_cpt_cv');
        $this->loader->add_action('save_post', $plugin_cpt, 'save_links_box_cpt_cv');
        $this->loader->add_action('save_post', $plugin_cpt, 'save_contact_box_cpt_cv');
        $this->loader->add_action('save_post', $plugin_cpt, 'save_skills_box_cpt_cv');
        // save metabox fields of CPT education
        $this->loader->add_action('save_post', $plugin_cpt, 'save_box_cpt_edu');
        
        // add and build an options page with Settings API
        ///////////////////////////////////////////////////
        // add a kscv plugin options page under CPT cv menu
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_kscv_options_page');
        // add sections and fields and register settings of kscv plugion options page
        $this->loader->add_action('admin_init', $plugin_admin, 'init_kscv_options');
        
        
        
         
    }
    
    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {
        
        $plugin_public = new KS_CV_Public( $this->get_plugin_name(), $this->get_version() );
        
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        
        $this->loader->add_filter('kscv_get_links_cv_to_display', $plugin_public, 'get_links_cv', 10, 2 );
        $this->loader->add_filter('kscv_get_contact_cv_to_display', $plugin_public, 'get_contact_cv', 10, 2 );
        $this->loader->add_filter('kscv_get_skills_meta_cv_to_display', $plugin_public, 'get_skills_meta_cv', 10, 2 );
        $this->loader->add_filter('kscv_get_skills_taxo_cv_to_display', $plugin_public, 'get_skills_taxo_cv', 10, 2 );
        $this->loader->add_filter('kscv_get_lang_taxo_cv_to_display', $plugin_public, 'get_langs_taxo_cv', 10, 2 );
        $this->loader->add_filter('kscv_get_hobbies_taxo_cv_to_display', $plugin_public, 'get_hobbies_taxo_cv', 10, 2 );
        $this->loader->add_filter('kscv_get_formations_taxo_cv_to_display', $plugin_public, 'get_formations_taxo_cv', 10, 2 );
        $this->loader->add_filter('kscv_get_keywords_taxo_job_to_display', $plugin_public, 'get_keywords_taxo_job', 10, 2 );
        
        
    }
    
    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }
    
    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }
    
    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }
    
    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }
    
}
