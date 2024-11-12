<?php
/**
 * Displays the post header
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

	// Borrowed from https://wordpress.stackexchange.com/a/116512
	$ancestors = get_ancestors(
		get_queried_object_id(),
		get_queried_object()->taxonomy
	);
	if ( !empty ( $ancestors ) ) {
		foreach ( $ancestors as $ancestor )
		{
				$term     = get_term( $ancestor, get_queried_object()->taxonomy );
				$subtype = esc_attr( "$term->slug-$term->taxonomy" );
		}
	}


$object = get_queried_object();

$is_archive = is_archive(); //Not search, 404 or Analysis
$is_page = is_page();
$has_thumbnail = has_post_thumbnail();
$post_type = get_post_type(); //News, updates, projects, events, programs
$is_404 = is_404(); //404
$is_search = is_search(); //Search
$is_home = is_home(); //Analysis
$page_for_posts = get_option( 'page_for_posts' );
$is_tag = is_tag(); //Tag
$series_page = get_field('series_page', 'option'); // Series page as archive
$series_page_id = $series_page->ID;
$is_series_page = is_page($series_page_id);
$is_series = is_tax('series') || is_page( $series_page_id ); //Series
$is_category = is_category(); //Category
$is_single = is_single();
$post_parent_id = wp_get_post_parent_id(get_the_ID());


$title_classes = 'entry-header__title entry-header__title--yellow';
if ( $is_tag || $is_category || $is_search || $post_type === 'programs' && $is_single && $post_parent_id ) {
	$title_classes = 'entry-header__title';
}
$description = get_field( 'archive_description', $object->name );
$npn_link = get_field( 'nuclear_policy_news_link', 'option' );
$monthly_news_link = get_field( 'monthly_newsletter_link', 'option' );

$archive_image = get_field('image', $object->name);

if ( $is_home || $is_series || $is_series_page || $subtype === 'analysis-filtered_content_types' ) {
	$archive_image = get_field('image', $page_for_posts);
} elseif ( $is_category || $is_tag || $is_search ) {
	$archive_image = get_field('general_archive_header_image', 'option');
} elseif ( $subtype === 'event-filtered_content_types' ) {
	$archive_image = get_field('image', $term->name . 's');
} elseif ( $post_type === 'programs' && $is_single && $post_parent_id ) {
	$archive_image = get_field('image', $object->post_type);
}

$archive_image_url = $archive_image['url'];
$archive_header_bg = 'linear-gradient(0deg, rgba(2, 99, 190, 0.43), rgba(2, 99, 190, 0.43)),
url(' . $archive_image_url . ')';
?>

<header class="entry-header entry-header--blue" style="background: <?php echo $archive_header_bg; ?> center / cover no-repeat">

<?php
	if ( $is_series || $subtype === 'analysis-filtered_content_types' ) {
		if ( is_page( $series_page_id ) ) {
			the_title( '<h1 class="' . $title_classes . '"> Analysis / <span class="entry-header__title-secondary">', '</span></h1>' );
		} else {
			the_archive_title( '<h1 class="' . $title_classes . '"> Analysis / <span class="entry-header__title-secondary">', '</span></h1>' );
		}
		?>

			<div class="entry-header__grid">

				<div class="entry-header__desc text--short">
					<?php
						if ( is_page( $series_page_id ) ) {
							the_content();
						} else {
							echo term_description();
						}
					?>
				</div>

				<a href="/analysis" class="entry-header__cta cta btn btn--med">All Analysis <?php echo nuclearnetwork_get_svg( 'chevron-right' ); ?></a>

				<div class="entry-header__write-for-us desktop-only">
					<?php dynamic_sidebar( 'write-for-us' ); ?>
				</div>
			</div>
			<?php

	} elseif ( $subtype === 'event-filtered_content_types' ) { ?>

		<?php
		the_archive_title( '<h1 class="' . $title_classes . '"> Events / <span class="entry-header__title-secondary">', '</span></h1>' ); ?>

		<div class="entry-header__grid">
			<a href="/events" class="entry-header__cta cta btn btn--med">All Events <?php echo nuclearnetwork_get_svg( 'chevron-right' ); ?></a>
		</div>
		<?php


	} elseif ( $is_search ) {

		$archive_title = sprintf(
			'%1$s %2$s',
			'<span class="entry-header__title-label">' . __( 'Search results for', 'nuclearnetwork' ) . '</span>',
			'&lsquo;' . get_search_query() . '&rsquo;'
		); ?>

			<h1 class="<?php echo $title_classes; ?>"><?php echo wp_kses_post( $archive_title ); ?></h1>

			<?php

	} elseif ( $post_type === 'updates' && $is_archive ) {

			the_archive_title( '<h1 class="' . $title_classes . '">', '</h1>' ); ?>

		<div class="entry-header__grid">
			<div class="entry-header__desc text--short"><?php echo $description; ?></div>

			<div class="entry-header__newsletter communication-block desktop-only">
				<h2>Monthly Newsletter</h2>
				<p>Get PONI Program Updates delivered directly to your inbox by signing up for our monthly newsletter!</p>
				<a href="<?php echo $monthly_news_link; ?>" class="btn btn--teal">Subscribe</a>
			</div>
		</div>
		<?php

	} else if ( $post_type === 'programs' && $is_single && $post_parent_id ) {

		$parent = $post->post_parent;

		$parent_title = get_the_title( $parent);
		$parent_url = get_permalink( $parent );

		the_title( '<h1 class="' . $title_classes . '"><span class="entry-header__title-label">' . $parent_title . '</span>', '</h1>' );
		?>
		<a href="<?php echo $parent_url; ?>" class="entry-header__cta cta btn btn--med"><?php echo nuclearnetwork_get_svg( 'chevron-left' ); ?> Back to <?php echo $parent_title; ?></a>

		<?php

	} elseif ( $post_type === 'news' ) {

		the_archive_title( '<h1 class="' . $title_classes . '">', '</h1>' ); ?>
		<div class="entry-header__desc text--short"><?php echo $description; ?></div>

		<a href="<?php echo $npn_link; ?>" class="btn btn--teal entry-header__news-btn">Subscribe to the Newsletter</a>
		<?php

	} elseif ( $is_home ) {

		$description = get_field( 'archive_description', $page_for_posts );

		$post = get_page($page_for_posts);
		setup_postdata($post); ?>
		<h1 class="<?php echo $title_classes; ?>"><?php echo wp_kses_post( the_title() ); ?></h1>

		<div class="entry-header__grid">
			<div class="entry-header__desc text--short"><?php echo $description; ?></div>

			<div class="entry-header__write-for-us desktop-only">
			<?php dynamic_sidebar( 'write-for-us' ); ?>
			</div>
		</div>
		<?php

	} elseif ( $is_archive ) {

		the_archive_title( '<h1 class="' . $title_classes . '">', '</h1>' ); ?>

		<div class="entry-header__desc text--short"><?php echo $description; ?></div>
		<?php

	} elseif ( $is_category || $is_tag ) {

		the_archive_title( '<h1 class="' . $title_classes . '">', '</h1>' ); ?>

		<div class="entry-header__desc text--short"><?php echo $description; ?></div>
		<?php

	} else {
		get_template_part( 'template-parts/entry-header-light' );
	}
	?>

</header><!-- .entry-header -->
