<?php
/**
 * Photolab function file
 *
 * @package photolab
 */

/**
 * Autoload all classes
 */
require_once 'src/autoload.php';
new Autoload(
	array(
		'ui',
		'configuration',
		'core',
		'view',
	)
);
Configuration::load();
add_action( 'init', 'photolab_init' );
/**
 * Photolab theme init
 */
function photolab_init() {
	View::add_data( Main_Model::main() );
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1140; /* pixels */
}

/**
 * Need for theme check
 */
add_theme_support( 'automatic-feed-links' );
