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
$page_for_posts = get_option( 'page_for_posts' );
$is_author = is_author(); //Author
$is_single = is_single();
$post_parent_id = wp_get_post_parent_id(get_the_ID());

$description = get_the_excerpt();

$template = get_page_template_slug( get_the_ID() );
$isNoImageTemplate = false;

if ( $template === 'templates/template-no-image.php' ){
	$isNoImageTemplate = true;
}

?>

<header class="entry-header entry-header--light">

<div class="entry-header__header-content">
	<div class="home__subtitle--border"></div>

<?php
	if ( !$is_author ) { 
		nuclearnetwork_display_subtypes(); 
	}
	if ( $is_author || $pagename === 'about' ) { echo '<div class="post-meta post-meta__terms"><a href="' . site_url( "/about/" ) . '" class="post-meta__terms-type text--bold">About</a></div>';}
	if ( $is_author ) {
		the_archive_title( '<h1 class="entry-header__title">', '</h1>' );
	} else {
		the_title( '<h1 class="entry-header__title">', '</h1>' );
	}

	if ( $is_404 ) { ?>

			<h1 class="entry-header__title"><?php _e( '404', 'nuclearnetwork' ); ?></h1>

		<?php 

	} elseif ( $post_type === 'events' && $is_single ) {
		// echo '<div class="entry-header__header-content">';

	} elseif ( $is_single ) { 
		nuclearnetwork_display_series();
		the_excerpt();
		nuclearnetwork_posted_on();
		nuclearnetwork_authors();
	} 

	if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { ADDTOANY_SHARE_SAVE_KIT(); }
	?>

</div><!-- .entry-header__header-content -->
	<?php
	if ( !$isNoImageTemplate ) {
		get_template_part( 'template-parts/featured-image' );
	}
	?>

</header><!-- .entry-header -->
