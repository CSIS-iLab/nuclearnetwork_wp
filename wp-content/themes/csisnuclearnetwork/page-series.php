<?php
/**
 * Template for displaying "Series" page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

get_header(); ?>

<main id="site-content" role="main">

  <?php
		get_template_part( 'template-parts/entry-header-blue' );
	?>

  <div class="archive__content">
    <?php
      $seriesList = get_terms( array(
				'taxonomy' => 'series',
				'hide_empty' => true,
      ) );

      if ( !empty($seriesList) ) {
        foreach($seriesList as $post) : setup_postdata($post);
          get_template_part( 'template-parts/block-series' );
        endforeach;
        wp_reset_postdata();
      }
    ?>

  </div>
</main><!-- #main -->

<?php
get_footer();
