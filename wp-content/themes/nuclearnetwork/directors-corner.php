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

$img = get_option( 'nuclearnetwork_authors_archive_image' );
$featured_img = ' style="background-image:url(\'' . esc_attr( $img ) . '\');"';
?>

<div id="primary" class="content-area">
  <main id="main" class="site-main">
  
      <!-- page-header -->
	  <header class="page-header"<?php echo $featured_img; ?>>
      <div class="header-content">
        <div class="archive-category"><p><?php the_field('title'); ?></p></div>
        <h1 class="page-title"><?php the_field('name');  ?></h1>
      </div>
    </header>

    <div class="content-wrapper row archive-container">
      <div class="col-xs-12 col-md-9 archive-content"> 
        <div class="entry-content">
          <div class="post-wrapper">

          <!-- Wordpress loop to display main content -->
          <?php
            while ( have_posts() ) {
              the_post();
              get_template_part( 'template-parts/content', 'page' );
            } 
          ?>
              
          <!-- To friends of Poni Section -->
          <?php
            if ( nuclearnetwork_directors_list('Rebecca Hersman') ) :
          ?>
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
            endif;
          ?>

          <a class="btn btn-blue" href="http://nuclearnetwork.csis/tag/directors-corner/">view all</a>   
        </div>
      </div>

      <div class="bio-wrapper"><button class="btn btn-blue">full bio & headshot</button></div>
        <?php endif; ?>

      
        <hr>
        <!-- WP query to display posts by type -->
        <?php
          $posts = get_posts(array(
            'post_type'			=> 'post',
            'posts_per_page'	=> -1,
            'order'				=> 'DESC',
          ));

          $name = get_field('name');
          
          if( $posts ):
            foreach( $posts as $post ): 
                  
              setup_postdata( $post );
              if ( nuclearnetwork_directors_list($name) ) :    
  

                
          ?>
          <?php	get_template_part( 'template-parts/content', get_post_type() );?>
                <?php
              endif;
            endforeach;
          wp_reset_postdata();
        endif; ?>

        
      </div>
  
      </div>
				<div class="col-xs-12 col-md-3 archive-sidebar">
					<?php get_sidebar(); ?>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
