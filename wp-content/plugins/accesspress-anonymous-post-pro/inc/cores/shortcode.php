<?php

$ap_form = '';
/**
 * Setting all the backend option values in the form
 * */
//$ap_settings = $this->ap_settings;
//including plugin only if admin has selected the option to show
if ($ap_settings['plugin_styles'] == 1) {
    if ($ap_settings['plugin_style_type'] == 'template') {
        $template_class = $ap_settings['form_template'];
    } else {
        ob_start();
        include_once('form-styler-css.php');
        $ap_form .= ob_get_contents();
        ob_end_clean();
        $template_class = 'ap-front-form-styler';
    }
} else {
    $template_class = '';
}


if ($ap_settings['login_check'] == 0) {//if login is not require to submit the post
    $ap_form .= '<div class="ap-form-wrapper ' . $template_class . '">';
    $ap_form .= $this->prepare_form_html($form_id); //includes the form html 
    $ap_form .='</div><!--ap-form-->';
} else {
    if (is_user_logged_in()) {//if user is logged in 
        $ap_form .= '<div class="ap-form-wrapper ' . $template_class . '">';
        $ap_form .= $this->prepare_form_html($form_id); //includes the form html
        $ap_form .='</div><!--ap-form-->';
    } else {
        $current_page = urlencode($this->curPageURL());
        if ($ap_settings['login_type'] == 'login_message') {
            $login_message = ($ap_settings['login_message'] == '') ? __('Please login to submit the post', 'anonymous-post-pro') : $ap_settings['login_message'];
            $login_link_text = ($ap_settings['login_link_text'] == '') ? __('Login', 'anonymous-post-pro') : $ap_settings['login_link_text'];
            $login_link_url = (isset($ap_settings['login_link_url']) && $ap_settings['login_link_url']!='')?esc_url($ap_settings['login_link_url']):site_url() . '/wp-login.php?redirect_to=' . $current_page;
            $ap_form = '<div class="ap-login-message-wrapper"><div class="ap-login-message">' . $login_message . '</div><a href="' . $login_link_url . '">' . $login_link_text . '</a></div>';
        } else {
            $ap_form = $this->prepare_login_form($form_id);
            unset($_SESSION['ap_login_error']);
        }
    }
}

