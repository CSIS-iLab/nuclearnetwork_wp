<?php
/**
 * Custom Post Meta Boxes
 *
 * Add custom meta boxes to the post screen for "Posts". Meta boxes are for sources, download link, view online link.
 *
 * @package Nuclear_Network
 */

add_action( 'post_submitbox_misc_actions', 'nuclearnetwork_add_publish_meta_options' );
/**
 * Add custom meta to the "Publish" box for a featured item.
 *
 * @param array $post Post information.
 */
function nuclearnetwork_add_publish_meta_options( $post ) {
	// Make sure the form request comes from WordPress.
	wp_nonce_field( basename( __FILE__ ), 'publish_meta_box_nonce' );

	$current_is_featured = get_post_meta( $post->ID, '_post_is_featured', true );
	?>
	<div class="misc-pub-section misc-pub-section-last">
		<input type="checkbox" name="is_featured" value="1" <?php checked( $current_is_featured, '1' ); ?> /> <?php esc_html_e( 'Feature Post?', 'nuclearnetwork' ); ?>
	</div>
	<?php
}

add_action( 'save_post', 'nuclearnetwork_extra_publish_options_save', 10 , 3 );
/**
 * Save custom post meta for "Publish" box.
 *
 * @param  int   $post_id Post ID.
 * @param  array $post    Post object.
 * @param  bool  $update  Updating or not.
 */
