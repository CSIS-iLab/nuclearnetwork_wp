<?php
/**
 * Reconnecting Asia functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

/**
 * Table of Contents:
 * Theme Support
 * Required Files
 * Register Styles
 * Register Scripts
 * Register Menus
 * Custom Logo
 * WP Body Open
 * Register Sidebars
 * Enqueue Block Editor Assets
 * Enqueue Classic Editor Styles
 * Block Editor Settings
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function nuclearnetwork_theme_support() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Set content-width.
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 580;
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Set post thumbnail size.
	set_post_thumbnail_size( 1200, 9999 );

	// Add custom image size used in Cover Template.
	add_image_size( 'nuclearnetwork-fullscreen', 1980, 9999 );

	// Custom logo.
	$logo_width  = 120;
	$logo_height = 90;

	// If the retina setting is active, double the recommended width and height.
	if ( get_theme_mod( 'retina_logo', false ) ) {
		$logo_width  = floor( $logo_width * 2 );
		$logo_height = floor( $logo_height * 2 );
	}

	add_theme_support(
		'custom-logo',
		array(
			'height'      => $logo_height,
			'width'       => $logo_width,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'gallery',
			'caption',
			'script',
			'style',
		)
	);

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Reconnecting Asia, use a find and replace
	 * to change 'nuclearnetwork' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'nuclearnetwork' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	/* Disable custom font sizes, colors, gradients in Blocks */
	add_theme_support( 'editor-font-sizes', array() );
	add_theme_support( 'disable-custom-font-sizes' );
	add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'editor-color-palette' );
	add_theme_support( 'disable-custom-gradients' );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Adds `async` and `defer` support for scripts registered or enqueued
	 * by the theme.
	 */
	$loader = new NuclearNetwork_Script_Loader();
	add_filter( 'script_loader_tag', array( $loader, 'filter_script_loader_tag' ), 10, 2 );

}

add_action( 'after_setup_theme', 'nuclearnetwork_theme_support' );

/**
 * Register navigation menus uses wp_nav_menu in five places.
 */
function nuclearnetwork_menus() {

	$locations = array(
		'primary'  => __( 'Main Menu', 'nuclearnetwork' ),
		'social'   => __( 'Social Menu', 'nuclearnetwork' ),
	);

	register_nav_menus( $locations );
}

add_action( 'init', 'nuclearnetwork_menus' );

/**
 * REQUIRED FILES
 * Include required files.
 */
require get_template_directory() . '/inc/template-functions.php';

require get_template_directory() . '/inc/template-tags.php';

// Handle SVG icons.
require get_template_directory() . '/inc/svg-icons.php';

// Custom script loader class.
require get_template_directory() . '/classes/class-csis-script-loader.php';

// Custom Blocks.
require get_template_directory() . '/inc/custom-blocks.php';

// Shortcodes.
require get_template_directory() . '/inc/shortcodes.php';

/**
 * Register and Enqueue Styles.
 */
function nuclearnetwork_register_styles() {

	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'nuclearnetwork-fonts', 'https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=PT+Sans:wght@400;700&display=swap', array(), null );

	wp_enqueue_style( 'nuclearnetwork-style', get_stylesheet_directory_uri() . '/style.min.css', array(), $theme_version );

	wp_enqueue_style( 'nuclearnetwork-carousel', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@2.4.21/dist/css/splide-core.min.css', array(), $theme_version );

	if ( is_front_page() ) {
		wp_enqueue_style( 'nuclearnetwork-style-home', get_stylesheet_directory_uri() . '/assets/css/pages/home.min.css', array(), $theme_version );
	}

	// Series Page as Archive
	$series_page = get_field('series_page', 'option');

	if ( is_archive() || is_search() || is_home() || is_page( $series_page->ID ) ) {
		wp_enqueue_style( 'nuclearnetwork-style-archive', get_stylesheet_directory_uri() . '/assets/css/pages/archive.min.css', array(), $theme_version );
	}

	if ( is_singular() ) {
		wp_enqueue_style( 'nuclearnetwork-style-single', get_stylesheet_directory_uri() . '/assets/css/pages/single.min.css', array(), $theme_version );
	}

	if ( is_page() ) {
		wp_enqueue_style( 'nuclearnetwork-style-page', get_stylesheet_directory_uri() . '/assets/css/pages/page.min.css', array(), $theme_version );
	}

	if ( is_404() ) {
		wp_enqueue_style( 'nuclearnetwork-style-404', get_stylesheet_directory_uri() . '/assets/css/pages/404.min.css', array(), $theme_version );
	}

	if ( 'post' === get_post_type() && is_single() ) {
		wp_enqueue_style( 'nuclearnetwork-style-post', get_stylesheet_directory_uri() . '/assets/css/pages/post.min.css', array(), $theme_version );

		wp_enqueue_style( 'nuclearnetwork-style-post-blocks', get_stylesheet_directory_uri() . '/assets/css/blocks/post.min.css', array(), $theme_version );
	}

	// Add print CSS.
	wp_enqueue_style( 'nuclearnetwork-print-style', get_template_directory_uri() . '/print.css', null, $theme_version, 'print' );

}

