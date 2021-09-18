<?php
/**
 * The template for displaying Author info
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

global $coauthors_plus;

$author = get_queried_object();
$author_id = $author->ID;


$coauthor_data = $coauthors_plus->get_coauthor_by( 'id', $author_id );
$title = get_field( 'title', $author_id );
$bio_file = get_field( 'bio_file', $author_id );
$is_senior = get_field( 'senior_staff', $author_id );
$user_bio = $coauthor_data->description;
if ( !$user_bio ) {
	$user_bio = get_user_meta( $author_id, 'description', true );
} elseif ( !$user_bio) {
	$user_bio = get_field( 'short_bio', $author_id );
}

?>
<div class="author-bio">
		<div class="author-avatar vcard">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 160 ); ?>
		</div>
	<div class="author-description">
		<?php echo wp_kses_post( wpautop( $user_bio ) ); ?>
	</div><!-- .author-description -->
		<?php if ( $is_senior === true ) {
			echo '<a href="' . $bio_file['url'] . '" class="btn btn--large btn--outline-dark">Download Bio and Headshot ' . nuclearnetwork_get_svg( 'download' ) .'</a>';
		}
		?>
</div><!-- .author-bio -->
