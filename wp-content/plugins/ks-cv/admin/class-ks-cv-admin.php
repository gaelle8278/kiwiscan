<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    KS_CV
 * @subpackage KS_CV/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 *
 * @package    KS_CV
 * @subpackage KS_CV/admin
 * @author     Gaëlle Rauffet <gaelle.rauffet@kiwiscan.net>
 */
class KS_CV_Admin {
    
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;
    
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;
    
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {
        
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        
    }
    
    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ks-cv-admin.css', array(), $this->version, 'all' );
        
    }
    
    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts( $hook ) {
        //media uploader
        wp_enqueue_media();
        
        //custom js file
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ks-cv-admin.js', array( 'jquery' ), $this->version, true );
        
    }
    
    /**
     * Add custom image size 
     */
    public function add_custom_image_size() {
        add_image_size( 'icon_hobby', 32, 32, true ); 
    }
    
    
    /* ------------------------------------------------------------------------ *
     * Add options page
     * ------------------------------------------------------------------------ */
    
    /**
     * Add a sub-menu page under CPT cv admin menu.
     *
     * The page is used to set some general options for CV
     * Options defined is this page can be used by different cpt CV and don't change between it.
     */
    public function add_kscv_options_page() {
        add_submenu_page(
            'edit.php?post_type=kscv_cv',
            'Données CV',
            'CV Options',
            'edit_posts',
            'kscv_options_page',
            array($this, 'kscv_options_page_render')
       );
    }
    
    /**
     * Callback function to render the kscv plugin sub-menu page
     */
    public function kscv_options_page_render() {
        // check user capabilities
        if ( ! current_user_can( 'edit_posts' ) ) {
            return;
        }
        //include template part view
        require_once plugin_dir_path( __FILE__ ) . 'partials/settings/kscv_options_page_render.php';
    }
    
    /* ------------------------------------------------------------------------ *
     * Options registration
     * ------------------------------------------------------------------------ */ 
    
    /**
     * Manage sections, fields and settings for the kscv plugin Options page
     */
    public function init_kscv_options() {
        $this->add_contact_section();
        $this->add_links_section();
        
    }
    
    /**
    * Add section, fields and settings for the "Social links" section
    **/
    private function add_links_section() {
        //section to define links that can be used in a CV
        add_settings_section(
            'kscv_links_section',
            'Liens',
            array($this, 'kscv_links_section_render'),
            'kscv_links_options'
        );
        // add fields to links section
        $list_links_field = array(
            array(
                'id' => 'kscv_site_link',
                'label' => 'Lien du site perso',
                'callback' => 'site_link_field_render'
            ),
            array(
                'id' => 'kscv_facebook_profile',
                'label' => 'Lien du profil Facebook',
                'callback' => 'facebook_profile_field_render'
            ),
            array(
                'id' => 'kscv_twitter_profile',
                'label' => 'Lien du profil Twitter',
                'callback' => 'twitter_profile_field_render'
            ),
            array(
                'id' => 'kscv_linkedin_profile',
                'label' => 'Lien du profil LinkedIn',
                'callback' => 'linkedin_profile_field_render'
            ),
            array(
                'id' => 'kscv_github_profile',
                'label' => 'Lien du profil github',
                'callback' => 'github_profile_field_render'
            ),
            array(
                'id' => 'kscv_stackoverflow_profile',
                'label' => 'Lien du profil Stackoverflow',
                'callback' => 'stackoverflow_profile_field_render'
            ),
            array(
                'id' => 'kscv_skype_contact',
                'label' => 'Contact Skype',
                'callback' => 'skype_contact_field_render'
            )
        );
        
        foreach ( $list_links_field as $field ) {
            add_settings_field(
                $field['id'],
                $field['label'],
                array($this, $field['callback']),
                'kscv_links_options',
                'kscv_links_section'
            );
        }
        
        
        // save the fields about links section
        register_setting(
            'kscv_links_fields',
            'kscv_cv_links',
            array($this, 'kscv_sanitize_links_options')
        );
    }
    
    /**
     * Add section, fields and settings for the "Contact" section
     **/
    private function add_contact_section() {
        //section to define links that can be used in a CV
        add_settings_section(
            'kscv_contact_section',
            'Informations de contact',
            array($this, 'kscv_contact_section_render'),
            'kscv_contact_options'
        );
        
        //add email field
        add_settings_field(
            'kscv_name',
            'Nom',
            array($this, 'name_field_render'),
            'kscv_contact_options',
            'kscv_contact_section'
        );
        
        //add email field
        add_settings_field(
            'kscv_email',
            'Adresse email',
            array($this, 'email_field_render'),
            'kscv_contact_options',
            'kscv_contact_section'
        );
        
        //add tel field
        add_settings_field(
            'kscv_phone',
            'Numéro de téléphone',
            array($this, 'phone_field_render'),
            'kscv_contact_options',
            'kscv_contact_section'
        );
        
        //add address field
        add_settings_field(
            'kscv_address',
            'Adresse',
            array($this, 'address_field_render'),
            'kscv_contact_options',
            'kscv_contact_section'
        );
        
        // save the fields about links section
        register_setting(
            'kscv_contact_fields',
            'kscv_cv_contact',
            array($this, 'kscv_sanitize_contact_options')
        );
    }
    
    /* ------------------------------------------------------------------------ *
     * Section Callbacks
     * ------------------------------------------------------------------------ */ 
    
    /**
     * Callback function to render the "links" section of the kscv plugin Options page 
     */
    public function kscv_links_section_render() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/settings/kscv_options_page_links_section_render.php';
    } 
    
    /**
     * Callback function to render the "contact" section of the kscv plugin Options page
     */
    public function kscv_contact_section_render() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/settings/kscv_options_page_contact_section_render.php';
    }
    
    /* ------------------------------------------------------------------------ *
     * Field Callbacks
     * ------------------------------------------------------------------------ */ 
    
    /**
     * Callback function to render "kscv_site_link" field of the links section
     */
    public function site_link_field_render() {
        $site_link = $this->get_option_in_array('kscv_cv_links', 'site_link');
        require_once plugin_dir_path( __FILE__ ) . 'partials/settings/kscv_options_page_site_link_field_render.php';
    }
    
    /**
     * Callback function to render "kscv_facebook_profile" field of the links section
     */
    public function facebook_profile_field_render() {
        $facebook_profile = $this->get_option_in_array('kscv_cv_links', 'facebook_profile');
        require_once plugin_dir_path( __FILE__ ) . 'partials/settings/kscv_options_page_facebook_profile_field_render.php';
    }
    
    /**
     * Callback function to render "kscv_twitter_profile" field of the links section
     */
    public function twitter_profile_field_render() {
        $twitter_profile = $this->get_option_in_array('kscv_cv_links', 'twitter_profile');
        require_once plugin_dir_path( __FILE__ ) . 'partials/settings/kscv_options_page_twitter_profile_field_render.php';
    }
    
    /**
     * Callback function to render "kscv_github_profile" field of the links section
     */
    public function github_profile_field_render() {
        $github_profile = $this->get_option_in_array('kscv_cv_links', 'github_profile');
        require_once plugin_dir_path( __FILE__ ) . 'partials/settings/kscv_options_page_github_profile_field_render.php';
    }
    
    /**
     * Callback function to render "kscv_linkedin_profile" field of the links section
     */
    public function linkedin_profile_field_render() {
        $linkedin_profile = $this->get_option_in_array('kscv_cv_links', 'linkedin_profile');
        require_once plugin_dir_path( __FILE__ ) . 'partials/settings/kscv_options_page_linkedin_profile_field_render.php';
    }
    
    /**
     * Callback function to render "kscv_stackoverflowr_profile" field of the links section
     */
    public function stackoverflow_profile_field_render() {
        $stackoverflow_profile = $this->get_option_in_array('kscv_cv_links', 'stackoverflow_profile');
        require_once plugin_dir_path( __FILE__ ) . 'partials/settings/kscv_options_page_stackoverflow_profile_field_render.php';
    }
    
    /**
     * Callback function to render "kscv_skype_contact" field of the links section
     */
    public function skype_contact_field_render() {
        $skype_contact = $this->get_option_in_array('kscv_cv_links', 'skype_contact');
        require_once plugin_dir_path( __FILE__ ) . 'partials/settings/kscv_options_page_skype_contact_field_render.php';
    }
    
    /**
     * Callback function to render "kscv_name" field of the contact section
     */
    public function name_field_render() {
        $name_value = $this->get_option_in_array('kscv_cv_contact', 'name');
        require_once plugin_dir_path( __FILE__ ) . 'partials/settings/kscv_options_page_name_field_render.php';
    }
    
    /**
     * Callback function to render "kscv_email" field of the contact section
     */
    public function email_field_render() {
        $email_value = $this->get_option_in_array('kscv_cv_contact', 'email');
        require_once plugin_dir_path( __FILE__ ) . 'partials/settings/kscv_options_page_email_field_render.php';
    }
    
    /**
     * Callback function to render "kscv_phone" field of the contact section
     */
    public function phone_field_render() {
        $phone_value = $this->get_option_in_array('kscv_cv_contact', 'phone');
        require_once plugin_dir_path( __FILE__ ) . 'partials/settings/kscv_options_page_phone_field_render.php';
    }
    
    /**
     * Callback function to render "kscv_address" field of the contact section
     */
    public function address_field_render() {
        $address_value = $this->get_option_in_array('kscv_cv_contact', 'address');
        require_once plugin_dir_path( __FILE__ ) . 'partials/settings/kscv_options_page_address_field_render.php';
    }
    
    /* ------------------------------------------------------------------------ *
     * Sanitization Callbacks
     * ------------------------------------------------------------------------ */ 
    
    /** 
     * Sanitize input fields associated to "links" section
     * 
     * @param array $inputs     form fields associated to links section
     */
    public function kscv_sanitize_links_options( $inputs ) {
        // Define the array for the updated options
        $output = array();
        
        $fields_string = ['skype_contact'];
        // Loop through each of the options sanitizing the data
        foreach( $inputs as $key => $val ) {
            
            if( isset ( $inputs[$key] ) ) {
                if( in_array($key, $fields_string) ) {
                    $output[$key] =  strip_tags( stripslashes( $inputs[$key] ) ) ;
                } else {
                    $output[$key] = esc_url_raw( strip_tags( stripslashes( $inputs[$key] ) ) );
                }
            }
            
        }
        
        // Return the new collection
        return apply_filters( 'kscv_sanitize_links_inputs', $output, $inputs );
        
    }
    
    /**
    * Sanitize input fields associated to "contact" section
    *
    * @param array $inputs     form fields associated to contact section
    */
    public function kscv_sanitize_contact_options( $inputs ) {
        // Define the array for the updated options
        $output = array();
        
        // Loop through each of the options sanitizing the data
        foreach( $inputs as $key => $val ) {
            
            if( isset ( $inputs[$key] ) ) {
                $output[$key] =  strip_tags( stripslashes( $inputs[$key] ) ) ;
            }
            
        }
        
        // Return the new collection
        return apply_filters( 'kscv_sanitize_contact_inputs', $output, $inputs );
    }
    
    /* ------------------------------------------------------------------------ *
     * Helpers methods
     * ------------------------------------------------------------------------ */ 
    
    /**
     * Retrives values of an option stored in array
     * 
     * @param string $tabOption     key of the tab that stored options
     * @param string $nameOption    key of the option to retrieve in the array of options
     * @return boolean
     */
    private function get_option_in_array($tabOption, $nameOption) {
        $valueOption = '';
        
        $options = get_option($tabOption);
        if( $options && isset( $options[$nameOption] ) ) {
            $valueOption = $options[$nameOption];
        }
        
        return $valueOption;
    }
    
    
}