add_action( 'wp_enqueue_scripts', 'nuclearnetwork_register_styles' );

/**
 * Register and Enqueue Scripts.
 */
function nuclearnetwork_register_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );

	if ( ( ! is_admin() ) && is_singular() ) {
		wp_enqueue_script( 'nuclearnetwork-iframeResizer', 'https://cdnjs.cloudflare.com/ajax/libs/iframe-resizer/4.2.10/iframeResizer.min.js', array(), $theme_version, true );

		wp_add_inline_script( 'nuclearnetwork-iframeResizer', 'const iframes = iFrameResize({ log: false }, ".js-resize")' );

		// wp_script_add_data( 'nuclearnetwork-iframeResizer', 'async', true );
	}

	wp_enqueue_script( 'nuclearnetwork-js-vendor', get_template_directory_uri() . '/assets/js/vendor.min.js', array(), $theme_version, true );
	wp_script_add_data( 'nuclearnetwork-js-vendor', 'async', true );

	wp_enqueue_script( 'nuclearnetwork-js-skip-link', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.min.js', array(), $theme_version, true );
	wp_script_add_data( 'nuclearnetwork-js-skip-link', 'async', true );

	wp_enqueue_script( 'nuclearnetwork-js-bundle', get_template_directory_uri() . '/assets/js/bundle.min.js', array(), $theme_version, true );
	wp_script_add_data( 'nuclearnetwork-js-bundle', 'defer', true );

	if ( is_front_page() ) {
		wp_enqueue_script( 'nuclearnetwork-js-carousel', get_template_directory_uri() . '/assets/js/carousel.min.js', array(), $theme_version, true );
		wp_script_add_data( 'nuclearnetwork-js-carousel', 'async', true );
	}

	// Series Page as Archive
	$series_page = get_field('series_page', 'option');

	if ( is_home() || is_archive() || is_search() || is_page( $series_page->ID ) ) {
		wp_enqueue_script( 'nuclearnetwork-js-archive', get_template_directory_uri() . '/assets/js/archive.min.js', array(), $theme_version, true );
		wp_script_add_data( 'nuclearnetwork-js-archive', 'defer', true );
	}

	if ( is_single() ) {
		wp_enqueue_script('nuclearnetwork-clipboard', 'https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js', array(), '20170713', true );
		wp_add_inline_script('nuclearnetwork-clipboard', "var clipboard = new ClipboardJS('#btn-copy');
			clipboard.on('success', function(e) {
					var d = document.getElementById('btn-copy');
				d.className += ' tooltipped tooltipped-n tooltipped-no-delay';
			});
		");
	}

}

add_action( 'wp_enqueue_scripts', 'nuclearnetwork_register_scripts' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function nuclearnetwork_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'nuclearnetwork_skip_link_focus_fix' );


if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Shim for wp_body_open, ensuring backwards compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

/**
 * Include a skip to content link at the top of the page so that users can bypass the menu.
 */
function nuclearnetwork_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#site-content">' . __( 'Skip to the content', 'nuclearnetwork' ) . '</a>';
}

