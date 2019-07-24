<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    KS_CV
 * @subpackage KS_CV/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and front site hooks
 *
 * @package    KS_CV
 * @subpackage KS_CV/public
 * @author     Gaëlle Rauffet <gaelle.rauffet@kiwiscan.net>
 */
class KS_CV_Public {
    
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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {
        
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        
    }
    
    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ks-cv-public.css', array(), $this->version, 'all' );
        
    }
    
    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        
        
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ks-cv-public.js', array( 'jquery' ), $this->version, false );
        
    }
    
    /**
     * Returns list of links associated to a CPT cv.
     * 
     * Filter used in template page.
     * 
     * @param array $list_links     list of cv links
     * @param int   $id_cv          id of cv
     */
    public function get_links_cv($cv_list_links, $id_cv) {
        //links choosen in cv
        $cv_type_links = get_post_meta($id_cv, '_kscv_cv_links');
        
        if( ! empty( $cv_type_links ) ) {
            //links with its values defined in options page
            $list_links = get_option('kscv_cv_links');
            
            //foreach type of links choosen in cv, url values is retrieved
            foreach ( $cv_type_links as $link_id ) {
                $font_icon = $this->get_font_icon_from_link_id($link_id);
                $cv_list_links[] = array(
                    'class_icon' => $font_icon,
                    'url' => $list_links[$link_id]
                    
                );
            }
        }
        
        return $cv_list_links;
    }
    
    /**
     * Retrieves contact informations of a CPT cv. 
     * 
     * Retrieves informations if "contact" option is selected.
     * 
     * @param array $contact_infos  list of contact informations
     * @param int   $id_cv          id of cv
     * @return array
     */
    public function get_contact_cv($contact_infos, $id_cv) {
        if ( 1 == get_post_meta($id_cv, '_kscv_cv_contact_choice', true) ) {
            $contact_infos = get_option('kscv_cv_contact');
        }
        
        return $contact_infos;
    }
    
    /**
     * Retrieves skills of a CPT cv, stored via post meta 
     * 
     * @param array     $skills         list of skills
     * @param int       $id_cv          id of cv
     * @return array
     */
    public function get_skills_meta_cv($skills, $id_cv) {
        $skills = get_post_meta($id_cv, '_kscv_cv_skills');
        
        return $skills;
    }
    
    /**
     * Retrieves skills of a CPT cv, stored via custom taxonomy skill
     * 
     * @param array     $skills     list of taxo skill values
     * @param int       $id_cv      id of cv
     * @return array
     */
    public function get_skills_taxo_cv($skills, $id_cv) {
        $skills = array();
        
        //get name of taxonomy
        $taxo = get_taxonomy('kscv_cv_skill_taxo');
        
        if( $taxo ) {
            //get taxo skills associated to cv
            $skills_taxo = get_the_terms($id_cv, $taxo->name );
            
            if( $skills_taxo ) {
                foreach ( $skills_taxo as $term) {
                    //foreach taxo skill, retrieve meta level
                    $term_level = get_term_meta( $term->term_id, 'ks_cv_skill_level', true );
                    if( $term_level ) {
                        //taxo term is kept if there is value for meta level
                        $skills[] = array(
                                        'name' => $term->name,
                                        'level' => $term_level
                                    );
                    }
                }
            }
        }
        
        return $skills;
    }
    
    /**
     * Retrieves languages associated to a given CPT cv
     * 
     * @param array $langs  list of languages
     * @param int $id_cv    id of cv
     * 
     * @return array
     */
    public function get_langs_taxo_cv($langs, $id_cv) {
        //get taxo lang associated to cv
        $langs_taxo = get_the_terms($id_cv, 'kscv_cv_lang_taxo' );
        if ( $langs_taxo ) {
            foreach($langs_taxo as $term ) {
                $langs[] = array(
                                'name' => $term->name,
                                'desc' => term_description( $term->term_id ),
                                'level' => get_term_meta( $term->term_id, 'ks_cv_lang_level', true )
                           );
            }
        }
        
        return $langs;
        
    }
    
    /**
     * Retrieves hobbies associated to a given CPT cv
     * 
     * @param array $hobbies    list of hobbies
     * @param int   $id_cv      id of cv
     * @return array
     */
    public function get_hobbies_taxo_cv($hobbies, $id_cv) {
        //get taxo hobby associated to cv
        $hobbies_taxo = get_the_terms($id_cv, 'kscv_cv_hobby_taxo' );
        
        if ( $hobbies_taxo ) {
            foreach($hobbies_taxo as $term ) {
                $icon_id = get_term_meta( $term->term_id, 'ks_cv_hobby_icon', true );
                $icon = ! empty($icon_id) ? wp_get_attachment_image( $icon_id, 'icon_hobby' ) : "";
                $hobbies[] = array(
                    'name' => $term->name,
                    'icon_element' => $icon,
                    'desc' => term_description( $term->term_id )
                );
            }
        }
        return $hobbies;
    }
    
    /**
     * Retrieves formations associated to a given CPT cv
     * 
     * @param array $formations     list of formations
     * @param int  $id_cv           id of cv
     * @return array
     */
    public function get_formations_taxo_cv($formations, $id_cv) {
        //get taxo formations associated to cv
        $formations_taxo = get_the_terms($id_cv, 'kscv_cv_formation_taxo' );
        
        if ( $formations_taxo ) {
            foreach($formations_taxo as $term ) {
                $formations[] = $term->name;
            }
        }
        return $formations;
    }
    
    
    /**
     * Retrieves keywords associated to a given CPT job
     *
     * @param array $formations     list of formations
     * @param int  $id_cv           id of cv
     * @return array
     */
    public function get_keywords_taxo_job($keywords, $id_cv) {
        //get taxo keyword associated to job
        $keywords_taxo = get_the_terms($id_cv, 'kscv_job_keyword_taxo' );
        
        if ( ! empty( $keywords_taxo ) ) {
            foreach($keywords_taxo as $term ) {
                $keywords[] = $term->name;
            }
        }
        return $keywords;
    }
    
    
    /**
     * Returns the front ui icon corresponding to a given link id
     *
     * @param   string      id used to manage link
     * @return  string      css class usefull to set front ui icon
     */
    private function get_font_icon_from_link_id( $link_id ) {
        switch ($link_id) {
            case "site_link":
                $class_icon = "fas fa-globe";
                break;
            case "twitter_profile":
                $class_icon = "fas fa-hashtag";
                break;
            case "facebook_profile":
                $class_icon = "fab fa-facebook-f";
                break;
            case "linkedin_profile":
                $class_icon = "fab fa-linkedin-in";
                break;
            case "github_profile": 
                $class_icon = "fab fa-github";
                break;
            case "stackoverflow_profile":
                $class_icon =  "fab fa-stack-overflow";
                break;
            case "skype_contact": 
                $class_icon = "fab fa-skype";
                break;
            default:
                $class_icon = "";
                break;
        }
        
        return $class_icon;
    }
}



