<div class="ap-tabs-board" id="board-form-settings" style="display: none;">

    <div class="ap-form-config">
        <h2><?php _e('Form field configurations', 'anonymous-post-pro'); ?></h2>
        <div class="ap-tab-wrapper">
            <div class="ap-option-wrapper">
                <div class="ap-form-configuration-wrapper">
                    <ul class="ap-pro-fields">
                        <?php
                        $post_label_array = array( 'post_title' => __('Post Title', 'anonymous-post-pro'),
                            'post_content' => __('Post Content', 'anonymous-post-pro'),
                            'post_excerpt' => __('Post Excerpt', 'anonymous-post-pro'),
                            'post_image' => __('Post Image', 'anonymous-post-pro'),
                            'author_name' => __('Author Name', 'anonymous-post-pro'),
                            'author_url' => __('Author URL', 'anonymous-post-pro'),
                            'author_email' => __('Author Email', 'anonymous-post-pro')
                        );
                        // $this->print_array($ap_settings['form_fields']);
                        foreach ( $ap_settings[ 'form_fields' ] as $field_title => $field_array ) {
                            $field_title = esc_attr($field_title);
                            if ( isset($field_array[ 'file_extension' ]) ) {
                                $file_extensions = $field_array[ 'file_extension' ];
                            }
                            if ( isset($field_array[ 'option' ]) ) {
                                $options = array_map('esc_attr', $field_array[ 'option' ]);
                                $values = array_map('esc_attr', $field_array[ 'value' ]);
                                $checked_option = isset($field_array[ 'checked_option' ]) ? $field_array[ 'checked_option' ] : array();
                                $checked_option = array_map('esc_attr', $checked_option);
                            }
                            $field_array = array_map('esc_attr', $field_array);
                            if ( isset($file_extensions) ) {
                                $field_array[ 'file_extension' ] = $file_extensions;
                            }

                            //$this->print_array($field_array);
                            //echo $field_title;
                            switch ( $field_array[ 'field_type' ] ) {
                                case 'taxonomy':
                                    ?>
                                    <li class="ap-pro-form-taxonomies ap-pro-li-sortable">
                                        <div class="dragicon"></div>
                                        <div class="ap-pro-labels-head">
                                            <?php echo $field_array[ 'taxonomy_label' ]; ?>
                                            <span class="ap-arrow-down ap-arrow">Down</span>
                                        </div>

                                        <div class="ap-pro-labels-content" style="display: none;">
                                            <ul class="ap-pro-inner-configs">
                                                <li>
                                                    <label><?php _e('Show on form', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[<?php echo $field_title; ?>][show_form]" value="1" <?php if ( $field_array[ 'show_form' ] == 1 ) { ?>checked="checked"<?php } ?>/></div>
                                                </li>
                                                <li>
                                                    <label><?php _e('Required', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[<?php echo $field_title ?>][required]" value="1" <?php if ( $field_array[ 'required' ] == 1 ) { ?>checked="checked"<?php } ?>/></div>
                                                </li>
                                                <li>
                                                    <label><?php _e('Custom required message'); ?></label>
                                                    <div class="ap-pro-textbox"><input type="text" name="form_fields[<?php echo $field_title ?>][required_message]" value="<?php echo $field_array[ 'required_message' ] ?>"/></div>
                                                </li>
                                                <li>
                                                    <label><?php _e('Label', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-textbox"><input type="text" name="form_fields[<?php echo $field_title ?>][label]" value="<?php echo $field_array[ 'label' ]; ?>"/></div>
                                                </li>

                                                <li>
                                                    <label><?php _e('Show field as:', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-select">
                                                        <select name="form_fields[<?php echo $field_title ?>][taxonomy_field_type]" class="ap-taxonomy-field-type">
                                                            <?php
                                                            if ( isset($field_array[ 'hierarchical' ]) && $field_array[ 'hierarchical' ] == 0 ) {
                                                                ?>
                                                                <option value="textfield" <?php echo (isset($field_array[ 'taxonomy_field_type' ]) && $field_array[ 'taxonomy_field_type' ] == 'textfield') ? 'selected="selected"' : ''; ?>>Textfield</option>
                                                                <?php
                                                            }
                                                            ?>
                                                            <option value="dropdown" <?php echo (isset($field_array[ 'taxonomy_field_type' ]) && $field_array[ 'taxonomy_field_type' ] == 'dropdown') ? 'selected="selected"' : ''; ?>>Dropdown</option>
                                                            <option value="checkbox" <?php echo (isset($field_array[ 'taxonomy_field_type' ]) && $field_array[ 'taxonomy_field_type' ] == 'checkbox') ? 'selected="selected"' : ''; ?>>Checkbox</option>

                                                        </select>
                                                        <div class="ap-option-note ap-option-width">
                                                            <p><strong>Textfield:</strong><?php _e('It will show textfield to add new items using comma for multiple items', 'anonymous-post-pro'); ?></p>
                                                            <p><strong>Dropdown & Checkbox:</strong><?php _e('It will show already available items as dropdown or checkbox', 'anonymous-post-pro'); ?></p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                                if ( isset($field_array[ 'hierarchical' ]) && $field_array[ 'hierarchical' ] == 1 ) {
                                                    ?>
                                                    <li>
                                                        <label><?php _e('Parent Category/Term', 'anonymous-post-pro'); ?></label>
                                                        <div class="ap-pro-select">
                                                            <select name="form_fields[<?php echo $field_title ?>][parent_term]" class="ap-parent-term" data-parent-term="<?php echo (isset($field_array[ 'parent_term' ])) ? $field_array[ 'parent_term' ] : ''; ?>">
                                                                <option value="0"><?php _e('None', 'anonymous-post-pro'); ?></option>
                                                                <?php
                                                                $parent_term = (isset($field_array[ 'parent_term' ])) ? $field_array[ 'parent_term' ] : '';
                                                                $terms = get_terms($field_title, array( 'hide_empty' => 0 ));
                                                                $categoryHierarchy = array();
                                                                $this->sort_terms_hierarchicaly($terms, $categoryHierarchy);
                                                                if ( count($categoryHierarchy) > 0 ) {
                                                                    $option = $this->print_option($categoryHierarchy, array(), 1, '', '', $parent_term);
                                                                }
                                                                echo $option;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                                <li class="ap-taxonomy-autocomplete" <?php if ( isset($field_array[ 'hierarchical' ], $field_array[ 'taxonomy_field_type' ]) && $field_array[ 'hierarchical' ] == 0 && $field_array[ 'taxonomy_field_type' ] != 'textfield' ) { ?>style="display:none"<?php } ?>>
                                                    <label><?php _e('Auto Complete', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-checkbox">
                                                        <input type="checkbox" name="form_fields[ <?php echo $field_title ?>][auto_complete]" value="1" <?php echo (isset($field_array[ 'auto_complete' ]) && $field_array[ 'auto_complete' ] == 1) ? 'checked="checked"' : ''; ?>/>
                                                        <div class="ap-option-note ap-option-width"><?php _e('Check if you want to enable auto complete for this tags/terms', 'anonymous-post-pro'); ?></div>
                                                    </div>
                                                </li>

                                                <li class="ap-taxonomy-multiple" <?php if ( isset($field_array[ 'hierarchical' ], $field_array[ 'taxonomy_field_type' ]) && $field_array[ 'hierarchical' ] == 0 && $field_array[ 'taxonomy_field_type' ] != 'dropdown' ) { ?>style="display:none"<?php } ?>>
                                                    <label><?php _e('Multiple Select', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-checkbox">
                                                        <input type="checkbox" name="form_fields[<?php echo $field_title ?>][multiple_select]" value="1" <?php echo (isset($field_array[ 'multiple_select' ]) && $field_array[ 'multiple_select' ] == 1) ? 'checked="checked"' : ''; ?>/>
                                                        <div class="ap-option-note ap-option-width"><?php _e('Check if you want to allow users to select multiple items pressing control or command key', 'anonymous-post-pro'); ?></div>
                                                    </div>
                                                </li>
                                                <li class="ap-taxonomy-multiple" <?php if ( isset($field_array[ 'hierarchical' ], $field_array[ 'taxonomy_field_type' ]) && $field_array[ 'hierarchical' ] == 0 && $field_array[ 'taxonomy_field_type' ] != 'dropdown' ) { ?>style="display:none"<?php } ?>>
                                                    <label><?php _e('Dropdown First Option Label', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-checkbox">
                                                        <input type="text" name="form_fields[<?php echo $field_title ?>][first_option_label]" value="<?php echo (isset($field_array[ 'first_option_label' ])) ? $field_array[ 'first_option_label' ] : ''; ?>" />
                                                        <div class="ap-option-note ap-option-width"><?php _e('Please enter the first option label of the dropdown.', 'anonymous-post-pro'); ?></div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <label><?php _e('Exclude Categories/Tags/Terms', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-textbox">
                                                        <input type="text" name="form_fields[<?php echo $field_title ?>][exclude_terms]" value="<?php echo isset($field_array[ 'exclude_terms' ]) ? $field_array[ 'exclude_terms' ] : ''; ?>"/>
                                                        <div class="ap-option-note ap-option-width">
                                                            <?php _e('Please add the <b>slugs</b> of the categories/tags/terms separated by comma that you want<br/> to exclude while showing in the front form.For e.g:category-3,category-2', 'anonymous-post-pro'); ?>
                                                        </div>
                                                    </div>

                                                </li>
                                                <li>
                                                    <label><?php _e('Field Notes', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-select">
                                                        <select name="form_fields[<?php echo $field_title ?>][notes_type]">
                                                            <option value="0" <?php if ( $field_array[ 'notes_type' ] == "0" ) { ?>selected="selected"<?php } ?>><?php _e('Don\'t Show', 'anonymous-post-pro'); ?></option>
                                                            <option value="icon" <?php if ( $field_array[ 'notes_type' ] == "icon" ) { ?>selected="selected"<?php } ?>><?php _e('Show as info icon', 'anonymous-post-pro'); ?></option>
                                                            <option value="tooltip" <?php if ( $field_array[ 'notes_type' ] == "tooltip" ) { ?>selected="selected"<?php } ?>><?php _e('Show as tooltip', 'anonymous-post-pro'); ?></option>
                                                        </select>
                                                    </div>
                                                </li>
                                                <li>
                                                    <label><?php _e('Field Notes Text', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-textbox"><input type="text" name="form_fields[<?php echo $field_title; ?>][notes]" value="<?php echo $field_array[ 'notes' ]; ?>"/></div>
                                                    <div class="ap-pro-notes"><?php _e('These are extra notes for the front form fields ', 'anonymous-post-pro'); ?></div>
                                                </li>
                                            </ul>
                                            <input type="hidden" name="form_included_taxonomy[]" value="<?php echo $field_title; ?>"/>
                                            <input type="hidden" name="form_fields[<?php echo $field_title; ?>][hierarchical]" value="<?php echo $field_array[ 'hierarchical' ]; ?>"/>
                                            <input type="hidden" name="form_field_order[]" value="<?php echo $field_title; ?>|taxononmy"/>
                                            <input type="hidden" name="form_fields[<?php echo $field_title; ?>][field_type]" value="taxonomy"/>
                                            <input type="hidden" name="form_fields[<?php echo $field_title; ?>][taxonomy_label]" value="<?php echo $field_array[ 'taxonomy_label' ] ?>"/>
                                        </div>
                                    </li>
                                    <?php
                                    break;
                                case 'field':
                                    ?>
                                    <li class="ap-pro-li-sortable">
                                        <div class="dragicon"></div>
                                        <div class="ap-pro-labels-head">
                                            <?php echo $post_label_array[ $field_title ]; ?>
                                            <span class="ap-arrow-down ap-arrow">Down</span>
                                        </div>

                                        <div class="ap-pro-labels-content" style="display: none;">
                                            <ul class="ap-pro-inner-configs">
                                                <li>
                                                    <label><?php _e('Show on form', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[<?php echo $field_title ?>][show_form]" value="1"  <?php if ( $field_array[ 'show_form' ] == 1 ) { ?>checked="checked"<?php } ?> /></div>
                                                </li>
                                                <li>
                                                    <label><?php _e('Required', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[<?php echo $field_title ?>][required]" value="1"  <?php if ( $field_array[ 'required' ] == 1 ) { ?>checked="checked"<?php } ?> /></div>
                                                </li>
                                                <li>
                                                    <label><?php _e('Custom required message'); ?></label>
                                                    <div class="ap-pro-textbox"><input type="text" name="form_fields[<?php echo $field_title ?>][required_message]" value="<?php echo $field_array[ 'required_message' ]; ?>"/></div>
                                                </li>
                                                <li>
                                                    <label><?php _e('Label', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-textbox"><input type="text" name="form_fields[<?php echo $field_title ?>][label]" value="<?php echo $field_array[ 'label' ]; ?>"/></div>
                                                </li>
                                                <li>
                                                    <label><?php _e('Field Notes', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-select">
                                                        <select name="form_fields[<?php echo $field_title ?>][notes_type]">
                                                            <option value="0" <?php if ( $field_array[ 'notes_type' ] == '0' ) { ?>selected="selected"<?php } ?>><?php _e('Don\'t Show', 'anonymous-post-pro'); ?></option>
                                                            <option value="icon" <?php if ( $field_array[ 'notes_type' ] == 'icon' ) { ?>selected="selected"<?php } ?>><?php _e('Show as info icon', 'anonymous-post-pro'); ?></option>
                                                            <option value="tooltip" <?php if ( $field_array[ 'notes_type' ] == 'tooltip' ) { ?>selected="selected"<?php } ?>><?php _e('Show as tooltip', 'anonymous-post-pro'); ?></option>
                                                        </select>
                                                    </div>
                                                </li>
                                                <li>
                                                    <label><?php _e('Field Notes Text', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-textbox">
                                                        <input type="text" name="form_fields[<?php echo $field_title ?>][notes]" value="<?php echo $field_array[ 'notes' ]; ?>"/>
                                                        <div class="ap-pro-notes"><?php _e('These are extra notes for the front form fields', 'anonymous-post-pro'); ?></div>
                                                    </div>

                                                </li>
                                                <?php if ( $field_title == 'post_content' ) { ?>
                                                    <li>
                                                        <label><?php _e('Editor Type', 'anonymous-post-pro'); ?></label>
                                                        <div class="ap-pro-select">
                                                            <select name="form_fields[<?php echo $field_title ?>][editor_type]">
                                                                <option value="simple" <?php if ( $field_array[ 'editor_type' ] == 'simple' ) { ?>selected='selected'<?php } ?>>Simple Textarea</option>
                                                                <option value="rich" <?php if ( $field_array[ 'editor_type' ] == 'rich' ) { ?>selected='selected'<?php } ?>>Rich Text Editor</option>
                                                                <option value="visual" <?php if ( $field_array[ 'editor_type' ] == 'visual' ) { ?>selected='selected'<?php } ?>>Visual Editor</option>
                                                                <option value="html" <?php if ( $field_array[ 'editor_type' ] == 'html' ) { ?>selected='selected'<?php } ?>>HTML Editor</option>
                                                            </select>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <label><?php _e('Character Limit', 'anonymous-post-pro'); //$this->print_array($field_array);                                                                     ?></label>
                                                        <div class="ap-pro-textbox">
                                                            <input type="text" name="form_fields[<?php echo $field_title ?>][character_limit]" value="<?php echo isset($field_array[ 'character_limit' ]) ? $field_array[ 'character_limit' ] : ''; ?>" placeholder="<?php _e('e.g: 200', 'anonymous-post-pro'); ?>"/>
                                                            <div class="ap-pro-notes"><?php _e('Please enter character limit in number for visual or rich <br/>content editor.Please leave blank if you don\'t want character limit.<br/>Please note that this feature will only work if there is only one visual/rich editor in the page.', 'anonymous-post-pro'); ?></div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <label><?php _e('Character Limit Message'); ?></label>
                                                        <div class="ap-pro-textbox">
                                                            <input type="text" name="form_fields[<?php echo $field_title ?>][character_limit_message]" value="<?php echo isset($field_array[ 'character_limit_message' ]) ? $field_array[ 'character_limit_message' ] : ''; ?>"/>
                                                            <div class="ap-pro-notes"><?php _e('Please enter the message to be displayed when user exceeds <br/> character limit.', 'anonymous-post-pro'); ?></div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <label><?php _e('Rich/Visual Editor Size'); ?></label>
                                                        <div class="ap-pro-textbox">
                                                            <input type="number" name="form_fields[<?php echo $field_title ?>][editor_size]" value="<?php echo isset($field_array[ 'editor_size' ]) ? $field_array[ 'editor_size' ] : ''; ?>"/>
                                                            <div class="ap-pro-notes"><?php _e('Please enter the size of editor in number of rows.Default number of rows is 10.', 'anonymous-post-pro'); ?></div>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                                if ( $field_title == 'author_name' || $field_title == 'author_email' || $field_title == 'author_url' ) {
                                                    ?>
                                                    <li>
                                                        <label><?php _e('Frontend Display', 'anonymous-post-pro'); ?></label>
                                                        <div class="ap-pro-checkbox">
                                                            <input type="checkbox" name="form_fields[<?php echo $field_title; ?>][frontend_show]" value='1' <?php if ( isset($field_array[ 'frontend_show' ]) && $field_array[ 'frontend_show' ] == 1 ) { ?>checked="checked"<?php } ?> class="ap-frontend-show-checkbox"/>
                                                            <div class="ap-option-note"><?php _e('Check if you want to show this custom field value in the frontend post.', 'anonymous-post-pro'); ?></div>
                                                        </div>
                                                        <?php
                                                        if ( isset($field_array[ 'frontend_show' ]) ) {
                                                            if ( $field_array[ 'frontend_show' ] == 0 ) {
                                                                $frontend_display_reference = 'style="display:none"';
                                                            } else {
                                                                $frontend_display_reference = '';
                                                            }
                                                        } else {
                                                            $frontend_display_reference = 'style="display:none"';
                                                        }
                                                        ?>
                                                        <div class="ap-frontend-display-reference" <?php echo $frontend_display_reference; ?>>
                                                            <ul>
                                                                <li>
                                                                    <label><?php _e('Frontend Display Label', 'anonymous-post-pro'); ?></label>
                                                                    <div class="ap-pro-checkbox">
                                                                        <input type="text" name="form_fields[<?php echo $field_title; ?>][frontend_show_label]" value="<?php echo (isset($field_array[ 'frontend_show_label' ])) ? $field_array[ 'frontend_show_label' ] : ''; ?>"/>
                                                                        <div class="ap-pro-notes ap-option-width"><?php _e('Label to be shown in frontend', 'anonymous-post-pro'); ?></div>
                                                                    </div>
                                                                </li>
                                                                <?php
                                                                if ( $field_title == 'author_url' ) {
                                                                    ?>
                                                                    <li>
                                                                        <label><?php _e('Show as link', 'anonymous-post-pro'); ?></label>
                                                                        <div class="ap-pro-checkbox">
                                                                            <input type="checkbox" name="form_fields[<?php echo $field_title; ?>][show_link]" value='1' <?php if ( isset($field_array[ 'show_link' ]) && $field_array[ 'show_link' ] == 1 ) { ?>checked="checked"<?php } ?>/>
                                                                            <div class="ap-option-note"><?php _e('Check if you want to show the url as link.', 'anonymous-post-pro'); ?></div>
                                                                        </div>
                                                                    </li>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                    </li>

                                                    <?php
                                                }
                                                if ( $field_title == 'post_image' ) {
                                                    ?>
                                                    <li>
                                                        <label><?php _e('Advance Uploader', 'anonymous-post-pro'); ?></label>
                                                        <div class="ap-pro-checkbox">
                                                            <input type="checkbox" name="form_fields[<?php echo $field_title ?>][advance_uploader]" value="1"  <?php if ( isset($field_array[ 'advance_uploader' ]) && $field_array[ 'advance_uploader' ] == 1 ) { ?>checked="checked"<?php } ?> class="ap-advance-uploader-trigger"/>
                                                            <div class="ap-option-note"><?php _e('Check if you want to enable advance uploader for post image', 'anonymous-post-pro'); ?></div>
                                                        </div>
                                                    </li>
                                                    <div class="ap-advance-uploader-wrap" <?php if ( !isset($field_array[ 'advance_uploader' ]) ) { ?>style="display:none"<?php } ?>>
                                                        <div class="ap-pro-file-upload-size">
                                                            <label><?php _e('Upload Button Label', 'anonymous-post-pro'); ?></label>
                                                            <input type="text" name="form_fields[<?php echo $field_title ?>][button_label]" class="ap-pro-upload-button-label" value="<?php echo isset($field_array[ 'button_label' ]) ? $field_array[ 'button_label' ] : ''; ?>"/>
                                                            <div class="ap-option-note ap-option-width"><?php _e('Please enter the file upload button label', 'anonymous-post-pro'); ?></div>
                                                        </div>
                                                        <div class="ap-pro-file-upload-size">
                                                            <label><?php _e('Max Upload File Size', 'anonymous-post-pro'); ?></label>
                                                            <input type="text" name="form_fields[<?php echo $field_title ?>][upload_size]" class="ap-pro-file-upload-size" value="<?php echo isset($field_array[ 'upload_size' ]) ? $field_array[ 'upload_size' ] : ''; ?>"/>
                                                            <div class="ap-option-note ap-option-width"><?php _e('Please enter the max upload size in MB.Default file size is 8MB.Please enter the size less than what is set in your php.ini post_max_size and upload_max_size else alert message may show up in frontend.', 'anonymous-post-pro'); ?></div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                            </ul>
                                            <input type="hidden" name="form_field_order[]" value="<?php echo $field_title ?>|field"/>
                                            <input type="hidden" name="form_fields[<?php echo $field_title ?>][field_type]" value="field"/>
                                        </div>
                                    </li>
                                    <?php
                                    break;

                                /**
                                 * Custom Fields
                                 * */
                                case 'custom':
                                    ?>
                                    <li class="ap-pro-li-sortable">
                                        <div class="dragicon"></div>
                                        <div class="ap-pro-labels-head"><?php echo $field_array[ 'custom_label' ]; ?>
                                            <span class="ap-arrow-down ap-arrow">Down</span>
                                            <span class="ap-custom-li-delete">Delete</span>
                                        </div>

                                        <div class="ap-pro-labels-content" style="display: none;">
                                            <ul class="ap-pro-inner-configs">
                                                <li>
                                                    <label><?php _e('Show on form', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[<?php echo $field_title; ?>][show_form]" value="1" <?php if ( $field_array[ 'show_form' ] == 1 ) { ?>checked="checked"<?php } ?>/></div>
                                                </li>
                                                <li>
                                                    <label><?php _e('Required', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[<?php echo $field_title; ?>][required]" value="1" <?php if ( $field_array[ 'required' ] == 1 ) { ?>checked="checked"<?php } ?>/></div>
                                                </li>
                                                <li>
                                                    <label><?php _e('Required Message', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-textbox"><input type="text" name="form_fields[<?php echo $field_title; ?>][required_message]" value="<?php echo $field_array[ 'required_message' ]; ?>"/></div>
                                                </li>
                                                <li>
                                                    <label><?php _e('Label', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-textbox"><input type="text" name="form_fields[<?php echo $field_title; ?>][label]" value="<?php echo $field_array[ 'label' ]; ?>"/></div>
                                                </li>
                                                <li>
                                                    <label><?php _e('Field Type', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-select">
                                                        <select name="form_fields[<?php echo $field_title; ?>][textbox_type]" data-key="<?php echo $field_title; ?>" class="ap-pro-custom-field-type">
                                                            <option value="textfield" <?php if ( $field_array[ 'textbox_type' ] == 'textfield' ) { ?>selected="selected"<?php } ?>>Text Field</option>
                                                            <option value="textarea" <?php if ( $field_array[ 'textbox_type' ] == 'textarea' ) { ?>selected="selected"<?php } ?>>Text Area</option>
                                                            <option value="datepicker" <?php if ( $field_array[ 'textbox_type' ] == 'datepicker' ) { ?>selected="selected"<?php } ?>>Date Picker</option>
                                                            <option value="file_uploader" <?php if ( $field_array[ 'textbox_type' ] == 'file_uploader' ) { ?>selected="selected"<?php } ?>>File Uploader</option>
                                                            <option value="radio_button" <?php if ( $field_array[ 'textbox_type' ] == 'radio_button' ) { ?>selected="selected"<?php } ?>>Radio Button</option>
                                                            <option value="checkbox" <?php if ( $field_array[ 'textbox_type' ] == 'checkbox' ) { ?>selected="selected"<?php } ?>>Checkbox</option>
                                                            <option value="select" <?php if ( $field_array[ 'textbox_type' ] == 'select' ) { ?>selected="selected"<?php } ?>>Select-option</option>
                                                        </select>
                                                    </div>
                                                    <div class="ap-pro-file-extensions" <?php if ( $field_array[ 'textbox_type' ] != 'file_uploader' ) { ?>style="display: none;"<?php } ?>>
                                                        <?php
                                                        if ( $field_array[ 'textbox_type' ] == 'file_uploader' ) {
                                                            $field_array[ 'file_extension' ] = (isset($field_array[ 'file_extension' ]) && is_array($field_array[ 'file_extension' ])) ? $field_array[ 'file_extension' ] : array();
                                                            ?>
                                                            <label>Choose File Extensions</label>
                                                            <div class="ap-pro-fileuploader">
                                                                <label>Images:</label>
                                                                <ul>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="jpg" <?php if ( in_array('jpg', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>jpg</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="jpeg" <?php if ( in_array('jpeg', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>jpeg</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="png" <?php if ( in_array('png', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>png</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="gif" <?php if ( in_array('gif', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>gif</span></li>
                                                                </ul>
                                                            </div>
                                                            <div class="ap-pro-fileuploader">
                                                                <label>Documents:</label>
                                                                <ul>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="pdf" <?php if ( in_array('pdf', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>pdf</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="doc|docx" <?php if ( in_array('doc|docx', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>doc/docx</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="xls|xlsx" <?php if ( in_array('xls|xlsx', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>xls/xlsx</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="odt" <?php if ( in_array('odt', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>odt</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="ppt|pptx|pps|ppsx" <?php if ( in_array('ppt|pptx|pps|ppsx', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>ppt,pptx,pps,ppsx</span></li>
                                                                </ul>
                                                            </div>
                                                            <div class="ap-pro-fileuploader">
                                                                <label>Audio:</label>
                                                                <ul>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="mp3" <?php if ( in_array('mp3', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>mp3</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="mp4" <?php if ( in_array('mp4', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>mp4</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="ogg" <?php if ( in_array('ogg', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>ogg</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="wav" <?php if ( in_array('wav', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>wav</span></li>
                                                                </ul>
                                                            </div>
                                                            <div class="ap-pro-fileuploader">
                                                                <label>Video:</label>
                                                                <ul>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="mp4" <?php if ( in_array('mp4', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>mp4</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="m4v" <?php if ( in_array('m4v', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>m4v</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="mov" <?php if ( in_array('mov', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>mov</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="wmv" <?php if ( in_array('wmv', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>wmv</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="avi" <?php if ( in_array('avi', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>avi</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="mpg" <?php if ( in_array('mpg', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>mpg</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="ogv" <?php if ( in_array('ogv', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>ogv</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="3gp" <?php if ( in_array('3gp', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>3gp</span></li>
                                                                    <li><input type="checkbox" name="form_fields[<?php echo $field_title ?>][file_extension][]" value="3g2" <?php if ( in_array('3g2', $field_array[ 'file_extension' ]) ) { ?>checked="checked"<?php } ?>/><span>3g2</span></li>
                                                                </ul>
                                                            </div>
                                                            <div class="ap-pro-file-upload-size">
                                                                <label><?php _e('Custom Extensions', 'anonymous-post-pro'); ?></label>
                                                                <input type="text" name="form_fields[<?php echo $field_title ?>][custom_extensions]" class="ap-pro-custom-extensions" placeholder="zip,bmp" value="<?php echo isset($field_array[ 'custom_extensions' ]) ? $field_array[ 'custom_extensions' ] : ''; ?>"/>
                                                                <div class="ap-option-note ap-option-width"><?php _e('Please enter custom extensions separated by comma without (.) if required extensions are not available in the above list. But please note that those extensions should be supported by media library.', 'anonymous-post-pro'); ?></div>
                                                            </div>
                                                            <div class="ap-pro-file-upload-size">
                                                                <label><?php _e('Custom Folder Upload', 'anonymous-post-pro'); ?></label>
                                                                <input type="text" name="form_fields[<?php echo $field_title ?>][custom_folder]" class="ap-pro-custom-extensions" value="<?php echo isset($field_array[ 'custom_folder' ]) ? $field_array[ 'custom_folder' ] : ''; ?>"/>
                                                                <div class="ap-option-note ap-option-width"><?php _e('Please enter custom directory name which is inside the uploads folder. Please note that the entered folder should be already available inside the uploads directory. Leave blank if you want to use the default WordPress Media folder.', 'anonymous-post-pro'); ?></div>
                                                            </div>
                                                            <div class="ap-pro-file-upload-size">
                                                                <label>Upload Button Label</label>
                                                                <input type="text" name="form_fields[<?php echo $field_title ?>][button_label]" class="ap-pro-upload-button-label" value="<?php echo isset($field_array[ 'button_label' ]) ? $field_array[ 'button_label' ] : ''; ?>"/>
                                                                <div class="ap-option-note ap-option-width"><?php _e('Please enter the file upload button label', 'anonymous-post-pro'); ?></div>
                                                            </div>
                                                            <div class="ap-pro-file-upload-size">
                                                                <label>Max Upload File Size</label>
                                                                <input type="text" name="form_fields[<?php echo $field_title ?>][upload_size]" class="ap-pro-file-upload-size" value="<?php echo $field_array[ 'upload_size' ] ?>"/>
                                                                <div class="ap-option-note ap-option-width"><?php _e('Please enter the max upload size in MB.Default file size is 8MB.Please enter the size less than what is set in your php.ini post_max_size and upload_max_size else alert message may show up in frontend.', 'anonymous-post-pro'); ?></div>
                                                            </div>
                                                            <div class="ap-pro-file-upload-size">
                                                                <label>Multiple Image Upload</label>
                                                                <input type="checkbox" name="form_fields[<?php echo $field_title ?>][multiple_upload]" class="ap-pro-multiple-file-upload" value="1" <?php if ( isset($field_array[ 'multiple_upload' ]) && $field_array[ 'multiple_upload' ] == 1 ) { ?>checked="checked"<?php } ?>/>
                                                                <div class="ap-option-note"><?php _e('Check if you want to allow the visitors to upload multiple files', 'anonymous-post-pro'); ?></div>
                                                            </div>
                                                            <div class="ap-pro-file-upload-size">
                                                                <label>Max Upload File Limit</label>
                                                                <input type="text" name="form_fields[<?php echo $field_title ?>][upload_limit]" class="ap-pro-file-upload-limit" value="<?php echo isset($field_array[ 'upload_limit' ]) ? $field_array[ 'upload_limit' ] : ''; ?>"/>
                                                                <div class="ap-option-note ap-option-width"><?php _e('Please enter the maximum number of file to allow for multiple upload.Default maximum number is infinite', 'anonymous-post-pro'); ?></div>
                                                            </div>
                                                            <div class="ap-pro-file-upload-size">
                                                                <label>Max Upload Limit Message</label>
                                                                <input type="text" name="form_fields[<?php echo $field_title ?>][upload_limit_message]" class="ap-pro-file-upload-limit-message" value="<?php echo isset($field_array[ 'upload_limit_message' ]) ? $field_array[ 'upload_limit_message' ] : ''; ?>"/>
                                                            </div>
                                                            <div class="ap-pro-file-upload-size">
                                                                <label>Attach Media to Post</label>
                                                                <input type="checkbox" name="form_fields[<?php echo $field_title ?>][attach_media]" class="ap-pro-attach-media" value="1" <?php
                                                                if ( isset($field_array[ 'attach_media' ]) ) {
                                                                    checked($field_array[ 'attach_media' ], true);
                                                                }
                                                                ?>/>
                                                                <div class="ap-option-note"><?php _e('Check if you want to attach the media to post', 'anonymous-post-pro'); ?></div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <?php
                                                    $date_format = (isset($field_array[ 'date_format' ])) ? esc_attr($field_array[ 'date_format' ]) : 'yy-mm-dd';
                                                    ?>
                                                    <div class="ap-date-format" <?php if ( $field_array[ 'textbox_type' ] != 'datepicker' ) { ?>style="display:none;"<?php } ?>>
                                                        <label><?php _e('Date Format', 'anonymous-post-pro'); ?></label>
                                                        <div class="ap-pro-select">
                                                            <select name="form_fields[<?php echo $field_title ?>][date_format]">
                                                                <option value="yy-mm-dd" <?php selected($date_format, 'yy-mm-dd'); ?>><?php _e('ISO 8601 - yy-mm-dd', 'anonymous-post-pro'); ?></option>
                                                                <option value="mm/dd/yy" <?php selected($date_format, 'mm/dd/yy'); ?>><?php _e('Default - mm/dd/yy', 'anonymous-post-pro'); ?></option>
                                                                <option value="d M, y" <?php selected($date_format, 'd M, y'); ?>><?php _e('Short - d M, y', 'anonymous-post-pro'); ?></option>
                                                                <option value="d MM, y" <?php selected($date_format, 'd MM, y'); ?>><?php _e('Medium - d MM, y', 'anonymous-post-pro'); ?></option>
                                                                <option value="DD, d MM, yy" <?php selected($date_format, 'DD, d MM, yy'); ?>><?php _e('Full - DD, d MM, yy', 'anonymous-post-pro'); ?></option>
                                                                <option value="'day' d 'of' MM 'in the year' yy" <?php selected($date_format, "&#039;day&#039; d &#039;of&#039; MM &#039;in the year&#039; yy"); ?>><?php _e("With text - 'day' d 'of' MM 'in the year' yy", 'anonymous-post-pro'); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $option_value_fields_array = array( 'radio_button', 'select', 'checkbox' );
                                                    ?>
                                                    <div class="ap-pro-option-value" <?php if ( !in_array($field_array[ 'textbox_type' ], $option_value_fields_array) ) { ?>style="display: none;"<?php } ?>>
                                                        <input type="button" class="button button-primary ap-add-option" value="Add Option" data-key="<?php echo $field_title; ?>">
                                                        <div class="ap-pro-option-wrap">
                                                            <?php
                                                            if ( isset($options) ) {
                                                                $option_count = 0;
                                                                foreach ( $options as $option ) {
                                                                    ?>
                                                                    <div class="ap-each-option-value">
                                                                        <span class="ap-drap-arrow"></span>
                                                                        <input type="text" name="form_fields[<?php echo $field_title; ?>][option][]" placeholder="option" value="<?php echo $option; ?>">
                                                                        <input type="text" name="form_fields[<?php echo $field_title; ?>][value][]" placeholder="value" value="<?php echo $values[ $option_count ]; ?>">
                                                                        <?php
                                                                        $checked_option_value = (isset($checked_option[ $option_count ])) ? $checked_option[ $option_count ] : 0;
                                                                        if ( $field_array[ 'textbox_type' ] == 'checkbox' ) {
                                                                            ?>
                                                                            <input type="checkbox" class="ap-option-checked-trigger" <?php checked($checked_option_value, '1'); ?>/>
                                                                            <input type="hidden" name="form_fields[<?php echo $field_title; ?>][checked_option][]" value="<?php echo $checked_option_value; ?>" class="ap-option-default-checked-ref"/> <?php _e('Checked', 'anonymous-post-pro'); ?>
                                                                            <?php
                                                                        } else if ( $field_array[ 'textbox_type' ] == 'radio_button' ) {
                                                                            ?>
                                                                            <input type="radio" class="ap-radio-checked-trigger" name="form_fields[<?php echo $field_title; ?>][checked_radio]" <?php checked($checked_option_value, '1'); ?>/>
                                                                            <input type="hidden" name="form_fields[<?php echo $field_title; ?>][checked_option][]" value="<?php echo $checked_option_value; ?>" class="ap-option-default-checked-ref"/> <?php _e('Checked', 'anonymous-post-pro'); ?>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <input type="radio" class="ap-radio-checked-trigger" name="form_fields[<?php echo $field_title; ?>][checked_radio]" <?php checked($checked_option_value, '1'); ?>/>
                                                                            <input type="hidden" name="form_fields[<?php echo $field_title; ?>][checked_option][]" value="<?php echo $checked_option_value; ?>" class="ap-option-default-checked-ref"/> <?php _e('Selected', 'anonymous-post-pro'); ?>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <a href="javascript:void(0)" class="ap-remove-option-value">X</a>
                                                                    </div>
                                                                    <?php
                                                                    $option_count++;
                                                                }//foreach close
                                                            }//if close
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="ap-pro-display-ref" <?php if ( !($field_array[ 'textbox_type' ] == 'radio_button' || $field_array[ 'textbox_type' ] == 'checkbox') ) { ?>style="display:none<?php } ?>">
                                                        <label><?php _e('Display Type', 'anonymous-post-pro') ?></label>
                                                        <div class="ap-pro-select">
                                                            <?php //$this->print_array($field_array); ?>
                                                            <select name="form_fields[<?php echo $field_title; ?>][display_type]">
                                                                <?php $display_type = isset($field_array[ 'display_type' ]) ? $field_array[ 'display_type' ] : 'multiple'; ?>
                                                                <option value="single" <?php selected($display_type, 'single'); ?>>Show on single line </option>
                                                                <option value="multiple" <?php selected($display_type, 'multiple'); ?>>Show on multiple line </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="ap-multiple-select" <?php if ( $field_array[ 'textbox_type' ] != 'select' ) { ?>style="display:none"<?php } ?>>
                                                    <label><?php _e('Multiple Select', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-checkbox">
                                                        <input type="checkbox" name="form_fields[<?php echo $field_title; ?>][multiple_select]" value='1' <?php if ( isset($field_array[ 'multiple_select' ]) && $field_array[ 'multiple_select' ] == 1 ) { ?>checked="checked"<?php } ?>/>
                                                        <div class="ap-pro-notes ap-option-width"><?php _e('Check if you want to allow users to select multiple items by pressing control or command key', 'anonymous-post-pro'); ?></div>
                                                    </div>

                                                </li>
                                                <li>
                                                    <label><?php _e('Field Notes', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-select">
                                                        <select name="form_fields[<?php echo $field_title ?>][notes_type]">
                                                            <option value="0" <?php if ( $field_array[ 'notes_type' ] == '0' ) { ?>selected="selected"<?php } ?>><?php _e('Don\'t Show', 'anonymous-post-pro'); ?></option>
                                                            <option value="icon" <?php if ( $field_array[ 'notes_type' ] == 'icon' ) { ?>selected="selected"<?php } ?>><?php _e('Show as info icon', 'anonymous-post-pro'); ?></option>
                                                            <option value="tooltip" <?php if ( $field_array[ 'notes_type' ] == 'tooltip' ) { ?>selected="selected"<?php } ?>><?php _e('Show as tooltip', 'anonymous-post-pro'); ?></option>
                                                        </select>
                                                    </div>
                                                </li>
                                                <li>
                                                    <label><?php _e('Field Notes Text', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-textbox">
                                                        <input type="text" name="form_fields[<?php echo $field_title; ?>][notes]" value="<?php echo $field_array[ 'notes' ] ?>"/>
                                                        <div class="ap-pro-notes"><?php _e('These are extra notes for the front form fields', 'anonymous-post-pro'); ?></div>
                                                    </div>

                                                </li>
                                                <li>
                                                    <label><?php _e('Field Class', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-textbox">
                                                        <input type="text" name="form_fields[<?php echo $field_title; ?>][field_class]" value="<?php echo isset($field_array[ 'field_class' ]) ? $field_array[ 'field_class' ] : ''; ?>"/>

                                                    </div>

                                                </li>
                                                <li>
                                                    <label><?php _e('Frontend Display', 'anonymous-post-pro'); ?></label>
                                                    <div class="ap-pro-checkbox">
                                                        <input type="checkbox" name="form_fields[<?php echo $field_title; ?>][frontend_show]" value='1' <?php if ( isset($field_array[ 'frontend_show' ]) && $field_array[ 'frontend_show' ] == 1 ) { ?>checked="checked"<?php } ?> class="ap-frontend-show-checkbox"/>
                                                        <div class="ap-option-note"><?php _e('Check if you want to show this custom field value in the frontend post.', 'anonymous-post-pro'); ?></div>
                                                    </div>
                                                    <?php
                                                    if ( isset($field_array[ 'frontend_show' ]) ) {
                                                        if ( $field_array[ 'frontend_show' ] == 0 ) {
                                                            $frontend_display_reference = 'style="display:none"';
                                                        } else {
                                                            $frontend_display_reference = '';
                                                        }
                                                    } else {
                                                        $frontend_display_reference = 'style="display:none"';
                                                    }
                                                    ?>
                                                    <div class="ap-frontend-display-reference" <?php echo $frontend_display_reference; ?>>
                                                        <ul>
                                                            <li>
                                                                <label><?php _e('Frontend Display Label', 'anonymous-post-pro'); ?></label>
                                                                <div class="ap-pro-checkbox">
                                                                    <input type="text" name="form_fields[<?php echo $field_title; ?>][frontend_show_label]" value="<?php echo (isset($field_array[ 'frontend_show_label' ])) ? $field_array[ 'frontend_show_label' ] : ''; ?>"/>
                                                                    <div class="ap-pro-notes ap-option-width"><?php _e('Label to be shown in frontend', 'anonymous-post-pro'); ?></div>
                                                                </div>
                                                            </li>
                                                            <li class="ap-pro-file-reference" <?php if ( $field_array[ 'textbox_type' ] != 'file_uploader' ) { ?>style="display: none;"<?php } ?>>
                                                                <label><?php _e('Show as link', 'anonymous-post-pro'); ?></label>
                                                                <div class="ap-pro-checkbox">
                                                                    <input type="checkbox" name="form_fields[<?php echo $field_title; ?>][show_link]" value='1' <?php if ( isset($field_array[ 'show_link' ]) && $field_array[ 'show_link' ] == 1 ) { ?>checked="checked"<?php } ?>/>
                                                                    <div class="ap-option-note"><?php _e('Check if you want to show the url as link.', 'anonymous-post-pro'); ?></div>
                                                                </div>
                                                            </li>
                                                            <li class="ap-pro-file-reference" <?php if ( $field_array[ 'textbox_type' ] != 'file_uploader' ) { ?>style="display: none;"<?php } ?>>
                                                                <label><?php _e('Image Dimensions', 'anonymous-post-pro'); ?></label>
                                                                <div class="ap-pro-textbox ap-half-textbox">
                                                                    <input type="text" name="form_fields[<?php echo $field_title; ?>][image_width]" value='<?php
                                                                    if ( isset($field_array[ 'image_width' ]) ) {
                                                                        echo $field_array[ 'image_width' ];
                                                                    }
                                                                    ?>' placeholder="eg. 100px"/>
                                                                    <input type="text" name="form_fields[<?php echo $field_title; ?>][image_height]" value='<?php
                                                                    if ( isset($field_array[ 'image_height' ]) ) {
                                                                        echo $field_array[ 'image_height' ];
                                                                    }
                                                                    ?>' placeholder="eg. 100px"/>
                                                                    <div class="ap-option-note ap-option-width"><?php _e('Note: Height and width will only work for images file types.', 'anonymous-post-pro'); ?></div>
                                                                </div>
                                                            </li>
                                                            <li class="ap-pro-file-reference" <?php if ( $field_array[ 'textbox_type' ] != 'file_uploader' ) { ?>style="display: none;"<?php } ?>>
                                                                <label><?php _e('Open as lightbox', 'anonymous-post-pro'); ?></label>
                                                                <div class="ap-pro-checkbox">
                                                                    <input type="checkbox" name="form_fields[<?php echo $field_title; ?>][lightbox]" value='1' <?php if ( isset($field_array[ 'lightbox' ]) && $field_array[ 'lightbox' ] == 1 ) { ?>checked="checked"<?php } ?>/>
                                                                    <div class="ap-option-note"><?php _e('Check if you want to open image in lightbox.', 'anonymous-post-pro'); ?></div>
                                                                    <div class="ap-option-note ap-option-width"><?php _e('Note: This will only work for image file type', 'anonymous-post-pro'); ?></div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>


                                            </ul>
                                            <input type="hidden" name="form_field_order[]" value="<?php echo $field_title; ?>|custom"/>
                                            <input type="hidden" name="form_fields[<?php echo $field_title; ?>][field_type]" value="custom"/>
                                            <input type="hidden" name="form_fields[<?php echo $field_title; ?>][custom_label]" value="<?php echo $field_array[ 'custom_label' ]; ?>"/>
                                        </div>
                                    </li>
                                    <?php
                                    break;
                            }//main switch case ends
                        }//foreach ends
                        ?>
                        <?php /*
                          include_once('form-fields-html.php');
                         */ ?>
                    </ul>
                    <div class="ap-option-note ap-option-width"><?php _e('Post Title and Post Content are mandatory.', 'anonymous-post-pro'); ?></div>

                </div><!--ap-form-configuration-wrapper-->
            </div><!--ap-option-wrapper-->
        </div>



    </div><!--Form Configurations-->
    <div class="line"></div>
    <!--Form Labels-->
    <div class="ap-form-labels">
        <h3><?php _e('Form Extra Settings', 'anonymous-post-pro'); ?></h3>
        <div class="ap-tab-wrapper">
            <div class="ap-option-wrapper">
                <label><?php _e('Post Categories', 'anonymous-post-pro'); ?></label>
                <div class="ap-option-field">
                    <select name="post_category[]" multiple="multiple">
                        <?php
                        if ( isset($ap_settings[ 'post_category' ]) ) {
                            if ( !is_array($ap_settings[ 'post_category' ]) ) {
                                $post_categories = array( $ap_settings[ 'post_category' ] );
                            } else {
                                $post_categories = $ap_settings[ 'post_category' ];
                            }
                        } else {
                            $post_categories = array();
                        }

                        echo $this->get_terms_for_category_drodown($ap_settings[ 'post_type' ], $post_categories);
                        ?>
                    </select>
                    <div class="ap-option-note ap-option-width"><?php _e('Choose any  only if you don\'t include to show the category selecting options in the form', 'anonymous-post-pro'); ?></div>
                </div>
            </div>
        </div>
        <div class="ap-tab-wrapper">
            <div class="ap-option-wrapper">
                <label><?php _e('Terms and Agreement', 'anonymous-post-pro'); ?></label>
                <div class="ap-option-field">
                    <input type="checkbox" name="terms_agreement" value="1" <?php echo (isset($ap_settings[ 'terms_agreement' ]) && $ap_settings[ 'terms_agreement' ] == 1) ? 'checked="checked"' : ''; ?>/>
                    <div class="ap-option-note"><?php _e('Check if you want to show the terms and agreement text at the end of the form', 'anonymous-post-pro'); ?></div>
                </div>

            </div>
        </div>
        <div class="ap-tab-wrapper">
            <div class="ap-option-wrapper">
                <label class="ap-terms-required-msg-label"><?php _e('Terms and Agreement Required Message', 'anonymous-post-pro'); ?></label>
                <div class="ap-option-field">
                    <input type="text" name="terms_agreement_message" value="<?php echo (isset($ap_settings[ 'terms_agreement_message' ])) ? esc_attr($ap_settings[ 'terms_agreement_message' ]) : ''; ?>"/>
                    <div class="ap-option-note ap-option-width"><?php _e('Message to be displayed if agreement is not checked before submitting form', 'anonymous-post-pro'); ?></div>
                </div>
            </div>
        </div>
        <div class="ap-tab-wrapper">
            <div class="ap-option-wrapper">
                <label><?php _e('Terms and Agreement Text', 'anonymous-post-pro'); ?></label>
                <div class="ap-option-field">
                    <textarea name='terms_agreement_text' rows='10'><?php echo (isset($ap_settings[ 'terms_agreement_text' ])) ? $ap_settings[ 'terms_agreement_text' ] : ''; ?></textarea>
                </div>
            </div>
            <div class="ap-pro-extra-note">
                <?php _e('Note: You can use basic html tags such as anchor links, strong, em,  ul li etc in Terms and Agreement Text.', 'anonymous-post-pro'); ?>
            </div>
        </div>
        <!--Submit Button-->
        <div class="ap-tab-wrapper">
            <div class="ap-option-wrapper">
                <label><?php _e('Submit Button Label', 'anonymous-post-pro'); ?></label>
                <div class="ap-option-field">
                    <input type="text" name="post_submit_label" value="<?php echo $ap_settings[ 'post_submit_label' ]; ?>"/>
                </div>
            </div>
        </div>
        <!--Submit Button-->
    </div><!--ap-form-label-->
    <!--Form Labels-->



</div>