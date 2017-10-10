<?php

global $error;
if ( $ap_settings[ 'plugin_style_type' ] == 'template' ) {
    $font1 = str_replace(' ', '+', $ap_settings[ 'form_styles' ][ 'label' ][ 'font' ]);
    $font2 = str_replace(' ', '+', $ap_settings[ 'form_styles' ][ 'button' ][ 'font' ]);
    $form = '<link href=\'//fonts.googleapis.com/css?family=Roboto+Condensed:400,700|Roboto:400,700|Open+Sans:400,700\' rel=\'stylesheet\' type=\'text/css\'/>';
    $form .= "<link href='//fonts.googleapis.com/css?family=$font1:400,700|$font2:400,700' rel='stylesheet' type='text/css'/>";
} else {
    $form = '';
}
//$this->print_array($ap_settings);

$file_upload_counter = isset($_SESSION[ 'file_uploader_counter' ]) ? $_SESSION[ 'file_uploader_counter' ] : 0;
$each_upload_counter = 0;

$form_title = ($ap_settings[ 'form_title' ] == '') ? 'Anonymous Post' : $ap_settings[ 'form_title' ];
$form .= '<div class="ap-pro-front-form-wrapper">';
$form .= '<h2 class="ap-pro-front-form-title">' . $form_title . '</h2>';
if ( isset($_SESSION[ 'ap_form_success_msg' ], $_SESSION[ 'ap_form_id' ]) && $ap_settings[ 'redirect_url' ] == '' && $_SESSION[ 'ap_form_id' ] == $form_id ) {
    $success_msg = $_SESSION[ 'ap_form_success_msg' ];
    unset($_SESSION[ 'ap_form_success_msg' ]);
    unset($_SESSION[ 'ap_form_id' ]);
    $form .= '<div class="ap-pro-form-success-msg">' . $success_msg . '</div>';
}
$auto_author_details = isset($ap_settings[ 'auto_author_details' ]) ? esc_attr($ap_settings[ 'auto_author_details' ]) : 0;
if ( is_user_logged_in() && $auto_author_details == 1 ) {
    $current_user = wp_get_current_user();
    $author_name = (isset($current_user->data->user_login)) ? $current_user->data->user_login : '';
    $author_email = (isset($current_user->data->user_email)) ? $current_user->data->user_email : '';
    $author_url = (isset($current_user->data->user_url)) ? $current_user->data->user_url : '';
} else {
    $author_name = '';
    $author_email = '';
    $author_url = '';
}
// var_dump($current_user);
//check_form_submittable()
$form .= '<form method="post" action="" enctype="multipart/form-data" class="ap-pro-front-form" onsubmit="return check_form_submittable(\'ap-form-' . $form_id . '\');" id="ap-form-' . $form_id . '">';
foreach ( $ap_settings[ 'form_fields' ] as $field_title => $field_array ) {
    if ( $field_array[ 'show_form' ] == 1 ):
        if ( isset($field_array[ 'option' ]) ) {
            $options = $field_array[ 'option' ];
            $values = $field_array[ 'value' ];
            $checked_option = isset($field_array[ 'checked_option' ]) ? $field_array[ 'checked_option' ] : array();
        }
        if ( !isset($field_array[ 'file_extension' ]) ) {
            $field_array = array_map('esc_attr', $field_array);
        }

        switch ( $field_array[ 'field_type' ] ) {
            case 'field':
                switch ( $field_title ) {
                    /**
                     * Post Title
                     * */
                    case 'post_title':
                        $post_title_label = ($field_array[ 'label' ] == '') ? __('Post Title', 'anonymous-post-pro') : $field_array[ 'label' ];
                        $form .= '<div class="ap-pro-form-field-wrapper">';
                        $form .= '<div class="label-wrap"><label for="ap_form_post_title">' . $post_title_label . '</label>';
                        if ( $field_array[ 'notes_type' ] == 'icon' && $field_array[ 'notes' ] != '' ) {
                            $form .= '<div class="ap-pro-info-wrap"><span class="ap-pro-info-notes-icon">i</span><div class="ap-pro-info-notes">' . $field_array[ 'notes' ] . '</div></div>';
                        }
                        $required_message = ($field_array[ 'required_message' ] == '') ? __('This field is required.', 'anonymous-post-pro') : $field_array[ 'required_message' ];
                        $form .= '</div><div class="ap-pro-form-field">
                   <input type="text" id="ap_form_post_title" name="ap_form_post_title" data-required-msg="' . $field_array[ 'required_message' ] . '" class="ap-pro-textfield ap-required-field""/>
                   <input type="hidden" name="form_included_fields[]" value="post_title"/>';
                        if ( $field_array[ 'notes_type' ] == 'tooltip' && $field_array[ 'notes' ] != '' ) {
                            $form .= '<span class="ap-pro-tooltip-notes">' . $field_array[ 'notes' ] . '</span>';
                        }
                        $error_title = (isset($error->title) && $error->form_id == $form_id) ? $error->title : '';
                        $form .= '</div><!--ap-pro-form-field-->
                 <div class="ap-form-error">' . $error_title . '</div>';
                        $form .= '</div><!--ap-pro-form-field-wrapper-->';
                        break;

                    /**
                     * Post Content
                     * */
                    case 'post_content':
                        $post_content_label = ($field_array[ 'label' ] == '') ? __('Post Content', 'anonymous-post-pro') : $field_array[ 'label' ];
                        $form .= '<div class="ap-pro-form-field-wrapper">';
                        $form .= '<div class="label-wrap"><label for="ap_form_post_content">' . $post_content_label . '</label>';
                        if ( $field_array[ 'notes_type' ] == 'icon' && $field_array[ 'notes' ] != '' ) {
                            $form .= '<div class="ap-pro-info-wrap"><span class="ap-pro-info-notes-icon">i</span><div class="ap-pro-info-notes">' . $field_array[ 'notes' ] . '</div></div>';
                        }



                        if ( $field_array[ 'editor_type' ] == 'simple' ) {
                            $wp_editor = '<textarea id="ap_form_post_content" name="ap_form_post_content" rows="5" class="ap-simple-textarea ap-form-content-editor"></textarea>';
                        } else {
                            $editor_size = (isset($field_array[ 'editor_size' ]) && $field_array[ 'editor_size' ] != '') ? $field_array[ 'editor_size' ] : 10;
                            $media_upload_flag = (isset($ap_settings[ 'media_upload' ]) && $ap_settings[ 'media_upload' ] == 1) ? true : false;
                            $wp_editor = $this->get_wp_editor_html($field_array[ 'editor_type' ], $media_upload_flag, $form_id, $editor_size);
                        }
                        $required = (isset($field_array[ 'required' ]) && $field_array[ 'required' ] == 1) ? 'required' : '';
                        $required_message = ($field_array[ 'required_message' ] == '') ? __('This field is required.', 'anonymous-post-pro') : $field_array[ 'required_message' ];
                        $form .= '</div><div class="ap-pro-form-field">';
                        if ( (!is_user_logged_in() || !current_user_can('upload_files') || (is_user_logged_in() && $ap_settings[ 'media_upload' ] == 0)) && $ap_settings[ 'anonymous_image_upload' ] == 1 && ($field_array[ 'editor_type' ] == 'rich' || $field_array[ 'editor_type' ] == 'visual') ) {
                            $content_uploader_id = 'ap-content-file-uploader-' . $form_id;
                            $link_source_url = (isset($ap_settings[ 'link_source_url' ]) && $ap_settings[ 'link_source_url' ] == 1) ? 1 : 0;
                            $lightbox_rel_attr = (isset($ap_settings[ 'lightbox_rel_attr' ]) && $ap_settings[ 'lightbox_rel_attr' ] == 1) ? 1 : 0;
                            $max_upload_size = (isset($ap_settings[ 'ap_image_max_upload_size' ]) && $ap_settings[ 'ap_image_max_upload_size' ] != '') ? $ap_settings[ 'ap_image_max_upload_size' ] * 1000000 : 2000000;
                            $form .= '<div class="ap-content-file-uploader" data-upload-size="' . $max_upload_size . '" id="' . $content_uploader_id . '" data-link-source-url="' . $link_source_url . '" data-lightbox-rel-attr="' . $lightbox_rel_attr . '"></div>';
                        }

                        $form .= $wp_editor . '
                   <input type="hidden" name="form_included_fields[]" value="post_content"/>';
                        if ( isset($field_array[ 'character_limit' ]) && $field_array[ 'character_limit' ] != '' && ($field_array[ 'editor_type' ] == 'rich' || $field_array[ 'editor_type' ] == 'visual') ) {
                            $character_limit_message = isset($field_array[ 'character_limit_message' ]) ? $field_array[ 'character_limit_message' ] : __('Only ' . $field_array[ 'character_limit' ] . ' characters allowed', 'anonymous-post-pro');
                            $form .= '<input type="hidden" class="ap-pro-character-limit" value="' . $field_array[ 'character_limit' ] . '"/>';
                            $form .= '<input type="hidden" class="ap-pro-character-limit-message" value="' . $character_limit_message . '"/>';
                            $form .= '<input type="hidden" class="ap-character-limit-flag" value="0"/>';
                        }
                        if ( $field_array[ 'notes_type' ] == 'tooltip' && $field_array[ 'notes' ] != '' ) {
                            $form .= '<span class="ap-pro-tooltip-notes">' . $field_array[ 'notes' ] . '</span>';
                        }
                        $error_content = (isset($error->content) && $error->form_id == $form_id) ? $error->content : '';
                        $form .= '</div><!--ap-pro-form-field-->
                 <div class="ap-form-error ap-form-content-error" data-required-msg="' . $field_array[ 'required_message' ] . '" data-required="' . $required . '">' . $error_content . '</div>';
                        $form .= '</div><!--ap-pro-form-field-wrapper-->';
                        break;

                    /**
                     * Post Image
                     * */
                    case 'post_image':
                        $post_image_label = ($field_array[ 'label' ] == '') ? __('Post Image', 'anonymous-post-pro') : $field_array[ 'label' ];
                        $form .= '<div class="ap-pro-form-field-wrapper">';
                        $form .= '<div class="label-wrap"><label>' . $post_image_label . '</label>';
                        if ( $field_array[ 'notes_type' ] == 'icon' && $field_array[ 'notes' ] != '' ) {
                            $form .= '<div class="ap-pro-info-wrap"><span class="ap-pro-info-notes-icon">i</span><div class="ap-pro-info-notes">' . $field_array[ 'notes' ] . '</div></div>';
                        }
                        $required = ($field_array[ 'required' ] == '1') ? ' ap-required-field' : '';
                        $required_message = ($field_array[ 'required_message' ] == '') ? __('This field is required.', 'anonymous-post-pro') : $field_array[ 'required_message' ];
                        $form .= '</div><div class="ap-pro-form-field">';

                        if ( isset($field_array[ 'advance_uploader' ]) ) {
                            $file_upload_counter++;
                            $each_upload_counter++;
                            $upload_size = ($field_array[ 'upload_size' ] == '') ? 8 * 1000000 : $field_array[ 'upload_size' ] * 1000000;
                            $file_types = 'gif|jpeg|png|jpg';

                            $multiple_upload = false;
                            $upload_limit = -1;
                            $upload_limit_message = '';
                            $uploader_label = (isset($field_array[ 'button_label' ]) && $field_array[ 'button_label' ] != '') ? $field_array[ 'button_label' ] : 'Upload a file';
                            $media_attachment = isset($field_array[ 'attach_media' ]) ? 1 : 0;
                            $custom_folder = isset($field_array[ 'custom_folder' ]) ? esc_attr($field_array[ 'custom_folder' ]) : '';
                            $form .= '<div class="ap-file-uploader ap-post-image-uploader" id="ap-file-uploader-' . $file_upload_counter . '" data-extensions="' . $file_types . '" data-size="' . $upload_size . '" data-multiple="' . $multiple_upload . '" data-upload-limit="' . $upload_limit . '" data-uploader-label="' . $uploader_label . '" data-upload-limit-message="' . $upload_limit_message . '" data-media-attachment="' . $media_attachment . '" data-cf="' . $custom_folder . '">
                     </div>
                          ';
                            $form .= '<div class="ap-pro-file-preview" id="ap-pro-file-preview' . $file_upload_counter . '"></div><input type="hidden" name="post_image" id="ap-pro-file-url-' . $file_upload_counter . '" class="ap-pro-file-url ' . $required . '" data-required-msg="' . $required_message . '" /><input type="hidden" class="ap-pro-upload-counter" value="0" id="ap-pro-upload-counter-' . $file_upload_counter . '"/><div class="ap-upload-limit-error" style="color:red" id="ap-upload-limit-error-' . $file_upload_counter . '"></div>';
                        } else {
                            $form .= '<input type="file" name="ap_form_post_image" data-required-msg="' . $field_array[ 'required_message' ] . '" class="ap-pro-filefield' . $required . '"/>
                   <input type="hidden" name="form_included_fields[]" value="post_image"/>';
                        }
                        if ( $field_array[ 'notes_type' ] == 'tooltip' && $field_array[ 'notes' ] != '' ) {
                            $form .= '<span class="ap-pro-tooltip-notes">' . $field_array[ 'notes' ] . '</span>';
                        }
                        $error_image = isset($error->image) ? $error->image : '';
                        $form .= '</div><!--ap-pro-form-field-->
                 <div class="ap-form-error">' . $error_image . '</div>';
                        $form .= '</div><!--ap-pro-form-field-wrapper-->';
                        break;

                    /**
                     * Post Excerpt
                     * */
                    case 'post_excerpt':
                        $post_excerpt_label = ($field_array[ 'label' ] == '') ? __('Post Excerpt', 'anonymous-post-pro') : $field_array[ 'label' ];
                        $form .= '<div class="ap-pro-form-field-wrapper">';
                        $form .= '<div class="label-wrap"><label>' . $post_excerpt_label . '</label>';
                        if ( $field_array[ 'notes_type' ] == 'icon' && $field_array[ 'notes' ] != '' ) {
                            $form .= '<div class="ap-pro-info-wrap"><span class="ap-pro-info-notes-icon">i</span><div class="ap-pro-info-notes">' . $field_array[ 'notes' ] . '</div></div>';
                        }
                        $required = ($field_array[ 'required' ] == '1') ? ' ap-required-field' : '';
                        $required_message = ($field_array[ 'required_message' ] == '') ? __('This field is required.', 'anonymous-post-pro') : $field_array[ 'required_message' ];
                        $form .= '</div><div class="ap-pro-form-field">
                   <textarea name="ap_form_post_excerpt" data-required-msg="' . $field_array[ 'required_message' ] . '" class="ap-pro-textarea' . $required . '"></textarea>
                   <input type="hidden" name="form_included_fields[]" value="post_excerpt"/>';
                        if ( $field_array[ 'notes_type' ] == 'tooltip' && $field_array[ 'notes' ] != '' ) {
                            $form .= '<span class="ap-pro-tooltip-notes">' . $field_array[ 'notes' ] . '</span>';
                        }
                        $form .= '</div><!--ap-pro-form-field-->
                 <div class="ap-form-error"></div>';
                        $form .= '</div><!--ap-pro-form-field-wrapper-->';
                        break;

                    /**
                     * Author Name
                     * */
                    default:
                        if ( $field_title == 'author_name' ) {
                            $author_label = ($field_array[ 'label' ] == '') ? __('Author Name', 'anonymous-post-pro') : $field_array[ 'label' ];
                            $author_auto_fill_value = $author_name;
                        }
                        if ( $field_title == 'author_url' ) {
                            $author_label = ($field_array[ 'label' ] == '') ? __('Author URL', 'anonymous-post-pro') : $field_array[ 'label' ];
                            $author_auto_fill_value = $author_url;
                        }
                        if ( $field_title == 'author_email' ) {
                            $author_label = ($field_array[ 'label' ] == '') ? __('Author Email', 'anonymous-post-pro') : $field_array[ 'label' ];
                            $author_auto_fill_value = $author_email;
                        }

                        $form .= '<div class="ap-pro-form-field-wrapper ' . $field_title . '">';
                        $form .= '<div class="label-wrap"><label for="ap_form_' . $field_title . '">' . $author_label . '</label>';
                        if ( $field_array[ 'notes_type' ] == 'icon' && $field_array[ 'notes' ] != '' ) {
                            $form .= '<div class="ap-pro-info-wrap"><span class="ap-pro-info-notes-icon">i</span><div class="ap-pro-info-notes">' . $field_array[ 'notes' ] . '</div></div>';
                        }
                        $required = ($field_array[ 'required' ] == '1') ? ' ap-required-field' : '';
                        $required = ($field_title == 'author_email') ? $required . ' ap-email-field' : $required;
                        $required_message = ($field_array[ 'required_message' ] == '') ? __('This field is required.', 'anonymous-post-pro') : $field_array[ 'required_message' ];
                        $form .= '</div><div class="ap-pro-form-field">
                   <input type="text" id="ap_form_' . $field_title . '" name="ap_form_' . $field_title . '" data-required-msg="' . $field_array[ 'required_message' ] . '" class="ap-pro-textfield' . $required . '" value="' . $author_auto_fill_value . '"/>
                   <input type="hidden" name="form_included_fields[]" value="' . $field_title . '"/>';
                        if ( $field_array[ 'notes_type' ] == 'tooltip' && $field_array[ 'notes' ] != '' ) {
                            $form .= '<span class="ap-pro-tooltip-notes">' . $field_array[ 'notes' ] . '</span>';
                        }
                        $form .= '</div><!--ap-pro-form-field-->
                 <div class="ap-form-error"></div>';
                        $form .= '</div><!--ap-pro-form-field-wrapper-->';
                }//secondary switch close
                break;

            /**
             * Taxonomy Fields
             * */
            case 'taxonomy':
                $taxonomy_label = ($field_array[ 'label' ] == '') ? $field_label[ 'taxonomy_label' ] : $field_array[ 'label' ];
                $form .= '<div class="ap-pro-form-field-wrapper ' . $field_title . '">';
                $form .= '<div class="label-wrap"><label for="' . $field_title . '">' . $taxonomy_label . '</label>';
                if ( $field_array[ 'notes_type' ] == 'icon' && $field_array[ 'notes' ] != '' ) {
                    $form .= '<div class="ap-pro-info-wrap"><span class="ap-pro-info-notes-icon">i</span><div class="ap-pro-info-notes">' . $field_array[ 'notes' ] . '</div></div>';
                }
                $required = ($field_array[ 'required' ] == '1') ? ' ap-required-field' : '';
                $required_message = ($field_array[ 'required_message' ] == '') ? __('This field is required.', 'anonymous-post-pro') : $field_array[ 'required_message' ];
                $form .= '</div><div class="ap-pro-form-field">';
                $taxonomy_field_type = (isset($field_array[ 'taxonomy_field_type' ])) ? $field_array[ 'taxonomy_field_type' ] : 'dropdown';
                if ( $field_array[ 'hierarchical' ] == 0 && $taxonomy_field_type == 'textfield' ) {
                    $autocomplete = (isset($field_array[ 'auto_complete' ]) && $field_array[ 'auto_complete' ] == 1) ? 'ap-autocomplete' : '';
                    if ( $autocomplete == 'ap-autocomplete' ) {
                        $terms = get_terms($field_title, array( 'hide_empty' => 0 ));
                        $terms_exclude = isset($field_array[ 'exclude_terms' ]) ? explode(',', $field_array[ 'exclude_terms' ]) : array();
                        $auto_complete_tags = array();
                        if ( count($terms) > 0 ) {
                            foreach ( $terms as $term ) {
                                if ( !in_array($term->slug, $terms_exclude) ) {

                                    $auto_complete_tags[] = $term->name;
                                }
                            }
                        }
                        $auto_complete_tags = implode(',', $auto_complete_tags);
                    } else {
                        $auto_complete_tags = '';
                    }
                    $form .= '<input type="text" name="' . $field_title . '" data-required-msg="' . $field_array[ 'required_message' ] . '" class="ap-pro-textfield' . $required . ' ' . $autocomplete . '" data-autocomplete-terms="' . $auto_complete_tags . '"/>';
                } else if ( $taxonomy_field_type == 'checkbox' ) {

                    $child_of = isset($field_array[ 'parent_term' ]) ? esc_attr($field_array[ 'parent_term' ]) : 0;
                    $terms = get_terms($field_title, array( 'hide_empty' => 0, 'child_of' => $child_of ));
                    $categoryHierarchy = array();
                    $this->sort_terms_hierarchicaly($terms, $categoryHierarchy, $child_of);
                    $terms_exclude = isset($field_array[ 'exclude_terms' ]) ? explode(',', $field_array[ 'exclude_terms' ]) : array();
                    $form .= '<div class="ap-checkbox-wrap ' . $required . '" data-required-msg="' . $required_message . '">';
                    $option_count = 0;
                    if ( count($categoryHierarchy) > 0 ) {
                        $form .= $this->print_checkbox($categoryHierarchy, $terms_exclude, $field_array[ 'hierarchical' ], '', $field_title);
                        /*
                          foreach ( $terms as $term ) {
                          if ( !in_array($term->slug, $terms_exclude) ) {

                          $option_value = ($field_array[ 'hierarchical' ] == 0) ? $term->name : $term->term_id;
                          $form .= '<label class="ap-checkbox-label"><input type="checkbox" name="' . $field_title . '[]"  value="' . $option_value . '"/>' . $term->name . '</label>';
                          }
                          }
                         * /
                         */
                    }
                    $form .= '</div>';
                } else {
                    $taxonomy_field_title = (isset($field_array[ 'multiple_select' ]) && $field_array[ 'multiple_select' ] == 1) ? $field_title . '[]' : $field_title;
                    $multiple = (isset($field_array[ 'multiple_select' ]) && $field_array[ 'multiple_select' ] == 1) ? 'multiple' : '';
                    $multiple_class = (isset($field_array[ 'multiple_select' ]) && $field_array[ 'multiple_select' ] == 1) ? 'ap-multiple-select' : '';
                    $first_opt_label = (isset($field_array[ 'first_option_label' ]) && $field_array[ 'first_option_label' ] != '') ? $field_array[ 'first_option_label' ] : __('Choose', 'anonymous-post-pro') . ' ' . $field_array[ 'taxonomy_label' ];
                    $form .= '<select name=' . $taxonomy_field_title . ' class="ap-pro-select ' . $multiple_class . $required . '" data-required-msg="' . $field_array[ 'required_message' ] . '" ' . $multiple . '>
                     <option value="">' . $first_opt_label . '</option>';
                    $child_of = isset($field_array[ 'parent_term' ]) ? esc_attr($field_array[ 'parent_term' ]) : 0;
                    $terms = get_terms($field_title, array( 'hide_empty' => 0, 'child_of' => $child_of ));
                    $categoryHierarchy = array();
                    $this->sort_terms_hierarchicaly($terms, $categoryHierarchy, $child_of);
                    $terms_exclude = isset($field_array[ 'exclude_terms' ]) ? explode(',', $field_array[ 'exclude_terms' ]) : array();

                    if ( count($categoryHierarchy) > 0 ) {
                        $form .= $this->print_option($categoryHierarchy, $terms_exclude, $field_array[ 'hierarchical' ], '', $field_title);
                        /*
                          foreach ( $terms as $term ) {
                          if ( !in_array($term->slug, $terms_exclude) ) {
                          $option_value = ($field_array[ 'hierarchical' ] == 0) ? $term->name : $term->term_id;
                          $form .= '<option value="' . $option_value . '">' . $term->name . '</option>';
                          }
                          }
                         * /
                         */
                    }
                    $form .= '</select>';
                }

                $form .= '<input type="hidden" name="form_included_fields[]" value="' . $field_title . '"/>
                <input type="hidden" name="form_included_taxonomy[]" value="' . $field_title . '"/>';
                if ( $field_array[ 'notes_type' ] == 'tooltip' && $field_array[ 'notes' ] != '' ) {
                    $form .= '<span class="ap-pro-tooltip-notes">' . $field_array[ 'notes' ] . '</span>';
                }
                $form .= '</div><!--ap-pro-form-field-->
                 <div class="ap-form-error"></div>';
                $form .= '</div><!--ap-pro-form-field-wrapper-->';
                break;

            /**
             * Custom Fields
             * */
            case 'custom':
                $custom_label = ($field_array[ 'label' ] == '') ? $field_array[ 'custom_label' ] : $field_array[ 'label' ];
                $field_class = isset($field_array[ 'field_class' ]) ? $field_array[ 'field_class' ] : '';
                $form .= '<div class="ap-pro-form-field-wrapper ' . $field_class . $field_title . '">';
                $form .= '<div class="label-wrap"><label for="' . $field_title . '">' . $custom_label . '</label>';
                if ( $field_array[ 'notes_type' ] == 'icon' && $field_array[ 'notes' ] != '' ) {
                    $form .= '<div class="ap-pro-info-wrap"><span class="ap-pro-info-notes-icon">i</span><div class="ap-pro-info-notes">' . $field_array[ 'notes' ] . '</div></div>';
                }
                $required = ($field_array[ 'required' ] == '1') ? ' ap-required-field' : '';
                $required_message = ($field_array[ 'required_message' ] == '') ? __('This field is required.', 'anonymous-post-pro') : $field_array[ 'required_message' ];
                $form .= '</div><div class="ap-pro-form-field">';
                if ( $field_array[ 'textbox_type' ] == 'textarea' ) {
                    $form .= '<textarea name="' . $field_title . '" data-required-msg="' . $field_array[ 'required_message' ] . '" class="ap-pro-textarea' . $required . '"></textarea>';
                } else if ( $field_array[ 'textbox_type' ] == 'file_uploader' ) {
                    $file_upload_counter++;
                    $each_upload_counter++;
                    $upload_size = ($field_array[ 'upload_size' ] == '') ? 8 * 1000000 : $field_array[ 'upload_size' ] * 1000000;
                    $file_types = (isset($field_array[ 'file_extension' ])) ? implode('|', $field_array[ 'file_extension' ]) : 'gif|jpeg|png|jpg';
                    if ( isset($field_array[ 'custom_extensions' ]) && $field_array[ 'custom_extensions' ] != '' ) {
                        $custom_extensions = str_replace(' ', '', $field_array[ 'custom_extensions' ]);
                        $custom_extensions = str_replace(',', '|', $custom_extensions);
                        $file_types .= '|' . $custom_extensions;
                    }
                    $multiple_upload = (isset($field_array[ 'multiple_upload' ]) && $field_array[ 'multiple_upload' ] == 1) ? true : false;
                    $upload_limit = (isset($field_array[ 'upload_limit' ], $field_array[ 'multiple_upload' ]) && $field_array[ 'multiple_upload' ] == 1) ? $field_array[ 'upload_limit' ] : -1;
                    $upload_limit = ($upload_limit == '') ? -1 : $upload_limit;
                    $upload_limit_message = isset($field_array[ 'upload_limit_message' ]) ? $field_array[ 'upload_limit_message' ] : '';
                    $uploader_label = (isset($field_array[ 'button_label' ]) && $field_array[ 'button_label' ] != '') ? $field_array[ 'button_label' ] : 'Upload a file';
                    $media_attachment = isset($field_array[ 'attach_media' ]) ? 1 : 0;
                    $custom_folder = isset($field_array[ 'custom_folder' ]) ? esc_attr($field_array[ 'custom_folder' ]) : '';
                    $form .= '<div class="ap-file-uploader" id="ap-file-uploader-' . $file_upload_counter . '" data-extensions="' . $file_types . '" data-size="' . $upload_size . '" data-multiple="' . $multiple_upload . '" data-upload-limit="' . $upload_limit . '" data-uploader-label="' . $uploader_label . '" data-upload-limit-message="' . $upload_limit_message . '" data-media-attachment="' . $media_attachment . '" data-cf="' . $custom_folder . '">
                     </div>
                          ';
                    $form .= '<div class="ap-pro-file-preview" id="ap-pro-file-preview' . $file_upload_counter . '"></div><input type="hidden" name="' . $field_title . '" id="ap-pro-file-url-' . $file_upload_counter . '" class="ap-pro-file-url ' . $required . '" data-required-msg="' . $required_message . '" /><input type="hidden" class="ap-pro-upload-counter" value="0" id="ap-pro-upload-counter-' . $file_upload_counter . '"/><div class="ap-upload-limit-error" style="color:red" id="ap-upload-limit-error-' . $file_upload_counter . '"></div>';
                } else if ( $field_array[ 'textbox_type' ] == 'select' ) {
                    $select_name = (isset($field_array[ 'multiple_select' ]) && $field_array[ 'multiple_select' ] == 1) ? $field_title . '[]' : $field_title;
                    $multiple = (isset($field_array[ 'multiple_select' ]) && $field_array[ 'multiple_select' ] == 1) ? 'multiple' : '';
                    $multiple_class = (isset($field_array[ 'multiple_select' ]) && $field_array[ 'multiple_select' ] == 1) ? 'ap-multiple-select' : '';
                    $form .= '<select name="' . $select_name . '" class="' . $multiple_class . ' ' . $required . '" data-required-msg="' . $required_message . '" ' . $multiple . '>';
                    if ( !empty($field_array[ 'option' ]) ) {
                        $option_count = 0;
                        foreach ( $options as $option ) {
                            $checked_option_value = (isset($checked_option[ $option_count ])) ? $checked_option[ $option_count ] : 0;
                            $selected = ($checked_option_value == 1) ? 'selected="selected"' : '';
                            $form .= '<option value="' . $values[ $option_count ] . '" ' . $selected . '>' . $option . '</option>';
                            $option_count++;
                        }
                    }
                    $form .= '</select>';
                } else if ( $field_array[ 'textbox_type' ] == 'radio_button' ) {
                    if ( !empty($field_array[ 'option' ]) ) {
                        $form .= '<div class="ap-radio-wrap ' . $required . '" data-required-msg="' . $required_message . '">';

                        $option_count = 0;
                        $display_type = (isset($field_array[ 'display_type' ])) ? $field_array[ 'display_type' ] : 'multiple';
                        $display_type_class = 'ap-pro-display-' . $display_type;
                        foreach ( $options as $option ) {
                            $checked_option_value = (isset($checked_option[ $option_count ])) ? $checked_option[ $option_count ] : 0;
                            $checked = ($checked_option_value == 1) ? 'checked="checked"' : '';

                            $form .= '<label class="ap-radio-label ' . $display_type_class . '"><input type="radio" name="' . $field_title . '" class="' . $required . '" data-required-msg="' . $required_message . '" value="' . $values[ $option_count ] . '" ' . $checked . '/>' . $option . '</label>';
                            $option_count++;
                        }
                        $form .= '</div>';
                    }
                } else if ( $field_array[ 'textbox_type' ] == 'checkbox' ) {
                    if ( !empty($field_array[ 'option' ]) ) {
                        $form .= '<div class="ap-checkbox-wrap ' . $required . '" data-required-msg="' . $required_message . '">';
                        $option_count = 0;
                        $display_type = (isset($field_array[ 'display_type' ])) ? $field_array[ 'display_type' ] : 'multiple';
                        $display_type_class = 'ap-pro-display-' . $display_type;
                        foreach ( $options as $option ) {
                            $checked_option_value = (isset($checked_option[ $option_count ])) ? $checked_option[ $option_count ] : 0;
                            $checked = ($checked_option_value == 1) ? 'checked="checked"' : '';

                            $form .= '<label class="ap-checkbox-label ' . $display_type_class . '"><input type="checkbox" name="' . $field_title . '[]"  value="' . $values[ $option_count ] . '" ' . $checked . '>' . $option . '</label>';
                            $option_count++;
                        }
                        $form .= '</div>';
                    }
                } else {
                    if ( $field_array[ 'textbox_type' ] == 'datepicker' ) {
                        $datepicker = 'ap-pro-datepicker';
                    } else {
                        $datepicker = '';
                    }
                    $date_format = isset($field_array[ 'date_format' ]) ? $field_array[ 'date_format' ] : 'yy-mm-dd';
                    $form .= '<input type="text" name="' . $field_title . '" data-required-msg="' . $field_array[ 'required_message' ] . '" class="ap-pro-textfield' . $required . ' ' . $datepicker . '" data-date-format="' . $date_format . '"/>';
                }

                $form .= '<input type="hidden" name="form_included_fields[]" value="' . $field_title . '"/>
                <input type="hidden" name="form_custom_fields[]" value="' . $field_title . '"/>';
                if ( $field_array[ 'notes_type' ] == 'tooltip' && $field_array[ 'notes' ] != '' ) {
                    $form .= '<span class="ap-pro-tooltip-notes">' . $field_array[ 'notes' ] . '</span>';
                }
                if ( $field_array[ 'textbox_type' ] == 'datepicker' ) {
                    $form .= '<span class="ap-datepicker-icon"></span>';
                }

                $form .= '</div><!--ap-pro-form-field-->
                 <div class="ap-form-error"></div>';
                $form .= '</div><!--ap-pro-form-field-wrapper-->';
                break;
        }//switch close
    endif;
}//foreach close
$_SESSION[ 'file_uploader_counter' ] = $file_upload_counter;

