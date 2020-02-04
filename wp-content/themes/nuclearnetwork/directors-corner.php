<?php
/**
 * The template for the Director's Corner 
 *
 * Template Name: Director's Corner
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nuclear_Network
 */

get_header();

// if ( is_category() || is_tag() ) {
// 	$img = get_option( 'nuclearnetwork_category_and_tag_archive_image' );
// } elseif ( is_author() ) {
// 	$img = get_option( 'nuclearnetwork_authors_archive_image' );
// } else {
// 	$img = get_archive_thumbnail_src( 'full' );
// }

// $featured_img = ' style="background-image:url(\'' . esc_attr( $img ) . '\');"';

?>

<div id="primary" class="content-area">
		<main id="main" class="site-main content-wrapper">
			<header class="page-header"<?php echo $featured_img; ?>>
        <div class="header-content">
          <h2><?php the_field('title'); ?></h2>
          <h1><?php the_field('name'); ?></h1>
        </div>
        
      </header><!-- .page-header -->
      

			<div class="content-wrapper row archive-container">
				<div class="col-xs-12 col-md-9 archive-content director-content">

      <div class="entry-content">
        <!-- To friends of Poni Section -->
      </div>
            <div class="director-sidebar">
              <img src="<?php the_field('image'); ?>" alt="director's photo"/>
              <h4>to friends of poni</h4>
              <p><?php the_field('community_message'); ?></p>
                <!-- for looop here -->
              <a class="btn btn-blue" href="">view all</a>   
            </div>
				
				
<?php

	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/content', 'page' );
		

	endwhile; // End of the loop.

	the_posts_pagination();


	?>
    </div>
      <div class="col-xs-12 col-md-3 archive-sidebar">
        <?php get_sidebar(); ?>
      </div>
    </div>

    </main><!-- #main -->
  </div><!-- #primary -->

    <?php
    get_footer();