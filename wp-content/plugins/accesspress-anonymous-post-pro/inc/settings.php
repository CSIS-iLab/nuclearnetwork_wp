<?php
/**
 * Get Settings from DB
 * */
global $ap_settings;
global $wpdb;

if ( isset($_GET[ 'form_id' ]) ) {
    $form_id = $_GET[ 'form_id' ];
    $table_name = $table_name = $wpdb->prefix . "ap_pro_forms";
    $forms = $wpdb->get_results("SELECT * FROM $table_name where ap_form_id = $form_id");
    $form = $forms[ 0 ];
    $ap_settings = $this->get_unserialized($form->form_details);
} else {
    $ap_settings = $this->get_default_settings();
}

//$this->print_array($ap_settings);
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

        <div class="ap-title"><?php
            if ( isset($_GET[ 'form_id' ]) ) {
                _e('Edit Anonymous Form', 'anonymous-post-pro');
            } else {
                _e('Add New Anonymous Form', 'anonymous-post-pro');
            }
            ?></div>
    </div>


    <?php if ( isset($_SESSION[ 'ap_message' ]) ) { ?>
        <div id="messages" class="update">
            <?php
            echo $_SESSION[ 'ap_message' ];
            unset($_SESSION[ 'ap_message' ]);
            ?>
        </div>
        <?php
    }
    if ( isset($_GET[ 'form_id' ]) ) {
        ?>

        <div class="ap-pro-shortcode-ref">
            <h3>Shortcode:</h3>
            <input type="text" readonly="readonly" value='[ap-form id="<?php echo $_GET[ 'form_id' ] ?>"]' onfocus="this.select();">
            <a href="<?php echo site_url() . '/?ap_preview=true&form_id=' . $_GET[ 'form_id' ]; ?>" target="_blank">
                <input type="button" class="button-primary" value="<?php _e('Preview', 'anonymous-post-pro'); ?>"/>
            </a>
            <p class="description"><?php _e('Please save your changes before preview', 'anonymous-post-pro'); ?></p>
        </div>

    <?php } ?>
    <ul class="ap-settings-tabs">
        <li><a href="javascript:void(0)" id="general-settings" class="ap-tabs-trigger ap-active-tab"><?php _e('General Settings', 'anonymous-post-pro') ?></a></li>
        <li><a href="javascript:void(0)" id="email-settings" class="ap-tabs-trigger"><?php _e('Email Settings', 'anonymous-post-pro') ?></a></li>
        <li><a href="javascript:void(0)" id="form-settings" class="ap-tabs-trigger"><?php _e('Form Settings', 'anonymous-post-pro'); ?></a></li>
        <li><a href="javascript:void(0)" id="captcha-settings" class="ap-tabs-trigger"><?php _e('Captcha Settings', 'anonymous-post-pro'); ?></a></li>
        <li><a href="javascript:void(0)" id="formstyle-settings" class="ap-tabs-trigger"><?php _e('Form Style Settings', 'anonymous-post-pro'); ?></a></li>
        <li><a href="javascript:void(0)" id="how_to_use-settings" class="ap-tabs-trigger"><?php _e('How to use', 'anonymous-post-pro'); ?></a></li>
        <li><a href="javascript:void(0)" id="about-settings" class="ap-tabs-trigger"><?php _e('About', 'anonymous-post-pro'); ?></a></li>
    </ul>

    <div class="metabox-holder">
        <div id="optionsframework" class="postbox">
            <form class="ap-settings-form" method="post" action="<?php echo admin_url() . 'admin-post.php' ?>">
                <input type="hidden" name="action" value="ap_settings_action"/>
                <input type="hidden" name="taxonomy_reference" value="<?php echo $ap_settings[ 'taxonomy_reference' ] ?>"/>
                <?php
                /**
                 * General Settings
                 * */
                include_once('boards/general-settings.php');
                ?>

                <?php
                /**
                 * Email Settings
                 * */
                include_once('boards/email-settings.php');
                ?>

                <?php
                /**
                 * Form Settings
                 * */
                include_once('boards/form-settings.php');
                ?>

                <?php
                /**
                 * Captcha Settings
                 * */
                include_once('boards/captcha-settings.php');
                ?>
                <?php
                /**
                 * Form Styles Settings
                 * */
                include_once('boards/form-styles.php');
                ?>
                <?php
                /**
                 * Form Styles Settings
                 * */
                include_once('boards/how-to-use.php');
                ?>
                <?php
                /**
                 * About Tab
                 * */
                include_once('boards/about.php');
                $restore_nonce = wp_create_nonce('ap-restore-default-nonce');
                ?>
                <div id="optionsframework-submit" class="ap-settings-submit">
                    <input type="submit" value="Save all changes" name="ap_settings_submit"/>
                    <?php if ( isset($_GET[ 'form_id' ]) ) { ?>

                        <a href="<?php echo site_url() . '/?ap_preview=true&form_id=' . $_GET[ 'form_id' ]; ?>" target="_blank">
                            <input type="button" class="button-primary" value="<?php _e('Preview', 'anonymous-post-pro'); ?>"/>
                        </a>
                        <a href="<?php echo admin_url() . '/admin-post.php?action=ap_restore_default_settings&form_id=' . $_GET[ 'form_id' ] . '&_wpnonce=' . $restore_nonce; ?>">
                            <input type="button" class="button ap-restore-default-settings" value="<?php _e('Restore Default Settings', 'anonymous-post-pro'); ?>" onclick="return confirm('Are you sure you want to restore default settings?', 'anonymous-post-pro');"/>
                        </a>
                        <p class="description"><?php _e('Please save your changes before preview', 'anonymous-post-pro'); ?></p>
                    <?php } ?>

                </div>
                <?php if ( isset($_GET[ 'form_id' ]) ) { ?>
                    <input type="hidden" value="<?php echo $_GET[ 'form_id' ]; ?>" name="ap_form_id"/>
                <?php } ?>
            </form>
            <div class="ap-extensions-clone" style="display: none;">
                <label>Choose File Extensions</label>
                <div class="ap-pro-fileuploader">
                    <label>Images:</label>
                    <ul>
                        <li><input type="checkbox" name="" value="jpg"/><span>jpg</span></li>
                        <li><input type="checkbox" name="" value="jpeg"/><span>jpeg</span></li>
                        <li><input type="checkbox" name="" value="png"/><span>png</span></li>
                        <li><input type="checkbox" name="" value="gif"/><span>gif</span></li>
                    </ul>
                </div>
                <div class="ap-pro-fileuploader">
                    <label>Documents:</label>
                    <ul>
                        <li><input type="checkbox" name="" value="pdf"/><span>pdf</span></li>
                        <li><input type="checkbox" name="" value="doc|docx"/><span>doc/docx</span></li>
                        <li><input type="checkbox" name="" value="xls|xlsx"/><span>xls/xlsx</span></li>
                        <li><input type="checkbox" name="" value="odt"/><span>odt</span></li>
                        <li><input type="checkbox" name="" value="ppt|pptx|pps|ppsx"/><span>ppt,pptx,pps,ppsx</span></li>
                    </ul>
                </div>
                <div class="ap-pro-fileuploader">
                    <label>Audio:</label>
                    <ul>
                        <li><input type="checkbox" name="" value="mp3"/><span>mp3</span></li>
                        <li><input type="checkbox" name="" value="mp4"/><span>mp4</span></li>
                        <li><input type="checkbox" name="" value="ogg"/><span>ogg</span></li>
                        <li><input type="checkbox" name="" value="wav"/><span>wav</span></li>
                    </ul>
                </div>
                <div class="ap-pro-fileuploader">
                    <label>Video:</label>
                    <ul>
                        <li><input type="checkbox" name="" value="mp4"/><span>mp4</span></li>
                        <li><input type="checkbox" name="" value="m4v"/><span>m4v</span></li>
                        <li><input type="checkbox" name="" value="mov"/><span>mov</span></li>
                        <li><input type="checkbox" name="" value="wmv"/><span>wmv</span></li>
                        <li><input type="checkbox" name="" value="avi"/><span>avi</span></li>
                        <li><input type="checkbox" name="" value="mpg"/><span>mpg</span></li>
                        <li><input type="checkbox" name="" value="ogv"/><span>ogv</span></li>
                        <li><input type="checkbox" name="" value="3gp"/><span>3gp</span></li>
                        <li><input type="checkbox" name="" value="3g2"/><span>3g2</span></li>
                    </ul>
                </div>
                <div class="ap-pro-file-upload-size">
                    <label><?php _e('Custom Extensions', 'anonymous-post-pro'); ?></label>
                    <input type="text" name="" class="ap-pro-custom-extensions" placeholder="zip,bmp"/>
                    <div class="ap-option-note ap-option-width"><?php _e('Please enter custom extensions separated by comma without (.) if required extensions are not available in the above list.', 'anonymous-post-pro'); ?></div>
                </div>
                <div class="ap-pro-file-upload-size">
                    <label><?php _e('Custom Folder Upload', 'anonymous-post-pro'); ?></label>
                    <input type="text" name="" class="ap-pro-custom-folder" value=""/>
                    <div class="ap-option-note ap-option-width"><?php _e('Please enter custom directory name which is inside the uploads folder. Please note that the entered folder should be already available inside the uploads directory. Leave blank if you want to use the default WordPress Media folder.', 'anonymous-post-pro'); ?></div>
                </div>
                <div class="ap-pro-file-upload-size">
                    <label><?php _e('Upload Button Label', 'anonymous-post-pro'); ?></label>
                    <input type="text" name="" class="ap-pro-upload-button-label"/>
                    <div class="ap-option-note ap-option-width"><?php _e('Please enter the file upload button label', 'anonymous-post-pro'); ?></div>
                </div>
                <div class="ap-pro-file-upload-size">
                    <label>Max Upload File Size</label>
                    <input type="text" name="" class="ap-pro-file-upload-size"/>
                    <div class="ap-option-note ap-option-width"><?php _e('Please enter the max upload size in MB.Default max upload file size is 8MB.Please enter the size less than what is set in your php.ini <strong>post_max_size</strong> and <strong>upload_max_size</strong> else alert message may show up in frontend.', 'anonymous-post-pro'); ?></div>
                </div>
                <div class="ap-pro-file-upload-size">
                    <label>Multiple File Upload</label>
                    <input type="checkbox" name="" class="ap-pro-multiple-file-upload" value="1"/>
                    <div class="ap-option-note"><?php _e('Check if you want to allow the vistors to upload multiple files', 'anonymous-post-pro'); ?></div>
                </div>
                <div class="ap-pro-file-upload-size">
                    <label>Max Upload File Limit</label>
                    <input type="text" name="" class="ap-pro-file-upload-limit"/>
                    <div class="ap-option-note ap-option-width"><?php _e('Please enter the maximum number of file to allow for multiple upload.Default maximum number is infinite', 'anonymous-post-pro'); ?></div>
                </div>
                <div class="ap-pro-file-upload-size">
                    <label>Max Upload Limit Message</label>
                    <input type="text" name="" class="ap-pro-file-upload-limit-message"/>

                </div>
                <div class="ap-pro-file-upload-size">
                    <label>Attach Media to Post</label>
                    <input type="checkbox" name="" class="ap-pro-attach-media" value="1"/>
                    <div class="ap-option-note"><?php _e('Check if you want to attach the media to post', 'anonymous-post-pro'); ?></div>
                </div>
            </div>
        </div>
        <div class="ap-pro-custom-field-adder" style="display: none;">
            <h3><?php _e('Custom Fields', 'anonymous-post-pro'); ?></h3>
            <div class="ap-tab-wrapper">
                <div class="ap-pro-custom-field-label">
                    <label><?php _e('Label', 'anonymous-post-pro'); ?></label>
                    <input type="text" id="ap-custom-field-label"/>
                    <div class="ap-custom-error"></div>
                </div>
                <div class="ap-pro-custom-field-label">
                    <label><?php _e('Meta Key', 'anonymous-post-pro'); ?></label>
                    <input type="text" id="ap-custom-field-key"/>
                    <div class="ap-custom-error"></div>
                </div>
                <div class="ap-pro-custom-field-label">
                    <label><?php _e('Pre Available Meta Keys', 'anonymous-post-pro'); ?></label>
                    <?php
                    $post_meta_table = $wpdb->postmeta;
                    $meta_keys = $wpdb->get_results("SELECT DISTINCT(meta_key) FROM $post_meta_table");
                    ?>
                    <select id="ap-pro-pre-meta">
                        <option value=""><?php _e('None'); ?></option>
                        <?php
                        foreach ( $meta_keys as $meta_key ) {
                            ?>
                            <option value="<?php echo $meta_key->meta_key; ?>"><?php echo $meta_key->meta_key; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <div class="ap-custom-error"></div>
                </div>
                <div class="ap-pro-custom-field-label">
                    <input type="button" class="button primary-button" id="ap-custom-field-submit" value="Add Field"/>
                </div>
            </div>
            <div class="ap-pro-extra-note">
                <?php _e('Note: Please use lower case letters only for meta key and please don\'t use any symbols or space keys.Use <br/>underscore( _ ) instead.For example: If you are to add Product Model then meta key can be product_model .', 'anonymous-post-pro'); ?>
            </div>
        </div>
    </div>



</div>