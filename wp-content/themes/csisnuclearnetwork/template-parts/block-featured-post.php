<?php
/**
 * The default template for displaying content
 *
 * Used for front page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */
$post_type = get_post_type();
?>

<?php
$event_info = get_field( 'event_post_info' );
$event_start_date = $event_info['event_start_date'];
$legacy_event_date = get_post_meta( $id, '_post_start_date', true );


if ($args[0] == "true") {
    $post_info = "primary";
}else {
    $post_info = "secondary";
}

$classes = 'feat-post';

if ( $event_start_date ) {
	$event_day = date_i18n('d', strtotime($event_start_date));
	$event_month = date_i18n('M', strtotime($event_start_date));
	$event_year = date_i18n('Y', strtotime($event_start_date));
	
	$event_date = $event_month . ' ' . $event_day . ', ' . $event_year;
}

if ( $legacy_event_date ) {
	$event_day = date_i18n('d', strtotime($legacy_event_date));
	$event_month = date_i18n('M', strtotime($legacy_event_date));
	$event_year = date_i18n('Y', strtotime($legacy_event_date));
	
	$event_date = $event_month . ' ' . $event_day . ', ' . $event_year;
}


?>
<article <?php post_class( $classes ); ?> id="post-<?php the_ID(); ?>">	
		<?php if ( $args[0] == "true" ) : ?>
				<?php echo "<div class='aspect-ratio'><div class='feat-post__image' style='background-image: linear-gradient(180deg, rgba(0, 0, 0, 0) 66.55%, rgba(10, 35, 58, 0.7) 100%), url(" . get_the_post_thumbnail_url() . ") ;'><div class='feat-post__gradient-top'></div><div class='feat-post__gradient-bottom'></div></div></div>" ?>
			<!-- <div class="feat-post__gradient-top"></div>
			<div class="feat-post__gradient-bottom"></div> -->
			<?php endif; ?>
			<div class="feat-post__content">
				<?php
			nuclearnetwork_display_subtypes();
			the_title( '<h3 class="feat-post__title text--bold"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );

if ( $post_type === 'events' ) { 
			if ( $event_date ) {
			echo '<dl class="post-meta post-meta__date"><dt class="post-meta__label">Event Date</dt><dd>' . $event_date . '</dd></dl>';
			}
			the_excerpt(); 

	} else {
		nuclearnetwork_authors();
		nuclearnetwork_posted_on('M j, Y');
		the_excerpt();
		nuclearnetwork_display_series();
	} 
	?>
	</div>
</article><!-- .post -->
