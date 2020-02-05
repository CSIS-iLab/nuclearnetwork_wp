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
		<main id="main" class="site-main">
			<header class="page-header">
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



              <a class="btn btn-blue" href="http://nuclear-network:8888/tag/directors-corner/">view all</a>   
            </div>
				
 
	<?php
		$args = array(
			'post_type' => 'announcements',
			'tag' => 'directors-corner',
			'posts_per_page' => 3
		);
		$the_query = new WP_Query( $args );
	?>	
	<?php
		if ( $the_query->have_posts() ):
		while ( $the_query->have_posts() ):
		$the_query->the_post();
	?>
	<h2><?php
		the_title();
	?></h2>
	<?php
		the_excerpt();
	?>

	<?php
		endwhile;
		wp_reset_postdata();
		else:
	?>

	<p><?php
		esc_html_e( 'Sorry, no posts matched your criteria.' );
	?></p>

<?php
	endif;
?>




<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

			endwhile; // End of the loop.
			?>





	
    </div>
      <div class="col-xs-12 col-md-3 archive-sidebar">
        <?php get_sidebar(); ?>
      </div>
    </div>
	<div>
</div>



		
    </main><!-- #main -->
  </div><!-- #primary -->

    <?php
	get_footer();
	
