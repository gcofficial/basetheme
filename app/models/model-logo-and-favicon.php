<?php
/**
 * General Site settings model
 *
 * @package photolab
 */

/**
 * Logo & Favicon MODEL
 */
class Model_Logo_And_Favicon{
	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		$logo_and_favicon = Utils::array_get(
			(array) get_option( 'general_site_settings' ),
			'logo_and_favicon',
			array( 'logo_and_favicon' => array() )
		);
		return Utils::array_get( (array) $logo_and_favicon, $key, '' );
	}

	/**
	 * Is enable page preloader ?
	 *
	 * @return boolean Enable / Disable.
	 */
	public static function is_enable_page_preloader() {
		return '1' === self::get_option( 'show_preloader' );
	}
}
