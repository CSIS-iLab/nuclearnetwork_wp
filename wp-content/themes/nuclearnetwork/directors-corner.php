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


	


		<?php
				if ( have_posts() ) :

					nuclearnetwork_post_num();

					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						
						if( in_array( get_post_type(), array( 'post' ), true ) ) {
							get_template_part( 'template-parts/content-search', nuclearnetwork_post_format( ) );
						} else {
							get_template_part( 'template-parts/content', 'search' );
						}

					endwhile;

				endif; ?>


































      </div>
            <div class="director-sidebar">
              <img src="<?php the_field('image'); ?>" alt="director's photo"/>
              <h4>to friends of poni</h4>
              <p><?php the_field('community_message'); ?></p>
        



             
				
 
	<?php
		$args = array(
			'post_type' => 'announcements',
			'tag' => 'directors-corner',
			'posts_per_page' => 2
		);
		$the_query = new WP_Query( $args );
	?>	
	<?php
		if ( $the_query->have_posts() ):
		while ( $the_query->have_posts() ):
		$the_query->the_post();
	?>
	<ul>
		<li>
			<a href="http://nuclear-network:8888/?page_id=<?php echo the_ID(); ?>&preview=true"><?php the_Title() ?></a>
		</li>	
	</ul>
			
	<?php
		endwhile;
		wp_reset_postdata();
		else:
	?>

	<?php
		endif;
	?>
 <a class="btn btn-blue" href="http://nuclearnetwork.csis/tag/directors-corner/">view all</a>   
            </div>



<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

			endwhile; // End of the loop.
			?>

<?php
		$args = array(
			'post_type' => 'post',
			'author_name' => 'rebecca-hersman',
			'_post_post_format' => 'report',
			'posts_per_page' => 5
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
	                   ?>
                   </h2>
                   

	<?php
		endwhile;
		wp_reset_postdata();
		else:

		endif;
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
	
