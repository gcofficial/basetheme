<?php
/**
 * Options model file
 *
 * @package photolab
 */

/**
 * Options model abstract class
 */
abstract class Options_Model {

	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		return \Core\Utils::array_get( static::get_all(), $key, '' );
	}

	/**
	 * Get all options
	 */
	public static function get_all() {
		die( 'It must be ovverided!' );
	}
}
