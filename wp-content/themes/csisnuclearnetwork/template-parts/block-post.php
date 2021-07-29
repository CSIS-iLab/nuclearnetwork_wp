<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

$post_type = get_post_type();
$page_for_posts = get_option( 'page_for_posts' );

$featured_post = get_field( 'featured_post' );
$is_monthly_newsletter = get_field( 'newsletter');
$event_info = get_field( 'event_post_info' );
$event_start_date = $event_info['event_start_date'];
$event_start_time = $event_info['event_start_time'];
$legacy_event_date = get_post_meta( $id, '_post_start_date', true );

$classes = ' post-block post-block--post ' . $post_type;

if ( $is_monthly_newsletter ) {
	$classes .= ' post-block__monthly-newsletter';
} elseif ( $featured_post ) {
	$classes .= ' post-block__featured';
}

if ( $event_start_date ) {
	$event_day = date_i18n('d', strtotime($event_start_date));
	$event_month = date_i18n('M', strtotime($event_start_date));
	$event_year = date_i18n('Y', strtotime($event_start_date));
	
	$event_date = '<span class="post-block__event-month text--caps">' . $event_month . '</span><span class="post-block__event-day">' . $event_day . '</span><span class="post-block__event-year text--short">' . $event_year . '</span>';
}

if ( $legacy_event_date ) {
	$event_day = date_i18n('d', strtotime($legacy_event_date));
	$event_month = date_i18n('M', strtotime($legacy_event_date));
	$event_year = date_i18n('Y', strtotime($legacy_event_date));
	
	$event_date = '<span class="post-block__event-month text--caps">' . $event_month . '</span><span class="post-block__event-day">' . $event_day . '</span><span class="post-block__event-year text--short">' . $event_year . '</span>';
}

$event_full_date = date_i18n( strtotime("$event_start_date $event_start_time"));
$yesterday = strtotime('now');

if ( $event_full_date >= $yesterday ) {
	$is_future_event = true;
}

if ( $event_start_time && $event_info['event_end_time'] ) {
	$start_time = wp_date('g:i', strtotime($event_start_time));
	$end_time = wp_date('g:i A T', strtotime($event_info['event_end_time']));
	$event_time = $start_time . ' - ' . $end_time;
} elseif ( $event_start_time ) {
	$event_time = wp_date('g:i A T', strtotime($event_start_time));
}

?>
<article <?php post_class( $classes ); ?> id="post-<?php the_ID(); ?>">	
		<?php if ( has_post_thumbnail() && $post_type != 'events' && !$is_monthly_newsletter ) : ?>
			<a href="<?php the_permalink(); ?>" class="post-block__img" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'large' ); ?>
			</a>
		<?php endif; ?>

	<?php

	if ( $is_monthly_newsletter ) {
		nuclearnetwork_display_subtypes();
		the_title( '<h3 class="post-block__title text--bold"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
		nuclearnetwork_posted_on('M j, Y');
	} elseif ( $post_type === 'news' ) {
		the_title( '<h3 class="post-block__title text--bold"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
		nuclearnetwork_posted_on('Y');
	} elseif ( $post_type === 'events' ) { ?>
	<div class="post-block__event-content">
		<?php
		if ( $event_date ) { ?>
		<div class="post-block__event-date"><?php echo $event_date; ?></div>
		<?php
		}
		nuclearnetwork_display_subtypes();
		the_title( '<h3 class="post-block__title text--bold"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
		the_excerpt(); 
		if ( $event_info['event_registration_link'] && $is_future_event && !$legacy_event_date ) { ?>
		<a href="<?php echo esc_url( $event_info['event_registration_link'] ); ?>" class="post-block__register btn btn--outline-blue">Register<?php echo nuclearnetwork_get_svg( 'arrow-external' ); ?></a>
		<?php
		} ?>
	</div>
	<?php
	if ( $event_start_date || $event_info['event_location'] ) { ?>
	<div class="post-block__event-meta">
		<?php
		if ( $event_start_time ) { ?>
		<div class="post-meta post-meta__event"><span class="post-meta__label">Time</span><?php echo $event_time; ?></div>
		<?php
		}
		if ( $event_info['event_location'] ) { ?>
		<div class="post-meta post-meta__event"><span class="post-meta__label">Location</span><?php echo $event_info['event_location']; ?></div>
		<?php
		} ?>
	</div>
	<?php
	}
	} else {
		nuclearnetwork_display_subtypes();
		the_title( '<h3 class="post-block__title text--bold"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
		nuclearnetwork_authors();
		nuclearnetwork_posted_on('M j, Y');
		the_excerpt();
		nuclearnetwork_display_series();
	} 
	?>
</article><!-- .post -->
