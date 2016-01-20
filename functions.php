<?php
/**
 * Photolab function file
 *
 * @category MyClass
 * @package  photolab
 * @author   Guriev Eugen
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.templatemonster.com/
 */

require_once 'src/autoload.php';
new Autoload(
	array(
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


