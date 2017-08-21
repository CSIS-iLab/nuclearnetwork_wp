<?php

//$this->print_array($_POST);
defined('ABSPATH') or die("No script kiddies please!");
global $error;
global $wpdb;
$form_id = intval($_POST[ 'ap_form_id' ]);

$ap_settings = $this->get_ap_settings($form_id);

$ap_form_post_title = isset($_POST[ 'ap_form_post_title' ]) ? sanitize_text_field($_POST[ 'ap_form_post_title' ]) : '';
if ( isset($_POST[ 'ap_form_post_content' ]) ) {
    $ap_form_content = wp_kses_post($_POST[ 'ap_form_post_content' ]);
} else {
    if ( $ap_form_post_title == '' ) {
        $ap_form_content = '&nbsp;';
    } else {
        $ap_form_content = '';
    }
}

$error = new stdClass();
$error_flag = 0;
$error->form_id = $form_id;

//if captcha is disabled or captcha has been entered correctly
if ( $error_flag == 0 ) {

    if ( in_array('post_image', $_POST[ 'form_included_fields' ]) ) {//if post image is enabled in form
        if ( $_FILES[ 'ap_form_post_image' ][ 'name' ] != '' ) {//if user has uploaded the files
            $image_name = $_FILES[ 'ap_form_post_image' ][ 'name' ];
            $image_name_array = explode('.', $image_name);
            $ext = end($image_name_array);
            if ( !($ext == 'jpeg' || $ext == 'png' || $ext == 'jpg' || $ext == 'gif' || $ext = 'JPEG' || $ext == 'JPG' || $ext == 'PNG' || $ext == 'GIF') ) {//if users upload invalid file type
                $error->image = __('Invalid File Type', 'anonymous-post-pro');
                $error_flag = 1;
            }
        }
    }
    if ( $error_flag == 0 ) {

        //uploading image to media
        if ( in_array('post_image', $_POST[ 'form_included_fields' ]) && $_FILES[ 'ap_form_post_image' ][ 'name' ] != '' ) {
            if ( !function_exists('wp_handle_upload') )
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
            $uploadedfile = $_FILES[ 'ap_form_post_image' ];
            $upload_overrides = array( 'test_form' => false );
            $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
            //$this->print_array($movefile);
            if ( $movefile ) {
                include_once( ABSPATH . 'wp-admin/includes/image.php' );
                $wp_filetype = $movefile[ 'type' ];
                $filename = $movefile[ 'file' ];
                $wp_upload_dir = wp_upload_dir();
                $attachment = array(
                    'guid' => $wp_upload_dir[ 'url' ] . '/' . basename($filename),
                    'post_mime_type' => $wp_filetype,
                    'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                $attach_id = wp_insert_attachment($attachment, $filename);
                $attach_data = wp_generate_attachment_metadata($attach_id, $movefile[ 'file' ]);
                wp_update_attachment_metadata($attach_id, $attach_data);
            }
        } else if ( isset($_POST[ 'post_image' ]) && $_POST[ 'post_image' ] != '' && is_numeric($_POST[ 'post_image' ]) ) {
            $attach_id = intval($_POST[ 'post_image' ]);
        }
        // var_dump($attach_id);
        //  die();
        $post_type = esc_attr($ap_settings[ 'post_type' ]);
        $publish_status = esc_attr($ap_settings[ 'publish_status' ]);
        if ( $ap_settings[ 'login_check' ] == 1 ) {
            $author = get_current_user_id();
        } else {
            if ( isset($ap_settings[ 'logged_user_author' ]) && $ap_settings[ 'logged_user_author' ] == 1 && is_user_logged_in() ) {
                $author = get_current_user_id();
            } else {
                $author = esc_attr($ap_settings[ 'post_author' ]);
            }
        }
        $post_arguments = array( 'post_type' => $post_type,
            'post_title' => $ap_form_post_title,
            'post_content' => $ap_form_content,
            'post_status' => $publish_status,
            'post_author' => $author
        );
        if ( isset($_POST[ 'ap_form_post_excerpt' ]) ) {
            $post_arguments[ 'post_excerpt' ] = sanitize_text_field($_POST[ 'ap_form_post_excerpt' ]);
        }
        $post_id = wp_insert_post($post_arguments);

        /**
         * Remove explicit uncategorized category assignment
         * */
        wp_remove_object_terms($post_id, 1, 'category');

        /**
         * WPML Compatibility
         */
        if ( $post_id && isset($ap_settings[ 'language_code' ]) ) {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            if ( is_plugin_active('sitepress-multilingual-cms/sitepress.php') ) {
                global $sitepress;
                $check = $sitepress->set_element_language_details($post_id, 'post_' . $post_type, $post_id, $ap_settings[ 'language_code' ]);
                // var_dump($check);die();
            }
        }
        if ( $post_id && isset($attach_id) ) {
            add_post_meta($post_id, '_thumbnail_id', $attach_id, true); //adding featured image to post
        }

        if ( isset($_POST[ 'form_included_taxonomy' ]) && !empty($_POST[ 'form_included_taxonomy' ]) && $post_id ) {
            foreach ( $_POST[ 'form_included_taxonomy' ] as $taxonomy ) {
                $taxonomy_field_type = (isset($ap_settings[ 'form_fields' ][ $taxonomy ][ 'taxonomy_field_type' ])) ? $ap_settings[ 'form_fields' ][ $taxonomy ][ 'taxonomy_field_type' ] : 'textfield';
                $taxonomy_field_type = ($ap_settings[ 'form_fields' ][ $taxonomy ][ 'hierarchical' ] == 1) ? 'dropdown' : $taxonomy_field_type;
                if ( $taxonomy_field_type == 'dropdown' ) {
                    $term_ids = (is_array($_POST[ $taxonomy ])) ? array_map('sanitize_text_field', $_POST[ $taxonomy ]) : array( sanitize_text_field($_POST[ $taxonomy ]) );
                    if ( !empty($term_ids) ) {
                        wp_set_post_terms($post_id, $term_ids, $taxonomy);
                    }
                } else {

                    $tags = (is_array($_POST[ $taxonomy ])) ? array_map('sanitize_text_field', $_POST[ $taxonomy ]) : sanitize_text_field($_POST[ $taxonomy ]);
                    if ( !empty($tags) ) {
                        wp_set_post_terms($post_id, $tags, $taxonomy);
                    }
                }
            }
        }
        // var_dump($ap_settings[ 'post_category' ]);
        //    die();
        //if none of the taxonomies are included on the form and still admin wants to assign to specific taxonomy
        if ( !empty($ap_settings[ 'post_category' ]) ) {

            $post_categories = $ap_settings[ 'post_category' ];
            if ( !is_array($post_categories) ) {
                $post_categories = array( $post_categories );
            }
            foreach ( $post_categories as $post_category ) {
                $post_category_array = explode('|', $post_category);
                $post_category_id = $post_category_array[ 0 ];
                $post_taxonomy = $post_category_array[ 1 ];
                wp_set_post_terms($post_id, array( $post_category_id ), $post_taxonomy, true);
            }
        }

        if ( $post_id ) {
            if ( is_user_logged_in() ) {
                $current_user = wp_get_current_user();
                $loggedin_author_name = isset($current_user->user_firstname) ? $current_user->user_firstname : '';
                $loggedin_author_email = isset($current_user->user_email) ? $current_user->user_email : '';
                $loggedin_author_url = isset($current_user->user_url) ? $current_user->user_url : '';
            }
            //Post format from version 3.0.0
            if ( isset($ap_settings[ 'post_format' ]) && $ap_settings[ 'post_format' ] != 'none' ) {
                set_post_format($post_id, $ap_settings[ 'post_format' ]);
            }
            //adding author name as post meta field
            if ( in_array('author_name', $_POST[ 'form_included_fields' ]) && $_POST[ 'ap_form_author_name' ] != '' ) {
                $author_name = sanitize_text_field($_POST[ 'ap_form_author_name' ]);
                add_post_meta($post_id, 'ap_author_name', $author_name, false);
            } else {
                if ( is_user_logged_in() ) {
                    add_post_meta($post_id, 'ap_author_name', $loggedin_author_name, false);
                }
            }

            if ( in_array('author_url', $_POST[ 'form_included_fields' ]) && $_POST[ 'ap_form_author_url' ] != '' ) {
                $author_url = sanitize_text_field($_POST[ 'ap_form_author_url' ]);
                add_post_meta($post_id, 'ap_author_url', $author_url, false);
            } else {
                if ( is_user_logged_in() ) {
                    add_post_meta($post_id, 'ap_author_url', $loggedin_author_url, false);
                }
            }
            if ( in_array('author_email', $_POST[ 'form_included_fields' ]) && $_POST[ 'ap_form_author_email' ] != '' ) {
                $author_email = sanitize_email($_POST[ 'ap_form_author_email' ]);
                add_post_meta($post_id, 'ap_author_email', $author_email, false);
            } else {
                if ( is_user_logged_in() ) {
                    add_post_meta($post_id, 'ap_author_email', $loggedin_author_email, false);
                }
            }
            if ( isset($_POST[ 'form_custom_fields' ]) && !empty($_POST[ 'form_custom_fields' ]) ) {
                foreach ( $_POST[ 'form_custom_fields' ] as $key ) {
                    $meta_key = sanitize_text_field($key);
                    if ( is_array($_POST[ $key ]) ) {
                        $value = implode(',', $_POST[ $key ]);
                    } else {
                        $value = sanitize_text_field($_POST[ $key ]);
                    }

                    if ( $value != '' ) {
                        add_post_meta($post_id, $meta_key, $value, false);
                    }
                }
            }
            add_post_meta($post_id, 'ap_form_id', $form_id, false);

            /**
             * Post Attachment Functionality
             */
            if ( isset($_POST[ 'ap_attachment_ids' ]) ) {
                $attachment_ids = trim(sanitize_text_field($_POST[ 'ap_attachment_ids' ]));
                if ( $attachment_ids != '' ) {
                    $attachment_ids_array = explode(',', $attachment_ids);
                    foreach ( $attachment_ids_array as $attachment_id ) {
                        $attachment = get_post($attachment_id);
                        if ( $attachment ) {
                            $fullsize_path = get_attached_file($attachment_id); // Full path
                            $check = wp_insert_attachment($attachment, $fullsize_path, $post_id);
                        }
                    }
                }
            }

            $this->send_admin_notification($post_id, $ap_form_post_title, $form_id);

            if ( $publish_status == 'publish' ) {
                $this->post_instant_published_notification($post_id);
            }
            $success = new stdClass();
            $success->msg = ($ap_settings[ 'post_submission_message' ] == '') ? __('Hi there, Thank you for submitting a post.', 'anonymous-post-pro') : wp_kses_post($ap_settings[ 'post_submission_message' ]);
            $_SESSION[ 'ap_form_success_msg' ] = $success->msg;
            $_SESSION[ 'ap_form_id' ] = $form_id;
            $redirect_url = esc_url($_POST[ 'redirect_url' ]);
            $redirect_type = isset($ap_settings[ 'redirect_type' ]) ? $ap_settings[ 'redirect_type' ] : 'url';
            //  die();
            if ( $redirect_type == 'url' ) {
                wp_redirect($_POST[ 'redirect_url' ]);
            } else {
                if ( $publish_status == 'publish' ) {

                    $post_url = get_permalink($post_id);
                    if ( $post_url != '' ) {
                        wp_redirect($post_url);
                    } else {
                        wp_redirect($redirect_url);
                    }
                } else {
                    wp_redirect($redirect_url);
                }
            }

            exit;
        }
    }//if close
}