function nuclearnetwork_extra_publish_options_save( $post_id, $post, $update ) {
	// Verify meta box nonce.
	if ( ! isset( $_POST['publish_meta_box_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['publish_meta_box_nonce'] ) ), basename( __FILE__ ) ) ) { // Input var okay.
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

	// Is Featured
	if ( isset( $_REQUEST['is_featured'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_is_featured', intval( wp_unslash( $_POST['is_featured'] ) ) ); // Input var okay.
	} else {
		update_post_meta( $post_id, '_post_is_featured', 0 );
	}
}

/**
 * Add meta box to different post types.
 *
 * @param post $post The post object.
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
 */
function post_add_meta_boxes( $post ) {
	add_meta_box( 'post_meta_box', __( 'Additional Post Information', 'nuclearnetwork' ), 'post_build_meta_box', 'post', 'normal', 'high' );

	add_meta_box( 'post_meta_box', __( 'Additional Post Information', 'nuclearnetwork' ), 'essentials_build_meta_box', 'essentials', 'normal', 'high' );

	add_meta_box( 'post_meta_box', __( 'Additional Post Information', 'nuclearnetwork' ), 'events_build_meta_box', 'events', 'normal', 'high' );

	add_meta_box( 'post_meta_box', __( 'Additional Post Information', 'nuclearnetwork' ), 'news_build_meta_box', 'news', 'normal', 'high' );

	add_meta_box( 'post_meta_box', __( 'Additional Post Information', 'nuclearnetwork' ), 'opportunities_build_meta_box', 'opportunities', 'normal', 'high' );

	add_meta_box( 'post_meta_box', __( 'Additional Post Information', 'nuclearnetwork' ), 'pages_build_meta_box', 'page', 'normal', 'high' );
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
	$current_linkedin_url = get_post_meta( $post->ID, '_post_linkedin_url', true );
	$current_disable_disclaimer = get_post_meta( $post->ID, '_post_disable_disclaimer', true );
	$current_is_nextgen = get_post_meta( $post->ID, '_post_is_nextgen', true );

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
							'teeny' => true,
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
				<input type="text" class="large-text" name="download_url" value="<?php echo esc_textarea( $current_download_url ); ?>" /> 
			</p>
		</div>
		<h3><?php esc_html_e( 'LinkedIn:', 'nuclearnetwork' ); ?></h3>
		<p>
			<label for="linkedin_url"><?php esc_html_e( 'LinkedIn URL:', 'nuclearnetwork' ); ?></label> <input type="text" class="large-text" name="linkedin_url" value="<?php echo esc_textarea( $current_linkedin_url ); ?>" /> 
		</p>
		<p>
			<input type="checkbox" name="disable_linkedin" value="1" <?php checked( $current_disable_linkedin, '1' ); ?> /> <?php esc_html_e( 'Yes, disable the LinkedIn message', 'nuclearnetwork' ); ?>
		</p>
		<h3><?php esc_html_e( 'Disable Disclaimer Message:', 'nuclearnetwork' ); ?></h3>
		<p>
			<input type="checkbox" name="disable_disclaimer" value="1" <?php checked( $current_disable_disclaimer, '1' ); ?> /> <?php esc_html_e( 'Yes, disable the disclaimer message', 'nuclearnetwork' ); ?>
		</p>
		<h3><?php esc_html_e( 'Next Generation Perspectives:', 'nuclearnetwork' ); ?></h3>
		<p>
			<input type="checkbox" name="is_nextgen" value="1" <?php checked( $current_is_nextgen, '1' ); ?> /> <?php esc_html_e( 'Yes, this is a Next Generation Perspective post', 'nuclearnetwork' ); ?>
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
 * Build custom field meta box for essentials posts.
 *
 * @param post $post The post object.
 */
function essentials_build_meta_box( $post ) {
	// Make sure the form request comes from WordPress.
	wp_nonce_field( basename( __FILE__ ), 'post_meta_box_nonce' );

	// Retrieve current value of fields.
	$current_sources = get_post_meta( $post->ID, '_post_sources', true );
	$current_disable_linkedin = get_post_meta( $post->ID, '_post_disable_linkedin', true );
	$current_linkedin_url = get_post_meta( $post->ID, '_post_linkedin_url', true );

	?>
	<div class='inside'>
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
						'teeny' => true,
					)
				);
			?>
		</p>
		<h3><?php esc_html_e( 'LinkedIn:', 'nuclearnetwork' ); ?></h3>
		<p>
			<label for="linkedin_url"><?php esc_html_e( 'LinkedIn URL:', 'nuclearnetwork' ); ?></label> <input type="text" class="large-text" name="linkedin_url" value="<?php echo esc_textarea( $current_linkedin_url ); ?>" /> 
		</p>
		<p>
			<input type="checkbox" name="disable_linkedin" value="1" <?php checked( $current_disable_linkedin, '1' ); ?> /> <?php esc_html_e( 'Yes, disable the LinkedIn message', 'nuclearnetwork' ); ?>
		</p>
	</div>
	<?php
}

/**
 * Build custom field meta box for events posts.
 *
 * @param post $post The post object.
 */
function events_build_meta_box( $post ) {
	// Make sure the form request comes from WordPress.
	wp_nonce_field( basename( __FILE__ ), 'post_meta_box_nonce' );

	// Retrieve current value of fields.
	$current_poni_sponsored = get_post_meta( $post->ID, '_post_poni_sponsored', true );
	$current_location = get_post_meta( $post->ID, '_post_location', true );
	$current_info_url = get_post_meta( $post->ID, '_post_info_url', true );
	$current_start_date = get_post_meta( $post->ID, '_post_start_date', true );
	$current_end_date = get_post_meta( $post->ID, '_post_end_date', true );
	?>
	<div class='inside'>
		<h3><?php esc_html_e( 'PONI Sponsored:', 'nuclearnetwork' ); ?></h3>
		<p>
			<input type="checkbox" name="poni_sponsored" value="1" <?php checked( $current_poni_sponsored, '1' ); ?> /> <?php esc_html_e( 'Yes, this is a PONI Sponsored opportunity', 'nuclearnetwork' ); ?>
		</p>
		<h3><?php esc_html_e( 'Location:', 'nuclearnetwork' ); ?></h3>
		<p>
			<input type="text" class="large-text" name="location" value="<?php echo esc_textarea( $current_location ); ?>" /> 
		</p>
		<h3><?php esc_html_e( 'Event Dates:', 'nuclearnetwork' ); ?></h3>
		<p>
			<label for="start_date"><?php esc_html_e( 'Start Date:', 'nuclearnetwork' ); ?></label> <input type="date" class="medium-text" name="start_date" value="<?php echo esc_textarea( $current_start_date ); ?>" /><br />
			<label for="end_date"><?php esc_html_e( 'End Date:', 'nuclearnetwork' ); ?></label> <input type="date" class="medium-text" name="end_date" value="<?php echo esc_textarea( $current_end_date ); ?>" />
		</p>
		<h3><?php esc_html_e( 'Register URL:', 'nuclearnetwork' ); ?></h3>
		<p>
			<input type="text" class="large-text" name="info_url" value="<?php echo esc_textarea( $current_info_url ); ?>" /> 
		</p>
	</div>
	<?php
}

/**
 * Build custom field meta box for news posts.
 *
 * @param post $post The post object.
 */
function news_build_meta_box( $post ) {
	// Make sure the form request comes from WordPress.
	wp_nonce_field( basename( __FILE__ ), 'post_meta_box_nonce' );

	// Retrieve current value of fields.
	$current_disable_linkedin = get_post_meta( $post->ID, '_post_disable_linkedin', true );
	$current_linkedin_url = get_post_meta( $post->ID, '_post_linkedin_url', true );

	?>
	<div class='inside'>
		<h3><?php esc_html_e( 'LinkedIn:', 'nuclearnetwork' ); ?></h3>
		<p>
			<label for="linkedin_url"><?php esc_html_e( 'LinkedIn URL:', 'nuclearnetwork' ); ?></label> <input type="text" class="large-text" name="linkedin_url" value="<?php echo esc_textarea( $current_linkedin_url ); ?>" /> 
		</p>
		<p>
			<input type="checkbox" name="disable_linkedin" value="1" <?php checked( $current_disable_linkedin, '1' ); ?> /> <?php esc_html_e( 'Yes, disable the LinkedIn message', 'nuclearnetwork' ); ?>
		</p>
	</div>
	<?php
}

/**
 * Build custom field meta box for opportunity posts.
 *
 * @param post $post The post object.
 */
function opportunities_build_meta_box( $post ) {
	// Make sure the form request comes from WordPress.
	wp_nonce_field( basename( __FILE__ ), 'post_meta_box_nonce' );

	// Retrieve current value of fields.
	$current_poni_sponsored = get_post_meta( $post->ID, '_post_poni_sponsored', true );
	$current_location = get_post_meta( $post->ID, '_post_location', true );
	$current_deadline = get_post_meta( $post->ID, '_post_deadline', true );
	$current_is_ongoing = get_post_meta( $post->ID, '_post_is_ongoing', true );
	$current_info_url = get_post_meta( $post->ID, '_post_info_url', true );
	?>
	<div class='inside'>
		<h3><?php esc_html_e( 'PONI Sponsored:', 'nuclearnetwork' ); ?></h3>
		<p>
			<input type="checkbox" name="poni_sponsored" value="1" <?php checked( $current_poni_sponsored, '1' ); ?> /> <?php esc_html_e( 'Yes, this is a PONI Sponsored opportunity', 'nuclearnetwork' ); ?>
		</p>
		<h3><?php esc_html_e( 'Location:', 'nuclearnetwork' ); ?></h3>
		<p>
			<input type="text" class="large-text" name="location" value="<?php echo esc_textarea( $current_location ); ?>" /> 
		</p>
		<h3><?php esc_html_e( 'Application Deadline:', 'nuclearnetwork' ); ?></h3>
		<p>
			<input type="date" class="medium-text" name="deadline" value="<?php echo esc_textarea( $current_deadline ); ?>" />&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="is_ongoing" value="1" <?php checked( $current_is_ongoing, '1' ); ?> /> <?php esc_html_e( 'This opportunity is ongoing', 'nuclearnetwork' ); ?>
		</p>
		<h3><?php esc_html_e( 'Apply URL:', 'nuclearnetwork' ); ?></h3>
		<p>
			<input type="text" class="large-text" name="info_url" value="<?php echo esc_textarea( $current_info_url ); ?>" /> 
		</p>
	</div>
	<?php
}

/**
 * Build custom field meta box for pages.
 *
 * @param post $post The post object.
 */
function pages_build_meta_box( $post ) {
	// Make sure the form request comes from WordPress.
	wp_nonce_field( basename( __FILE__ ), 'post_meta_box_nonce' );

	// Retrieve current value of fields.
	$current_sidebar = get_post_meta( $post->ID, '_post_sidebar', true );
	$current_footer = get_post_meta( $post->ID, '_post_footer', true );
	?>
	<div class='inside'>
		<h3><?php esc_html_e( 'Sidebar Content:', 'nuclearnetwork' ); ?></h3>
		<p>
			<?php
				wp_editor(
					$current_sidebar,
					'sidebar',
					array(
						'media_buttons' => false,
						'textarea_name' => 'sidebar',
						'textarea_rows' => 5,
						'teeny' => true,
					)
				);
			?>
		</p>
		<h3><?php esc_html_e( 'Footer Content:', 'nuclearnetwork' ); ?></h3>
		<p>
			<?php
				wp_editor(
					$current_footer,
					'footer',
					array(
						'media_buttons' => false,
						'textarea_name' => 'footer',
						'textarea_rows' => 5,
						'teeny' => true,
					)
				);
			?>
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

	// Deadline
	if ( isset( $_REQUEST['deadline'] ) ) { // Input var okay.
		$deadline = sanitize_text_field( wp_unslash( $_POST['deadline'] ) ); // Input var okay.
		$date = explode( '-', $deadline );
		if ( wp_checkdate( $date[1], $date[2], $date[0], $deadline ) || empty( $deadline ) ) {
			update_post_meta( $post_id, '_post_deadline', $deadline ); // Input var okay.
		}
	}
	// Disable Disclaimer
	if ( isset( $_REQUEST['disable_disclaimer'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_disable_disclaimer', intval( wp_unslash( $_POST['disable_disclaimer'] ) ) ); // Input var okay.
	} else {
		update_post_meta( $post_id, '_post_disable_disclaimer', '' );
	}
	// Disable LinkedIn
	if ( isset( $_REQUEST['disable_linkedin'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_disable_linkedin', intval( wp_unslash( $_POST['disable_linkedin'] ) ) ); // Input var okay.
	} else {
		update_post_meta( $post_id, '_post_disable_linkedin', '' );
	}
	// Download URL
	if ( isset( $_REQUEST['download_url'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_download_url', esc_url_raw( wp_unslash( $_POST['download_url'] ) ) ); // Input var okay.
	}
	// End Date
	if ( isset( $_REQUEST['end_date'] ) ) { // Input var okay.
		$end_date = sanitize_text_field( wp_unslash( $_POST['end_date'] ) ); // Input var okay.
		$date = explode( '-', $end_date );
		if ( wp_checkdate( $date[1], $date[2], $date[0], $end_date ) || empty( $start_date ) ) {
			update_post_meta( $post_id, '_post_end_date', $end_date ); // Input var okay.
		}
	}
	// Info URL (Apply/Register URL)
	if ( isset( $_REQUEST['info_url'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_info_url', esc_url_raw( wp_unslash( $_POST['info_url'] ) ) ); // Input var okay.
	}
	// Is Ongoing
	if ( isset( $_REQUEST['is_ongoing'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_is_ongoing', intval( wp_unslash( $_POST['is_ongoing'] ) ) ); // Input var okay.
	} else {
		update_post_meta( $post_id, '_post_is_ongoing', '' );
	}
	// Is Next Gen
	if ( isset( $_REQUEST['is_nextgen'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_is_nextgen', intval( wp_unslash( $_POST['is_nextgen'] ) ) ); // Input var okay.
	} else {
		update_post_meta( $post_id, '_post_is_nextgen', '' );
	}
	// Footer
	if ( isset( $_REQUEST['footer'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_footer', wp_kses_post( wp_unslash( $_POST['footer'] ) ) ); // Input var okay.
	}
	// LinkedIn URL
	if ( isset( $_REQUEST['linkedin_url'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_linkedin_url', esc_url_raw( wp_unslash( $_POST['linkedin_url'] ) ) ); // Input var okay.
	}
	// Location
	if ( isset( $_REQUEST['location'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_location', sanitize_text_field( wp_unslash( $_POST['location'] ) ) ); // Input var okay.
	}
	// PONI Sponsored
	if ( isset( $_REQUEST['poni_sponsored'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_poni_sponsored', intval( wp_unslash( $_POST['poni_sponsored'] ) ) ); // Input var okay.
	} else {
		update_post_meta( $post_id, '_post_poni_sponsored', '' );
	}
	// Post Format
	if ( isset( $_REQUEST['post_format'] ) ) { // Input var okay.
		// echo $_POST['post_format'];
		// die();
		update_post_meta( $post_id, '_post_post_format', sanitize_text_field( wp_unslash( $_POST['post_format'] ) ) ); // Input var okay.
	}
	// Sidebar
	if ( isset( $_REQUEST['sidebar'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_sidebar', wp_kses_post( wp_unslash( $_POST['sidebar'] ) ) ); // Input var okay.
	}
	// Sources
	if ( isset( $_REQUEST['sources'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_sources', wp_kses_post( wp_unslash( $_POST['sources'] ) ) ); // Input var okay.
	}
	// Start Date
	if ( isset( $_REQUEST['start_date'] ) ) { // Input var okay.
		$start_date = sanitize_text_field( wp_unslash( $_POST['start_date'] ) ); // Input var okay.
		$date = explode( '-', $start_date );
		if ( wp_checkdate( $date[1], $date[2], $date[0], $start_date ) || empty( $start_date ) ) {
			update_post_meta( $post_id, '_post_start_date', $start_date ); // Input var okay.
		}
	}
	// View URL
	if ( isset( $_REQUEST['view_url'] ) ) { // Input var okay.
		update_post_meta( $post_id, '_post_view_url', esc_url_raw( wp_unslash( $_POST['view_url'] ) ) ); // Input var okay.
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
