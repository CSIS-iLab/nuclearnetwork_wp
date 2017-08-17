<?php
/**
 * Custom Post Meta Boxes
 *
 * Add custom meta boxes to the post screen for "Posts". Meta boxes are for sources, download link, view online link.
 *
 * @package Nuclear_Network
 */

/**
 * Add meta box
 *
 * @param post $post The post object.
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
 */
function post_add_meta_boxes( $post ) {
	add_meta_box( 'post_meta_box', __( 'Additional Post Information', 'nuclearnetwork' ), 'post_build_meta_box', 'post', 'normal', 'high' );

	add_meta_box( 'post_meta_box', __( 'Additional Post Information', 'nuclearnetwork' ), 'news_build_meta_box', 'news', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'post_add_meta_boxes' );

/**
 * Build custom field meta box
 *
 * @param post $post The post object.
 */
function post_build_meta_box( $post ) {
	// Make sure the form request comes from WordPress.
	wp_nonce_field( basename( __FILE__ ), 'post_meta_box_nonce' );

	// Retrieve current value of fields.
	$current_sources = get_post_meta( $post->ID, '_post_sources', true );
	$current_post_format = get_post_meta( $post->ID, '_post_post_format', true );
	$current_download_url = get_post_meta( $post->ID, '_post_download_url', true );
	$current_view_url = get_post_meta( $post->ID, '_post_view_url', true );
	$current_disable_linkedin = get_post_meta( $post->ID, '_post_disable_linkedin', true );

	// Set default value for post format.
	if ( empty( $current_post_format ) ) {
		$current_post_format = 'analysis';
	}

	if ( 'analysis' === $current_post_format ) {
		$analysis_class = 'nuclearnetwork_meta meta-is-active';
		$report_class = 'nuclearnetwork_meta';
	} else {
		$analysis_class = 'nuclearnetwork_meta';
		$report_class = 'nuclearnetwork_meta meta-is-active';
	}

	?>
	<div class='inside'>
		<h3>Post Format:</h3>
		<p>
			<input type="radio" name="post_format" value="analysis" <?php checked( $current_post_format, 'analysis' ); ?> /> Analysis &nbsp;&nbsp;
			<input type="radio" name="post_format" value="report" <?php checked( $current_post_format, 'report' ); ?> /> Report
		</p>
		<div class="<?php echo esc_html( $analysis_class ); ?>">
			<h3><?php esc_html_e( 'Additional Sources:', 'nuclearnetwork' ); ?></h3>
			<p>
				<?php
					wp_editor(
						$current_sources,
						'sources',
						array(
							'media_buttons' => false,
							'textarea_name' => 'sources',
							'textarea_rows' => 5,
							'teeny' => false,
							'tinymce' => array(
								'menubar' => false,
								'toolbar1' => 'bold,italic,underline,strikethrough,subscript,superscript,bullist,numlist,alignleft,aligncenter,alignright,undo,redo,link,unlink',
								'toolbar2' => false,
							),
						)
					);
				?>
			</p>
		</div>
		<div class="<?php echo esc_html( $report_class ); ?>">
			<h3><?php esc_html_e( 'View URL:', 'nuclearnetwork' ); ?></h3>
			<p>
				<input type="text" class="large-text" name="view_url" value="<?php echo esc_textarea( $current_view_url ); ?>" /> 
			</p>
			<h3><?php esc_html_e( 'Download URL:', 'nuclearnetwork' ); ?></h3>
			<p>
				<input type="text" class="large-text" name="download_url" value="<?php echo esc_textarea( $current_download_download ); ?>" /> 
			</p>
		</div>
		<h3>Disable LinkedIn Link:</h3>
		<p>
			<input type="checkbox" name="disable_linkedin" value="1" <?php checked( $current_disable_linkedin, '1' ); ?> /> Yes, disable the LinkedIn message
		</p>
	</div>

	<style>
		.nuclearnetwork_meta {display: none;}
		.meta-is-active {display: block;}
	</style>

	<script type="text/javascript">
		( function( $ ) {
			$('input[type=radio][name=post_format]').change(function() {
				$(".nuclearnetwork_meta").toggleClass("meta-is-active");
			});
		} )( jQuery );
	</script>
	<?php
}

/**
 * Build custom field meta box
 *
 * @param post $post The post object.
 */
function news_build_meta_box( $post ) {
	// Make sure the form request comes from WordPress.
	wp_nonce_field( basename( __FILE__ ), 'post_meta_box_nonce' );

	// Retrieve current value of fields.
	$current_disable_linkedin = get_post_meta( $post->ID, '_post_disable_linkedin', true );

	?>
	<div class='inside'>
		<h3>Disable LinkedIn Link:</h3>
		<p>
			<input type="checkbox" name="disable_linkedin" value="1" <?php checked( $current_disable_linkedin, '1' ); ?> /> Yes, disable the LinkedIn message
		</p>
	</div>
	<?php
}

/**
 * Store custom field meta box data
 *
 * @param int $post_id The post ID.
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/save_post
 */
function post_save_meta_box_data( $post_id ) {
	// Verify meta box nonce.
	if ( ! isset( $_POST['post_meta_box_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['post_meta_box_nonce'] ) ), basename( __FILE__ ) ) ) { // Input var okay.
		return;
	}
	// Return if autosave.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Sources
	if ( isset( $_REQUEST['sources'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_sources', wp_kses_post( sanitize_text_field( wp_unslash( $_POST['sources'] ) ) ) ); // Input var okay.
	}
	// Post Format
	if ( isset( $_REQUEST['post_format'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_post_format', sanitize_text_field( wp_unslash( $_POST['post_format'] ) ) ); // Input var okay.
	}
	// Download URL
	if ( isset( $_REQUEST['download_url'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_download_url', esc_url_raw( wp_unslash( $_POST['download_url'] ) ) ); // Input var okay.
	}
	// View URL
	if ( isset( $_REQUEST['view_url'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_view_url', esc_url_raw( wp_unslash( $_POST['view_url'] ) ) ); // Input var okay.
	}
	// Disable LinkedIn
	if ( isset( $_REQUEST['disable_linkedin'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_disable_linkedin', sanitize_text_field( wp_unslash( $_POST['disable_linkedin'] ) ) ); // Input var okay.
	} else {
		update_post_meta( $post_id, '_post_disable_linkedin', '');
	}
}
add_action( 'save_post', 'post_save_meta_box_data' );

/*
@Recreate the default filters on the_content so we can pull formated content with get_post_meta
*/
add_filter( 'meta_content', 'wptexturize' );
add_filter( 'meta_content', 'convert_smilies' );
add_filter( 'meta_content', 'convert_chars' );
add_filter( 'meta_content', 'wpautop' );
add_filter( 'meta_content', 'shortcode_unautop' );
add_filter( 'meta_content', 'prepend_attachment' );
add_filter( 'meta_content', 'do_shortcode' );
