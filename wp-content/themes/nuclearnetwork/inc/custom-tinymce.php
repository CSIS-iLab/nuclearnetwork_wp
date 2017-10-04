<?php
/**
 * Custom buttons for TinyMCE
 *
 * @package nuclearnetwork
 */

add_action( 'after_setup_theme', 'nuclearnetwork_theme_setup' );

if ( ! function_exists( 'nuclearnetwork_theme_setup' ) ) {
	/**
	 * Initialize custom buttons for TinyMCE.
	 */
	function nuclearnetwork_theme_setup() {
		add_action( 'init', 'nuclearnetwork_buttons' );
	}
}

/********* TinyMCE Buttons ***********/
if ( ! function_exists( 'nuclearnetwork_buttons' ) ) {

	/**
	 * Only render buttons if users can edit posts & is using rich editor
	 */
	function nuclearnetwork_buttons() {
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
			return;
		}

		if ( get_user_option( 'rich_editing' ) !== 'true' ) {
			return;
		}

		add_filter( 'mce_external_plugins', 'nuclearnetwork_add_buttons' );
		add_filter( 'mce_buttons_3', 'nuclearnetwork_register_buttons' );
	}
}

if ( ! function_exists( 'nuclearnetwork_add_buttons' ) ) {

	/**
	 * Include the JS file with the button information.
	 *
	 * @param Array $plugin_array Plugin array to update.
	 */
	function nuclearnetwork_add_buttons( $plugin_array ) {
		$plugin_array['nuclearnetwork'] = get_template_directory_uri() . '/js/tinymce.js';
		return $plugin_array;
	}
}

if ( ! function_exists( 'nuclearnetwork_register_buttons' ) ) {
	/**
	 * Add custom buttons to buttons array
	 *
	 * @param  Array $buttons Array of buttons to appear in editor.
	 * @return Array          Updated buttons array.
	 */
	function nuclearnetwork_register_buttons( $buttons ) {
		array_push( $buttons, 'note', 'toc', 'readPDF' );
		return $buttons;
	}
}
