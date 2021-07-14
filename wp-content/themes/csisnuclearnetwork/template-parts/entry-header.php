<?php
/**
 * Displays the post header
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

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
$is_series = is_tax('series'); //Series
$is_category = is_category(); //Category
$is_author = is_author(); //Author
$is_single = is_single();

if ( $is_search || $is_tag || $is_category ) {
	$image_URL = get_field( 'header_image', 'option' );
} elseif ( $is_home || $is_series) {
	$image_URL = get_the_post_thumbnail_url( $page_for_posts );
} else {
	$image_URL = get_archive_thumbnail_src( 'nuclearnetwork-fullscreen' );
}

$feat_image = 'style="background-image:url('. $image_URL .');"';
$header = '<header class="entry-header entry-header--blue">';
if ( $is_author || $is_single || $pagename === 'about' || $is_author ) {
	$header = '<header class="entry-header entry-header--light">';
}
$description = get_field( 'archive_description', $object->name );
$npn_link = get_field( 'nuclear_policy_news_link', 'option' );
$monthly_news_link = get_field( 'monthly_newsletter_link', 'option' );

$template = get_page_template_slug( get_the_ID() );
$isNoImageTemplate = false;

if ( $template === 'templates/template-no-image.php' ){
	$isNoImageTemplate = true;
}

?>


<?php

echo $header;

	if ( $is_series ) { ?>

			<?php 
			the_archive_title( '<h1 class="entry-header__title"> Analysis / <span class="entry-header__title--secondary">', '</span></h1>' ); ?>

			<div class="entry-header__desc"><?php echo term_description(); ?></div>

			<a href="/analysis" class="entry-header__cta cta">All Analysis ></a>

			<div class="entry-header__write-for-us">
				<h2>Write for us placeholder</h2>
				<p>Become a guest author with PONI to have your analysis published on our site. </p>
			</div>
			<?php

			
	} elseif ( $post_type === 'programs' ) {

			the_archive_title( '<h1 class="entry-header__title">', '</h1>' ); ?>
			<div class="entry-header__desc"><?php echo $description; ?></div>

			<div class="entry-header__newsletter">
				<h2>Monthly Newsletter</h2>
				<p>Get PONI Program Updates delivered directly to your inbox by signing up for our monthly newsletter!</p>
				<a href="<?php echo $monthly_news_link; ?>" class="btn">Subscribe</a>
			</div>
			<?php
	} elseif ( $post_type === 'news' ) {

		the_archive_title( '<h1 class="entry-header__title">', '</h1>' ); ?>
		<div class="entry-header__desc"><?php echo $description; ?></div>

		<a href="<?php echo $npn_link; ?>" class="btn">Subscribe to the Newsletter</a>
		<?php

	} elseif ( $is_archive ) {

			the_archive_title( '<h1 class="entry-header__title">', '</h1>' ); ?>
			
			<div class="entry-header__desc"><?php echo $description; ?></div>
			<?php

	} elseif ( $is_home ) {

		$description = get_field( 'archive_description', $page_for_posts );
		
		$post = get_page($page_for_posts);
		setup_postdata($post); ?>
		<h1 class="entry-header__title"><?php echo wp_kses_post( the_title() ); ?></h1>
		<div class="entry-header__desc"><?php echo $description; ?></div>

		<div class="entry-header__write-for-us">
			<h2>Write for us placeholder</h2>
			<p>Become a guest author with PONI to have your analysis published on our site. </p>
		</div>
		<?php

	} elseif ( $is_search ) {
			
		$archive_title = sprintf(
			'%1$s %2$s',
			'<span class="entry-header__title-label">' . __( 'Search results for', 'nuclearnetwork' ) . '</span>',
			'&lsquo;' . get_search_query() . '&rsquo;'
		); ?>
				
			<h1 class="entry-header__title"><?php echo wp_kses_post( $archive_title ); ?></h1>
			
			<?php

	} elseif ( $is_404 ) { ?>

			<h1 class="entry-header__title"><?php _e( '404', 'nuclearnetwork' ); ?></h1>

		<?php 

	} elseif ( $is_page ) { 
			the_title( '<h1 class="entry-header__title">', '</h1>' );

			nuclearnetwork_page_desc();

	} elseif ( $is_single ) { 
			echo '<div class="entry-header__header-content">';
				the_title( '<h1 class="entry-header__title">', '</h1>' );
				nuclearnetwork_page_desc();
				nuclearnetwork_authors();
				nuclearnetwork_posted_on();
			echo '</div>';
			if ( !$isNoImageTemplate ) {
				get_template_part( 'template-parts/featured-image' );
			}

	}
	?>

</header><!-- .entry-header -->
