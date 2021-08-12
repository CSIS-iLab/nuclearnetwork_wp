<?php
/**
 * Displays the post header
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

$object = get_queried_object();

$is_archive = is_archive(); //Not search, 404 or Analysis
$is_page = is_page();
$has_thumbnail = has_post_thumbnail();
$post_type = get_post_type(); //News, updates, projects, events, programs
$is_404 = is_404(); //404
$page_for_posts = get_option( 'page_for_posts' );
$is_author = is_author(); //Author
$is_single = is_single();
$post_parent_id = wp_get_post_parent_id(get_the_ID());

$author_title = get_field( 'title', $object->ID );
$description = get_the_excerpt();

$event_info = get_field( 'event_post_info' );
$event_start_date = $event_info['event_start_date'];
$event_start_time = $event_info['event_start_time'];
$legacy_event_date = get_post_meta( $id, '_post_start_date', true );

$program_info = get_field( 'program_post_info' ); 
$application_deadline = $program_info['application_deadline'];

$template = get_page_template_slug( get_the_ID() );
$isNoImageTemplate = false;

if ( $template === 'templates/template-no-image.php' || $is_author ){
	$isNoImageTemplate = true;
}

$is_future_event = false;
$yesterday = date_i18n( strtotime('now'));





?>

<header class="entry-header entry-header--light">

<div class="entry-header__header-content">

<?php
// var_dump($event_full_date);
	if ( !$is_author ) { 
		nuclearnetwork_display_subtypes(); 
	}
	if ( $is_author || $pagename === 'about' ) { echo '<div class="post-meta post-meta__terms"><a href="' . site_url( "/about/" ) . '" class="post-meta__terms-type text--bold">About</a></div>';}
	if ( $is_author ) {
		the_archive_title( '<h1 class="entry-header__title">', '</h1>' );
		if ( isset( $author_title ) && !empty( $author_title ) ) { 
			echo '<div class="entry-header__job-title">' . $author_title . '</div>'; 
		}
	} else {
		the_title( '<h1 class="entry-header__title">', '</h1>' );
	}

	if ( !$is_author ) {
		nuclearnetwork_display_series();
		the_excerpt();
	}

	if ( $is_404 ) { ?>

			<h1 class="entry-header__title"><?php _e( '404', 'nuclearnetwork' ); ?></h1>

		<?php 

	} elseif ( $post_type === 'events' && $is_single ) {

		$registration_link = $event_info['event_registration_link'];
		$event_full_date = date_i18n( strtotime("$event_start_date $event_start_time"));
		if ( $event_full_date >= $yesterday ) {
			$is_future_event = true;
		}

		if ( !$is_future_event || $legacy_event_date ) {
			echo '<div class="entry-header__event-past">' . nuclearnetwork_get_svg( 'alert' ) . 'This event has already occurred.</div>';
		}

		nuclearnetwork_display_event_date();
		nuclearnetwork_display_event_location();

		if ( isset($registration_link) && !empty($registration_link) && $is_future_event && !$legacy_event_date ) { ?>
			<a href="<?php echo esc_url( $registration_link ); ?>" class="post-block__register btn btn--blue">Register<?php echo nuclearnetwork_get_svg( 'arrow-external' ); ?></a>
			<?php
			}

	} elseif ( $post_type === 'programs' && $is_single && !$post_parent_id ) { 

		$application_link = $program_info['link_to_application_page'];
		$is_rolling = $program_info['rolling_application'];
		$class_name = $program_info['class_name'];
		$deadline_formatted = date_i18n('M. d, Y', strtotime($application_deadline));
		$app_deadline_full_date = date_i18n( strtotime("$application_deadline"));
		if ( $app_deadline_full_date >= $yesterday || $is_rolling ) {
			$is_future_event = true;
		}

		if ( $is_future_event || $is_rolling ) {
			echo '<div class="entry-header__accepting-applications">Accepting Applications</div>';
			
			echo '<div class="entry-header__program-class">' . $class_name . '</div>';
			
			if ( !$is_rolling && $is_future_event ) {
				echo '<dl class="post-meta post-meta__program-date"><dt class="post-meta__label--small text--bold text--caps">Deadline</dt><dd class="post-meta__date--program">' . $deadline_formatted . '</dd></dl>';
			}
			
			if ( isset($application_link) && !empty($application_link) && $is_future_event ) {
				echo '<a href="' . esc_url( $application_link ) . '" class="post-block__apply btn btn--blue">Apply ' . nuclearnetwork_get_svg( 'arrow-external' ) . '</a>';
			}
		}

	} elseif ( $is_single ) { 

		nuclearnetwork_posted_on();
		nuclearnetwork_authors();
	} 

	if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { ADDTOANY_SHARE_SAVE_KIT(); }
	?>

</div><!-- .entry-header__header-content -->
	<?php
	if ( !$isNoImageTemplate ) {
		get_template_part( 'template-parts/featured-image' );
	}
	?>

</header><!-- .entry-header -->
