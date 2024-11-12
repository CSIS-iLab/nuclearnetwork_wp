<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

?>
			<footer id="site-footer" class="footer" role="contentinfo">
				<!-- div for the row -->
				<!-- 1st column -->
				<div class="footer__logo">
					<a href="https://www.csis.org" class="footer__logo--small"><?php include( get_template_directory() . '/assets/static/csis-poni-logo.svg'); ?></a>
					<a href="https://www.csis.org" class="footer__logo--medium"><?php include( get_template_directory() . '/assets/static/csis-logo-poni-full.svg'); ?></a>
				</div>

				<!-- description block -->
				<div class="footer__description">
					<?php dynamic_sidebar( 'Footer-Description' ); ?>
				</div>

				<!-- Newsletter Block -->
				<div class="footer__newsletter">
					<h2>Stay Up to Date</h2>
					<?php dynamic_sidebar( 'Newsletters' ); ?>
				</div>

				<div class="footer__contact">
					<h2>Contact Us</h2>
					<?php dynamic_sidebar( 'Social-Share-1' ); ?>
					<div>
						<div class="footer__social-icons">
							<a href="https://www.facebook.com/csisponi/" class="footer__facebook-icon" aria-label="Visit the Nuclear Network Facebook page"><?php echo nuclearnetwork_get_svg( 'facebook' ); ?></a>
							<a href="https://x.com/csisponi" class="footer__x-icon" aria-label="Visit the PONI X page"><?php echo nuclearnetwork_get_svg( 'x' ); ?></a>
							<a href="https://www.linkedin.com/company/csis/" class="footer__linkedin-icon" aria-label="Visit the CSIS LinkedIn page"><?php echo nuclearnetwork_get_svg( 'linkedin' ); ?></a>
							<a href="https://www.instagram.com/csis/" class="footer__instagram-icon" aria-label="Visit the CSIS Instagram page"><?php echo nuclearnetwork_get_svg( 'instagram' ); ?></a>
							<a href="https://www.youtube.com/channel/UCr5jq6MC_VCe1c5ciIZtk_w" class="footer__youtube-icon" aria-label="Visit the CSIS YouTube page"><?php echo nuclearnetwork_get_svg( 'youtube' ); ?></a>
						</div>
					</div>
				</div>

				<p class="footer__copyright">Copyright &copy;
					<?php
					echo date_i18n(
						/* translators: Copyright date format, see https://secure.php.net/date */
						_x( 'Y', 'copyright date format', 'nuclearnetwork' )
					);
					?>
					Center for Strategic and International Studies. All rights reserved. <a href="https://www.csis.org/privacy-policy">Privacy Policy</a>
				</p><!-- .footer-copyright -->

			</footer><!-- #site-footer -->

		</div><!-- .container -->

		<?php wp_footer(); ?>

	</body>
</html>
