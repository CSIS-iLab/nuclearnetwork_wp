<?php
defined('ABSPATH') or die("No script kiddies please!");
/**
 * Plugin Name:AccessPress Anonymous Post Pro
 * Plugin URI: http://accesspressthemes.com/wordpress-plugins/accesspress-anonymous-post-premium/
 * Description: Publish any type of post from frontend anonymously with or without login with loads of configurable settings
 * Version:3.1.8
 * Author:AccessPress Themes
 * Author URI:http://accesspressthemes.com
 * Text Domain: anonymous-post-pro
 * Domain Path: /languages/
 * */
/**
 * Declartion of necessary constants for plugin
 * */
if ( !defined('AP_PRO_IMAGE_DIR') ) {
    define('AP_PRO_IMAGE_DIR', plugin_dir_url(__FILE__) . 'images');
}
if ( !defined('AP_PRO_JS_DIR') ) {
    define('AP_PRO_JS_DIR', plugin_dir_url(__FILE__) . 'js');
}
if ( !defined('AP_PRO_CSS_DIR') ) {
    define('AP_PRO_CSS_DIR', plugin_dir_url(__FILE__) . 'css');
}
if ( !defined('AP_PRO_LIGHTBOX_DIR') ) {
    define('AP_PRO_LIGHTBOX_DIR', plugin_dir_url(__FILE__) . 'lightbox');
}
if ( !defined('AP_PRO_LANG_DIR') ) {
    define('AP_PRO_LANG_DIR', basename(dirname(__FILE__)) . '/languages');
}
if ( !defined('AP_PRO_VERSION') ) {
    define('AP_PRO_VERSION', '3.1.8');
}
if ( !defined('AP_PRO_FILE_UPLOADER') ) {
    define('AP_PRO_FILE_UPLOADER', plugin_dir_url(__FILE__) . 'file-uploader');
}
if ( !class_exists('AP_Pro_Class') ) {

    class AP_Pro_Class {

        var $ap_settings;

        /**
         * Initializes the plugin functions
         */
        function __construct() {

            //$this->ap_settings = get_option('ap_pro_settings');
            //$ap_settings = $this->ap_settings;
            add_action('init', array( $this, 'plugin_text_domain' ));
            add_action('init', array( $this, 'session_init' ));
            add_action('init', array( $this, 'notify_user_email' ));
            add_action('template_redirect', array( $this, 'submit_form' ));
            add_action('template_redirect', array( $this, 'form_preview' ));
            register_activation_hook(__FILE__, array( $this, 'activate_plugin' ));
            add_action('admin_post_ap_settings_action', array( $this, 'ap_settings_action' )); //settings action
            add_action('admin_post_ap_extra_settings_action', array( $this, 'extra_settings_action' )); //settings action
            add_action('admin_menu', array( $this, 'add_ap_menu' )); //add AP menu in wp-admin
            add_action('admin_enqueue_scripts', array( $this, 'register_admin_assets' )); //register plugin scripts and css in wp-admin
            add_action('wp_ajax_get_terms_by_post_type', array( $this, 'get_terms_by_post_type' )); //action to return all the terms of the specific post type
            add_action('wp_ajax_nopriv_get_terms_by_post_type', array( $this, 'no_permission' )); //action for unauthorize ajax call
            add_action('wp_ajax_ap_file_upload_action', array( $this, 'ap_file_upload_action' )); //action to return all the terms of the specific post type
            add_action('wp_ajax_nopriv_ap_file_upload_action', array( $this, 'ap_file_upload_action' )); //action to return all the terms of the specific post type
            add_shortcode('ap-form', array( $this, 'ap_form' ));
            add_shortcode('ap-form-message', array( $this, 'ap_form_message' ));
            add_action('wp_enqueue_scripts', array( $this, 'register_frontend_assets' )); //registers scripts and styles for front end
            add_action('admin_post_ap_restore_default_settings', array( $this, 'ap_pro_restore_default_settings' ));
            add_action('admin_post_ap_form_delete_action', array( $this, 'ap_form_delete_action' )); //form delete action
            add_action('admin_post_ap_form_copy_action', array( $this, 'ap_form_copy_action' )); //form copy action
            add_filter('the_content', array( $this, 'show_custom_fields' ));
            add_action('wp_ajax_ap_file_delete_action', array( $this, 'ap_file_delete_action' )); //action to delete uploaded file
            add_action('wp_ajax_nopriv_ap_file_delete_action', array( $this, 'ap_file_delete_action' )); //action to delete uploaded file
            /**
             * Google Recaptcha validation
             * */
            add_action('wp_ajax_ap_validate_recaptcha', array( $this, 'ap_validate_recaptcha' )); //action to return all the terms of the specific post type
            add_action('wp_ajax_nopriv_ap_validate_recaptcha', array( $this, 'ap_validate_recaptcha' )); //action to return all the terms of the specific post type

            /**
             * Post reject notification
             */
            add_action('wp_trash_post', array( $this, 'post_reject_notification' ));
        }

        //plugin activation action
        function activate_plugin() {
            if ( is_multisite() ) {
                include('inc/cores/multisite-activation.php');
            } else {
                include('inc/cores/activation.php');
            }
        }

        function notify_user_email() {
            $post_types = $this->get_registered_post_types();
            foreach ( $post_types as $post_type ) {
                $publish_action = 'publish_' . $post_type;
                add_action($publish_action, array( $this, 'post_published_notification' ), 10, 2);
            }
        }

        //load the text domain for language translation
        function plugin_text_domain() {
            load_plugin_textdomain('anonymous-post-pro', FALSE, AP_PRO_LANG_DIR);
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            if ( is_plugin_active('accesspress-anonymous-post/accesspress-anonymous-post.php') ) {
                deactivate_plugins('accesspress-anonymous-post/accesspress-anonymous-post.php');
            }
        }

        function submit_form() {
            if ( isset($_POST[ 'ap_form_submit_button' ], $_POST[ 'ap_form_nonce' ]) ) {
                include_once('inc/cores/save-post.php');
            }
            if ( isset($_POST[ 'ap_login_submit' ], $_POST[ 'ap_form_nonce' ]) ) {
                include_once('inc/cores/login.php');
            }
        }

        //registers all the necessary css and js for wp-admin
        function register_admin_assets() {
            //including the plugin's css and js only in plugin's settings page

            if ( isset($_GET[ 'page' ]) && ($_GET[ 'page' ] == 'anonymous-post-pro' || $_GET[ 'page' ] == 'ap-settings' || $_GET[ 'page' ] == 'add-new-ap-form' || $_GET[ 'page' ] == 'ap-pro-settings') ) {
                /**
                 * Enqueue Styles
                 */
                wp_enqueue_style('wp-color-picker');
                wp_enqueue_style('ap-admin-style', AP_PRO_CSS_DIR . '/admin-style.css', false, AP_PRO_VERSION);
                wp_enqueue_style('thickbox'); //for including wp thickbox css

                /**
                 * Enqueue Scripts
                 */
                wp_enqueue_script('ap-webfont', '//ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js');
                wp_enqueue_script('jquery-ui-sortable');
                wp_enqueue_script('ap-admin-script', AP_PRO_JS_DIR . '/admin-script.js', array( 'jquery', 'wp-color-picker', 'jquery-ui-sortable', 'ap-webfont' ), AP_PRO_VERSION);
                wp_enqueue_script('media-upload'); //for uploading image using wp native uploader
                wp_enqueue_script('thickbox'); //for uploading image using wp native uploader + thickbox

                /**
                 * Localize Script variables
                 */
                wp_localize_script('ap-admin-script', 'ap_ajax_url', admin_url() . 'admin-ajax.php'); //localizes the variable in the admin-script.js file
                wp_localize_script('ap-admin-script', 'ap_admin_list_placeholder', __('Enter email address', 'anonymous-post-pro')); //localizes the variable in the admin-script.js file
                wp_localize_script('ap-admin-script', 'ap_form_required_message', __('This field is required', 'anonymous-post-pro'));
                wp_localize_script('ap-admin-script', 'ap_show_form', __('Show on form', 'anonymous-post-pro'));
                wp_localize_script('ap-admin-script', 'ap_custom_required', __('Required', 'anonymous-post-pro'));
                wp_localize_script('ap-admin-script', 'ap_custom_required_message', __('Custom required message', 'anonymous-post-pro'));
                wp_localize_script('ap-admin-script', 'ap_custom_label', __('Label', 'anonymous-post-pro'));
                wp_localize_script('ap-admin-script', 'ap_field_notes', __('Field Notes', 'anonymous-post-pro'));
                wp_localize_script('ap-admin-script', 'ap_field_notes_textfield', __('Field Notes Text', 'anonymous-post-pro'));
                wp_localize_script('ap-admin-script', 'ap_field_notes_text', __('These are extra notes for the front form fields and will show <Br/>just below the field in the frontend form', 'anonymous-post-pro'));
                wp_localize_script('ap-admin-script', 'ap_custom_textbox_type', __('Field Type', 'anonymous-post-pro'));
                $ap_pro_notes_array = array( 'dont_show' => __('Don\'t Show', 'anonymous-post-pro'),
                    'icon' => __('Show as info icon', 'anonymous-post-pro'),
                    'tooltip' => __('Show as tooltip', 'anonymous-post-pro'),
                    'multiple_select' => __('Check if you want allow users to select multiple items by pressing control or command key', 'anonymous-post-pro'),
                    'frontend_show_note' => __('Check if you want to show this custom field value in the frontend post.', 'anonymous-post-pro'),
                    'frontend_show' => __('Frontend Display', 'anonymous-post-pro'),
                    'frontend_label' => __('Frontend Label', 'anonymous-post-pro'),
                    'frontend_show_label_note' => __('Label to be shown in frontend', 'anonymous-post-pro'),
                    'lightbox_msg' => __('Check if you want to open image in lightbox.', 'anonymous-post-pro'),
                    'lightbox_note' => __('Note: This will only work for image file type', 'anonymous-post-pro'),
                    'image_note' => __('Note: Height and width will only work for images file types.', 'anonymous-post-pro'),
                    'link_note' => __('Check if you want to show the url as link.', 'anonymous-post-pro'),
                    'link_label' => __('Show as label', 'anonymous-post-pro'),
                    'image_label' => __('Image Dimensions', 'anonymous-post-pro'),
                    'lightbox_label' => __('Open as lightbox', 'anonymous-post-pro'),
                    'field_class_label' => __('Field Class', 'anonymous-post-pro'),
                    'taxonomy_texts' => array( 'textfield_note' => __('<strong>Textfield:</strong>It will show textfield to add new items using comma for multiple items', 'anonymous-post-pro'),
                        'checkbox_note' => __('<strong>Dropdown & Checkbox:</strong>It will show already available items as dropdown or checkbox', 'anonymous-post-pro'),
                        'auto_complete_label' => __('Auto Complete', 'anonymous-post-pro'),
                        'auto_complete_note' => __('Check if you want to enable auto complete for this tags/terms', 'anonymous-post-pro'),
                        'multiple_select_label' => __('Multiple Select', 'anonymous-post-pro'),
                        'multiple_select_note' => __('Check if you want to allow users to select multiple items pressing control or command key', 'anonymous-post-pro'),
                        'dropdown_label' => __('Dropdown First Option Label', 'anonymous-post-pro'),
                        'dropdown_note' => __('Please enter the first option label of the dropdown.', 'anonymous-post-pro'),
                        'exclude_category_label' => __('Exclude Categories/Tags/Terms', 'anonymous-post-pro'),
                        'exclude_category_note' => __('Please add the <b>slugs</b> of the categories/tags/terms separated by comma that you want<br/> to exclude while showing in the front form.For e.g:category-3,category-2', 'anonymous-post-pro'),
                    )
                );
                wp_localize_script('ap-admin-script', 'ap_pro_notes_obj', $ap_pro_notes_array);
            }
            if ( isset($_GET[ 'post' ]) ) {
                wp_enqueue_script('ap-admin-extra', AP_PRO_JS_DIR . '/admin-extra.js', array( 'jquery' ), AP_PRO_VERSION);
            }
        }

        //registers css and js for frontend
        function register_frontend_assets() {
            $ap_extra_settings = get_option('ap_pro_extra_settings');
            //$frontend_js_dependencies = array( 'jquery', 'jquery-ui-datepicker', 'ap-fileuploader', 'ap-tagit-js' );
            $tagit_dep = array( 'jquery' );
            if ( empty($ap_extra_settings) ) {
                $ap_extra_settings = array( 'lightbox_disable' => 0, 'jquery_ui_disable' => 0 );
            }
            /**
             * Frontend Styles
             * */
            wp_enqueue_style('ap-fileuploader-animation', AP_PRO_CSS_DIR . '/loading-animation.css');
            wp_enqueue_style('ap-fileuploader', AP_PRO_CSS_DIR . '/fileuploader.css');
            if ( $ap_extra_settings[ 'jquery_ui_disable' ] == 0 ) {

                wp_enqueue_style('ap-jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
                wp_enqueue_script('ap-jquery-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js', array( 'jquery' ));
                //$tagit_dep[] = 'ap-jquery-ui';
                wp_enqueue_script('ap-tagit-js', AP_PRO_JS_DIR . '/tag-it.js', $tagit_dep, AP_PRO_VERSION);
                wp_enqueue_script('ap-tagit-custom-js', AP_PRO_JS_DIR . '/tag-it-custom.js', array( 'jquery', 'ap-jquery-ui', 'ap-tagit-js' ), AP_PRO_VERSION);
            }

            wp_enqueue_style('ap-tagit-styles', AP_PRO_CSS_DIR . '/jquery.tagit.css');
            wp_enqueue_style('ap-tagit-ui-styles', AP_PRO_CSS_DIR . '/tagit.ui-zendesk.css');
            wp_enqueue_style('ap-front-styles', AP_PRO_CSS_DIR . '/frontend-style.css', false, AP_PRO_VERSION);
            if ( $ap_extra_settings[ 'lightbox_disable' ] == 0 ) {

                wp_enqueue_style('ap-lightbox-css', AP_PRO_LIGHTBOX_DIR . '/css/lightbox.css', false, AP_PRO_VERSION);
            }

            /**
             * Fronend Js
             *
             */
            wp_enqueue_script('ap-fileuploader', AP_PRO_JS_DIR . '/fileuploader.js');

            if ( $ap_extra_settings[ 'lightbox_disable' ] == 0 ) {
                wp_enqueue_script('ap-lightbox-js', AP_PRO_LIGHTBOX_DIR . '/js/lightbox.js', array( 'jquery' ), AP_PRO_VERSION);
            }

            wp_enqueue_script('ap-frontend-js', AP_PRO_JS_DIR . '/frontend.js', array( 'jquery', 'jquery-ui-datepicker', 'ap-fileuploader' ), AP_PRO_VERSION);



            /**
             * Localizing php variables in js files
             * */
            $fileuploader_variables = array( 'upload_url' => admin_url() . 'admin-ajax.php',
                'nonce' => wp_create_nonce('ap-file-uploader-nonce') );
            wp_localize_script('ap-frontend-js', 'ap_fileuploader', $fileuploader_variables);
            wp_localize_script('ap-frontend-js', 'ap_form_required_message', __('This field is required', 'anonymous-post-pro'));
            wp_localize_script('ap-frontend-js', 'ap_captcha_error_message', __('Sum is not correct.', 'anonymous-post-pro'));
        }

        //Adds admin menu
        function add_ap_menu() {
            add_menu_page('AccessPress Anonymoust Post Pro Settings', 'AccessPress Anonymous Post &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pro', 'manage_options', 'anonymous-post-pro', array( $this, 'list_forms' ), AP_PRO_IMAGE_DIR . '/ap-icon.png');
            add_submenu_page('anonymous-post-pro', 'Anonymous Forms', 'Anonymous Forms', 'manage_options', 'anonymous-post-pro', array( $this, 'list_forms' ));
            add_submenu_page('anonymous-post-pro', 'Add New Form', 'Add New', 'manage_options', 'add-new-ap-form', array( $this, 'add_new_form' ));
            add_submenu_page('anonymous-post-pro', 'Settings', 'Settings', 'manage_options', 'ap-pro-settings', array( $this, 'extra_settings' ));
        }

        //lists all the forms
        function list_forms() {
            if ( isset($_GET[ 'form_id' ]) ) {
                include('inc/settings.php');
            } else {
                include('inc/cores/list-forms.php');
            }
        }

        function add_new_form() {
            include_once('inc/settings.php');
        }

        //returns the ID of the first user
        function get_first_user_id() {
            $users = get_users();
            foreach ( $users as $user ) {
                return $user->ID;
                exit;
            }
        }

        function session_init() {
            if ( !session_id() ) {
                session_start();
            }
            $_SESSION[ 'file_uploader_counter' ] = 0;
        }

        //Load default settings during plugin activation
        function load_default_settings() {
            $ap_settings = array(); //array for saving all the plugin's settings in single array
            $ap_settings[ 'version' ] = AP_PRO_VERSION;
            /**
             * General Settings
             * */
            $ap_settings[ 'form_title' ] = 'Anonymous Post';
            $ap_settings[ 'publish_status' ] = 'draft';
            $ap_settings[ 'post_format' ] = 'none';
            $ap_settings[ 'post_type' ] = 'post';
            $ap_settings[ 'admin_notification' ] = 1;
            $ap_settings[ 'admin_email_list' ] = array();
            $admin_notification_message = 'Hello There,<br/><br/>

                                           A new post has been submitted via AccessPress Anonymous Post plugin in ' . get_bloginfo('name') . ' website. Please find details below:<br/><br/>

                                           Post title:<br/>
                                           #post_title <br/><br/>


                                           <br/><br/>
                                           To take action (approve/reject) - please go here:<br/><br/>
                                           #post_link <br/><br/>


                                           Thank you!';
            //$ap_settings['admin_notification_message'] = __(wp_kses_post($admin_notification_message),'anonymous-post-pro');
            $ap_settings[ 'admin_notification_message' ] = '';
            $ap_settings[ 'user_notification' ] = 0;
            $ap_settings[ 'user_notification_message' ] = '';
            $ap_settings[ 'login_check' ] = 0;
            $ap_settings[ 'login_type' ] = 'login_message';
            $ap_settings[ 'login_message' ] = '';
            $ap_settings[ 'login_link_text' ] = '';
            $ap_settings[ 'anonymous_image_upload' ] = 0;
            $ap_settings[ 'media_upload' ] = 0;
            $ap_settings[ 'ap_image_max_upload_size' ] = '';
            $ap_settings[ 'post_author' ] = $this->get_first_user_id();
            $ap_settings[ 'redirect_type' ] = 'url';
            $ap_settings[ 'redirect_url' ] = '';
            $ap_settings[ 'post_submission_message' ] = __('Thank you for submitting the post.', 'anonymous-post-pro');

            /**
             * Form Settings
             * */
            $ap_settings[ 'form_fields' ] = array( 'post_title' => array( 'show_form' => 1,
                    'required' => 1,
                    'required_message' => '',
                    'label' => '',
                    'notes_type' => 0,
                    'notes' => '',
                    'field_type' => 'field'
                ),
                'post_content' => array( 'show_form' => 1,
                    'required' => 1,
                    'required_message' => '',
                    'label' => '',
                    'notes_type' => 0,
                    'notes' => '',
                    'editor_type' => 'simple',
                    'field_type' => 'field',
                ),
                'post_excerpt' => array(
                    'required_message' => '',
                    'label' => '',
                    'notes_type' => 0,
                    'notes' => '',
                    'field_type' => 'field',
                    'show_form' => 0,
                    'required' => 0
                ),
                'post_image' => array( 'required_message' => '',
                    'label' => '',
                    'notes_type' => 0,
                    'notes' => '',
                    'field_type' => 'field',
                    'show_form' => 0,
                    'required' => 0,
                ),
                'author_name' => array( 'required_message' => '',
                    'label' => '',
                    'notes_type' => 0,
                    'notes' => '',
                    'field_type' => 'field',
                    'show_form' => 0,
                    'required' => 0
                ),
                'author_url' => array( 'required_message' => '',
                    'label' => '',
                    'notes_type' => 0,
                    'notes' => '',
                    'field_type' => 'field',
                    'show_form' => 0,
                    'required' => 0
                ),
                'author_email' => array( 'required_message' => '',
                    'label' => '',
                    'notes_type' => 0,
                    'notes' => '',
                    'field_type' => 'field',
                    'show_form' => 0,
                    'required' => 0
                ),
                'category' => array( 'required_message' => '',
                    'label' => 'Categories',
                    'notes_type' => 0,
                    'notes' => '',
                    'hierarchical' => 1,
                    'field_type' => 'taxonomy',
                    'taxonomy_label' => 'Categories',
                    'show_form' => 0,
                    'required' => 0
                ),
                'post_tag' => array( 'required_message' => '',
                    'label' => 'Tags',
                    'notes_type' => 0,
                    'notes' => '',
                    'hierarchical' => 0,
                    'field_type' => 'taxonomy',
                    'taxonomy_label' => 'Tags',
                    'show_form' => 0,
                    'required' => 0
                )
            );
            $ap_settings[ 'post_submit_label' ] = '';
            $ap_settings[ 'post_category' ] = '';
            $ap_settings[ 'taxonomy_reference' ] = 'category,post_tag';
            $ap_settings[ 'form_included_taxonomy' ] = array( 'category', 'post_tag' );
            $ap_settings[ 'form_field_order' ] = array( 'post_title|field',
                'post_content|field',
                'post_excerpt|field',
                'post_image|field',
                'author_name|field',
                'author_url|field',
                'author_email|field',
                'category|taxononmy',
                'post_tag|taxononmy' );

            /**
             * Form Style Settings
             * */
            $ap_settings[ 'plugin_styles' ] = 1;
            $ap_settings[ 'plugin_style_type' ] = 'template';
            $ap_settings[ 'form_template' ] = '';
            $ap_settings[ 'form_styles' ] = array( 'label' => array( 'font' => 'Open Sans',
                    'font_size' => '12',
                    'label_color' => '#000',
                ),
                'field' => array( 'color' => '#000',
                    'border_thickness' => '1',
                    'border_color' => '#000',
                ),
                'button' => array( 'font' => 'Open Sans',
                    'font_size' => '12px',
                    'font_color' => '#000',
                    'button_background' => '#FFF',
                ),
                'form' => array( 'width' => '100',
                    'width_type' => 'per',
                    'border' => 'yes',
                    'round_corners' => 'no',
                    'form_background' => 'no',
                    'form_background_type' => 'color',
                    'form_background_color' => '',
                    'background_image' => '',
                    'background_repeat' => 'repeat',
                    'border_color' => '#000',
                    'border_thickness' => '1'
                )
            );

            /**
             * Captcha Settings
             * */
            $ap_settings[ 'captcha_settings' ] = 1;
            $ap_settings[ 'captcha_type' ] = 'human';
            $ap_settings[ 'google_captcha_version' ] = 'v1';
            $ap_settings[ 'google_captcha_label' ] = '';
            $ap_settings[ 'google_catpcha_public_key' ] = '';
            $ap_settings[ 'google_catpcha_private_key' ] = '';
            $ap_settings[ 'google_captcha_site_key' ] = '';
            $ap_settings[ 'google_captcha_secret_key' ] = '';
            $ap_settings[ 'google_captcha_error_message' ] = '';
            $ap_settings[ 'math_captcha_error_message' ] = '';
            $ap_settings[ 'math_captcha_label' ] = '';
            $ap_settings[ 'google_captcha_error_message' ] = '';
            $ap_settings[ 'math_captcha_error_message' ] = '';


            if ( !get_option('ap_settings') ) {
                update_option('ap_pro_settings', $ap_settings);
            } else {
                $ap_settings = $this->ap_settings;
                //$ap_settings['']
            }
        }

        //plugin backend settings page
        function ap_settings() {
            include_once('inc/settings.php');
        }

        //returns all the registered post types only
        function get_registered_post_types() {
            $post_types = get_post_types();
            unset($post_types[ 'revision' ]);
            unset($post_types[ 'attachment' ]);
            unset($post_types[ 'nav_menu_item' ]);
            return $post_types;
        }

        //prints array in pre format
        function print_array($array) {
            echo "<pre>";
            print_r($array);
            echo "</pre>";
        }

        //returns all the terms of a specific post type called from ajax
        function get_terms_by_post_type() {
            if ( !empty($_POST) ) {
                $post_type = $_POST[ 'post_type' ];
                $taxonomies = get_object_taxonomies($post_type, 'objects');
                //die($this->print_array($taxonomies));
                $post_obj = new stdClass();
                $option_html = "<option value=\"\">" . __('Choose Category', 'anonymous-post-pro') . "</option>";
                //die(count($taxonomies));
                //$this->print_array($taxonomies);
                //if the post type has atleast one taxonomy registered
                if ( count($taxonomies) != 0 ) {
                    //unset($taxonomies['post_tag']);
                    unset($taxonomies[ 'post_format' ]);
                    //if(count($taxonomies)>1) //condition check if the taxonomy is not category
//                    {

                    $taxonomies_array = array();
                    $taxonomies_label_array = array();
                    $taxonomies_hierarchical_array = array();
                    foreach ( $taxonomies as $taxonomy => $taxonomy_object ) {
                        $taxonomies_array[] = $taxonomy;
                        $taxonomies_hierarchical_array[] = intval($taxonomy_object->hierarchical);
                        $taxonomies_label_array[] = $taxonomy_object->labels->name;
                        $terms = get_terms($taxonomy, array( 'hide_empty' => false ));
                        if ( count($terms) > 0 && $taxonomy_object->hierarchical == 1 ) { //condition check if the taxonomy has atleast single term
                            $option_html .= "<optgroup label=\"{$taxonomy_object->labels->name}\">";
                            foreach ( $terms as $term ) {
                                $option_html .= "<option value=\"{$term->term_id}|{$taxonomy}\">{$term->name}</option>";
                            }
                            $option_html .= "</optgroup>";
                            $post_obj->options = $option_html;
                        }
                    }
                    $post_obj->taxonomy = $taxonomies_array;
                    $post_obj->taxonomy_label = $taxonomies_label_array;
                    $post_obj->taxonomy_hierarchical = $taxonomies_hierarchical_array;
                }//if close
                die(json_encode($post_obj));
            } else {
                die("No script kiddies please!");
            }
        }

        //prevents the unauthorized ajax call without admin login
        function no_permission() {
            die("No script kiddies please!");
        }

        //Sanitizes field values for saving in db
        function filter_field($field) {
            //$field = trim($field);
            $field = strip_tags($field);
            $field = stripslashes($field);
            //$field = mysql_real_escape_string($field);
            return $field;
        }

        //Saves all the settings
        function ap_settings_action() {
            if ( !empty($_POST) ) {
                include_once('inc/cores/save-settings.php');
            }
        }

        //returns all the terms for category dropdown as options
        function get_terms_for_category_drodown($post_type, $term_id) {

            $taxonomies = get_object_taxonomies($post_type, 'objects');
            $option_html = "<option value=\"\">" . __('Choose Category', 'anonymous-post-pro') . "</option>";
            //die(count($taxonomies));
            // $this->print_array($term_id);
            //if the post type has atleast one taxonomy registered
            if ( count($taxonomies) != 0 ) {
                unset($taxonomies[ 'post_tag' ]);
                unset($taxonomies[ 'post_format' ]);
                foreach ( $taxonomies as $taxonomy => $taxonomy_object ) {
                    $taxonomies_array[] = $taxonomy;
                    $taxonomies_label_array[] = $taxonomy_object->labels->name;
                    $terms = get_terms($taxonomy, array( 'hide_empty' => false ));
                    $categoryHierarchy = array();
                    $this->sort_terms_hierarchicaly($terms, $categoryHierarchy);
                    if ( count($categoryHierarchy) > 0 ) { //condition check if the taxonomy has atleast single term
                        $option_html .= "<optgroup label=\"{$taxonomy_object->labels->name}\">";
                        $terms_exclude = array();
                        $option_html .= $this->print_option($categoryHierarchy, array(), 1, '', '', $term_id, true);
                        /*
                          foreach ( $terms as $term ) {
                          $option_html .= "<option value=\"{$term->term_id}|{$taxonomy}\"";
                          if ( $term_id == $term->term_id . '|' . $taxonomy ) {
                          $option_html .= "selected=\"selected\"";
                          };
                          $option_html .= ">{$term->name}</option>";
                          }
                         *
                         */
                        $option_html .= "</optgroup>";
                    }
                }
            }//if close
            return $option_html;
        }

        //Prints all the taxonomies in checkbox format
        function print_all_included_taxonomies() {
            global $ap_settings;
            $taxonomies = get_object_taxonomies($ap_settings[ 'post_type' ], 'objects');
            if ( count($taxonomies) != 0 ) {
                //unset($taxonomies['post_tag']);
                unset($taxonomies[ 'post_format' ]);
                foreach ( $taxonomies as $taxonomy => $taxonomy_object ) {
                    ?>
                    <div class="ap-each-config-wrapper">
                        <div class="ap-fields-label">
                            <label><?php echo $taxonomy_object->labels->name; ?></label>
                        </div><!--ap-fields-label-->
                        <div class="ap-fields-configurations">
                            <div class="ap-included-single-wrap">
                                <input type="checkbox" name="form_included_taxonomy[]" value="<?php echo $taxonomy ?>"  <?php if ( in_array($taxonomy, $ap_settings[ 'form_included_taxonomy' ]) ) { ?>checked="checked"<?php } ?> /><span>Included</span>
                            </div>
                            <div class="ap-required-single-wrap">
                                <input type="checkbox" name="form_required_fields[]" value="<?php echo $taxonomy ?>" <?php if ( in_array($taxonomy, $ap_settings[ 'form_required_fields' ]) ) { ?>checked="checked"<?php } ?>/><span>Required</span>
                            </div>
                            <div class="ap-required-message-single-wrap">
                                <input type="text" name="<?php echo $taxonomy; ?>_required_message" placeholder="<?php _e('Custom Required Message', 'anonymous-post-pro'); ?>" value="<?php echo $ap_settings[ $taxonomy . '_required_message' ]; ?>"/><span></span>
                            </div>
                        </div><!--ap-fields-configurations-->
                    </div><!--ap-each-config-wrapper-->


                    <?php
                }
            }
        }

        //returns all the taxonomies in checkbox format for required fields
        function print_all_required_taxonomies() {
            global $ap_settings;
            $taxonomies = get_object_taxonomies($ap_settings[ 'post_type' ], 'objects');
            if ( count($taxonomies) != 0 ) {
                //unset($taxonomies['post_tag']);
                unset($taxonomies[ 'post_format' ]);
                foreach ( $taxonomies as $taxonomy => $taxonomy_object ) {
                    ?>
                    <div class="ap-checkbox-form"><input type="checkbox" name="form_required_fields[]" value="<?php echo $taxonomy ?>" <?php if ( in_array($taxonomy, $ap_settings[ 'form_required_fields' ]) ) { ?>checked="checked"<?php } ?>/></div><span><?php echo $taxonomy_object->labels->name; ?></span>
                    <?php
                }
            }
        }

        //Returns the label fields for the taxonomies
        function get_taxonomy_label_fields() {
            global $ap_settings;
            $post_type = $ap_settings[ 'post_type' ];
            $taxonomies = get_object_taxonomies($ap_settings[ 'post_type' ], 'objects');
            if ( count($taxonomies) != 0 ) {
                //unset($taxonomies['post_tag']);
                unset($taxonomies[ 'post_format' ]);
                foreach ( $taxonomies as $taxonomy => $taxonomy_object ) {
                    $label_name = $taxonomy . '_label';
                    ?>
                    <div class="ap-option-wrapper">
                        <label><?php echo $taxonomy_object->labels->name; ?></label>
                        <div class="ap-option-field">
                            <input type="text" name="<?php echo $label_name; ?>" value="<?php echo $ap_settings[ $label_name ] ?>"/>
                            <div class="ap-option-note ap-option-width">This field will only show up in frontend if you have checked the category in included fields.</div>
                        </div>
                    </div>
                    <?php
                }
            }
        }

        //Shortcode for the form
        function ap_form($atts) {
            global $wpdb;
            if ( empty($atts) ) {
                $form_id = 1;
                $table_name = $table_name = $wpdb->prefix . "ap_pro_forms";
                $forms = $wpdb->get_results("SELECT * FROM $table_name where ap_form_id = $form_id");
                if ( !empty($forms) ) {
                    $form = $forms[ 0 ];
                    $ap_settings = $this->get_unserialized($form->form_details);
                }
            } else {
                $form_id = $atts[ 'id' ];
                $table_name = $table_name = $wpdb->prefix . "ap_pro_forms";
                $forms = $wpdb->get_results("SELECT * FROM $table_name where ap_form_id = $form_id");
                if ( !empty($forms) ) {
                    $form = $forms[ 0 ];
                    $ap_settings = $this->get_unserialized($form->form_details);
                }

                // $this->print_array($ap_settings);
            }
            if ( isset($ap_settings) ) {
                $this->ap_settings = $ap_settings;

                //$this->print_array($ap_settings);
                include('inc/cores/shortcode.php');
                return $ap_form;
            } else {
                $no_form_message = __('Sorry!!No form found for id ' . $form_id, 'anonymous-post-pro');
                return $no_form_message;
            }
        }

        //Prepares the form html for the shortcode
        function prepare_form_html($form_id) {
            global $wpdb;
            $table_name = $table_name = $wpdb->prefix . "ap_pro_forms";
            $forms = $wpdb->get_results("SELECT * FROM $table_name where ap_form_id = $form_id");
            $form = $forms[ 0 ];
            $ap_settings = $this->get_unserialized($form->form_details);
            include('inc/cores/front-form.php');
            return $form;
        }

        //returns the html generated by wp_editor hook
        function get_wp_editor_html($editor_type, $media_upload_flag, $form_id, $editor_rows = 10) {

            switch ( $editor_type ) {
                case 'rich':
                    $teeny = false;
                    $show_quicktags = true;
                    break;
                case 'visual':
                    $teeny = false;
                    $show_quicktags = false;
                    break;
                case 'html':
                    $teeny = true;
                    $show_quicktags = true;
                    add_filter('user_can_richedit', create_function('', 'return false;'), 50);
                    break;
            }
            $settings = array(
                'textarea_name' => 'ap_form_post_content',
                'media_buttons' => $media_upload_flag,
                'teeny' => $teeny,
                'wpautop' => true,
                'quicktags' => $show_quicktags,
                'editor_class' => 'ap-form-content-editor ap-form-wp-editor',
                'textarea_rows' => $editor_rows
            );

            ob_start();
            wp_editor('', 'ap_form_post_content_' . $form_id, $settings);
            $wp_editor = ob_get_contents();
            ob_end_clean();
            return $wp_editor;
        }

        //returns nonce field html as variable
        function get_nonce_field_html() {
            ob_start();
            wp_nonce_field('ap_form_nonce', 'ap_form_nonce');
            $nonce_field = ob_get_contents();
            ob_end_clean();
            return $nonce_field;
        }

        //send admin notification if enabled from backend
        function send_admin_notification($post_id, $post_title, $form_id) {
            $ap_settings = $this->get_ap_settings($form_id);
            $blogname = get_option('blogname');
            $email = get_option('admin_email');
            $post_admin_link = admin_url() . 'post.php?post=' . $post_id . '&action=edit';
            $charset = get_option('blog_charset');
            $from_name = (isset($ap_settings[ 'admin_notification_from_name' ]) && $ap_settings[ 'admin_notification_from_name' ] != '') ? esc_attr($ap_settings[ 'admin_notification_from_name' ]) : $blogname;
            $from_email = (isset($ap_settings[ 'admin_notification_from_email' ]) && $ap_settings[ 'admin_notification_from_email' ] != '') ? esc_attr($ap_settings[ 'admin_notification_from_email' ]) : $email;
            $from_header = "From: $from_name <$from_email>";
            if ( $ap_settings[ 'admin_notification_message' ] == '' ) {
                $message = 'Hello There,<br/><br/>

                        A new post has been submitted via AccessPress Anonymous post plugin in your ' . get_bloginfo('name') . ' website. Please find details below:<br/><br/>

                        Post Title: ' . $post_title . '<br/><br/>

                        _____<br/><br/>

                        To take action (approve/reject) - please go here:<br/>
                        ' . $post_admin_link . '<br/><br/>

                        Thank you';
            } else {
                $message = str_replace('#post_title', $post_title, $ap_settings[ 'admin_notification_message' ]);
                $message = str_replace('#post_admin_link', $post_admin_link, $message);
                $author_email = get_post_meta($post_id, 'ap_author_email', true);
                $author_name = get_post_meta($post_id, 'ap_author_name', true);
                $author_url = get_post_meta($post_id, 'ap_author_url', true);
                if ( $author_email ) {
                    $message = str_replace('#post_author_email', $author_email, $message);
                }
                if ( $author_name ) {
                    $message = str_replace('#post_author_name', $author_name, $message);
                }
                if ( $author_url ) {
                    $message = str_replace('#post_author_url', $author_url, $message);
                }
            }

            //  $headers = "MIME-Version: 1.0\r\n" . "From: " . $blogname . " " . "<" . $email . ">\n" . "Content-Type: text/HTML; charset=\"" . get_option( 'blog_charset' ) . "\"\r\n";
            $headers = array();
            $headers[] = 'Content-Type: text/html; charset=' . $charset;
            $headers[] = $from_header;

            $message1 = __('Hi there,', 'anonymous-post-pro') . '<br/>' .
                    __('You have recived a new post submission from ', 'anonymous-post-pro') . $blogname . ' site.' . __('Details below:', 'anonymous-post-pro') . '<br/><br/>' .
                    'Post title: ' . $post_title . '><br/>' .
                    'Post Link: ' . get_permalink($post_id) . '<br/><br/>

                        ' . __('Thank You', 'anonymous-post-pro');

            $subject = (isset($ap_settings[ 'admin_notification_subject' ]) && $ap_settings[ 'admin_notification_subject' ] != '') ? esc_attr($ap_settings[ 'admin_notification_subject' ]) : __('New Post Submission', 'anonymous-post-pro');
            if ( $ap_settings[ 'admin_notification' ] ) {
                wp_mail($email, $subject, $message, $headers);
            }
            if ( !empty($ap_settings[ 'admin_email_list' ]) ) {
                $admin_email_list = array_map('esc_attr', $ap_settings[ 'admin_email_list' ]);
                foreach ( $admin_email_list as $email ) {
                    if ( is_email($email) ) {
                        wp_mail($email, $subject, $message, $headers);
                    }
                }
            }
        }

        //returns the current page url
        function curPageURL() {
            $pageURL = 'http';
            if ( isset($_SERVER[ 'HTTPS' ]) && $_SERVER[ "HTTPS" ] == "on" ) {
                $pageURL .= "s";
            }
            $pageURL .= "://";
            if ( $_SERVER[ "SERVER_PORT" ] != "80" ) {
                $pageURL .= $_SERVER[ "SERVER_NAME" ] . ":" . $_SERVER[ "SERVER_PORT" ] . $_SERVER[ "REQUEST_URI" ];
            } else {
                $pageURL .= $_SERVER[ "SERVER_NAME" ] . $_SERVER[ "REQUEST_URI" ];
            }
            return $pageURL;
        }

        //shortcode for showing the message in any redirected page after successful post submission
        function ap_form_message($atts) {
            if ( isset($_SESSION[ 'ap_form_success_msg' ]) ) {
                $msg = $_SESSION[ 'ap_form_success_msg' ];
                unset($_SESSION[ 'ap_form_success_msg' ]);
                return $msg;
            } else {
                if ( isset($atts[ 'redirect' ]) ) {
                    $redirect_url = $atts[ 'redirect' ];
                    echo "<script>";
                    echo "window.location = '$redirect_url';";
                    echo "</script>";
                }
            }
        }

        //prints the dropdown list of google font
        function print_google_fonts_dropdown() {
            include('inc/extras/google-fonts-dropdown.php');
        }

        //Sanitizes field by converting line breaks to <br /> tags
        function sanitize_escaping_linebreaks($text) {
            $text = implode("<br \>", array_map('sanitize_text_field', explode("\n", $text)));
            return $text;
        }

        //outputs by converting <Br/> tags into line breaks
        function output_converting_br($text) {
            $text = implode("\n", array_map('sanitize_text_field', explode("<br \>", $text)));
            return $text;
        }

        //returns the login form html
        function prepare_login_form($form_id) {
            $ap_settings = $this->get_ap_settings($form_id);
            $username_label = (isset($ap_settings[ 'username_label' ]) && $ap_settings[ 'username_label' ] != '') ? esc_attr($ap_settings[ 'username_label' ]) : __('Username', 'anonymous-post-pro');
            $password_label = (isset($ap_settings[ 'password_label' ]) && $ap_settings[ 'password_label' ] != '') ? esc_attr($ap_settings[ 'password_label' ]) : __('Password', 'anonymous-post-pro');
            $login_button_label = (isset($ap_settings[ 'login_button_label' ]) && $ap_settings[ 'login_button_label' ] != '') ? esc_attr($ap_settings[ 'login_button_label' ]) : __('Login', 'anonymous-post-pro');
            // $this->print_array($ap_settings);
            $nonce_field = $this->get_nonce_field_html();
            $form = '<div class="ap-login-form">
                      <h2>' . __('Login', 'anonymous-post-pro') . '</h2>';
            if ( isset($_SESSION[ 'ap_login_error' ]) ) {
                $login_error = $_SESSION[ 'ap_login_error' ];
                $form .= '<div class="ap-error ap-login-error">' . $login_error . '</div>';
            }
            $form .= '<form method="post" action="">
                         <div class="ap-login-field-wrapper">
                           <label>' . $username_label . '</label>
                           <div class="ap-login-field">
                             <input type="text" name="login_username" required/>
                           </div>
                         </div>
                         <div class="ap-login-field-wrapper">
                           <label>' . $password_label . '</label>
                           <div class="ap-login-field">
                             <input type="password" name="login_password" required/>
                           </div>
                         </div>

                         <div class="ap-login-field-wrapper">
                           <div class="ap-login-field">
                             <input type="submit" name="ap_login_submit" value="' . $login_button_label . '">
                           </div>
                         </div>
                         <input type="hidden" name="redirect_url" value="' . $this->curPageURL() . '"/>';
            $form .= $nonce_field;
            $form .= '</form>
            </div>';
            return $form;
        }

        //action triggered when the post is published and the user notification is enabled
        function post_published_notification($ID, $post) {
            if ( !isset($_POST[ 'hidden_post_status' ]) ) {
                return;
            }
            if ( $_POST[ 'hidden_post_status' ] == 'draft' || $_POST[ 'hidden_post_status' ] == 'pending' ) {
                $author_email = get_post_meta($ID, 'ap_author_email', true);
                $ap_form_id = get_post_meta($ID, 'ap_form_id', true);
                if ( empty($ap_form_id) || empty($author_email) ) {
                    return;
                }
                $ap_settings = $this->get_ap_settings($ap_form_id);
                if ( $ap_settings[ 'user_notification' ] == 1 && $ap_settings != null ) {
                    $blogname = get_option('blogname');
                    $email = get_option('admin_email');
                    $post_link = get_permalink($ID);
                    $post_title = get_the_title($ID);
                    $charset = get_option('blog_charset');
                    $from_name = (isset($ap_settings[ 'user_notification_from_name' ]) && $ap_settings[ 'user_notification_from_name' ] != '') ? esc_attr($ap_settings[ 'user_notification_from_name' ]) : $blogname;
                    $from_email = (isset($ap_settings[ 'user_notification_from_email' ]) && $ap_settings[ 'user_notification_from_email' ] != '') ? esc_attr($ap_settings[ 'user_notification_from_email' ]) : $email;
                    $from_header = "From: $from_name <$from_email>";
                    if ( $ap_settings[ 'user_notification_message' ] == '' ) {
                        $message = 'Hello There,<br/><br/>

                                Your post has been published in ' . get_bloginfo('name') . ' website. Please find details below:<br/><br/>

                                Post Title: ' . $post_title . '<br/><br/>

                                _____<br/><br/>

                                To view your post in the site - please go here:<br/>
                                ' . $post_link . '<br/><br/>

                                Thank you';
                    } else {
                        $message = str_replace('#post_title', $post_title, $ap_settings[ 'user_notification_message' ]);
                        $message = str_replace('#post_link', $post_link, $message);
                    }



                    // $headers = "MIME-Version: 1.0\r\n" . "From: " . $blogname . " " . "<" . $email . ">\n" . "Content-Type: text/HTML; charset=\"" . get_option( 'blog_charset' ) . "\"\r\n";
                    $headers = array();
                    $headers[] = 'Content-Type: text/html; charset=' . $charset;
                    $headers[] = $from_header;
                    $subject = (isset($ap_settings[ 'user_notification_subject' ]) && $ap_settings[ 'user_notification_subject' ] != '') ? esc_attr($ap_settings[ 'user_notification_subject' ]) : __('Post published', 'anonymous-post-pro');
                    if ( is_email($author_email) ) {
                        wp_mail($author_email, $subject, $message, $headers);
                    }
                }
            }
        }

        function ap_file_upload_action() {
            include_once('file-uploader/file-uploader-class.php');
            include_once('inc/cores/file-uploader.php');
            die();
        }

        //returns only logged in user related media items
        function restrict_media_library($wp_query_obj) {
            global $current_user, $pagenow;
            if ( !is_a($current_user, 'WP_User') )
                return;
            if ( 'admin-ajax.php' != $pagenow || $_REQUEST[ 'action' ] != 'query-attachments' )
                return;
            if ( !current_user_can('manage_media_library') )
                $wp_query_obj->set('author', $current_user->ID);
            return;
        }

        function ap_pro_restore_default_settings() {
            $nonce = $_REQUEST[ '_wpnonce' ];
            if ( !empty($_GET) && wp_verify_nonce($nonce, 'ap-restore-default-nonce') ) {
                $form_id = $_GET[ 'form_id' ];
                global $wpdb;
                $ap_settings = $this->get_default_settings();
                $ap_settings_serialized = base64_encode(serialize($ap_settings));
                $table_name = $wpdb->prefix . 'ap_pro_forms';
                $wpdb->update(
                        $table_name, array(
                    'form_details' => $ap_settings_serialized
                        ), array( 'ap_form_id' => $form_id ), array(
                    '%s'
                        ), array( '%d' )
                );
                $_SESSION[ 'ap_message' ] = __('Default Settings Restored Successfully', 'anonymous-post-pro');
                wp_redirect(admin_url() . 'admin.php?page=anonymous-post-pro&action=edit_form&form_id=' . $form_id);
                exit;
            } else {
                die('No script kiddies please');
            }
        }

        function get_default_settings() {
            $ap_settings[ 'version' ] = AP_PRO_VERSION;
            /**
             * General Settings
             * */
            $ap_settings[ 'form_title' ] = 'Anonymous Post';
            $ap_settings[ 'publish_status' ] = 'draft';
            $ap_settings[ 'post_type' ] = 'post';
            $ap_settings[ 'admin_notification' ] = 1;
            $ap_settings[ 'admin_email_list' ] = array();
            $admin_notification_message = 'Hello There,<br/><br/>

                                           A new post has been submitted via AccessPress Anonymous Post plugin in ' . get_bloginfo('name') . ' website. Please find details below:<br/><br/>

                                           Post title:<br/>
                                           #post_title <br/><br/>


                                           <br/><br/>
                                           To take action (approve/reject) - please go here:<br/><br/>
                                           #post_link <br/><br/>


                                           Thank you!';
            //$ap_settings['admin_notification_message'] = __(wp_kses_post($admin_notification_message),'anonymous-post-pro');
            $ap_settings[ 'admin_notification_message' ] = '';
            $ap_settings[ 'user_notification' ] = 0;
            $ap_settings[ 'user_notification_message' ] = '';
            $ap_settings[ 'login_check' ] = 0;
            $ap_settings[ 'login_type' ] = 'login_message';
            $ap_settings[ 'login_message' ] = '';
            $ap_settings[ 'login_link_text' ] = '';
            $ap_settings[ 'anonymous_image_upload' ] = 0;
            $ap_settings[ 'post_author' ] = $this->get_first_user_id();
            $ap_settings[ 'redirect_url' ] = '';
            $ap_settings[ 'post_submission_message' ] = __('Thank you for submitting the post.', 'anonymous-post-pro');

            /**
             * Form Settings
             * */
            $ap_settings[ 'form_fields' ] = array( 'post_title' => array( 'show_form' => 1,
                    'required' => 1,
                    'required_message' => '',
                    'label' => '',
                    'notes_type' => 0,
                    'notes' => '',
                    'field_type' => 'field'
                ),
                'post_content' => array( 'show_form' => 1,
                    'required' => 1,
                    'required_message' => '',
                    'label' => '',
                    'notes_type' => 0,
                    'notes' => '',
                    'editor_type' => 'simple',
                    'field_type' => 'field',
                ),
                'post_excerpt' => array(
                    'required_message' => '',
                    'label' => '',
                    'notes_type' => 0,
                    'notes' => '',
                    'field_type' => 'field',
                    'show_form' => 0,
                    'required' => 0
                ),
                'post_image' => array( 'required_message' => '',
                    'label' => '',
                    'notes_type' => 0,
                    'notes' => '',
                    'field_type' => 'field',
                    'show_form' => 0,
                    'required' => 0,
                ),
                'author_name' => array( 'required_message' => '',
                    'label' => '',
                    'notes_type' => 0,
                    'notes' => '',
                    'field_type' => 'field',
                    'show_form' => 0,
                    'required' => 0,
                    'frontend_show' => 0,
                    'frontend_show_label' => ''
                ),
                'author_url' => array( 'required_message' => '',
                    'label' => '',
                    'notes_type' => 0,
                    'notes' => '',
                    'field_type' => 'field',
                    'show_form' => 0,
                    'required' => 0,
                    'frontend_show' => 0,
                    'frontend_show_label' => '',
                    'show_link' => 0
                ),
                'author_email' => array( 'required_message' => '',
                    'label' => '',
                    'notes_type' => 0,
                    'notes' => '',
                    'field_type' => 'field',
                    'show_form' => 0,
                    'required' => 0,
                    'frontend_show' => 0,
                    'frontend_show_label' => ''
                ),
                'category' => array( 'required_message' => '',
                    'label' => 'Categories',
                    'notes_type' => 0,
                    'notes' => '',
                    'hierarchical' => 1,
                    'multiple_select' => 0,
                    'field_type' => 'taxonomy',
                    'taxonomy_label' => 'Categories',
                    'show_form' => 0,
                    'required' => 0
                ),
                'post_tag' => array( 'required_message' => '',
                    'label' => 'Tags',
                    'notes_type' => 0,
                    'notes' => '',
                    'hierarchical' => 0,
                    'taxonomy_field_type' => 'textfield',
                    'field_type' => 'taxonomy',
                    'taxonomy_label' => 'Tags',
                    'show_form' => 0,
                    'required' => 0
                )
            );
            $ap_settings[ 'post_submit_label' ] = '';
            $ap_settings[ 'post_category' ] = '';
            $ap_settings[ 'terms_agreement' ] = 0;
            $ap_settings[ 'terms_agreement_text' ] = '';
            $ap_settings[ 'terms_agreement_message' ] = '';
            $ap_settings[ 'taxonomy_reference' ] = 'category,post_tag';
            $ap_settings[ 'form_included_taxonomy' ] = array( 'category', 'post_tag' );
            $ap_settings[ 'form_field_order' ] = array( 'post_title|field',
                'post_content|field',
                'post_excerpt|field',
                'post_image|field',
                'author_name|field',
                'author_url|field',
                'author_email|field',
                'category|taxononmy',
                'post_tag|taxononmy' );

            /**
             * Form Style Settings
             * */
            $ap_settings[ 'plugin_styles' ] = 1;
            $ap_settings[ 'plugin_style_type' ] = 'template';
            $ap_settings[ 'form_template' ] = '';
            $ap_settings[ 'form_styles' ] = array( 'label' => array( 'font' => 'Open Sans',
                    'font_size' => '12',
                    'label_color' => '#000',
                ),
                'field' => array( 'color' => '#000',
                    'border_thickness' => '1',
                    'border_color' => '#000',
                ),
                'button' => array( 'font' => 'Open Sans',
                    'font_size' => '12px',
                    'font_color' => '#000',
                    'button_background' => '#FFF',
                ),
                'form' => array( 'width' => '100',
                    'width_type' => 'per',
                    'border' => 'yes',
                    'round_corners' => 'no',
                    'form_background' => 'no',
                    'form_background_type' => 'color',
                    'form_background_color' => '',
                    'background_image' => '',
                    'background_repeat' => 'repeat',
                    'border_color' => '#000',
                    'border_thickness' => '1'
                )
            );

            /**
             * Captcha Settings
             * */
            $ap_settings[ 'captcha_settings' ] = 1;
            $ap_settings[ 'captcha_type' ] = 'human';
            $ap_settings[ 'google_captcha_label' ] = '';
            $ap_settings[ 'google_catpcha_public_key' ] = '';
            $ap_settings[ 'google_catpcha_private_key' ] = '';
            $ap_settings[ 'google_captcha_error_message' ] = '';
            $ap_settings[ 'math_captcha_error_message' ] = '';
            $ap_settings[ 'math_captcha_label' ] = '';
            $ap_settings[ 'google_captcha_error_message' ] = '';
            $ap_settings[ 'math_captcha_error_message' ] = '';
            return $ap_settings;
        }

        function get_ap_settings($form_id) {
            global $wpdb;
            $table_name = $table_name = $wpdb->prefix . "ap_pro_forms";
            $forms = $wpdb->get_results("SELECT * FROM $table_name where ap_form_id = $form_id");
            if ( !empty($forms) ) {
                $form = $forms[ 0 ];
                $ap_settings = $this->get_unserialized($form->form_details);
                return $ap_settings;
            } else {
                return null;
            }
        }

        //form delete function
        function ap_form_delete_action() {
            if ( isset($_GET[ '_wpnonce' ]) && wp_verify_nonce($_GET[ '_wpnonce' ], 'ap-form-delete-nonce') ) {
                if ( $form_id != 1 ) {
                    $form_id = $_GET[ 'form_id' ];
                    global $wpdb;
                    $table_name = $table_name = $wpdb->prefix . "ap_pro_forms";
                    $wpdb->delete($table_name, array( 'ap_form_id' => $form_id ), array( '%d' ));
                    $_SESSION[ 'ap_message' ] = __('Form deleted successfully.', 'anonymous-post-pro');
                } else {
                    $_SESSION[ 'ap_message' ] = __('Default form can\'t be deleted', 'anonymous-post-pro');
                }

                wp_redirect(admin_url() . 'admin.php?page=anonymous-post-pro');
                exit;
            } else {
                die('No script kiddies please!');
            }
        }

        //form delete function
        function ap_form_copy_action() {
            if ( isset($_GET[ '_wpnonce' ]) && wp_verify_nonce($_GET[ '_wpnonce' ], 'ap-form-copy-nonce') ) {
                $form_id = $_GET[ 'form_id' ];
                $ap_settings = $this->get_ap_settings($form_id);
                $ap_settings[ 'form_title' ] = $ap_settings[ 'form_title' ] . '- Copy';
                $ap_settings_serialized = base64_encode(serialize($ap_settings));
                global $wpdb;
                $table_name = $table_name = $wpdb->prefix . "ap_pro_forms";
                $wpdb->insert(
                        $table_name, array(
                    'form_details' => $ap_settings_serialized
                        ), array(
                    '%s'
                        )
                );
                $_SESSION[ 'ap_message' ] = __('Form Copied successfully.', 'anonymous-post-pro');
                wp_redirect(admin_url() . 'admin.php?page=anonymous-post-pro');
                exit;
            } else {
                die('No script kiddies please!');
            }
        }

        function show_custom_fields($content) {
            include('inc/cores/content-filter.php');
            return $content;
        }

        //function to check if url is image or not
        function is_image($image_url) {
            $image_url_array = explode('/', $image_url);
            $image_name = end($image_url_array);
            $image_name_array = explode('.', $image_name);
            $ext = end($image_name_array);
            $image_ext = array( 'jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'PNG', 'gif', 'GIF' );
            if ( in_array($ext, $image_ext) ) {
                return true;
            } else {
                return false;
            }
        }

        function is_base64_encoded($data) {
            if ( base64_encode(base64_decode($data)) === $data ) {
                return true;
            } else {
                return false;
            }
        }

        function get_unserialized($data) {
            if ( $this->is_base64_encoded($data) ) {
                return unserialize(base64_decode($data));
            } else {
                return unserialize($data);
            }
        }

        function extra_settings() {
            include('inc/extra-settings.php');
        }

        /**
         * Extra Settings Action
         */
        function extra_settings_action() {
            if ( !empty($_POST) && wp_verify_nonce($_POST[ 'ap_extra_setting_nonce_field' ], 'ap_extra_setting_nonce') ) {
                $ap_extra_settings = array();
                $ap_extra_settings[ 'lightbox_disable' ] = isset($_POST[ 'lightbox_disable' ]) ? $_POST[ 'lightbox_disable' ] : 0;
                $ap_extra_settings[ 'jquery_ui_disable' ] = isset($_POST[ 'jquery_ui_disable' ]) ? $_POST[ 'jquery_ui_disable' ] : 0;
                update_option('ap_pro_extra_settings', $ap_extra_settings);
                $_SESSION[ 'ap_message' ] = __('Settings updated successfully.', 'anonymous-post-pro');
                wp_redirect('admin.php?page=ap-pro-settings');
                exit();
            } else {
                die('No script kiddies please!!');
            }
        }

        /**
         * File Delete Action
         * */
        function ap_file_delete_action() {
            if ( !empty($_POST) && wp_verify_nonce($_POST[ '_wpnonce' ], 'ap-file-uploader-nonce') ) {
                if ( isset($_POST[ 'attachment_id' ], $_POST[ 'attachment_code' ]) && $_POST[ 'attachment_id' ] != '' && $_POST[ 'attachment_code' ] != '' ) {
                    $attachment_id = intval(sanitize_text_field($_POST[ 'attachment_id' ]));
                    $attachment_code = sanitize_text_field($_POST[ 'attachment_code' ]);
                    $attachment_date = get_the_date("U", $attachment_id);
                    $attachment_check_code = md5($attachment_date);
                    if ( $attachment_check_code == $attachment_code ) {
                        $check = wp_delete_attachment($attachment_id, true);
                    } else {
                        die('Error');
                    }
                }
                if ( $check ) {
                    die('success');
                } else {
                    die('error');
                }
            } else {
                die('No script kiddies please!');
            }
        }

        /**
         * Recaptcha ajax validation
         * */
        function ap_validate_recaptcha() {
            //die('reached');
            //$this->print_array($_POST);die();
            if ( !empty($_POST) && wp_verify_nonce($_POST[ '_wpnonce' ], 'ap-file-uploader-nonce') ) {
                global $wpdb;
                $form_id = str_replace('ap-form-', '', $_POST[ 'form_id' ]);
                $table_name = $table_name = $wpdb->prefix . "ap_pro_forms";
                $forms = $wpdb->get_results("SELECT * FROM $table_name where ap_form_id = $form_id");
                $form = $forms[ 0 ];
                $ap_settings = $this->get_unserialized($form->form_details);
                $captcha_version = isset($ap_settings[ 'google_captcha_version' ]) ? $ap_settings[ 'google_captcha_version' ] : 'v1';
                if ( $captcha_version == 'v1' ) {
                    include_once("inc/cores/recaptchalib.php");
                    $privatekey = $ap_settings[ 'google_catpcha_private_key' ];
                    $resp = recaptcha_check_answer($privatekey, $_SERVER[ "REMOTE_ADDR" ], $_POST[ "recaptcha_challenge_field" ], $_POST[ "recaptcha_response_field" ]);

                    if ( !$resp->is_valid ) {
                        // What happens when the CAPTCHA was entered incorrectly
                        echo "fail";
                    } else {
                        echo "success";
                    }
                } else {
                    //$this->print_array($_POST);die();
                    $captcha = filter_input(INPUT_POST, 'captchaResponse'); // get the captchaResponse parameter sent from our ajax

                    /* Check if captcha is filled */
                    if ( !$captcha ) {
                        echo 'SPAM'; // Return error code if there is no captcha
                    }
                    $secret_key = $ap_settings[ 'google_captcha_secret_key' ];
                    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret_key . "&response=" . $captcha);
                    $response = json_decode($response);
                    if ( $response->success == false ) {
                        echo 'SPAM';
                    } else {
                        echo "success";
                        // Everything is ok and you can proceed by executing your login, signup, update etc scripts
                    }
                }
            } else {
                die('No script kiddies please');
            }
            die();
        }

        function post_instant_published_notification($ID) {


            $author_email = get_post_meta($ID, 'ap_author_email', true);
            $ap_form_id = get_post_meta($ID, 'ap_form_id', true);
            if ( empty($ap_form_id) || empty($author_email) ) {
                return;
            }
            $ap_settings = $this->get_ap_settings($ap_form_id);
            if ( $ap_settings[ 'user_notification' ] == 1 && $ap_settings != null ) {
                $blogname = get_option('blogname');
                $email = get_option('admin_email');
                $post_link = get_permalink($ID);
                $post_title = get_the_title($ID);
                $charset = get_option('blog_charset');
                $from_name = (isset($ap_settings[ 'user_notification_from_name' ]) && $ap_settings[ 'user_notification_from_name' ] != '') ? esc_attr($ap_settings[ 'user_notification_from_name' ]) : $blogname;
                $from_email = (isset($ap_settings[ 'user_notification_from_email' ]) && $ap_settings[ 'user_notification_from_email' ] != '') ? esc_attr($ap_settings[ 'user_notification_from_email' ]) : $email;
                $from_header = "From: $from_name <$from_email>";
                if ( $ap_settings[ 'user_notification_message' ] == '' ) {
                    $message = 'Hello There,<br/><br/>

                                Your post has been published in ' . get_bloginfo('name') . ' website. Please find details below:<br/><br/>

                                Post Title: ' . $post_title . '<br/><br/>

                                _____<br/><br/>

                                To view your post in the site - please go here:<br/>
                                ' . $post_link . '<br/><br/>

                                Thank you';
                } else {
                    $message = str_replace('#post_title', $post_title, $ap_settings[ 'user_notification_message' ]);
                    $message = str_replace('#post_link', $post_link, $message);
                }



                // $headers = "MIME-Version: 1.0\r\n" . "From: " . $blogname . " " . "<" . $email . ">\n" . "Content-Type: text/HTML; charset=\"" . get_option( 'blog_charset' ) . "\"\r\n";
                $headers = array();
                $headers[] = 'Content-Type: text/html; charset=' . $charset;
                $headers[] = $from_header;
                $subject = (isset($ap_settings[ 'user_notification_subject' ]) && $ap_settings[ 'user_notification_subject' ] != '') ? esc_attr($ap_settings[ 'user_notification_subject' ]) : __('Post published', 'anonymous-post-pro');
                if ( is_email($author_email) ) {
                    wp_mail($author_email, $subject, $message, $headers);
                }
            }
        }

        function form_preview() {
            if ( isset($_GET[ 'ap_preview' ], $_GET[ 'form_id' ]) && is_user_logged_in() ) {
                include('inc/cores/form-preview.php');
                die();
            } else {
                return;
            }
        }

        function post_reject_notification($ID) {


            $author_email = get_post_meta($ID, 'ap_author_email', true);
            $ap_form_id = get_post_meta($ID, 'ap_form_id', true);
            if ( empty($ap_form_id) || empty($author_email) ) {
                return;
            }

            $ap_settings = $this->get_ap_settings($ap_form_id);
            if ( $ap_settings[ 'post_reject_notification' ] == 1 && $ap_settings != null ) {
                $blogname = get_option('blogname');
                $email = get_option('admin_email');
                $post_title = get_the_title($ID);
                $charset = get_option('blog_charset');
                $from_name = (isset($ap_settings[ 'post_reject_notification_from_name' ]) && $ap_settings[ 'post_reject_notification_from_name' ] != '') ? esc_attr($ap_settings[ 'post_reject_notification_from_name' ]) : $blogname;
                $from_email = (isset($ap_settings[ 'post_reject_notification_from_email' ]) && $ap_settings[ 'post_reject_notification_from_email' ] != '') ? esc_attr($ap_settings[ 'post_reject_notification_from_email' ]) : $email;
                $from_header = "From: $from_name <$from_email>";
                if ( $ap_settings[ 'post_reject_notification_message' ] == '' ) {
                    $message = 'Hello There,<br/><br/>

                                Your post has been rejected in ' . get_bloginfo('name') . ' website. Please find details below:<br/><br/>

                                Post Title: ' . $post_title . '<br/><br/>

                                Thank you';
                } else {
                    $message = str_replace('#post_title', $post_title, $ap_settings[ 'post_reject_notification_message' ]);
                }



                $headers = array();
                $headers[] = 'Content-Type: text/html; charset=' . $charset;
                $headers[] = $from_header;
                $subject = (isset($ap_settings[ 'post_reject_notification_subject' ]) && $ap_settings[ 'post_reject_notification_subject' ] != '') ? esc_attr($ap_settings[ 'post_reject_notification_subject' ]) : __('Post Rejected', 'anonymous-post-pro');
                if ( is_email($author_email) ) {
                    // $author_email = 'regan@access-keys.com';
                    wp_mail($author_email, $subject, $message, $headers);
                }
            }
        }

        function sort_terms_hierarchicaly(Array &$cats, Array &$into, $parentId = 0) {
            foreach ( $cats as $i => $cat ) {
                if ( $cat->parent == $parentId ) {
                    $into[ $cat->term_id ] = $cat;
                    unset($cats[ $i ]);
                }
            }

            foreach ( $into as $topCat ) {
                $topCat->children = array();
                $this->sort_terms_hierarchicaly($cats, $topCat->children, $topCat->term_id);
            }
        }

        function check_parent($term, $space = '') {
            if ( is_object($term) ) {
                if ( $term->parent != 0 ) {
                    $space .= str_repeat('&nbsp;', 2);
                    $parent_term = get_term_by('id', $term->parent, $term->taxonomy);
                    // var_dump($space);
                    $space .= $this->check_parent($parent_term, $space);
                }
            }

            return $space;
        }

        function print_checkbox($terms, $exclude_terms = array(), $hierarchical = 1, $form = '', $field_title = '') {
            // $this->print_array($terms);

            foreach ( $terms as $term ) {
                if ( !in_array($term->slug, $exclude_terms) ) {
                    $space = $this->check_parent($term);
                    $option_value = ($hierarchical == 0) ? $term->name : $term->term_id;
                    $form .= '<label class="ap-checkbox-label">' . $space . '<input type="checkbox" name="' . $field_title . '[]"  value="' . $option_value . '"/><div class="checkbox-indicator"></div>' . $term->name . '</label>';
                }
                ?>

                <?php
                if ( !empty($term->children) ) {

                    $form .= $this->print_checkbox($term->children, $exclude_terms, $hierarchical, '', $field_title);
                }
            }

            return $form;
        }

        function print_option($terms, $exclude_terms = array(), $hierarchical = 1, $form = '', $field_title = '', $selected_term = '', $taxonomy_print = false) {
            // $this->print_array($terms);

            foreach ( $terms as $term ) {
                if ( !in_array($term->slug, $exclude_terms) ) {
                    $space = $this->check_parent($term);
                    $option_value = ($hierarchical == 0) ? $term->name : $term->term_id;
                    if ( $taxonomy_print ) {
                        $option_value = $option_value . '|' . $term->taxonomy;
                    }
                    if ( is_array($selected_term) ) {
                        $selected = (in_array($option_value, $selected_term)) ? 'selected="selected"' : '';
                    } else {

                        $selected = ($selected_term == $option_value) ? 'selected="selected"' : '';
                    }
                    /*  var_dump($selected_term);
                      var_dump($option_value);
                      var_dump($selected);
                     *
                     */
                    $form .= '<option value="' . $option_value . '" ' . $selected . '>' . $space . $term->name . '</option>';
                }
                ?>

                <?php
                if ( !empty($term->children) ) {

                    $form .= $this->print_option($term->children, $exclude_terms, $hierarchical, '', $field_title, $selected_term, $taxonomy_print);
                }
            }

            return $form;
        }

    }

    //class termination

    $ap_obj = new AP_Pro_Class();
}//class exist check close
