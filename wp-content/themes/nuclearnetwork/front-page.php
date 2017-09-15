<?php
/**
 * Home Page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nuclear_Network
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main content-wrapper">

			<!-- First Row -->
			<div class="row row-section">
				<div class="hp-block col-xs-12 col-md-6">
					Paragraph Intro
				</div>
				<div class="col-xs-12 col-md-6">
					<div class="hp-block dark-main split-main">
						Attend
					</div>
					<div class="hp-block dark-featured split-featured">
						Featured
					</div>
				</div>
			</div>

			<!-- Second Row -->
			<div class="row row-section">
				<div class="col-xs-12 col-md-6">
					<div class="hp-block light-main split-main">
						Discover
					</div>
					<div class="hp-block light-featured split-featured">
						Featured
					</div>
				</div>
				<div class="shape1">
					<div class="cutout"></div>
				</div>
			</div>

			<!-- Third Row -->
			<div class="row row-section">
				<div class="shape2"></div>
				<div class="col-xs-12 col-md-offset-3 col-md-6">
					<div class="hp-block dark-main split-main">
						Connect
					</div>
					<div class="hp-block dark-featured split-featured">
						Featured
					</div>
				</div>
			</div>

			<!-- 4th Row -->
			<div class="row row-section">
				<div class="img-block col-xs-12 col-md-offset-3 col-md-3">
					Image
				</div>
				<div class="col-xs-12 col-md-6">
					<div class="hp-block dark-main split-main">
						Apply
					</div>
					<div class="hp-block dark-featured split-featured">
						Featured
					</div>
				</div>
			</div>

			<!-- 5th/6th Row -->
			<div class="row row-section bottom-sm">
				<div class="col-xs-12 col-md-3">
					<div class="hp-block-2x light-main">
						<h4 class="section-header">
							<?php esc_html_e( 'Next Gen Scholar Highlight', 'nuclearnetwork' ); ?>
						</h4>
					</div>
				</div>
				<div class="shape3">
					<div class="cutout"></div>
				</div>
				<div class="col-xs-12 col-md-6 col-md-offset-3">
					<div class="hp-block dark-main hp-categories">
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

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
