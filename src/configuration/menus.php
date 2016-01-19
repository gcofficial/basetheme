<?php
/**
 * Configuration manus engine class file
 *
 * @package photolab
 */

namespace Configuration;

/**
 * Manus class
 */
class Menus {
	/**
	 * Save the menus list
	 *
	 * @var array
	 */
	protected $data = [];

	/**
	 * Menus class constructor
	 *
	 * @param array $data engine data.
	 */
	public function __construct( array $data ) {
		$this->data = $data;
		add_action( 'init', [ $this, 'install' ] );
	}

	/**
	 * Run by the 'init' hook.
	 * Execute the "register_nav_menus" function from WordPress
	 *
	 * @return void
	 */
	public function install() {
		if ( is_array( $this->data ) && ! empty( $this->data ) ) {
			$locations = [];

			foreach ( $this->data as $slug => $desc ) {
				$locations[ $slug ] = $desc;
			}

			register_nav_menus( $locations );
		}
	}
}
