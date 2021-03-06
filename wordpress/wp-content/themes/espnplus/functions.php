<?php
/**
 * espnplus functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package espnplus
 */


/*
* Jellyfish custom version number for cache busting
*/
define( 'VERSION', '20180905001' ); // increment to bust cache on css and js.
// needs to match version in gulp file.

/** WPML remove Language switch css */
define('ICL_DONT_LOAD_NAVIGATION_CSS', true);
define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);
define('ICL_DONT_LOAD_LANGUAGES_JS', true);
//
// REMOVE EMOJI ICONS
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
//
if ( ! function_exists( 'espnplus_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function espnplus_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on espnplus, use a find and replace
		 * to change 'espnplus' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'espnplus', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'espnplus' ),
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
		add_theme_support( 'custom-background', apply_filters( 'espnplus_custom_background_args', array(
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
add_action( 'after_setup_theme', 'espnplus_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function espnplus_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'espnplus_content_width', 640 );
}
add_action( 'after_setup_theme', 'espnplus_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function espnplus_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'espnplus' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'espnplus' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	//
	register_sidebar( array(
		'name'          => esc_html__( 'LangSelect', 'espnplus' ),
		'id'            => 'lang-select',
		'description'   => esc_html__( 'Add widgets here.', 'espnplus' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	//
}
add_action( 'widgets_init', 'espnplus_widgets_init' );
/* --- */
//Making jQuery to load from Google Library
function replace_jquery() {
	if (!is_admin()) {
 		// comment out the next two lines to load the local copy of jQuery
 		wp_deregister_script('jquery');
 		wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', false, '3.1.1');
 		wp_enqueue_script('jquery');
 	}
}
add_action('wp_enqueue_scripts', 'replace_jquery');
/* ------------------- */
/**
 * 
 * Enqueue scripts and styles.
 */
function espnplus_register_scripts() {
	wp_register_style( 'espnplus-style', get_stylesheet_uri(), array(), VERSION, false );

	// Register scripts
	wp_register_script( 'espnplus-top', get_template_directory_uri() . '/js/'.VERSION.'espnplus-top.min.js', array(), VERSION, false );
	wp_register_script( 'espnplus-bottom', get_template_directory_uri() . '/js/'.VERSION.'espnplus-bottom.min.js', array(), VERSION, true );
}
add_action('init', 'espnplus_register_scripts');

function espnplus_scripts() {
	// styles
	wp_enqueue_style( 'espnplus-style');
	
	// enqueue scripts
	wp_enqueue_script('espnplus-top');
	wp_enqueue_script('espnplus-bottom');

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'espnplus_scripts' );

/* Asyc wp_enqueue_script
*/
function add_async_attribute($tag, $handle) {
    if ( 'espnplus-bottom' !== $handle ) {
		return $tag;
	}
	
	return str_replace( ' src', ' async="async" src', $tag );
}
add_filter('script_loader_tag', 'add_async_attribute', 10, 2);

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
* ADD Main menu for CPT UI 
*/
function url_replace(){
	wp_redirect('edit.php?post_type=header');
}

function my_custom_menu_page(){
   add_menu_page('Headers', 'Components', 'manage_options', 'components', 'url_replace', 'dashicons-layout', 3);
}
add_action('admin_menu', 'my_custom_menu_page');

/**
* custom image sizes
**/
// Add other useful image sizes for use through Add Media modal
add_image_size( 'bamtech-xsmall-width', 40 );
add_image_size( 'bamtech-small-width', 150 );
add_image_size( 'bamtech-medium-width', 580);
add_image_size( 'bamtech-large-width', 900 );
add_image_size( 'bamtech-xlarge-width', 1280 );

// Register the three useful image sizes for use in Add Media modal
add_filter( 'image_size_names_choose', 'wpshout_custom_sizes' );
function wpshout_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
		'bamtech-xsmall-width' => __( 'Bamtech XSmall Width' ),
        'bamtech-small-width' => __( 'Bamtech Small Width' ),
        'bamtech-medium-width' => __( 'Bamtech Medium Width' ),
		'bamtech-large-width' => __( 'Bamtech Large Width' ),
		'bamtech-xlarge-width' => __( 'Bamtech XLarge Width' ),
    ) );
}

/**
* Disabling automatic plugin updates
*/
add_filter( 'auto_update_plugin', '__return_false' );
add_filter( 'auto_update_theme', '__return_false' );
/* -------- */