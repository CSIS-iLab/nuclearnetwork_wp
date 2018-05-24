<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nuclear_Network
 */

$description = get_option( 'nuclearnetwork_description' );
$disclaimer = get_option( 'nuclearnetwork_disclaimer' );
$address = get_option( 'nuclearnetwork_address' );
$email = get_option( 'nuclearnetwork_email' );
$phone = get_option( 'nuclearnetwork_phone' );
$facebook = get_option( 'nuclearnetwork_facebook' );
$twitter = get_option( 'nuclearnetwork_twitter' );
$linkedin = get_option( 'nuclearnetwork_linkedin' );
$newsletter_monthly_desc = get_option( 'nuclearnetwork_newsletter_monthly_desc' );
$newsletter_monthly_url = get_option( 'nuclearnetwork_newsletter_monthly_url' );
$newsletter_daily_desc = get_option( 'nuclearnetwork_newsletter_daily_desc' );
$newsletter_daily_url = get_option( 'nuclearnetwork_newsletter_daily_url' );

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="site-info content-wrapper row">
			<div class="footer-info col-xs-12 col-md-6">
				<img src="/wp-content/themes/nuclearnetwork/img/CSIS-PONI-logo-light.svg" alt="Center for Strategic and International Studies" title="Center for Strategic and International Studies" />
				<?php
				if ( $description ) {
					echo '<p>' . wp_kses_post( $description ) . '</p>';
				}
				?>
				<?php
				if ( $disclaimer ) {
					echo '<p class="footer-disclaimer">' . esc_html( $disclaimer ) . '</p>';
				}
				?>
			</div>
			<div class="footer-contact col-xs-12 col-md-3">
				<h6 class="section-title"><?php esc_html_e( 'Contact Us', 'nucleartnetwork' ); ?></h6>
				<?php
				if ( $address ) {
					echo '<p class="footer-subtitle">' . esc_html( 'Address', 'nuclearnetwork' ) . '</p>';
					echo '<address>' . wp_kses_post( $address ) . '</address>';
				}
				?>
				<?php
				if ( $email ) {
					echo '<p class="footer-subtitle">' . esc_html( 'Email', 'nuclearnetwork' ) . '</p>';
					echo '<p><a href="mailto:' . esc_attr( $email ) . '?subject=' . esc_attr( get_bloginfo( 'name' ) ) . '">' . esc_html( $email ) . '</a></p>';
				}
				?>
				<?php
				if ( $phone ) {
					echo '<p class="footer-subtitle">' . esc_html( 'Phone', 'nuclearnetwork' ) . '</p>';
					echo '<p>' . esc_html( $phone ) . '</p>';
				}
				?>
				<ul class="footer-social">
					<?php
					if ( $facebook ) {
						echo '<li><a href="' . esc_url( $facebook ) . '"><i class="icon-facebook"></i></a></li>';
					}
					if ( $twitter ) {
						echo '<li><a href="https://twitter.com/' . esc_attr( $twitter ) . '"><i class="icon-twitter"></i></a></li>';
					}
					if ( $linkedin ) {
						echo '<li><a href="' . esc_url( $linkedin ) . '"><i class="icon-linkedin"></i></a></li>';
					}
					?>
				</ul>
			</div>
			<div class="footer-newsletters col-xs-12 col-md-3">
				<h6 class="section-title"><?php esc_html_e( 'Stay up to date', 'nuclearnetwork' ); ?></h6>
				<?php
				if ( $newsletter_monthly_url && $newsletter_monthly_desc ) {
					echo '<p class="footer-subtitle">' . esc_html( 'Monthly PONI Newsletter', 'nuclearnetwork' ) . '</p>';
					echo '<p class="newsletter-desc">' . esc_html( $newsletter_monthly_desc ) . '</p>';
					echo '<a href="' . esc_attr( $newsletter_monthly_url ) . '" class="btn btn-blue">' . esc_html( 'Sign Up', 'nuclearnetwork' ) . '</a>';
				}
				?>
				<?php
				if ( $newsletter_daily_url && $newsletter_daily_desc ) {
					echo '<p class="footer-subtitle">' . esc_html( 'Daily PONI Newsletter', 'nuclearnetwork' ) . '</p>';
					echo '<p class="newsletter-desc">' . esc_html( $newsletter_daily_desc ) . '</p>';
					echo '<a href="' . esc_attr( $newsletter_daily_url ) . '" class="btn btn-blue">' . esc_html( 'Sign Up', 'nuclearnetwork' ) . '</a>';
				}
				?>
			</div>
		</div><!-- .site-info -->
		<div class="footer-copyright">
			<div class="content-wrapper">
				<p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> by the Center for Strategic and International Studies. All rights reserved. | <a href="https://www.csis.org/privacy-policy" target="_blank" rel="nofollow">Privacy Policy</a></p>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
