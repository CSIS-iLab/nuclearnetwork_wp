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
				<a href="https://www.csis.org" class="footer__logo"><?php include( get_template_directory() . '/assets/static/csis-logo.svg'); ?></a>

				<div class="footer__desc">
					<?php dynamic_sidebar( 'sidebar-1' ); ?>
					<?php dynamic_sidebar( 'sidebar-2' ); ?>
				</div>
				<?php dynamic_sidebar( 'sidebar-3' ); ?>

				<!-- Social Share -->
				<div class="footer__social">
					<h2 class="footer__social-header">
						Follow Us
					</h2>
					<div class="footer__social-icons">
						<a href="https://www.facebook.com/reconnasia/" class="footer__facebook-icon" aria-label="Visit the Reconnecting Asia Facebook page"><?php echo nuclearnetwork_get_svg( 'facebook' ); ?></a>
						<a href="https://twitter.com/NuclearNetwork" class="footer__twitter-icon" aria-label="Visit the Reconnecting Asia Twitter page"><?php echo nuclearnetwork_get_svg( 'twitter' ); ?></a>
						<a href="https://www.linkedin.com/company/csis/" class="footer__linkedin-icon" aria-label="Visit the CSIS LinkedIn page"><?php echo nuclearnetwork_get_svg( 'linkedin' ); ?></a>
						<a href="https://www.instagram.com/csis/" class="footer__instagram-icon" aria-label="Visit the CSIS Instagram page"><?php echo nuclearnetwork_get_svg( 'instagram' ); ?></a>
						<a href="https://www.youtube.com/channel/UCr5jq6MC_VCe1c5ciIZtk_w" class="footer__youtube-icon" aria-label="Visit the CSIS YouTube page"><?php echo nuclearnetwork_get_svg( 'youtube' ); ?></a>
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
