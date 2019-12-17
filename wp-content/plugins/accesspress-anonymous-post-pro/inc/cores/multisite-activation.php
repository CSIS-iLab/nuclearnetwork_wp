<?php

global $wpdb;
$current_blog = $wpdb->blogid;

// Get all blogs in the network and activate plugin on each one
$blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
foreach ($blog_ids as $blog_id) {
    switch_to_blog($blog_id);


    $ap_pro_extra_settings = array('lightbox_disable' => 0, 'jquery_ui_disable' => 0);
    if (!get_option('ap_pro_extra_settings')) {
        update_option('ap_pro_extra_settings', $ap_pro_extra_settings);
    }

    /**
     * Creating table for storing social icons sets
     * */
    $table_name = $wpdb->prefix . 'ap_pro_forms';
    $sql = "CREATE TABLE IF NOT EXISTS $table_name 
                                    (
                                    ap_form_id INT NOT NULL AUTO_INCREMENT, 
                                    PRIMARY KEY(ap_form_id),
                                    form_details TEXT
                                    )";
    $table_check = $wpdb->query($sql);
    if ($table_check !== 0) {
        $ap_settings = get_option('ap_pro_settings');
        if (!empty($ap_settings)) {
            $default_settings = $ap_settings;
        } else {
            $default_settings = $this->get_default_settings();
        }
        $default_settings = base64_encode(serialize($default_settings));
        $wpdb->get_results("select ap_form_id from $table_name", ARRAY_A);
        if ($wpdb->num_rows == 0) {
            $wpdb->insert(
                    $table_name, array(
                'form_details' => $default_settings
                    ), array(
                '%s'
                    )
            );
        }
    }
    restore_current_blog();
}