<div class="ap-settings-wrapper wrap">
    <div class="ap-settings-header">
        <div class="ap-logo">
            <img src="<?php echo AP_PRO_IMAGE_DIR; ?>/logo.png" alt="<?php esc_attr_e( 'AccessPress Anonymous Post Pro', 'anonymous-post-pro' ); ?>" />
        </div>

        <div class="ap-socials">
            <p><?php _e( 'Follow us for new updates', 'anonymous-post-pro' ) ?></p>
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

        <div class="ap-title"><?php _e( 'AccessPress Anonymous Post Pro Forms', 'anonymous-post-pro' ); ?></div>
    </div>
    <?php if ( isset( $_SESSION['ap_message'] ) ) { ?>
        <div id="messages" class="update" style="margin-bottom: 10px;">
            <?php
            echo $_SESSION['ap_message'];
            unset( $_SESSION['ap_message'] );
            ?>
        </div>
    <?php } ?>
    <div class="aps-panel-body">
        <h2>Anonymous Forms <a href="<?php echo admin_url() . 'admin.php?page=add-new-ap-form' ?>" class="add-new-h2">Add New</a></h2>

        <table class="wp-list-table widefat fixed posts">
            <thead>
                <tr>
                    <th scope="col" id="title" class="manage-column column-title sortable asc" style="">
                        <a href="javascript:void(0)"> <span><?php _e( 'Title', 'aps-social' ); ?></span> </a>
                    </th>
                    <th scope="col" id="shortcode" class="manage-column column-shortcode" style="">
                        <?php _e( 'Shortcode', 'aps-social' ); ?>
                    </th>
                    <th scope="col" id="template-shortcode" class="manage-column column-shortcode" style="">
                        <?php _e( 'Template Shortcode', 'aps-social' ); ?>
                    </th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th scope="col" class="manage-column column-title sortable asc" style=""><a href="javascript:void(0)"><span><?php _e( 'Title', 'aps-social' ); ?></span></a></th>
                    <th scope="col" class="manage-column column-shortcode" style=""><?php _e( 'Shortcode', 'aps-social' ); ?></th>
                    <th scope="col" id="template-shortcode" class="manage-column column-shortcode" style="">
                        <?php _e( 'Template Shortcode', 'aps-social' ); ?>
                    </th>
                </tr>
            </tfoot>
            <?php
            global $wpdb;
            $table_name = $table_name = $wpdb->prefix . "ap_pro_forms";
            $forms = $wpdb->get_results( "SELECT * FROM $table_name" );
            //$this->print_array($icon_sets);
            ?>
            <tbody id="the-list" data-wp-lists="list:post">
                <?php
                if ( count( $forms ) > 0 ) {
                    $form_counter = 1;
                    foreach ( $forms as $form ) {
                        $delete_nonce = wp_create_nonce( 'ap-form-delete-nonce' );
                        $copy_nonce = wp_create_nonce( 'ap-form-copy-nonce' );
                        $form_settings = $this->get_unserialized( $form->form_details );
                        ?>
                        <tr <?php if ( $form_counter % 2 != 0 ) { ?>class="alternate"<?php } ?>>
                            <td class="title column-title">
                                <strong>
                                    <a class="row-title" href="<?php echo admin_url() . 'admin.php?page=anonymous-post-pro&action=edit_form&form_id=' . $form->ap_form_id; ?>" title="Edit">
                                        <?php echo esc_attr( $form_settings['form_title'] ); ?>
                                    </a>
                                </strong>
                                <div class="row-actions">
                                    <span class="edit"><a href="<?php echo admin_url() . 'admin.php?page=anonymous-post-pro&action=edit_form&form_id=' . $form->ap_form_id; ?>"><?php _e('Edit','anonymous-post-pro');?></a></span>&nbsp;|&nbsp;
                                    <span class="edit"><a href="<?php echo admin_url() . 'admin-post.php?action=ap_form_copy_action&form_id=' . $form->ap_form_id . '&_wpnonce=' . $copy_nonce; ?>" onclick="return confirm('<?php _e( 'Are you sure you want to copy this form?', 'anonymous-post-pro' ); ?>')">Copy</a></span>&nbsp;|&nbsp;
                                    <span class="edit"><a href="<?php echo site_url() . '/?ap_preview=true&form_id=' . $form->ap_form_id ; ?>" target="_blank"><?php _e('Preview','anonymous-post-pro');?></a></span>&nbsp;|&nbsp;
                                    <span class="delete"><a href="<?php echo admin_url() . 'admin-post.php?action=ap_form_delete_action&form_id=' . $form->ap_form_id . '&_wpnonce=' . $delete_nonce; ?>" onclick="return confirm('<?php _e( 'Are you sure you want to delete this form?', 'anonymous-post-pro' ); ?>')">Delete</a></span>
                                </div>
                            </td>
                            <td class="shortcode column-shortcode"><input type="text" onFocus="this.select();" readonly="readonly" value="[ap-form id=&quot;<?php echo $form->ap_form_id; ?>&quot;]" class="shortcode-in-list-table wp-ui-text-highlight code"></td>
                            <td class="shortcode column-shortcode"><input type="text" onFocus="this.select();" readonly="readonly" value="&lt;?php echo do_shortcode('[ap-form id=&quot;<?php echo $form->ap_form_id; ?>&quot;]')?&gt;" class="shortcode-in-list-table wp-ui-text-highlight code"></td>
                        </tr>
                        <?php
                        $form_counter++;
                    }
                } else {
                    ?>
                    <tr><td colspan="3"><div class="ap-pro-noresult"><?php _e( 'No Forms Added Yet', 'anonymous-post-pro' ); ?></div></td></tr>
                            <?php
                        }
                        ?>
            </tbody>
        </table>
    </div>
</div>