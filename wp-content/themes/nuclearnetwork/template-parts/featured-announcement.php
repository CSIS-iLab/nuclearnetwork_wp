<?php
/**
 * Featured Announcement
 *
 * @package Nuclear_Network
 */

?>

<div class="featured-announcement row">
	<?php
	if ( has_post_thumbnail() ) {
		echo '<div class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">';
		the_post_thumbnail( 'medium_large' );
		echo '</a></div>';
	}
	?>
	<div class="post-container">
		<?php nuclearnetwork_post_format( $post->ID ); ?>
		<?php the_title( '<h5 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h5>' ); ?>
		<?php echo '<span class="post-date">'; ?>
		<?php the_date(); ?>
		<?php echo '</span>' ?>
	</div>
</div>
