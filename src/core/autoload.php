<?php
/**
 * Core Autoload class file
 *
 * @package photolab
 */

namespace Core;

/**
 * Autoload class
 */
class Autoload {

	/**
	 * Framework class constructor
	 */
	public function __construct() {
		spl_autoload_register( array( &$this, 'autoloader' ) );
	}

	/**
	 * Autoload my classes
	 *
	 * @param  type $class class name.
	 * @return void
	 */
	public function autoloader( $class ) {
		$class_path = self::get_class_path( $class );
		if ( file_exists( $class_path ) ) {
			require_once $class_path;
		}
	}

	/**
	 * Get class path from class called name
	 *
	 * @param type $class --- class called name.
	 * @return string        --- class path
	 */
	public static function get_class_path( $class ) {
		$file_name  = strtolower( $class );
		$file_name  = str_replace( '_', '-', $file_name );
		$class_path = str_replace( '\\', DIRECTORY_SEPARATOR, $file_name );

		return sprintf( '%s/src/%s.php', get_template_directory(), $class_path );
	}
}

new Autoload;
