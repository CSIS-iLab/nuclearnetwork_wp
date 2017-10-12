<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Nuclear_Network
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main content-wrapper">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Page Not Found', 'nuclearnetwork' ); ?></h1>
				</header><!-- .page-header -->

				<div class="entry-content row">
					<div class="col-xs-12">
						<img src="/wp-content/themes/nuclearnetwork/img/404-poni.jpg" alt="404 Page Not Found" alt="404 Page Not Found" class="img404" />
					</div>
					<div class="col-xs-12 col-md-8 post-content">
						<p><?php esc_html_e( 'We were unable to locate the page you requested. The page may have moved or may no longer be available. We apologize for the inconvenience!', 'nuclearnetwork' ); ?></p>
						<ul>
							<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">Go to the Homepage</a></li>

							<?php
							if ( get_option( 'nuclearnetwork_email' ) ) {
								echo '<li><a href="mailto:' . esc_attr( get_option( 'nuclearnetwork_email' ) ) . '">Tell us about this broken link</a></li>';
							}
							?>
						</ul>
					</div>
					<div class="col-xs-12 col-md-4 related-container">
						<h4 class="section-header"><?php esc_html_e( 'Recent Articles', 'nuclearnetwork' ); ?></h4>
						<?php
						$the_query = new WP_Query( 'posts_per_page=2' );
						while ( $the_query->have_posts()) : $the_query -> the_post();

							echo '<div class="related-post">';
							the_title( sprintf( '<h5 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' );
							nuclearnetwork_authors_list();
							nuclearnetwork_posted_on();
							echo '</div>';

						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</div><!-- .entry-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
