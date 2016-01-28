<?php
/**
 * IModel interface file
 *
 * @package photolab
 */

/**
 * IModel interface
 */
interface IModel {
	/**
	 * Get single option by key
	 *
	 * @param  [type] $key settging key.
	 * @return mixed
	 */
	public static function get_option( $key );
}
