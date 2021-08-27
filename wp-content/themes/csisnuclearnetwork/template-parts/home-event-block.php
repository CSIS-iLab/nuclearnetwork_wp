<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CSIS iLab
 * @subpackage @package nuclearnetwork
 * @since 1.0.0
 */

?>

<?php 
$post_type = get_post_type();

$event_info = get_field( 'event_post_info' );
$event_start_date = $event_info['event_start_date'];
$legacy_event_date = get_post_meta( $id, '_post_start_date', true );

if ( $event_start_date ) {
	$event_day = date_i18n('d', strtotime($event_start_date));
	$event_month = date_i18n('M', strtotime($event_start_date));
	$event_year = date_i18n('Y', strtotime($event_start_date));
	
	$event_date = '<span class="event-month text--caps">' . $event_month . '</span><span class="event-day">' . $event_day . '</span><span class="event-year text--short">' . $event_year . '</span>';
}

if ( $legacy_event_date ) {
	$event_day = date_i18n('d', strtotime($legacy_event_date));
	$event_month = date_i18n('M', strtotime($legacy_event_date));
	$event_year = date_i18n('Y', strtotime($legacy_event_date));
	
	$event_date = '<span class="event-month text--caps">' . $event_month . '</span><span class="event-day">' . $event_day . '</span><span class="event-year text--short">' . $event_year . '</span>';
}

$event_full_date = date_i18n( strtotime("$event_start_date $event_start_time"));
$yesterday = strtotime('now');
?>

<?php
if ($yesterday >= $event_full_date){
    // this event has passed
    return;
} else {
?>
<h3 class='upcoming-event-title'>Upcoming Event</h3>
<div class="event event-content">
			<?php
			if ( $event_date ) { ?>
			<div class="event-date"><?php echo $event_date; ?></div>
			<?php
			}
			nuclearnetwork_display_subtypes();
			the_title( '<h3 class="title text--bold"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
			?>
</div>
<div class='post-meta__event-meta'></div>

<?php } ?>