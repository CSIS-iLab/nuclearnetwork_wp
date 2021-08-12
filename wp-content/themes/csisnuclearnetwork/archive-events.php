<?php
/**
 * The Archive template.
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

$term = get_queried_object();
$date_now = date('Y-m-d H:i:s');

get_header();
?>

<main id="site-content" role="main">
	<?php
		get_template_part( 'template-parts/entry-header' );
	?>

	<div class='archive__content'>
		<?php
			if ( have_posts() && !is_paged() ) {
		?>
		<h2 class="archive__section-title">Upcoming Events</h2>
		<section class="archive__postlist events__upcoming">
		<?php
			$upcoming_args = array(
				'post_type' => 'events',
				'post_status' => 'publish',
				'meta_query' => array(
					'relation' => 'OR',
        	array(
            'key'           => 'event_post_info_event_start_date',
            'compare'       => '>=',
            'value'         => $date_now,
            'type'          => 'DATE',
					),
    		),
				'orderby' => 'meta_value',
				'order' => 'ASC'
			);

			$upcoming_posts = new WP_Query( $upcoming_args );

			if ( $upcoming_posts->have_posts() ) {
				while ( $upcoming_posts->have_posts() ) {
					$upcoming_posts->the_post();
					get_template_part( 'template-parts/block-post', get_post_type() );
				}
				wp_reset_postdata();
			} else {
				echo '<p class="archive__disclaimer text--long">There are no upcoming events at the moment. Check back soon!</p>';
			}
		?>
		</section>
	<?php } ?>
	<?php
		if ( have_posts() ) {
			echo '<h2 class="archive__section-title">Past Events</h2>';
			nuclearnetwork_pagination_number_of_posts( array("parent_tag" => "div") );

			echo '<section class="archive__postlist">';
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/block-post', get_post_type() );
			}
			wp_reset_postdata();

		  get_template_part( 'template-parts/pagination' );

			echo "</section>";
    }

	?>
	</div>

</main><!-- #site-content -->

<?php
get_footer();