/**
 * Captcha Conditions
 * */
if ( $ap_settings[ 'captcha_settings' ] == 1 ) {
    if ( $ap_settings[ 'captcha_type' ] == 'human' ) {
        $captcha_label = ($ap_settings[ 'math_captcha_label' ] == '') ? __('Human Check') : esc_attr($ap_settings[ 'math_captcha_label' ]);
        $form .= '<div class="ap-pro-form-field-wrapper">
              <div class="label-wrap"><label>' . $captcha_label . '</label></div>
              <div class="ap-form-field math-captcha">
                <span class="ap-captcha-first-num">' . rand(1, 9) . '</span>+<span class="ap-captcha-second-num">' . rand(1, 9) . '</span>=<input type="text" id="ap-captcha-result" placeholder="' . __('Enter Sum', 'anonymous-post-pro') . '" class="ap-required-field" data-required-msg="' . esc_attr($ap_settings[ 'math_captcha_error_message' ]) . '">
              </div>
              <div class="ap-form-error ap-captcha-error-msg"></div>
            </div><!--ap-form-field-wrapper-->';
    } else {
        $google_captcha_label = ($ap_settings[ 'google_captcha_label' ] == '') ? 'Google Captcha' : esc_attr($ap_settings[ 'google_captcha_label' ]);
        $captcha_version = (isset($ap_settings[ 'google_captcha_version' ])) ? $ap_settings[ 'google_captcha_version' ] : 'v1';
        if ( $captcha_version == 'v1' ) {
            if ( $ap_settings[ 'google_catpcha_public_key' ] != '' && $ap_settings[ 'google_catpcha_private_key' ] != '' ) {
                include_once('recaptchalib.php'); //including google captcha library

                $public_key = esc_attr($ap_settings[ 'google_catpcha_public_key' ]);
                $form .= '<div class="ap-form-field-wrapper">
                     <div class="label-wrap"><label>' . $google_captcha_label . '</label></div>
                     <div class="ap-form-field">
                     ' . recaptcha_get_html($public_key) .
                        '</div><!--ap-form-field-->
                     ';
                if ( isset($error->captcha) && $error->form_id == $form_id ) {
                    $form .= '<div class="ap-form-error-message">' . $error->captcha . '</div>';
                } else {
                    $error_captcha = ($ap_settings[ 'google_captcha_error_message' ] == '') ? __('The reCAPTCHA wasn\'t entered correctly. Please try it again.', 'anonymous-post-pro') : esc_attr($ap_settings[ 'google_captcha_error_message' ]);
                    $form .= '<div class="ap-form-error-message ap-captcha-error" data-error-message="' . $error_captcha . '"></div>';
                }
                $form .= '</div><!--ap-form-field-wrapper-->';
            }
        } else {
            if ( $ap_settings[ 'google_captcha_site_key' ] != '' && $ap_settings[ 'google_captcha_secret_key' ] != '' ) {
                $site_key = $ap_settings[ 'google_captcha_site_key' ];
                $form .= '<div class="ap-form-field-wrapper">
                        <div class="label-wrap"><label>' . $google_captcha_label . '</label></div>
                        <script src="https://www.google.com/recaptcha/api.js"></script>
                        <div class="g-recaptcha" data-sitekey="' . $site_key . '"></div>
                        </div><!--ap-form-field-wrapper-->';
                if ( isset($error->captcha) && $error->form_id == $form_id ) {
                    $form .= '<div class="ap-form-error-message">' . $error->captcha . '</div>';
                } else {
                    $error_captcha = ($ap_settings[ 'google_captcha_error_message' ] == '') ? __('The reCAPTCHA wasn\'t entered correctly. Please try it again.', 'anonymous-post-pro') : esc_attr($ap_settings[ 'google_captcha_error_message' ]);
                    $form .= '<div class="ap-form-error-message ap-captcha-error" data-error-message="' . $error_captcha . '"></div>';
                }
            }
        }
    }
}
if ( isset($ap_settings[ 'terms_agreement' ]) && $ap_settings[ 'terms_agreement' ] == 1 ) {
    $form .= '<div class="ap-form-agreement-wrap"><input type="checkbox" value="1" class="ap-agreement-checkbox" data-required-msg="' . $ap_settings[ 'terms_agreement_message' ] . '"/><div class="ap-agreement-text">' . $ap_settings[ 'terms_agreement_text' ] . '</div><div class="ap-form-error-message ap-agreement-error"></div></div>';
}
$submit_button_label = ($ap_settings[ 'post_submit_label' ] == '') ? __('Submit Post', 'anonymous-post-pro') : esc_attr($ap_settings[ 'post_submit_label' ]);
$redirect_url = ($ap_settings[ 'redirect_url' ] == '') ? $this->curPageURL() : esc_url($ap_settings[ 'redirect_url' ]);
$captcha_type = ($ap_settings[ 'captcha_settings' ] == 1) ? $ap_settings[ 'captcha_type' ] : '';
$captcha_version = (isset($ap_settings[ 'google_captcha_version' ])) ? $ap_settings[ 'google_captcha_version' ] : 'v1';
$form .= '<div class="ap-pro-form-field-wrapper form-submit">
            <input type="hidden" name="redirect_url" value="' . $redirect_url . '"/>
            <input type="hidden" class="ap-captcha-type" value="' . $captcha_type . '"/>
            <input type="hidden" class="ap-captcha-version" value="' . $captcha_version . '"/>
            <input type="hidden" id="ap-pro-file-uploader-counter" value="' . $each_upload_counter . '"/>
            <input type="hidden" name="ap_form_id" value="' . $form_id . '"/>
            <input type="submit" name="ap_form_submit_button" value="' . $submit_button_label . '" class="ap-pro-submit-btn"/>
            <img src="' . AP_PRO_IMAGE_DIR . '/ajax-loader.gif" class="ap-front-loader" style="display:none;"/>
            <input type="hidden" name="ap_attachment_ids" class="ap-attachment-ids"/>
          </div>';
$form .= $this->get_nonce_field_html();
$form .= '</form><!--ap-pro-front-form-->
         </div><!--ap-pro-front-form-wrapper-->';