add_action( 'wp_body_open', 'nuclearnetwork_skip_link', 5 );

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function nuclearnetwork_sidebar_registration() {

	// Arguments used in all register_sidebar() calls.
	$footer_shared_args = array(
		'before_title'  => '',
		'after_title'   => '',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
	);

	// Footer #1.
	register_sidebar(
		array_merge(
			$footer_shared_args,
			array(
				'name'        => __( 'Footer Description', 'nuclearnetwork' ),
				'id'          => 'sidebar-1',
				'description' => __( 'Widgets in this area will be displayed in the first column in the footer.', 'nuclearnetwork' ),
			)
		)
	);

	// Footer #2.
	register_sidebar(
		array_merge(
			$footer_shared_args,
			array(
				'name'        => __( 'Descrption Footer Component', 'nuclearnetwork' ),
				'id'          => 'sidebar-2',
				'description' => __( 'Widgets in this area will be displayed in the second column in the footer.', 'nuclearnetwork' ),
			)
		)
	);

	// Footer #3.
	register_sidebar(
		array_merge(
			$footer_shared_args,
			array(
				'name'        => __( 'Footer #3', 'nuclearnetwork' ),
				'id'          => 'sidebar-3',
				'description' => __( 'Widgets in this area will be displayed in the third column in the footer.', 'nuclearnetwork' ),
			)
		)
	);

		// Social Share
	register_sidebar(
		array_merge(
			$footer_shared_args,
			array(
			'name'        => __( 'Social Share 1', 'nuclearnetwork' ),
			'id'          => 'social-share-1',
			'description' => __( 'Social Share Widget', 'nuclearnetwork' )
			)
		)
	);

	register_sidebar(
		array_merge(
			$footer_shared_args,
			array(
			'name'        => __( 'Newsletters', 'nuclearnetwork' ),
			'id'          => 'newsletters',
			'description' => __( 'Newsletters for Nuclear Network', 'nuclearnetwork' )
			)
		)
	);

	register_sidebar(
		array(
			'name'        => __( 'Nuclear Policy News', 'nuclearnetwork' ),
			'id'          => 'nuclear-policy-news',
			'description' => __( 'Nuclear Policy News', 'nuclearnetwork' )
		)
	);


	register_sidebar(
		array_merge(
			$footer_shared_args,
			array(
				'name'        => __( 'Write for us', 'nuclearnetwork' ),
				'id'          => 'write-for-us',
				'description' => __( 'Write for us', 'nuclearnetwork' )
			)
		)
	);

}

add_action( 'widgets_init', 'nuclearnetwork_sidebar_registration' );

/**
 * Enqueue supplemental block editor styles.
 */
function nuclearnetwork_block_editor_styles() {

	$css_dependencies = array();

	// Enqueue the editor styles.
	wp_enqueue_style( 'nuclearnetwork-block-editor-styles', get_theme_file_uri( '/editor-style-block.css' ), $css_dependencies, wp_get_theme()->get( 'Version' ), 'all' );

}

add_action( 'enqueue_block_editor_assets', 'nuclearnetwork_block_editor_styles', 1, 1 );

/**
 * Enqueue classic editor styles.
 */
function nuclearnetwork_classic_editor_styles() {

	$classic_editor_styles = array(
		'/assets/css/editor-style-classic.css',
	);

	add_editor_style( $classic_editor_styles );

}

add_action( 'init', 'nuclearnetwork_classic_editor_styles' );


/** Modify Excerpt Classes */
function nuclearnetwork_filter_excerpt ($post_excerpt) {
	$class = 'post-block__excerpt';

	if ( !is_front_page() && is_singular() ) {
		$class = 'single__excerpt';
	}

  $post_excerpt = '<p class="' . $class . '">' . $post_excerpt . '</p>';
  return $post_excerpt;
}
add_filter ('get_the_excerpt','nuclearnetwork_filter_excerpt');

/**
 * Add options page for advanced custom fields.
 */

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page();

}
