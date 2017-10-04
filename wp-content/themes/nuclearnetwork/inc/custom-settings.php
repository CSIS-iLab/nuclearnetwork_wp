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

add_action( 'admin_init', 'nuclearnetwork_admin_init_section_home' );
/**
 * Creates the "Home" settings section.
 */
function nuclearnetwork_admin_init_section_home() {

	add_settings_section(
		'nuclearnetwork_settings_section_home',
		'Home Page',
		'nuclearnetwork_display_section_home_message',
		'nuclearnetwork-options-page'
	);

	add_settings_field(
		'nuclearnetwork_home_desc_short',
		'Brief Description',
		'nuclearnetwork_textarea_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_home',
		array( 'nuclearnetwork_home_desc_short' )
	);

	add_settings_field(
		'nuclearnetwork_home_desc_long',
		'About the Project',
		'nuclearnetwork_textarea_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_home',
		array( 'nuclearnetwork_home_desc_long' )
	);

	add_settings_field(
		'nuclearnetwork_home_img_1',
		'Featured Image #1',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_home',
		array( 'nuclearnetwork_home_img_1' )
	);

	add_settings_field(
		'nuclearnetwork_home_img_2',
		'Featured Image #2',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_home',
		array( 'nuclearnetwork_home_img_2' )
	);

	add_settings_field(
		'nuclearnetwork_home_img_3',
		'Featured Image #3',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_home',
		array( 'nuclearnetwork_home_img_3' )
	);

	add_settings_field(
		'nuclearnetwork_home_img_4',
		'Featured Image #4',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_home',
		array( 'nuclearnetwork_home_img_4' )
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_home_desc_short',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_home_desc_long',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_home_img_1',
		'esc_url_raw'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_home_img_2',
		'esc_url_raw'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_home_img_3',
		'esc_url_raw'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_home_img_4',
		'esc_url_raw'
	);
}

/**
 * Home section description.
 */
function nuclearnetwork_display_section_home_message() {
	echo 'Information visible on the site\'s homepage.';
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
		'wp_filter_post_kses'
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
		'Daily Description',
		'nuclearnetwork_textarea_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_newsletter',
		array( 'nuclearnetwork_newsletter_daily_desc' )
	);

	add_settings_field(
		'nuclearnetwork_newsletter_daily_url',
		'Daily URL',
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

add_action( 'admin_init', 'nuclearnetwork_admin_init_section_posts' );
/**
 * Creates the "Post" settings section.
 */
function nuclearnetwork_admin_init_section_posts() {

	add_settings_section(
		'nuclearnetwork_settings_section_posts',
		'Footer',
		'nuclearnetwork_display_section_posts_message',
		'nuclearnetwork-options-page'
	);

	add_settings_field(
		'nuclearnetwork_post_write',
		'Write for Us',
		'nuclearnetwork_textarea_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_posts',
		array( 'nuclearnetwork_post_write' )
	);

	add_settings_field(
		'nuclearnetwork_post_discuss',
		'Discuss this Post',
		'nuclearnetwork_textarea_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_posts',
		array( 'nuclearnetwork_post_discuss' )
	);

	add_settings_field(
		'nuclearnetwork_post_news',
		'Daily News',
		'nuclearnetwork_textarea_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_posts',
		array( 'nuclearnetwork_post_news' )
	);

	add_settings_field(
		'nuclearnetwork_post_disclaimer',
		'Guest Author Disclaimer',
		'nuclearnetwork_textarea_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_posts',
		array( 'nuclearnetwork_post_disclaimer' )
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_post_write',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_post_discuss',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_post_news',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_post_disclaimer',
		'sanitize_text_field'
	);
}

/**
 * Post section description.
 */
function nuclearnetwork_display_section_posts_message() {
	echo 'Information visible in the site\'s posts.';
}

add_action( 'admin_init', 'nuclearnetwork_admin_init_section_archives' );
/**
 * Creates the "Archives" settings section.
 */
function nuclearnetwork_admin_init_section_archives() {

	add_settings_section(
		'nuclearnetwork_settings_section_archives',
		'Archives',
		'nuclearnetwork_display_section_archives_message',
		'nuclearnetwork-options-page'
	);

	add_settings_field(
		'nuclearnetwork_analysis_desc',
		'Analysis Archive Description',
		'nuclearnetwork_textarea_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_archives',
		array( 'nuclearnetwork_analysis_desc' )
	);

	add_settings_field(
		'nuclearnetwork_analysis_category',
		'Analysis Archive Category',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_archives',
		array( 'nuclearnetwork_analysis_category' )
	);

	add_settings_field(
		'nuclearnetwork_category_and_tag_archive_image',
		'Category & Tags Archive Image',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_archives',
		array( 'nuclearnetwork_category_and_tag_archive_image' )
	);

	add_settings_field(
		'nuclearnetwork_authors_archive_image',
		'Authors Archive Image',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_archives',
		array( 'nuclearnetwork_authors_archive_image' )
	);

	add_settings_field(
		'nuclearnetwork_default_archive_search',
		'Default Archive Search Form ID',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_archives',
		array( 'nuclearnetwork_default_archive_search' )
	);

	add_settings_field(
		'nuclearnetwork_post_archive_search',
		'Analysis Archive Search Form ID',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_archives',
		array( 'nuclearnetwork_post_archive_search' )
	);

	add_settings_field(
		'nuclearnetwork_news_archive_search',
		'News Archive Search Form ID',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_archives',
		array( 'nuclearnetwork_news_archive_search' )
	);

	add_settings_field(
		'nuclearnetwork_events_archive_search',
		'Events Archive Search Form ID',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_archives',
		array( 'nuclearnetwork_events_archive_search' )
	);

	add_settings_field(
		'nuclearnetwork_opportunities_events_search',
		'Opportunities Archive Search Form ID',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_archives',
		array( 'nuclearnetwork_opportunities_archive_search' )
	);

	add_settings_field(
		'nuclearnetwork_announcements_events_search',
		'Announcements Archive Search Form ID',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_archives',
		array( 'nuclearnetwork_announcements_archive_search' )
	);

	add_settings_field(
		'nuclearnetwork_resources_events_search',
		'Resources Archive Search Form ID',
		'nuclearnetwork_text_callback',
		'nuclearnetwork-options-page',
		'nuclearnetwork_settings_section_archives',
		array( 'nuclearnetwork_resources_archive_search' )
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_analysis_desc',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_analysis_category',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_category_and_tag_archive_image',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_authors_archive_image',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_default_archive_search',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_post_archive_search',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_news_archive_search',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_events_archive_search',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_opportunities_archive_search',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_announcements_archive_search',
		'sanitize_text_field'
	);

	register_setting(
		'nuclearnetwork_settings',
		'nuclearnetwork_resources_archive_search',
		'sanitize_text_field'
	);
}

/**
 * Archives section description.
 */
function nuclearnetwork_display_section_archives_message() {
	echo 'Information visible in the site\'s archives.';
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
