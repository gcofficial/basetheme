<?php
/**
 * Configuration models engine class file
 *
 * @package photolab
 */

/**
 * Models class
 */
class Models {

	/**
	 * The image sizes.
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * Models class constructor
	 *
	 * @param array $data engine data.
	 */
	public function __construct( array $data ) {
		$this->data = $data;
		$this->load();
	}

	/**
	 * Load classes
	 */
	public function load() {
		foreach ( $this->data as $path ) {
			if ( file_exists( $path ) ) {
				require_once( $path );
			}
		}
	}
}
