<?php

/**
 * The cpt-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    KS_CV
 * @subpackage KS_CV/admin
 */

/**
 * The cpt-specific functionality of the plugin.
 *
 *
 * @package    KS_CV
 * @subpackage KS_CV/admin
 * @author     Gaëlle Rauffet <gaelle.rauffet@kiwiscan.net>
 */
class KS_CV_CPT {
    
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
    
    /* ------------------------------------------------------------------------ *
     * CPT 
     * ------------------------------------------------------------------------ */
    
    /**
     * Add CPT necessary to manage a CV
     *
     * CPT CV, CPT job experience, CP education
     *
     * @since    1.0.0
     */
    public function add_custom_cpt() {
        //register CPT CV
        register_post_type('kscv_cv',
            array(
                'labels'      => array(
                    'name'          => "CV",
                    'singular_name' => "CV",
                ),
                'public'      => true,
                'has_archive' => false,
                'supports' => array('title','editor','excerpt', 'custom-fields', 'thumbnail'),
                'taxonomies' => array('kscv_cv_skill_taxo', 'kscv_cv_lang_taxo', 'kscv_cv_hobby_taxo', 'kscv_cv_formation_taxo'),
                'rewrite'     => array( 'slug' => apply_filters( 'change_slug_cpt_cv', 'curriculum-vitae' ) ),
            )
            );
        
        //register CPT job
        register_post_type('kscv_job',
            array(
                'labels'      => array(
                    'name'          => "Expériences professionnelles",
                    'singular_name' => "Expérience professionnelle",
                ),
                'public'      => true,
                'has_archive' => true,
                'supports' => array('title','editor','excerpt', 'custom-fields', 'thumbnail'),
                'taxonomies' => array('kscv_job_keyword_taxo'),
                'rewrite'     => array( 'slug' => apply_filters( 'change_slug_cpt_job', 'experiences-professionnelles' ) ),
            )
            );
        
        // register CPT education
        register_post_type('kscv_education',
            array(
                'labels'      => array(
                    'name'          => "Formations",
                    'singular_name' => "Formation",
                ),
                'public'      => true,
                'has_archive' => true,
                'supports' => array('title','editor','excerpt', 'custom-fields', 'thumbnail'),
                'rewrite'     => array( 'slug' => apply_filters( 'change_slug_cpt_education', 'formations' ) ),
            )
            );
        
        
    }
    
