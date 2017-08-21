<?php 
$ap_pro_extra_settings = get_option('ap_pro_extra_settings'); 
//$this->print_array($ap_pro_extra_settings);
?>
<div class="ap-settings-wrapper wrap">
    <div class="ap-settings-header">
        <div class="ap-logo">
            <img src="<?php echo AP_PRO_IMAGE_DIR; ?>/logo.png" alt="<?php esc_attr_e('AccessPress Anonymous Post Pro', 'anonymous-post-pro'); ?>" />
        </div>

        <div class="ap-socials">
            <p><?php _e('Follow us for new updates', 'anonymous-post-pro') ?></p>
            <div class="social-bttns">

                <iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FAccessPress-Themes%2F1396595907277967&amp;width&amp;layout=button&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=35&amp;appId=1411139805828592" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:20px; width:50px " allowTransparency="true"></iframe>
                &nbsp;&nbsp;
                <a href="https://twitter.com/apthemes" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @apthemes</a>
                <script>!function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (!d.getElementById(id)) {
                            js = d.createElement(s);
                            js.id = id;
                            js.src = "//platform.twitter.com/widgets.js";
                            fjs.parentNode.insertBefore(js, fjs);
                        }
                    }(document, "script", "twitter-wjs");</script>

            </div>
        </div>

        <div class="ap-title"><?php _e('AccessPress Anonymous Post Pro Settings', 'anonymous-post-pro'); ?></div>
    </div>
    <?php if (isset($_SESSION['ap_message'])) { ?>
        <div id="messages" class="update" style="margin-bottom: 10px;">
            <?php
            echo $_SESSION['ap_message'];
            unset($_SESSION['ap_message']);
            ?>
        </div>
    <?php } ?>

    <div class="aps-panel-body">
        <div id="optionsframework1" class="postbox1 ap-extra-settings-wrap">
            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                <input type="hidden" name="action" value="ap_extra_settings_action"/>
                <?php echo wp_nonce_field('ap_extra_setting_nonce', 'ap_extra_setting_nonce_field')?>
                <div class="ap-option-wrapper">
                    <label><?php _e('Disable Lightbox', 'anonymous-post-pro'); ?></label>
                    <div class="ap-option-field">
                        <div class="ap-option-checkbox-field">
                            <div class="ap-checkbox-form">
                                <input type="checkbox" name="lightbox_disable" value="1" <?php echo (isset($ap_pro_extra_settings['lightbox_disable']) && $ap_pro_extra_settings['lightbox_disable']) ? 'checked="checked"' : ''; ?>>
                            </div>
                            <div class="ap-option-note">
                                <?php _e('Check if you want to disable lightbox in this plugin.', 'anonymous-post-pro'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ap-option-wrapper">
                    <label><?php _e('Disable Jquery UI', 'anonymous-post-pro'); ?></label>
                    <div class="ap-option-field">
                        <div class="ap-option-checkbox-field">
                            <div class="ap-checkbox-form">
                                <input type="checkbox" name="jquery_ui_disable" value="1" <?php echo (isset($ap_pro_extra_settings['jquery_ui_disable']) && $ap_pro_extra_settings['jquery_ui_disable']) ? 'checked="checked"' : ''; ?>>
                            </div>
                            <div class="ap-option-note">
                                <?php _e('Check if you want to disable jquery UI in this plugin.', 'anonymous-post-pro'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ap-option-wrapper">
                    <div class="ap-option-field">
                        <input type="submit" name="ap_save_extra_settings" value="<?php _e('Save Changes','anonymous-post-pro');?>" class="button-primary"/>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>