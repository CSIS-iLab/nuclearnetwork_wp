<?php
/**
 * Custom settings page for the theme.
 *
 * @package Nuclear_Network
 */

add_action( 'admin_menu', 'nuclearnetwork_add_options_page' );
/**
 * Create an options page for the theme.
 */
function nuclearnetwork_add_options_page() {

	add_options_page(
		'Nuclear Network Settings',
		'Nuclear Network Settings',
		'manage_options',
		'nuclearnetwork-options-page',
		'nuclearnetwork_display_options_page'
	);
}

/**
 * Displays the option page and creates the form.
 */
function nuclearnetwork_display_options_page() {
	echo '<h1>Nuclear Network Settings</h1>';
	echo '<form method="post" action="options.php">';
	do_settings_sections( 'nuclearnetwork-options-page' );
	settings_fields( 'nuclearnetwork_settings' );
	submit_button();
	echo '</form>';
}

add_action( 'admin_init', 'nuclearnetwork_admin_init_section_footer' );
/**
 * Creates the "Footer" settings section.
 */
function nuclearnetwork_admin_init_section_footer() {

	add_settings_section(
		'nuclearnetwork_settings_section_footer',
		'Footer',
		'nuclearnetwork_display_section_footer_message',
		'nuclearnetwork-options-page'
	);

	add_settings_field(
		'nuclearnetwork_description',
		'Description',
		'nuclearnetwork_textarea_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_footer',
		array( 'nuclearnetwork_description' )
	);

	add_settings_field(
		'nuclearnetwork_disclaimer',
		'General Disclaimer',
		'nuclearnetwork_textarea_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_footer',
		array( 'nuclearnetwork_disclaimer' )
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_description',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_disclaimer',
		'sanitize_text_field'
	);

}

/**
 * Footer section description.
 */
function nuclearnetwork_display_section_footer_message() {
	echo 'Information visible in the site\'s footer.';
}

add_action( 'admin_init', 'nuclearnetwork_admin_init_section_contact' );
/**
 * Creates the "Contact" settings section.
 */
function nuclearnetwork_admin_init_section_contact() {

	add_settings_section(
		'nuclearnetwork_settings_section_contact',
		'Contact Information',
		'nuclearnetwork_display_section_contact_message',
		'nuclearnetwork-options-page'
	);

	add_settings_field(
		'nuclearnetwork_address',
		'Address',
		'nuclearnetwork_textarea_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_contact',
		array( ' nuclearnetwork_address' )
	);

	add_settings_field(
		'nuclearnetwork_email',
		'Email',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_contact',
		array( ' nuclearnetwork_email' )
	);

	add_settings_field(
		'nuclearnetwork_phone',
		'Phone',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_contact',
		array( ' nuclearnetwork_phone' )
	);

	add_settings_field(
		'nuclearnetwork_facebook',
		'Facebook',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_contact',
		array( ' nuclearnetwork_facebook' )
	);

	add_settings_field(
		'nuclearnetwork_twitter',
		'Twitter',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_contact',
		array( ' nuclearnetwork_twitter' )
	);

	add_settings_field(
		'nuclearnetwork_linkedin',
		'LinkedIn',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_contact',
		array( ' nuclearnetwork_linkedin' )
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_address',
		'wp_filter_post_kses'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_email',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_phone',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_facebook',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_twitter',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_linkedin',
		'sanitize_text_field'
	);

}

/**
 * Contact section description.
 */
function nuclearnetwork_display_section_contact_message() {
	echo 'The contact information for the site, including physical address and social media accounts.';
}

add_action( 'admin_init', 'nuclearnetwork_admin_init_section_newsletter' );
/**
 * Creates the "Newsletter" settings section.
 */
function nuclearnetwork_admin_init_section_newsletter() {

	add_settings_section(
		'nuclearnetwork_settings_section_newsletter',
		'Newsletters',
		'nuclearnetwork_display_section_newsletter_message',
		'nuclearnetwork-options-page'
	);

	add_settings_field(
		'nuclearnetwork_newsletter_monthly_desc',
		'Monthly Description',
		'nuclearnetwork_textarea_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_newsletter',
		array( 'nuclearnetwork_newsletter_monthly_desc' )
	);

	add_settings_field(
		'nuclearnetwork_newsletter_monthly_url',
		'Monthly URL',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_newsletter',
		array( 'nuclearnetwork_newsletter_monthly_url' )
	);

	add_settings_field(
		'nuclearnetwork_newsletter_daily_desc',
		'Monthly Description',
		'nuclearnetwork_textarea_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_newsletter',
		array( 'nuclearnetwork_newsletter_daily_desc' )
	);

	add_settings_field(
		'nuclearnetwork_newsletter_daily_url',
		'Monthly URL',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_newsletter',
		array( 'nuclearnetwork_newsletter_daily_url' )
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_newsletter_monthly_desc',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_newsletter_monthly_url',
		'esc_url'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_newsletter_daily_desc',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_newsletter_daily_url',
		'esc_url'
	);
}

/**
 * Newsletter section description.
 */
function nuclearnetwork_display_section_newsletter_message() {
	echo 'Information visible in the site\'s newsletter.';
}

/**
 * Renders the text input fields.
 *
 * @param  Array $args Array of arguments passed by callback function.
 */
function nuclearnetwork_text_callback( $args ) {
	$option = get_option( $args[0] );
	echo '<input type="text" class="regular-text" id="' . esc_attr( $args[0] ) . '" name="' . esc_attr( $args[0] ) . '" value="' . esc_attr( $option ) . '" />';
}

/**
 * Renders the textareafields.
 *
 * @param  Array $args Array of arguments passed by callback function.
 */
function nuclearnetwork_textarea_callback( $args ) {
	$option = get_option( $args[0] );
	echo '<textarea class="regular-text" id="' . esc_attr( $args[0] ) . '" name="' . esc_attr( $args[0] ) . '" rows="5">' . esc_attr( $option ) . '</textarea>';
}
