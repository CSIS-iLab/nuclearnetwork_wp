<?php
/**
 * Nuclear Network functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Nuclear_Network
 */

if ( ! function_exists( 'nuclearnetwork_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function nuclearnetwork_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Nuclear Network, use a find and replace
		 * to change 'nuclearnetwork' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'nuclearnetwork', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'nuclearnetwork' ),
			'menu-2' => esc_html__( 'Secondary Home', 'nuclearnetwork' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'nuclearnetwork_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'nuclearnetwork_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function nuclearnetwork_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'nuclearnetwork_content_width', 640 );
}
add_action( 'after_setup_theme', 'nuclearnetwork_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function nuclearnetwork_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'nuclearnetwork' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'nuclearnetwork' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'nuclearnetwork_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function nuclearnetwork_scripts() {
	wp_enqueue_style( 'nuclearnetwork-style', get_stylesheet_uri() );

	wp_enqueue_script( 'nuclearnetwork-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'nuclearnetwork-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'nuclearnetwork-header', get_template_directory_uri() . '/js/header.js', array(), '20170901', true );

	wp_enqueue_script( 'nuclearnetwork-guest-authors', get_template_directory_uri() . '/js/guest-authors.js', array(), '20171005', true );

	if ( is_singular() ) {
		wp_enqueue_script( 'nuclearnetwork-posts', get_template_directory_uri() . '/js/posts.js', array(), '20170907', true );
	}
}
add_action( 'wp_enqueue_scripts', 'nuclearnetwork_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load custom post meta and post types.
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * Load custom user meta fields.
 */
require get_template_directory() . '/inc/custom-usermeta.php';

/**
 * Load custom settings.
 */
require get_template_directory() . '/inc/custom-settings.php';

/**
 * Load custom shortcodes..
 */
require get_template_directory() . '/inc/custom-shortcodes.php';

/**
 * Load custom TinyMCE buttons.
 */
require get_template_directory() . '/inc/custom-tinymce.php';

/**
 * Custom Rest API Endpoints.
 */
require get_template_directory() . '/inc/custom-rest-api.php';
