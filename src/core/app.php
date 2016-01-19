<?php
/**
 * Core App class file
 *
 * @package photolab
 */

namespace Core;

/**
 * App class
 */
class App {

	/**
	 * Start application
	 */
	public static function start() {
		/**
		 * Loading all configurations
		 */
		\Configuration\Configuration::load();
	}
}
