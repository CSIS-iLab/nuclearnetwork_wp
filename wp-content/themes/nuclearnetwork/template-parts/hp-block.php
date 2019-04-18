<?php
/**
 * Homepage Block Component
 *
 * @package Nuclear_Network
 */

if ( $post->menu_featured_img ) {
	$featured_img = ' style="background-image:url(\'' . esc_attr( $post->menu_featured_img ) . '\');"';
} else {
	$featured_img = null;
}

if ( 'events' === $post->featured_post->post_type ) {
	$date = get_post_meta( $post->featured_post->ID, '_post_start_date', true );
	$formatted_date = date_create_from_format('Y-n-d', $date);
	$date = date_format($formatted_date, 'F j, Y');
} elseif ( 'opportunities' === $post->featured_post->post_type ) {
	$date = get_post_meta( $post->featured_post->ID, '_post_deadline', true );
	if ( $date ) {
		$formatted_date = date_create_from_format('Y-n-d', $date);
		$date = date_format($formatted_date, 'F j, Y');
	} else {
		$date = '';
	}
} elseif ( 'page' === $post->featured_post->post_type ) {
	$date = '';
} else {
	$date = get_the_date( '', $post->featured_post->ID );
}

?>

<div class="hp-block split-main block-<?php echo sanitize_html_class( $post->block_color ); ?>">
	<?php
	the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
	?>
	<?php the_content(); ?>

	<ul class="block-submenu">
		<?php
		foreach ( $post->children as $child ) {
			echo '<li><a href="' . esc_url( $child->url ) . '" rel="bookmark">' . esc_html( $child->post_title ) . '</a></li>';
		}
		?>
	</ul>

</div>
<div class="hp-block split-featured">
	<div class="split-featured-img"<?php echo $featured_img; ?>></div>
	<?php if ( $post->featured_post ) :	?>
		<div class="split-featured-content">
			<h6 class="subsection-header"><?php esc_html_e( 'Featured', 'nuclearnetwork' ); ?></h6>
			<?php
				echo '<a href="' . esc_url( get_the_permalink( $post->featured_post->ID ) ) . '" rel="bookmark" class="post-title">' . esc_html( $post->featured_post->post_title ) . '</a>';
				echo '<span class="post-date">' . $date . '</span>';
			?>
		</div>
	<?php endif; ?>
</div>
