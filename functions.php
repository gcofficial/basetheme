<?php
Use \View\View;
Use \Core\Utils;

add_action('init', 'photolab_init');
function photolab_init()
{
	// ==============================================================
	// Global view variables declaration
	// ==============================================================
	View::addData(MainModel::main());
}
/**
 * photolab functions and definitions
 *
 * based on Underscores starter WordPress theme
 *
 * @package photolab
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1140; /* pixels */
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function photolab_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on photolab, use a find and replace
	 * to change 'photolab' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'photolab', get_template_directory() . '/languages' );

	// Add editor styling
	add_editor_style( 'editor-style.css' );
}
add_action( 'after_setup_theme', 'photolab_setup' );

/**
 * Include Google fonts
 */
function photolab_fonts_url() {

	$fonts_url = '';

	$locale = get_locale();

	$cyrillic_locales = array( 'ru_RU', 'mk_MK', 'ky_KY', 'bg_BG', 'sr_RS', 'uk', 'bel' );

	/* Translators: If there are characters in your language that are not
	* supported by Lora, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$libre = _x( 'on', 'Libre Baskerville font: on or off', 'photolab' );

	/* Translators: If there are characters in your language that are not
	* supported by Open Sans, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$open_sans = _x( 'on', 'Open Sans font: on or off', 'photolab' );

	if ( 'off' !== $libre || 'off' !== $open_sans ) {

		$font_families = array();

		if ( 'off' !== $libre ) {
			$font_families[] = 'Libre Baskerville:400,700,400italic';
		}

		if ( 'off' !== $open_sans ) {
			$font_families[] = 'Open Sans:300,400,700,400italic,700italic';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		if ( in_array($locale, $cyrillic_locales) ) {
			$query_args['subset'] = urlencode( 'latin,latin-ext,cyrillic' );
		}

		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

// Additional template tags
require get_template_directory() . '/inc/template-tags.php';

require_once 'src/Core/Autoload.php';
\Core\App::Start();

