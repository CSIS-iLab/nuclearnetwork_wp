<div class="ap-tabs-board" id="board-general-settings">
    <h2><?php _e( 'General Settings', 'anonymous-post-pro' ); ?></h2>
    <div class="ap-tab-wrapper">
        <div class="ap-option-wrapper">
            <label><?php _e( 'Form Title', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <input type="text" name="form_title" value="<?php echo $ap_settings['form_title']; ?>"/>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Post Publish Status:', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <select name="publish_status">
                    <option value="publish" <?php if ( $ap_settings['publish_status'] == 'publish' ) { ?>selected="selected"<?php } ?>>Publish</option>
                    <option value="pending" <?php if ( $ap_settings['publish_status'] == 'pending' ) { ?>selected="selected"<?php } ?>>Pending</option>
                    <option value="draft" <?php if ( $ap_settings['publish_status'] == 'draft' ) { ?>selected="selected"<?php } ?>>Draft</option>
                    <option value="private" <?php if ( $ap_settings['publish_status'] == 'private' ) { ?>selected="selected"<?php } ?>>Private</option>
                </select>
            </div>
        </div>
        <?php
        if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {

            $languages = icl_get_languages( 'skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str' );
            ?>
            <div class="ap-option-wrapper">
                <label><?php _e( 'Choose Language', 'anonymous-post-pro' ); ?></label>
                <div class="ap-option-field">
                    <select name="language_code">
                        <?php
                        global $sitepress;
                        $default_language = $sitepress->get_default_language();
                        $selected_language = isset( $ap_settings['language_code'] ) ? $ap_settings['language_code'] : $default_language;
                        if ( count( $languages ) > 0 ) {
                            foreach ( $languages as $language_code => $language ) {
                                ?>
                                <option value="<?php echo $language_code; ?>" <?php selected( $language_code, $selected_language ); ?>><?php echo $language['translated_name']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Post Format:', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <select name="post_format">
                    <?php
                    $ap_post_format = isset( $ap_settings['post_format'] ) ? $ap_settings['post_format'] : 'none';
                    ?>
                    <option value="none" <?php selected( $ap_post_format, 'none' ); ?>><?php _e( 'Standard', 'anonymous-post-pro' ); ?></option>
                    <?php
                    if ( current_theme_supports( 'post-formats' ) ) {
                        $post_formats = get_theme_support( 'post-formats' );
                        //$this->print_array($post_formats);
                        if ( is_array( $post_formats[0] ) ) {
                            foreach ( $post_formats[0] as $post_format ) {
                                ?>
                                <option value="<?php echo $post_format; ?>" <?php selected( $ap_post_format, $post_format ); ?>><?php echo $post_format; ?></option>
                                <?php
                            }
                            // Array( supported_format_1, supported_format_2 ... )
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Submit post as:', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <?php $post_types = $this->get_registered_post_types(); ?> 
                <select name="post_type">
                    <?php
                    foreach ( $post_types as $post_type ) {
                        ?>
                        <option value="<?php echo $post_type; ?>" <?php if ( $ap_settings['post_type'] == $post_type ) { ?>selected="selected"<?php } ?>><?php echo ucfirst( $post_type ); ?></option>            
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="ap-option-wrapper">
            <label class="ap-check-login"><?php _e( 'Check Login', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <div class="ap-option-checkbox-field">
                    <div class="ap-checkbox-form"><input type="checkbox" name="login_check" value="1" <?php if ( $ap_settings['login_check'] == 1 ) { ?>checked="checked"<?php } ?>/></div>
                    <div class="ap-option-note"><?php _e( 'Check if you want admin login to submit a new post.', 'anonymous-post-pro' ); ?></div>
                </div>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Login Type', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <div class="ap-option-checkbox-field">
                    <div class="ap-checkbox-form">
                        <div class="ap-row-half"><label class="ap-pro-plain-label"><input type="radio" name="login_type" value="login_message" <?php if ( $ap_settings['login_type'] == 'login_message' ) { ?>checked="checked"<?php } ?> class="ap-login-type"/><span>Show Login Message</span></label></div>
                        <div class="ap-row-half"><label class="ap-pro-plain-label"><input type="radio" name="login_type" value="login_form" <?php if ( $ap_settings['login_type'] == 'login_form' ) { ?>checked="checked"<?php } ?> class="ap-login-type"/><span>Show Login Form</span></label></div>
                    </div>
                    <div class="ap-option-note ap-option-width"><?php _e( 'Choose any one if you have enabled login check to submit the post', 'anonymous-post-pro' ); ?></div>
                </div>
            </div>
        </div>
        <div class="ap-login-type-wrapper" <?php if ( $ap_settings['login_type'] != 'login_message' ) { ?>style="display:none"<?php } ?>>
            <div class="ap-option-wrapper">
                <label><?php _e( 'Login Message', 'anonymous-post-pro' ); ?></label>
                <div class="ap-option-field">
                    <?php
                    if ( isset( $ap_settings['login_message'] ) ) {
                        $login_message = $this->output_converting_br( $ap_settings['login_message'] );
                    } else {
                        $login_message = '';
                    }
                    ?>
                    <textarea name="login_message" rows="10" cols="41" placeholder="<?php _e( 'Please login to submit the post', 'anonymous-post-pro' ) ?>"><?php echo $login_message; ?></textarea>
                </div>
            </div>
            <div class="ap-option-wrapper">
                <label><?php _e( 'Login Link Text', 'anonymous-post-pro' ); ?></label>
                <div class="ap-option-field">
                    <input type="text" name="login_link_text" value="<?php echo isset( $ap_settings['login_link_text'] ) ? esc_attr( $ap_settings['login_link_text'] ) : ''; ?>" placeholder="<?php _e( 'Login', 'anonymous-post-pro' ); ?>"/>
                </div> 
            </div>
            <div class="ap-option-wrapper">
                <label><?php _e( 'Login Link URL', 'anonymous-post-pro' ); ?></label>
                <div class="ap-option-field">
                    <input type="text" name="login_link_url" value="<?php echo isset( $ap_settings['login_link_url'] ) ? esc_attr( $ap_settings['login_link_url'] ) : ''; ?>" placeholder="<?php echo site_url( 'login' ); ?>"/>
                    <div class="ap-option-note ap-option-width"><?php _e( 'Please leave blank to provide the default login link of backend', 'anonymous-post-pro' ); ?></div>
                </div> 
            </div>
        </div>
        <div class="ap-login-form-wrapper" <?php if ( $ap_settings['login_type'] != 'login_form' ) { ?>style="display:none"<?php } ?>>
            <div class="ap-option-wrapper">
                <label><?php _e( 'Username Label', 'anonymous-post-pro' ); ?></label>
                <div class="ap-option-field">
                    <input type="text" name="username_label" value="<?php echo isset( $ap_settings['username_label'] ) ? esc_attr( $ap_settings['username_label'] ) : ''; ?>"/>
                </div>
            </div>
            <div class="ap-option-wrapper">
                <label><?php _e( 'Password Label', 'anonymous-post-pro' ); ?></label>
                <div class="ap-option-field">
                    <input type="text" name="password_label" value="<?php echo isset( $ap_settings['password_label'] ) ? esc_attr( $ap_settings['password_label'] ) : ''; ?>"/>
                </div> 
            </div>
            <div class="ap-option-wrapper">
                <label><?php _e( 'Login Button Label', 'anonymous-post-pro' ); ?></label>
                <div class="ap-option-field">
                    <input type="text" name="login_button_label" value="<?php echo isset( $ap_settings['login_button_label'] ) ? esc_attr( $ap_settings['login_button_label'] ) : ''; ?>"/>
                </div> 
            </div>

        </div>
        <div class="ap-option-wrapper">
            <label class="ap-check-login"><?php _e( 'Auto Fill Logged in Author Details:', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <div class="ap-option-checkbox-field">
                    <div class="ap-checkbox-form"><input type="checkbox" name="auto_author_details" value="1" <?php if ( isset( $ap_settings['auto_author_details'] ) && $ap_settings['auto_author_details'] == '1' ) { ?>checked="checked"<?php } ?>/></div>
                    <div class="ap-option-note"><?php _e( 'Check if you want to auto fill logged in author details', 'anonymous-post-pro' ); ?></div>
                </div>
            </div>
        </div><!--ap-option-wrapper-->
        <div class="ap-option-wrapper">
            <label class="ap-check-login"><?php _e( 'Anonymous Image Upload', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <div class="ap-option-checkbox-field">
                    <div class="ap-checkbox-form"><input type="checkbox" name="anonymous_image_upload" value="1" <?php if ( isset( $ap_settings['anonymous_image_upload'] ) && $ap_settings['anonymous_image_upload'] == 1 ) { ?>checked="checked"<?php } ?>/></div>
                    <div class="ap-option-note"><?php _e( 'Check if you want to allow the guest visitors to upload images in the post content editor', 'anonymous-post-pro' ); ?></div>
                </div>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label class="ap-check-login"><?php _e( 'Link to source url', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <div class="ap-option-checkbox-field">
                    <div class="ap-checkbox-form"><input type="checkbox" name="link_source_url" value="1" <?php if ( isset( $ap_settings['link_source_url'] ) && $ap_settings['link_source_url'] == 1 ) { ?>checked="checked"<?php } ?>/></div>
                    <div class="ap-option-note"><?php _e( 'Check if you want to link the anonymously uploaded image file to its source', 'anonymous-post-pro' ); ?></div>
                </div>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label class="ap-check-login"><?php _e( 'Add Lightbox Rel Attribute', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <div class="ap-option-checkbox-field">
                    <div class="ap-checkbox-form"><input type="checkbox" name="lightbox_rel_attr" value="1" <?php if ( isset( $ap_settings['lightbox_rel_attr'] ) && $ap_settings['lightbox_rel_attr'] == 1 ) { ?>checked="checked"<?php } ?>/></div>
                    <div class="ap-option-note ap-option-width"><?php _e( 'Check if you want to add rel="lightbox" parameter in the added source link of the anonymously uploaded image. Please check Link to source URL too to use this feature.', 'anonymous-post-pro' ); ?></div>
                </div>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Anonymous Image Max Upload Size', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <input type="text" name="ap_image_max_upload_size" value="<?php echo isset( $ap_settings['ap_image_max_upload_size'] ) ? $ap_settings['ap_image_max_upload_size'] : ''; ?>" placeholder="eg: 2"/>
                <div class="ap-option-note ap-option-width"><?php _e( 'Please enter the maximum allowed upload image size in MB for anonymous user.Default is 2 MB', 'anonymous-post-pro' ); ?></div>
            </div> 
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Media Upload', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <div class="ap-option-checkbox-field">
                    <div class="ap-checkbox-form">
                        <input type="checkbox" name="media_upload" value="1" <?php if ( isset( $ap_settings['media_upload'] ) && $ap_settings['media_upload'] == 1 ) { ?>checked="checked"<?php } ?>/>
                        <div class="ap-option-note"><?php _e( 'Check if you want to allow the logged in users to upload media in the rich/visual editor', 'anonymous-post-pro' ); ?></div>
                        <div class="ap-option-note ap-option-width"><?php _e( 'Please note that the Add Media button will only show for the users with the upload_files Capability such as Administrator and Editor. Please check <a href="https://codex.wordpress.org/Roles_and_Capabilities#Capability_vs._Role_Table" target="_blank">here</a> for more details.', 'anonymous-post-pro' ); ?></div>
                    </div>

                </div>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Assign Author', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <select name="post_author">
                    <?php
                    $users = get_users();
                    foreach ( $users as $user ) {
                        ?>
                        <option value="<?php echo $user->ID; ?>" <?php if ( $ap_settings['post_author'] == $user->ID ) { ?>selected="selected"<?php } ?>><?php echo $user->data->user_nicename; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label class="ap-check-login"><?php _e( 'Logged in User as Author', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <div class="ap-option-checkbox-field">
                    <div class="ap-checkbox-form"><input type="checkbox" name="logged_user_author" value="1" <?php
                        if ( isset( $ap_settings['logged_user_author'] ) ) {
                            checked( $ap_settings['logged_user_author'], true );
                        }
                        ?>/></div>
                    <div class="ap-option-note ap-option-width"><?php _e( 'Check if you want to assign logged in user as the author of a new post. If not logged in, above assigned author will be default author.', 'anonymous-post-pro' ); ?></div>
                </div>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Redirect Type', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <?php $redirect_type = isset( $ap_settings['redirect_type'] ) ? $ap_settings['redirect_type'] : 'url'; ?>
                <label class="ap-pro-plain-label"><input type="radio" name="redirect_type" value="url" <?php checked( $redirect_type, 'url' ); ?>/><?php _e( 'Redirect to URL', 'anonymous-post-pro' ); ?></label>
                <label  class="ap-pro-plain-label"><input type="radio" name="redirect_type" value="new" <?php checked( $redirect_type, 'new' ); ?>/><?php _e( 'Redirect to newly created posts/page', 'anonymous-post-pro' ); ?></label>
                <div class="ap-option-note ap-option-width"><?php _e( 'Note: Redirect to newly created posts/page will only work if you have set the post publish status to publish.', 'anonymous-post-pro' ); ?></div>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Redirect URL', 'anonymous-post-pro' ) ?></label>
            <div class="ap-option-field">
                <input type="text" name="redirect_url" value="<?php echo $ap_settings['redirect_url']; ?>"/>
                <div class="ap-option-note ap-option-width"><?php _e( 'URL to be redirected after successful post submission.If kept blank, it will be redirected to same page', 'anonymous-post-pro' ); ?></div>
            </div>

        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Post Submission Message', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <textarea name="post_submission_message" rows="10" cols="41"><?php echo $this->output_converting_br( $ap_settings['post_submission_message'] ); ?></textarea>
                <div class="ap-option-note  ap-option-width"><?php _e( 'Message displayed after successful post submission.', 'anonymous-post-pro' ); ?></div>
            </div>
        </div>
    </div>
</div>