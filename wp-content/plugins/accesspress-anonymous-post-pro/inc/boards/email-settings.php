<div class="ap-tabs-board" id="board-email-settings" style="display: none;">
    <h2><?php _e( 'Email Settings', 'anonymous-post-pro' ); ?></h2>
    <div class="ap-tab-wrapper">
        <div class="ap-option-wrapper">
            <label class="ap-check-login"><?php _e( 'Admin Notification:', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <div class="ap-option-checkbox-field"><div class="ap-checkbox-form"><input type="checkbox" name="admin_notification" value="1" <?php if ( $ap_settings['admin_notification'] == '1' ) { ?>checked="checked"<?php } ?>/></div>
                    <div class="ap-option-note"><?php _e( 'Check if you want admin to recieve notification email after submitting of a new post.', 'anonymous-post-pro' ); ?></div>
                </div>
                <div class="ap-admin-email-list">
                    <?php
                    if ( !empty( $ap_settings['admin_email_list'] ) ) {
                        foreach ( $ap_settings['admin_email_list'] as $email ) {
                            ?>
                            <div class="ap-each-admin-email"><input type="text" name="admin_email_list[]" value="<?php echo $email ?>" placeholder="Enter email address"/><span class="ap-remove-email-btn">X</span></div>
                            <?php
                        }//foreach ends
                    }//if ends
                    ?>
                </div>
                <div class="ap-admin-email-add-btn" <?php if ( count( $ap_settings['admin_email_list'] ) >= 3 ) { ?>style="display:none;"<?php } ?>>
                    <input type="button" value="Add Email Address" class="button primary-button" id="ap-admin-email-add-trigger"/></div>
                <input type="hidden" id="ap-admin-email-counter" value="<?php echo count( $ap_settings['admin_email_list'] ); ?>"/>
                <div class="ap-option-note ap-option-width"><?php _e( 'Add upto 3 extra email address for the admin notification.Only Site Admin will recieve notification if you don\'t add any.', 'anonymous-post-pro' ); ?></div>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Admin Notification Subject', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <input type="text" name="admin_notification_subject" placeholder="<?php _e( 'New Post Submission', 'anonymous-post-pro' ); ?>" value="<?php echo isset( $ap_settings['admin_notification_subject'] ) ? esc_attr( $ap_settings['admin_notification_subject'] ) : ''; ?>"/>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Admin Notification From Name', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <input type="text" name="admin_notification_from_name" placeholder="<?php echo get_option( 'blogname' ); ?>" value="<?php echo isset( $ap_settings['admin_notification_from_name'] ) ? esc_attr( $ap_settings['admin_notification_from_name'] ) : ''; ?>"/>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Admin Notification From Email', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <input type="text" name="admin_notification_from_email" value="<?php echo isset( $ap_settings['admin_notification_from_email'] ) ? esc_attr( $ap_settings['admin_notification_from_email'] ) : ''; ?>" placeholder="noreply@yourhost.com"/>
                <div class="ap-option-note ap-option-width"><?php _e( 'Please use an email that most of email domain won\'t consider as spam email such as noreply@yourhost.com or leave blank to use a default one.', 'anonymous-post-pro' ); ?></div>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Admin Notification Message', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <textarea rows="10" cols="41" name="admin_notification_message"><?php
                    if ( $ap_settings['admin_notification_message'] == '' ) {
                        _e( 'Hello There,
          
A new post has been submitted via AccessPress Anonymous post plugin in your ' . esc_attr( get_bloginfo( 'name' ) ) . ' website. Please find details below:
            
Post Title: #post_title

_____

To take action (approve/reject) - please go here:
#post_admin_link
            
Thank you'
                                , 'anonymous-post-pro' );
                    } else {
                        echo $this->output_converting_br( $ap_settings['admin_notification_message'] );
                    }
                    ?></textarea>
                <div class="ap-option-note ap-option-width"><?php _e( 'You can use #post_title,#post_admin_link,#post_author_name,#post_author_email,#post_author_url codes in the above message to get the respective values in the email.', 'anonymous-post-pro' ); ?></div>
            </div>

        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'User Notification', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <div class="ap-option-checkbox-field">
                    <div class="ap-checkbox-form"><input type="checkbox" name="user_notification" value="1" <?php if ( isset( $ap_settings['user_notification'] ) && $ap_settings['user_notification'] == 1 ) { ?>checked="checked"<?php } ?>/></div>
                    <div class="ap-option-note"><?php _e( 'Check if you want to notify guest author via email after the post is published .', 'anonymous-post-pro' ); ?></div>
                </div>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'User Notification Subject', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <input type="text" name="user_notification_subject" placeholder="<?php _e( 'Post Published', 'anonymous-post-pro' ); ?>"  value="<?php echo isset( $ap_settings['user_notification_subject'] ) ? esc_attr( $ap_settings['user_notification_subject'] ) : ''; ?>"/>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'User Notification From Name', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <input type="text" name="user_notification_from_name" placeholder="<?php echo get_option( 'blogname' ); ?>" value="<?php echo isset( $ap_settings['user_notification_from_name'] ) ? esc_attr( $ap_settings['user_notification_from_name'] ) : ''; ?>"/>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'User Notification From Email', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <input type="text" name="user_notification_from_email" value="<?php echo isset( $ap_settings['user_notification_from_email'] ) ? esc_attr( $ap_settings['user_notification_from_email'] ) : ''; ?>" placeholder="noreply@yourhost.com"/>
                <div class="ap-option-note ap-option-width"><?php _e( 'Please use an email that most of email domain won\'t consider as spam email such as noreply@yourhost.com or leave blank to use a default one.', 'anonymous-post-pro' ); ?></div>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'User Notification Message', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <?php
                $user_notification_message = $this->output_converting_br( $ap_settings['user_notification_message'] );
                ?>
                <textarea name="user_notification_message" rows="10" cols="41"><?php
                    if ( $user_notification_message == '' ) {
                        _e( 'Hello There,
          
Your post has been published in ' . get_bloginfo( 'name' ) . ' website. Please find details below:
            
Post Title: #post_title

_____

 To view your post in the site - please go here:
#post_link
            
Thank you'
                                , 'anonymous-post-pro' );
                    } else {
                        echo $user_notification_message;
                    }
                    ?></textarea>
                <div class="ap-option-note"><?php _e( 'Message sent to guest author after post published by admin.', 'anonymous-post-pro' ); ?></div><br /><br />
                <div class="ap-option-note ap-option-width"><?php _e( '<b>Note:</b>You can use #post_title,#post_link for sending respective values in the email.The email will only be sent to guest author if author email is also recieved from post submission form.', 'anonymous-post-pro' ); ?></div>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Post Rejection Notification', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <div class="ap-option-checkbox-field">
                    <div class="ap-checkbox-form"><input type="checkbox" name="post_reject_notification" value="1" <?php if ( isset( $ap_settings['post_reject_notification'] ) && $ap_settings['post_reject_notification'] == 1 ) { ?>checked="checked"<?php } ?>/></div>
                    <div class="ap-option-note"><?php _e( 'Check if you want to notify guest author via email after the post is rejected or trashed .', 'anonymous-post-pro' ); ?></div>
                </div>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Post Rejection Notification Subject', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <input type="text" name="post_reject_notification_subject" placeholder="<?php _e( 'Post Rejected', 'anonymous-post-pro' ); ?>"  value="<?php echo isset( $ap_settings['post_reject_notification_subject'] ) ? esc_attr( $ap_settings['post_reject_notification_subject'] ) : ''; ?>"/>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Post Rejection Notification From Name', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <input type="text" name="post_reject_notification_from_name" placeholder="<?php echo get_option( 'blogname' ); ?>" value="<?php echo isset( $ap_settings['post_reject_notification_from_name'] ) ? esc_attr( $ap_settings['post_reject_notification_from_name'] ) : ''; ?>"/>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Post Rejection Notification From Email', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <input type="text" name="post_reject_notification_from_email" value="<?php echo isset( $ap_settings['post_reject_notification_from_email'] ) ? esc_attr( $ap_settings['post_reject_notification_from_email'] ) : ''; ?>" placeholder="noreply@yourhost.com"/>
                <div class="ap-option-note ap-option-width"><?php _e( 'Please use an email that most of email domain won\'t consider as spam email such as noreply@yourhost.com or leave blank to use a default one.', 'anonymous-post-pro' ); ?></div>
            </div>
        </div>
        <div class="ap-option-wrapper">
            <label><?php _e( 'Post Rejection Notification Message', 'anonymous-post-pro' ); ?></label>
            <div class="ap-option-field">
                <?php
                $post_reject_notification_message = isset($ap_settings['post_reject_notification_message'])?$this->output_converting_br( $ap_settings['post_reject_notification_message'] ):'';
                ?>
                <textarea name="post_reject_notification_message" rows="10" cols="41"><?php
                    if ( $post_reject_notification_message == '' ) {
                        _e( 'Hello There,
          
Your post has been rejected in ' . get_bloginfo( 'name' ) . ' website. Please find details below:
            
Post Title: #post_title
            
Thank you'
                                , 'anonymous-post-pro' );
                    } else {
                        echo $post_reject_notification_message;
                    }
                    ?></textarea>
                <div class="ap-option-note"><?php _e( 'Message sent to guest author after post is rejected or trashed by admin.', 'anonymous-post-pro' ); ?></div><br /><br />
                <div class="ap-option-note ap-option-width"><?php _e( '<b>Note:</b>You can use #post_title for sending post title in the email.The email will only be sent to guest author if author email is also recieved from post submission form.', 'anonymous-post-pro' ); ?></div>
            </div>
        </div>


    </div>
</div>