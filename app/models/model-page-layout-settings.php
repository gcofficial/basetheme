<?php
/**
 * Blog setting model
 *
 * @package photolab
 */

/**
 * Blog settings model сlass
 */
class Model_Page_Layout_Settings implements IModel {

	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		$page_layout_settings = Utils::array_get(
			(array) get_option( 'general_site_settings' ),
			'page_layout_settings',
			array( 'page_layout_settings' => array() )
		);
		return Utils::array_get( (array) $page_layout_settings, $key, '' );
	}

	/**
	 * Layout style
	 *
	 * @return string Boxed, full width etc.
	 */
	public static function get_layout() {
		return self::get_option( 'layout' );
	}

	/**
	 * Container width
	 *
	 * @return string Width of container.
	 */
	public static function get_width() {
		return self::get_option( 'width' );
	}

	/**
	 * Sidebar width
	 *
	 * @return string Width of sidebar.
	 */
	public static function get_sidebar_width() {
		return self::get_option( 'sidebar_width' );
	}
}
