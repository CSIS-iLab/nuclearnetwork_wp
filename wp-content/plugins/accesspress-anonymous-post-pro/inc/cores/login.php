<?php 

global $user;
$creds = array();
$creds['user_login'] = sanitize_user($_POST['login_username']);
$creds['user_password'] =  $_POST['login_password'];
$creds['remember'] = true;
$user = wp_signon( $creds, false );
if ( is_wp_error($user) ) {
$_SESSION['ap_login_error'] =  __('Invalid Username or Password','anonymous-post-pro');
//print_r($_SESSION);
//die();

}
//die('reached');
wp_redirect($_POST['redirect_url']);
exit;
