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

if ( $is_search || $is_tag || $is_category ) {
	$image_URL = get_field( 'header_image', 'option' );
} elseif ( $is_home || $is_series) {
	$image_URL = get_the_post_thumbnail_url( $page_for_posts );
} else {
	$image_URL = get_archive_thumbnail_src( 'nuclearnetwork-fullscreen' );
}

$feat_image = 'style="background-image:url('. $image_URL .');"';
$headerClasses = 'entry-header--light';

$title_classes = 'entry-header__title entry-header__title--yellow';
if ( $is_tag || $is_category || $is_search || $post_type === 'programs' && $is_single && $post_parent_id ) {
	$title_classes = 'entry-header__title';
}
$description = get_field( 'archive_description', $object->name );
$monthly_news_link = get_field( 'monthly_newsletter_link', 'option' );

$template = get_page_template_slug( get_the_ID() );
$isNoImageTemplate = false;

if ( $template === 'templates/template-no-image.php' ){
	$isNoImageTemplate = true;
}

?>

<header class="entry-header <?php echo $headerClasses; ?>">

<?php
var_dump($is_author);

	if ( $is_404 ) { ?>

			<h1 class="<?php echo $title_classes; ?>"><?php _e( '404', 'nuclearnetwork' ); ?></h1>

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
