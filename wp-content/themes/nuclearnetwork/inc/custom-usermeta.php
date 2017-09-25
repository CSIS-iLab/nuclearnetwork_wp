<?php
/**
 * The field on the editing screens.
 *
 * @param $user WP_User user object
 */
function nuclearnetwork_user_title( $user ) {
	?>
	<h3>Additional Info</h3>
	<table class="form-table">
		<tr>
			<th>
				<label for="title">Job Title/Position</label>
			</th>
			<td>
				<input type="text"
					   class="regular-text ltr"
					   id="title"
					   name="title"
					   value="<?php echo esc_attr( get_user_meta( $user->ID, 'title', true ) ); ?>">
				<p class="description">
					Job Title/Position
				</p>
			</td>
		</tr>
	</table>
	<?php
}

/**
 * The save action.
 *
 * @param $user_id int the ID of the current user.
 *
 * @return bool Meta ID if the key didn't exist, true on successful update, false on failure.
 */
function nuclearnetwork_user_title_update( $user_id ) {
	// Check that the current user have the capability to edit the $user_id.
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	// Create/update user meta for the $user_id.
	return update_user_meta(
		$user_id,
		'title',
		$_POST['title']
	);
}

// Add the field to user's own profile editing screen.
add_action(
	'edit_user_profile',
	'nuclearnetwork_user_title'
);

// Add the field to user profile editing screen.
add_action(
	'show_user_profile',
	'nuclearnetwork_user_title'
);

// Add the save action to user's own profile editing screen update.
add_action(
	'personal_options_update',
	'nuclearnetwork_user_title_update'
);

// Add the save action to user profile editing screen update.
add_action(
	'edit_user_profile_update',
	'nuclearnetwork_user_title_update'
);


add_filter( 'coauthors_guest_author_fields', 'nuclearnetwork_filter_guest_author_fields', 10, 2 );
/**
 * Add fields for Guest Author names.
 */
function nuclearnetwork_filter_guest_author_fields( $fields_to_return, $groups ) {
	if ( in_array( 'all', $groups ) || in_array( 'name', $groups ) ) {
		$fields_to_return[] = array(
			'key'      => 'name_prefix',
			'label'    => 'Prefix/Title',
			'group'    => 'name',
		);
		$fields_to_return[] = array(
			'key'   => 'name_suffix',
			'label' => 'Suffix',
			'group' => 'name',
		);
	}
	return $fields_to_return;
}
