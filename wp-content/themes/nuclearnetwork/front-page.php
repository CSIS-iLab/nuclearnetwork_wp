<?php
/**
 * Home Page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nuclear_Network
 */

get_header();

$blocks = nuclearnetwork_homepage_blocks();
$img1 = get_option( 'nuclearnetwork_home_img_1' );
$img2 = get_option( 'nuclearnetwork_home_img_2' );
$img3 = get_option( 'nuclearnetwork_home_img_3' );
$img4 = get_option( 'nuclearnetwork_home_img_4' );

?>
	<!-- Logo -->
	<div class="home-logo-container">
		<div class="content-wrapper">
			<img src="/wp-content/themes/nuclearnetwork/img/NGNN-header-logo-home.svg" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" class="logo-home" />
			<?php echo $blocks[0]->post_title; ?>
		</div>
	</div>

	<div id="primary" class="content-area">
		<main id="main" class="site-main content-wrapper">

			<!-- First Row -->
			<div class="row row-section">
				<div class="hp-block col-xs-12 col-md-6">
					<?php echo '<p class="tagline">' . esc_html( get_option( 'nuclearnetwork_home_desc_short' ) ) . '</p>'; ?>
				</div>
				<div class="col-xs-12 col-md-6 combo-block">
					<?php
						$post = $blocks[1];
						setup_postdata( $post );
						$post->block_color = 'dark';
						get_template_part( 'template-parts/hp-block' );
						wp_reset_postdata();
					?>
				</div>
			</div>

			<!-- Second Row -->
			<div class="row row-section">
				<div class="col-xs-12 col-md-6 combo-block">
					<?php
						$post = $blocks[2];
						setup_postdata( $post );
						$post->block_color = 'secondary';
						get_template_part( 'template-parts/hp-block' );
						wp_reset_postdata();
					?>
				</div>
				<div class="shape1" style="background-image:url('<?php echo esc_url( $img1 ); ?>');">
					<div class="cutout"></div>
				</div>
			</div>

			<!-- Third Row -->

			<div class="row row-section hidden-md hidden-lg">
				<div class="img-block col-xs-6" style="background-image:url('<?php echo esc_url( $img1 ); ?>');"></div>
				<div class="img-block col-xs-6" style="background-image:url('<?php echo esc_url( $img2 ); ?>');"></div>
			</div>

			<div class="row row-section">
				<div class="shape2" style="background-image:url('<?php echo esc_url( $img2 ); ?>');"></div>
				<div class="col-xs-12 col-md-offset-3 col-md-6 combo-block">
					<?php
						$post = $blocks[3];
						setup_postdata( $post );
						$post->block_color = 'primary';
						get_template_part( 'template-parts/hp-block' );
						wp_reset_postdata();
					?>
				</div>
			</div>

			<!-- 4th Row -->
			<div class="row row-section">
				<div class="img-block hidden-xs hidden-sm col-md-offset-3 col-md-3" style="background-image:url('<?php echo esc_url( $img3 ); ?>');"></div>
				<div class="col-xs-12 col-md-6 combo-block">
					<?php
						$post = $blocks[4];
						setup_postdata( $post );
						$post->block_color = 'secondary';
						get_template_part( 'template-parts/hp-block' );
						wp_reset_postdata();
					?>
				</div>
			</div>

			<!-- 5th/6th Row -->
			<div class="row row-section hidden-md hidden-lg">
				<div class="col-xs-6 img-block" style="background-image:url('<?php echo esc_url( $img3 ); ?>');"></div>
				<div class="col-xs-6 img-block" style="background-image:url('<?php echo esc_url( $img4 ); ?>');"></div>
			</div>
			<div class="row row-section bottom-md">
				<div class="col-xs-12 col-md-3">
					<div class="hp-block-2x block-primary">
						<h4 class="section-header">
							<?php esc_html_e( 'Next Gen Highlight', 'nuclearnetwork' ); ?>
						</h4>
						<?php
							$args = array(
								'post_type'              => array( 'alumni' ),
								'posts_per_page' => 1,
								'cache_results'          => true,
								'update_post_meta_cache' => false,
								'meta_query' => array(
									array(
										'key' => '_post_is_featured',
										'value' => 1,
										'compare' => '=',
									),
								),
							);

							$alumni = new WP_Query( $args );
						?>
						<?php
						while ( $alumni->have_posts() ) : $alumni->the_post();
							get_template_part( 'template-parts/featured-alumni' );
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</div>
				<div class="shape3" style="background-image:url('<?php echo esc_url( $img4 ); ?>');">
					<div class="cutout"></div>
				</div>
				<div class="col-xs-12 col-md-6 col-md-offset-3">
					<div class="hp-block block-dark hp-categories">
						<h4 class="section-header">
							<?php esc_html_e( 'Explore by Category:', 'nuclearnetwork' ); ?>
						</h4>
						<ul>
						<?php
							wp_list_categories( array(
								'orderby' => 'name',
								'exclude' => array( 1 ),
								'title_li' => '',
							) );
						?>
						</ul>
					</div>
				</div>
			</div>

			<!-- About this Project -->
			<div class="row about-info">
				<div class="col-xs-12 col-sm-9">
					<h4 class="section-header"><?php esc_html_e( 'About this Project', 'nuclearnetwork' ); ?></h4>
					<?php echo '<p>' . esc_html( get_option( 'nuclearnetwork_home_desc_long' ) ) . '</p>'; ?>
				
					<?php 
						if ( have_posts() ) {
							wp_reset_query();
							setup_postdata($post); 
							echo esc_attr(htmlentities(the_content()));
						}
						// else {
						// 	echo "There is no content to be displayed.";
						// };
    			?>

					  
				</div>
				<div class="col-xs-12 col-sm-3">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'menu-2',
						) );
					?>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
