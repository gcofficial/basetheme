<?php
/**
 * Configuration pages engine class file
 *
 * @package photolab
 */

namespace Configuration;

/**
 * Page class
 */
class Pages {

	/**
	 * The image sizes.
	 *
	 * @var array
	 */
	protected $data = [];

	/**
	 * Widgets class constructor
	 *
	 * @param array $data engine data.
	 */
	public function __construct( array $data ) {
		$this->data = $data;
		add_action( 'admin_menu', [ $this, 'load' ] );
	}

	/**
	 * Load classes
	 */
	public function load() {
		foreach ( $this->data as $class => $properties ) {
			$class_name = 'Modules\\Pages\\'.$class;
			$path = $this->path( $class );

			if ( file_exists( $path ) ) {
				require_once( $path );
			}

			if ( 5 == count( $properties ) && is_array( $properties ) ) {
				list( $page_title, $menu_title, $capability, $menu_slug, $function ) = $properties;
				add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function );
			}
		}
	}

	/**
	 * Get class path
	 *
	 * @param type $class class name.
	 * @return string widget path
	 */
	public function path( $class ) {
		return sprintf(
			'%s%s.php',
			\Core\Utils::pages_path(),
			strtolower( $class )
		);
	}
}