    /**
     * Add custom columns to CTP job
     */
    public function edit_cpt_job_columns( $columns ) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => 'Titre',
            'organisation' => 'Entreprise',
            'startdate' => 'Début',
            'enddate' => 'Fin',
            'place' => 'Lieu',
            'contract' => 'Contrat',
            'keywords' => "Mots-clés",
            'date' =>'Date'
        );
        
        return $columns;
    }
    
    /**
     * Fill content for custom columns of CPT job
     */
    public function manage_cpt_job_columns( $column, $post_id ) {
        
        switch( $column ) {
            case 'organisation' :
                echo esc_html(get_post_meta($post_id, '_kscv_job_org', true));
                break;
            case 'startdate' : 
                $date = esc_html( get_post_meta( $post_id, '_kscv_job_startdate', true ) );
                if ( $date ) {
                    echo date_i18n( "m/Y", $date );
                }
                break;
            case 'enddate' :
                $date = esc_html( get_post_meta( $post_id, '_kscv_job_enddate', true ) );
                if ( $date ) {
                    echo date_i18n( "m/Y", $date );
                }
                break;
            case 'place' :
                echo esc_html(get_post_meta($post_id, '_kscv_job_location', true));
                break;
            case 'contract' :
                echo esc_html(get_post_meta($post_id, '_kscv_job_contrat', true));
                break;
            case 'keywords' :
                $tags = get_the_terms($post_id, 'kscv_job_keyword_taxo');
                if( ! empty( $tags ) ) {
                    $out = array();
                    foreach ( $tags as $tag ) {
                        $out[] = esc_html( sanitize_term_field( 'name', $tag->name, $tag->term_id, 'kscv_job_keyword_taxo', 'display' ) );
                    }
                    echo implode(', ', $out );;
                }
                break;
            default :
                break;
        }
        
    }
    
    /* ------------------------------------------------------------------------ *
     * Custom Taxonomies
     * ------------------------------------------------------------------------ */
    
    /**
     * Add custom taxonomies to CPT
     */
    public function register_taxonomies_cpt() {
        // taxonomy to add keywords to CPT job experience
        register_taxonomy('kscv_job_keyword_taxo',
            array('kscv_job'),
            array(
                'hierarchical'      => false,
                'labels'            => array(
                    'name'              => "Mots-clés expérience professionnelle",
                    'singular_name'     => "Mots-clé expérience professionnelle",
                    'search_items'      => "Recherche mots-clés expérience professionnelle",
                    'all_items'         => "Tous les mots-clés relatifs aux expériences professionnelles",
                    'edit_item'         => "Editer mot-clé expérience professionnelle",
                    'update_item'       => "Mettre à jour mot-clé expérience professionnelle",
                    'add_new_item'      => "Ajouter mot-clé expérience professionnelle",
                    'new_item_name'     => "Nouveau mot-clé expérience professionnelle",
                    'menu_name'         => "Mot-clé expérience professionnelle",
                ),
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => apply_filters( 'change_slug_taxo_keyword_cpt_job', 'mots-cles' ) ),
            )
            
        );
        
        // taxonomy to add skills to CPT CV
        register_taxonomy('kscv_cv_skill_taxo',
            array('kscv_cv'),
            array(
                'hierarchical'      => true,
                'labels'            => array(
                    'name'              => "Compétences",
                    'singular_name'     => "Compétence",
                    'search_items'      => "Recherche parmi les compétence",
                    'all_items'         => "Toutes les compétences",
                    'edit_item'         => "Editer la compétence",
                    'update_item'       => "Mettre à jour la compétence",
                    'add_new_item'      => "Ajouter une compétence",
                    'new_item_name'     => "Nouvelle compétence",
                    'menu_name'         => "Compétences",
                ),
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => apply_filters( 'change_slug_taxo_skill_cpt_cv', 'competences' ) ),
            )
        );
        
        
        // taxonomy to add languages to CPT CV
        register_taxonomy('kscv_cv_lang_taxo',
            array('kscv_cv'),
            array(
                'hierarchical'      => false,
                'labels'            => array(
                    'name'              => "Langues",
                    'singular_name'     => "Langue",
                    'search_items'      => "Recherche parmi les langues",
                    'all_items'         => "Toutes les langues",
                    'edit_item'         => "Editer la langue",
                    'update_item'       => "Mettre à jour la langue",
                    'add_new_item'      => "Ajouter une langue",
                    'new_item_name'     => "Nouvelle langue",
                    'menu_name'         => "Langues",
                ),
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => apply_filters( 'change_slug_taxo_lang_cpt_cv', 'langues' ) ),
            )
        );
        
        // taxonomy to add hobbies to CPT CV
        register_taxonomy('kscv_cv_hobby_taxo',
            array('kscv_cv'),
            array(
                'hierarchical'      => true,
                'labels'            => array(
                    'name'              => "Centres d'intérêt",
                    'singular_name'     => "Centre d'intérêt",
                    'search_items'      => "Recherche parmi les centres d'intérêt",
                    'all_items'         => "Tous les centres d'intérêt",
                    'edit_item'         => "Editer le centre d'intérêt",
                    'update_item'       => "Mettre à jour le centres d'intérêt",
                    'add_new_item'      => "Ajouter un centre d'intérêt",
                    'new_item_name'     => "Nouveau centre d'intérêt",
                    'menu_name'         => "Centres d'intérêt",
                ),
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => apply_filters( 'change_slug_taxo_hobby_cpt_cv', 'centres-d-interet' ) ),
            )
        );
        
        // taxonomy to add formations to CPT CV
        register_taxonomy('kscv_cv_formation_taxo',
            array('kscv_cv'),
            array(
                'hierarchical'      => false,
                'labels'            => array(
                    'name'              => "Formations",
                    'singular_name'     => "Formation",
                    'search_items'      => "Recherche parmi les formations",
                    'all_items'         => "Toutes les formations",
                    'edit_item'         => "Editer la formation",
                    'update_item'       => "Mettre à jour la formation",
                    'add_new_item'      => "Ajouter une formation",
                    'new_item_name'     => "Nouvelle formation",
                    'menu_name'         => "Formations",
                ),
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => apply_filters( 'change_slug_taxo_formation_cpt_cv', 'formation' ) ),
            )
        );
        
    }
    
    /**
     * Add custom meta to custom taxonomy "kscv_cv_lang_taxo"
     */
    public function add_meta_custom_lang_taxo( $term ) {
        require_once plugin_dir_path( __FILE__ ) . 'partials/terms/custom_lang_taxo_add_meta_render.php';
    }
    
    /**
     * Edit meta of custom taxonomy "kscv_cv_lang_taxo"
     */
    public function edit_meta_custom_lang_taxo( $term ) {
        $term_level = get_term_meta( $term->term_id, 'ks_cv_lang_level', true );
        require_once plugin_dir_path( __FILE__ ) . 'partials/terms/custom_lang_taxo_edit_meta_render.php';
    }
    
    /**
     * Save meta of custom taxonomy "kscv_cv_lang_taxo"
     */
    public function save_meta_custom_lang_taxo( $term_id ) {
        //check origin with nonce ?
        if ( isset( $_POST['meta_level_lang_taxo'] ) ) {
            $term_level = sanitize_text_field($_POST['meta_level_lang_taxo']);
            if( $term_level ) {
                update_term_meta( $term_id, 'ks_cv_lang_level', $term_level );
            }
        } 
        
        
    }
    
    /**
     * Add custom meta to custom taxonomy "kscv_cv_skill_taxo"
     */
    public function add_meta_custom_skill_taxo( $term ) {
        require_once plugin_dir_path( __FILE__ ) . 'partials/terms/custom_skill_taxo_add_meta_render.php';
    }
    
    /**
     * Edit custom meta to custom taxonomy "kscv_cv_skill_taxo"
     */
    public function edit_meta_custom_skill_taxo( $term ) {
        $term_level = get_term_meta( $term->term_id, 'ks_cv_skill_level', true );
        require_once plugin_dir_path( __FILE__ ) . 'partials/terms/custom_skill_taxo_edit_meta_render.php';
    }
    
    /**
     * Save custom meta to custom taxonomy "kscv_cv_skill_taxo"
     */
    public function save_meta_custom_skill_taxo( $term_id ) {
        if ( isset( $_POST['meta_level_skill_taxo'] ) ) {
            $term_level = sanitize_text_field($_POST['meta_level_skill_taxo']);
            if( $term_level ) {
                update_term_meta( $term_id, 'ks_cv_skill_level', $term_level );
            }
        } 
    }
    
    /**
     * Add custom meta to custom taxonomy "kscv_cv_hobby_taxo"
     */
    public function add_meta_custom_hobby_taxo( $term ) {
        require_once plugin_dir_path( __FILE__ ) . 'partials/terms/custom_hobby_taxo_add_meta_render.php';
    }
    
    /**
     * Edit meta of custom taxonomy "kscv_cv_hobby_taxo"
     */
    public function edit_meta_custom_hobby_taxo( $term ) {
        $term_icon = get_term_meta( $term->term_id, 'ks_cv_hobby_icon', true );
        require_once plugin_dir_path( __FILE__ ) . 'partials/terms/custom_hobby_taxo_edit_meta_render.php';
    }
    
    /**
     * Save meta of custom taxonomy "kscv_cv_hobby_taxo"
     */
    public function save_meta_custom_hobby_taxo( $term_id ) {
        if ( isset( $_POST['meta_icon_hobby_taxo'] ) ) {
            $term_icon = intval($_POST['meta_icon_hobby_taxo']);
            if( $term_icon ) {
                update_term_meta( $term_id, 'ks_cv_hobby_icon', $term_icon );
            }
        }
        
        
    }
    
    /* ------------------------------------------------------------------------ *
     * Metaboxes
     * ------------------------------------------------------------------------ */
    
    /**
     * Add field to post Admin 'Publish' Meta Box
     */
    public function add_publish_meta_fields( $post ) {
        //check post type
        if ( 'kscv_cv' == get_post_type( $post->ID ) ) {
            $value_sticky = get_post_meta($post->ID, '_sticky_ks_cv', true);
            require_once plugin_dir_path( __FILE__ ) . 'partials/cpt/cpt_cv_custom_publish_fields_render.php';
        }
    }
    
    /**
     * Add custom meta box to different CPT
     *
     * Add metabox to different registeredCPT
     */
    public function add_custom_box_cpt() {
        //metabox for CPT CV
        add_meta_box(
            'kscv_cv_job_box_id',
            'Expériences professionnelles',
            [$this, 'cpt_cv_job_box_render'],
            'kscv_cv'
        );
        add_meta_box(
            'kscv_cv_edu_box_id',
            'Formations',
            [$this, 'cpt_cv_edu_box_render'],
            'kscv_cv'
        );
        add_meta_box(
            'kscv_cv_links_box_id',
            'Liens',
            [$this, 'cpt_cv_links_box_render'],
            'kscv_cv'
        );
        add_meta_box(
            'kscv_cv_contact_box_id',
            'Contact',
            [$this, 'cpt_cv_contact_box_render'],
            'kscv_cv'
        );
        add_meta_box(
            'kscv_cv_skills_box_id',
            'Savoir-faire',
            [$this, 'cpt_cv_skills_box_render'],
            'kscv_cv'
        );
        
        //metabox for CPT job
        add_meta_box(
            'kscv_job_box_id',
            'Informations complémentaires',
            [$this, 'cpt_job_box_render'],
            'kscv_job'
        );
        
        //metabox for CPT education
        add_meta_box(
            'kscv_education_box_id',
            'Informations complémentaires',
            [$this, 'cpt_edu_box_render'],
            'kscv_education'
        );
    }
    
    
    /* ------------------------------------------------------------------------ *
     * Metabox render
     * ------------------------------------------------------------------------ */
    
    /**
     * Callback function to render "job" metabox of CPT cv
     *
     * @param WP_Post $post
     */
    public function cpt_cv_job_box_render($post) {
        //get current saved values
        $curr_jobs = get_post_meta($post->ID, '_kscv_cv_job');
        
        // get list of CPT job
        $list_cpt_job = $this->get_custom_post_type('kscv_job');
        
        //include template part view
        require_once plugin_dir_path( __FILE__ ) . 'partials/cpt/cpt_cv_job_box_render.php';
        
    }
    
    /**
     * Callback function to render "education" metabox of CPT cv
     *
     * @param WP_Post $post
     */
    public function cpt_cv_edu_box_render($post) {
        // get current saved values
        $curr_educations = get_post_meta($post->ID, '_kscv_cv_education');
        
        // get list of CPT education
        $list_cpt_education = $this->get_custom_post_type('kscv_education');
        
        //include template part view
        require_once plugin_dir_path( __FILE__ ) . 'partials/cpt/cpt_cv_edu_box_render.php';
        
    }
    
    /**
     * Callback function to render "links" metabox of CPT cv
     *
     * @param WP_Post $post
     */
    public function cpt_cv_links_box_render($post) {
        //get current saved values
        $curr_links = get_post_meta($post->ID, '_kscv_cv_links');
        
        // get links define in admin settings page
        $list_links = get_option('kscv_cv_links');
        $links_name = $this->get_links_names_from_id();
        
        //include template part view
        require_once plugin_dir_path( __FILE__ ) . 'partials/cpt/cpt_cv_links_box_render.php';
        
    }
    
    /**
     * Callback function to render "contact" metabox of CPT cv
     *
     * @param WP_Post $post
     */
    public function cpt_cv_contact_box_render( $post ) {
        // get current saved value
        $curr_contact_choice = get_post_meta($post->ID, '_kscv_cv_contact_choice', true);
        
        //include template part view
        require_once plugin_dir_path( __FILE__ ) . 'partials/cpt/cpt_cv_contact_box_render.php';
        
    }
    
    /**
     * Callback function to render "skills" metabox of CPT cv
     *
     * @param WP_Post $post
     */
    public function cpt_cv_skills_box_render( $post ) {
        $curr_skills = get_post_meta($post->ID, '_kscv_cv_skills');
        
        
        //include template part view
        require_once plugin_dir_path( __FILE__ ) . 'partials/cpt/cpt_cv_skills_box_render.php';
        
    }
    
    /**
     * Callback function to render the metabox associated to CPT job experience
     *
     * @param WP_Post $post
     */
    public function cpt_job_box_render($post) {
        
        $curr_location = esc_html( get_post_meta( $post->ID, '_kscv_job_location', true ) );
        $meta_startdate = esc_html( get_post_meta( $post->ID, '_kscv_job_startdate', true ) );
        if( $meta_startdate ) {
            $curr_startdate = date_i18n( "F Y", $meta_startdate );
        } else {
            $curr_startdate = "";
        }
        $meta_enddate = esc_html( get_post_meta( $post->ID, '_kscv_job_enddate', true ) );
        if( $meta_enddate ) {
            $curr_enddate = date_i18n( "F Y", $meta_enddate );
        } else {
            $curr_enddate = "";
        }
        
        $curr_org = esc_html(get_post_meta($post->ID, '_kscv_job_org', true));
        $curr_contrat = esc_html(get_post_meta($post->ID, '_kscv_job_contrat', true));
        
        //include template part view
        require_once plugin_dir_path( __FILE__ ) . 'partials/cpt/cpt_job_box_render.php';
    }
    
    /**
     * Callback function to render the metabox associated to CPT education
     *
     * @param WP_Post $post
     */
    public function cpt_edu_box_render($post) {
        $curr_location = esc_html(get_post_meta($post->ID, '_kscv_edu_location', true));
        $meta_startdate = esc_html(get_post_meta($post->ID, '_kscv_edu_startdate', true));
        if( $meta_startdate ) {
            $curr_startdate =  date_i18n( "F Y", $meta_startdate);
        } else {
            $curr_startdate = "";
        }
        
        $meta_enddate = esc_html(get_post_meta($post->ID, '_kscv_edu_enddate', true));
        if ( $meta_enddate ) {
            $curr_enddate = date_i18n( "F Y", $meta_enddate); 
        } else {
            $curr_enddate = "";
        }
        
        //include template part view
        require_once plugin_dir_path( __FILE__ ) . 'partials/cpt/cpt_edu_box_render.php';
    }
    
    /* ------------------------------------------------------------------------ *
     * Metabox saving
     * ------------------------------------------------------------------------ */
    /**
     * Save fields added to 'Publish' Meta Box
     * 
     *  @param     string   $post_id    id of the current post
     */
    public function save_publish_meta_fields( $post_id ) {
        // make sure we aren't using autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
        
        //check post type
        if ( 'kscv_cv' != get_post_type( $post_id ) ) {
            return $post_id;
        }
        
        //check origin with nonce
        if( ! isset( $_POST['kscv_cv_publish_box_data_nonce'] ) || ! wp_verify_nonce( $_POST['kscv_cv_publish_box_data_nonce'], 'kscv_cv_publish_box_data') ) {
            return $post_id;
        }
        
        // check user capabilities
        if( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
        
        $sticky_choice = ! empty( $_POST['ks_cv_sticky_post_action'] ) ? intval( $_POST['ks_cv_sticky_post_action'] ) : 0;
        update_post_meta(
                $post_id,
                '_sticky_ks_cv',
                $sticky_choice 
        );
    }
    
    /**
     * Save the content of "job" metabox associated to CPT cv
     */
    public function save_job_box_cpt_cv( $post_id ) {
        
        // make sure we aren't using autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
        
        //check post type
        if ( 'kscv_cv' != get_post_type( $post_id ) ) {
            return $post_id;
        }
        
        //check origin with nonce
        if( ! isset( $_POST['kscv_cv_job_box_data_nonce'] ) || ! wp_verify_nonce( $_POST['kscv_cv_job_box_data_nonce'], 'kscv_cv_job_box_data') ) {
            return $post_id;
        }
        
        // check user capabilities
        if( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
        
        //check data to store
        //@TODO : récupérer les valeurs actuelles (voir avec hook save_post si elles sont pas disponibles)
        // puis comparer tableau nouvelles valeurs et tableau valeurs actuelles
        // faire delete/add uniquememnt si changement (cela évite de le faire à chaque mse à jour)
        ////////////////
        //deletion of current values
        delete_post_meta($post_id, '_kscv_cv_job');
        //new values are added if selected
        if( ! empty( $_POST['kscv_cv_job'] ) ) {
            foreach( $_POST['kscv_cv_job'] as $job_id ) {
                add_post_meta(
                    $post_id,
                    '_kscv_cv_job',
                    intval($job_id)
                    );
            }
            
        }
    }
    
    /**
     * Save the content of "education" metabox associated to CPT cv
     */
    public function save_edu_box_cpt_cv($post_id) {
        // make sure we aren't using autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
        
        //check post type
        if ( 'kscv_cv' != get_post_type( $post_id ) ) {
            return $post_id;
        }
        
        //check origin with nonce
        if( ! isset( $_POST['kscv_cv_edu_box_data_nonce'] ) || ! wp_verify_nonce( $_POST['kscv_cv_edu_box_data_nonce'], 'kscv_cv_edu_box_data') ) {
            return $post_id;
        }
        
        // check user capabilities
        if( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
        
        //check data to store
        //@TODO : récupérer les valeurs actuelles (voir avec hook save_post si elles sont pas disponibles)
        // puis comparer tableau nouvelles valeurs et tableau valeurs actuelles
        // faire delete/add uniquememnt si changement (cela évite de le faire à chaque mse à jour)
        ////////////////
        //deletion of current values
        delete_post_meta($post_id, '_kscv_cv_education');
        //new values are added if selected
        if( ! empty( $_POST['kscv_cv_edu'] ) ) {
            foreach( $_POST['kscv_cv_edu'] as $edu_id ) {
                add_post_meta(
                    $post_id,
                    '_kscv_cv_education',
                    intval($edu_id)
                    );
            }
            
        }
        
    }
    
    /**
     * Save the content of "links" metabox associated to CPT cv
     */
    public function save_links_box_cpt_cv($post_id) {
        // make sure we aren't using autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
        
        //check post type
        if ( 'kscv_cv' != get_post_type( $post_id ) ) {
            return $post_id;
        }
        
        //check origin with nonce
        if( ! isset( $_POST['kscv_cv_links_box_data_nonce'] ) || ! wp_verify_nonce( $_POST['kscv_cv_links_box_data_nonce'], 'kscv_cv_links_box_data') ) {
            return $post_id;
        }
        
        // check user capabilities
        if( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
        
        //check data to store
        //@TODO : récupérer les valeurs actuelles (voir avec hook save_post si elles sont pas disponibles)
        // puis comparer tableau nouvelles valeurs et tableau valeurs actuelles
        // faire delete/add uniquememnt si changement (cela évite de le faire à chaque mise à jour)
        ////////////////
        //deletion of current values
        delete_post_meta($post_id, '_kscv_cv_links');
        //new values are added if selected
        if( ! empty( $_POST['kscv_cv_links'] ) ) {
            foreach( $_POST['kscv_cv_links'] as $link ) {
                add_post_meta(
                    $post_id,
                    '_kscv_cv_links',
                    sanitize_text_field($link)
                );
            }
            
        }
    }
    
    /**
     * Save the content of "contact" metabox associated to CPT cv
     */
    public function save_contact_box_cpt_cv($post_id) {
        // make sure we aren't using autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
        
        //check post type
        if ( 'kscv_cv' != get_post_type( $post_id ) ) {
            return $post_id;
        }
        
        //check origin with nonce
        if( ! isset( $_POST['kscv_cv_contact_box_data_nonce'] ) || ! wp_verify_nonce( $_POST['kscv_cv_contact_box_data_nonce'], 'kscv_cv_contact_box_data') ) {
            return $post_id;
        }
        
        // check user capabilities
        if( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
        
        
        //new values are added if selected
        if( ! empty( $_POST['kscv_cv_contact_choice'] ) ) {
            update_post_meta(
                $post_id,
                '_kscv_cv_contact_choice',
                intval( $_POST['kscv_cv_contact_choice'] )
                );
            
            
        } else {
            delete_post_meta($post_id,'_kscv_cv_contact_choice');
        }
        
    }
    
    /**
     * Save the content of "skills" metabox associated to CPT cv
     */
    public function save_skills_box_cpt_cv( $post_id ) {
        // make sure we aren't using autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
        
        //check post type
        if ( 'kscv_cv' != get_post_type( $post_id ) ) {
            return $post_id;
        }
        
        //check origin with nonce
        if( ! isset( $_POST['kscv_cv_skills_box_data_nonce'] ) || ! wp_verify_nonce( $_POST['kscv_cv_skills_box_data_nonce'], 'kscv_cv_skills_box_data') ) {
            return $post_id;
        }
        
        // check user capabilities
        if( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
        
        //check values to store
        $new_skills = array_map(function($item) {
            return sanitize_text_field($item);
        },
        $_POST['kscv_cv_skills']);
        $old_skills = get_post_meta($post_id, '_kscv_cv_skills');
        
        //if there is no new value but there are old values, stored values are deleted
        if( empty( $new_skills ) && ! empty( $old_skills )) {
            delete_post_meta($post->ID, '_kscv_cv_skills');
        } else {
            // check differences between old and new values
            $values_to_add = array_diff($new_skills, $old_skills);
            $values_to_delete = array_diff($old_skills, $new_skills);
            if( ! empty( $values_to_add ) ) {
                foreach( $values_to_add as $skill ) {
                    add_post_meta(
                        $post_id,
                        '_kscv_cv_skills',
                        $skill
                    );
                }
            }
            if( ! empty( $values_to_delete ) ) {
                foreach( $values_to_delete as $skill ) {
                     delete_post_meta(
                        $post_id,
                       '_kscv_cv_skills',
                        $skill
                    );
                }
            }
            
        }
    }
    
    /**
     * Save the content of the CPT job experience metabox
     */
    public function save_box_cpt_job($post_id) {
        // make sure we aren't using autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
        
        //check post type
        if ( 'kscv_job' != get_post_type( $post_id ) ) {
            return $post_id;
        }
        
        //check origin with nonce
        if( ! isset( $_POST['kscv_job_box_data_nonce'] ) || ! wp_verify_nonce( $_POST['kscv_job_box_data_nonce'], 'kscv_job_box_data') ) {
            return $post_id;
        }
        
        // check user capabilities
        if( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
        
        //check there are data to store
        ////////////////////////////////////
        //job location
        if( isset( $_POST['kscv_job_location'] ) ) {
            //sanitize data to store
            $location = sanitize_text_field($_POST['kscv_job_location']);
            if(empty( $location )) {
                delete_post_meta( $post_id, '_kscv_job_location' );
            } else {
                update_post_meta(
                    $post_id,
                    '_kscv_job_location',
                    $location
                );
            }
        }
        
        //start date of the job
        if( isset( $_POST['kscv_job_startdate'] ) ) {
            $startdate = sanitize_text_field($_POST['kscv_job_startdate']);
            if( empty( $startdate ) ) {
                delete_post_meta( $post_id, '_kscv_job_startdate' );
            } else {
                $meta_startdate = $this->getTimestampJobDate($startdate, 'F Y', "m");
                update_post_meta(
                    $post_id,
                    '_kscv_job_startdate',
                    $meta_startdate
                );
            }
            
        }
        
        //end date of the job
        if( isset( $_POST['kscv_job_enddate'] ) ) {
            $enddate = sanitize_text_field($_POST['kscv_job_enddate']);
            if( empty( $enddate ) ) {
                delete_post_meta( $post_id, '_kscv_job_enddate' );
            } else {
                $meta_enddate = $this->getTimestampJobDate($enddate, 'F Y', "m");
                update_post_meta(
                    $post_id,
                    '_kscv_job_enddate',
                    $meta_enddate
                );
            }
            
        }
        
        // company
        if( isset( $_POST['kscv_job_org'] ) ) {
            //sanitize data to store
            $org = sanitize_text_field($_POST['kscv_job_org']);
            if( empty( $org )) {
                delete_post_meta( $post_id, '_kscv_job_org' );
            } else {
                update_post_meta(
                    $post_id,
                    '_kscv_job_org',
                    $org
                );
            }
        }
        
        // company
        if( isset( $_POST['kscv_job_contrat'] ) ) {
            //sanitize data to store
            $org = sanitize_text_field($_POST['kscv_job_contrat']);
            if( empty( $org )) {
                delete_post_meta( $post_id, '_kscv_job_contrat' );
            } else {
                update_post_meta(
                    $post_id,
                    '_kscv_job_contrat',
                    $org
                );
            }
        }
        
    }
    
    /**
     * Save the content of the CPT education metabox
     */
    public function save_box_cpt_edu($post_id) {
        // make sure we aren't using autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
        
        //check post type
        if ( 'kscv_education' != get_post_type( $post_id ) ) {
            return $post_id;
        }
        
        //check origin with nonce
        if( ! isset( $_POST['kscv_edu_box_data_nonce'] ) || ! wp_verify_nonce( $_POST['kscv_edu_box_data_nonce'], 'kscv_edu_box_data') ) {
            return $post_id;
        }
        
        // check user capabilities
        if( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
        
        //check there are data to store
        ////////////////////////////////////
        //education location
        if( isset( $_POST['kscv_edu_location'] ) ) {
            //sanitize data to store
            $location = sanitize_text_field($_POST['kscv_edu_location']);
            if(empty( $location )) {
                delete_post_meta( $post_id, '_kscv_edu_location' );
            } else {
                update_post_meta(
                    $post_id,
                    '_kscv_edu_location',
                    $location
                    );
            }
        }
        
        //start date of the education
        if( isset( $_POST['kscv_edu_startdate'] ) ) {
            $startdate = sanitize_text_field($_POST['kscv_edu_startdate']);
            if( empty( $startdate ) ) {
                delete_post_meta( $post_id, '_kscv_edu_startdate' );
            } else {
                $meta_startdate = $this->getTimestampJobDate($startdate, 'F Y', "m");
                update_post_meta(
                    $post_id,
                    '_kscv_edu_startdate',
                    $meta_startdate
                    );
            }
            
        }
        
        //end date of the education
        if( isset( $_POST['kscv_edu_enddate'] ) ) {
            $enddate = sanitize_text_field($_POST['kscv_edu_enddate']);
            if( empty( $enddate ) ) {
                delete_post_meta( $post_id, '_kscv_edu_enddate' );
            } else {
                $meta_enddate = $this->getTimestampJobDate($enddate, 'F Y', "m");
                update_post_meta(
                    $post_id,
                    '_kscv_edu_enddate',
                    $meta_enddate
                    );
            }
            
        }
        
    }
    
    
    /* ------------------------------------------------------------------------ *
     * Helpers methods
     * ------------------------------------------------------------------------ */
    
    /**
     * Convert string date into Unix timestamp
     *
     * String date must be in english that is to say words must be in english
     * because format with french word (like month with F format) is not understand by many date function
     *
     * @param   string      $date               date to convert
     * @param   string      $format             format of the string date
     * @param   string      $textToConvert      to indicate with words must be replaced (day or month or both)
     * @return number
     */
    private function getTimestampJobDate($date, $format , $textToConvert = "") {
        $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
        
        $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $french_days = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');
        
        if($textToConvert === "all") {
            $dateToConvert = str_replace($french_days, $english_days, str_replace($french_months, $english_months, strtolower($date) ) );
        } else if( $textToConvert === "m" ) {
            $dateToConvert = str_replace($french_months, $english_months, strtolower($date) );
        } elseif( $textToConvert === "d" ) {
            $dateToConvert = str_replace($french_days, $english_days, strtolower($date) );
        } else {
            $dateToConvert = strtolower($date);
        }
        
        // Datetime ne tient pas compte de la locale (mois en texte français par exemple) dans le format de date
        // les textes français doivent donc d'abord être traduit en anglais
        $dateTime = DateTime::createFromFormat($format, $dateToConvert);
        
        //retur Unix timestamp of the date
        return $dateTime->getTimestamp();
        
    }
    
    /**
     * Retrieves list of a given custom post type.
     *
     * List of custom post type is used in <select> element into metabox
     *
     * @param   string  $post_type  custom post type to retrieve
     */
    private function get_custom_post_type($post_type) {
        $list = get_posts(
            array(
                'post_type'         => $post_type,
                'post_status'       => 'publish',
                'posts_per_page'    => -1,
                'fields'            => array('ID','title')
            )
            );
        
        return $list;
        
    }
    
    /**
     * Sets association between id of links and its admin ui name
     *
     * @return array
     */
    private function get_links_names_from_id() {
        return [
            "site_link" => "Lien du site perso",
            "twitter_profile" => "Profil Twitter",
            "facebook_profile" => "Profil Facebook",
            "linkedin_profile" => "Profil LinkedIn",
            "github_profile" => "Profil Github",
            "stackoverflow_profile" => "Profil Stackoverflow",
            "skype_contact" => "Contact Skype"
            
        ];
    }
}