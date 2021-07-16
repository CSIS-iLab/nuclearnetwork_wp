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
				<a href="https://www.csis.org" class="footer__logo"><?php include( get_template_directory() . '/assets/static/csis-logo.svg'); ?></a>

				<!-- description block -->
				<div class="footer__description">
					<?php dynamic_sidebar( 'Footer-Description' ); ?>
				</div>

				<!-- Newsletter Block -->
				<div class="footer__newsletter">
					<h2>Stay Up to Date</h2>
					<?php dynamic_sidebar( 'Newsletters' ); ?>
				</div>

				<!-- 2nd column -->
				<div>
					<h2>Stay Up to Date</h2>

					<div> <!--newsletter card -->
						<p>Monthly PONI Newsletter</p> <!-- subtitle -->
						<p>Get monthly updates with major news, events, and analysis.</p>
						<a href="https://www.csis.org/subscribe#edit-program-newsletters-poni-newsletter">Suscribe</a>
					</div>

					<div> <!--newsletter card -->
						<p>Daily PONI Newsletter</p> <!-- subtitle -->
						<p>Receive our recap of nuclear news from around the globe.</p>
						<a href="https://www.csis.org/subscribe#edit-program-newsletters-nuclear-policy-news">Suscribe</a>
					</div>
				</div>

				<!-- 3rd column -->
				<div>
					<h2>Contact Us</h2>

					<div> <!--address card -->
						<p>Address</p> <!-- subtitle -->
						<p>1616 Rhode Island Avenue NW Washington, DC 20036</p>
						<a href="https://www.csis.org/subscribe#edit-program-newsletters-poni-newsletter">Suscribe</a>
					</div>

					<div> <!--email card -->
						<p>Email</p> <!-- subtitle -->
						<p><a href="mailto:poni@csis.org">poni@csis.org</a></p>
					</div>

					<div> <!--phone card -->
						<p>Phone</p> <!-- subtitle -->
						<p><a href="tel:12027413878">202-741-3878</a></p>
					</div>

					<!-- Social Share -->
					<div class="footer__social">
						<div class="footer__social-icons">
							<a href="https://www.facebook.com/reconnasia/" class="footer__facebook-icon" aria-label="Visit the Reconnecting Asia Facebook page"><?php echo nuclearnetwork_get_svg( 'facebook' ); ?></a>
							<a href="https://twitter.com/NuclearNetwork" class="footer__twitter-icon" aria-label="Visit the Reconnecting Asia Twitter page"><?php echo nuclearnetwork_get_svg( 'twitter' ); ?></a>
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
