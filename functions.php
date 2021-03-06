<?php
/**
 * Pixoff Resume Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Pixoff_Resume_Theme
 */

if ( ! function_exists( 'pxo_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function pxo_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Pixoff Resume Theme, use a find and replace
		 * to change 'pxo' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'pxo', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'pxo' ),
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
add_action( 'after_setup_theme', 'pxo_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function pxo_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'pxo_content_width', 640 );
}
add_action( 'after_setup_theme', 'pxo_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function pxo_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'pxo' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'pxo' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'pxo_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function pxo_scripts() {
	$content = file_get_contents(__DIR__ . "/dist/mix-manifest.json");
	$files = json_decode($content, true);

	wp_enqueue_style( 'pxo-style', get_stylesheet_uri() );

	wp_enqueue_style( 'pxo-app-style', get_template_directory_uri() . '/dist' . $files['/app.css'] );

	wp_enqueue_script( 'pxo-app-script', get_template_directory_uri() . '/dist' . $files['/app.js'], array('jquery'), '20151215', true );

	wp_enqueue_script( 'pxo-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'pxo-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'pxo_scripts' );

/**
 * Implement the ACF.
 */
require get_template_directory() . '/inc/acf.php';

/**
 * Implement the Color functions.
 */
require get_template_directory() . '/inc/color-functions.php';

/**
 * Implement the WP Pixoff Functiion.
 */
require get_template_directory() . '/inc/pxo.php';

/**
 * Implement the WP Bootstrap Navwalker.
 */
require get_template_directory() . '/inc/wp-bootstrap-navwalker.php';

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

// ini_set('error_reporting', 0);

add_action('get_header', 'remove_admin_login_header');

function remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}

add_filter( 'allowed_http_origins', 'add_allowed_origins' );

function add_allowed_origins( $origins ) {
    $origins[] = 'https://zivorad.pxo.rs';
    $origins[] = 'https://xn--m-soa.rs';
    return $origins;
}
