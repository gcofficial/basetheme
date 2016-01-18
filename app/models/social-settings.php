<?php
/**
 * Social settings model file
 *
 * @package photolab
 */

/**
 * Social settings model class
 */
class Social_Settings_Model extends Options_Model{

	/**
	 * Get all options
	 * @return array --- all options
	 */
	public static function get_all() {
		return (array) get_option( 'social_settings' );
	}

	/**
	 * Show socials on header
	 *
	 * @return boolean
	 */
	public static function is_show_header() {
		return '' != self::get_option( 'header' );
	}

	/**
	 * Show socials on footer
	 *
	 * @return boolean
	 */
	public static function is_show_footer() {
		return '' != self::get_option( 'footer' );
	}

	/**
	 * Get all social with URLS
	 *
	 * @return array
	 */
	public static function get_all_socials() {
		$allowed     = self::get_allowed();
		$social_urls = [];

		foreach ( $allowed as $key => $properties ) {
			$option = (string) self::get_option( sprintf( '%s_url', $key ) );
			$option = trim( $option );

			if ( '' != $option ) {
				$properties['url']   = $option;
				$social_urls[ $key ] = $properties;
			}
		}
		return $social_urls;
	}

	/**
	 * Get all allowed socials
	 *
	 * @return array
	 */
	public static function get_allowed() {
		return [
			'facebook' => [
				'label' => __( 'Facebook', 'photolab' ),
				'icon'  => 'fa-facebook-official',
			],
			'twitter' => [
				'label' => __( 'Twitter', 'photolab' ),
				'icon'  => 'fa-twitter',
			],
			'google-plus' => [
				'label' => __( 'Google+', 'photolab' ),
				'icon'  => 'fa-google-plus',
			],
			'instagram' => [
				'label' => __( 'Instagram', 'photolab' ),
				'icon'  => 'fa-instagram',
			],
			'linkedin' => [
				'label' => __( 'LinkedIn', 'photolab' ),
				'icon'  => 'fa-linkedin',
			],
			'dribbble' => [
				'label' => __( 'Dribbble', 'photolab' ),
				'icon'  => 'fa-dribbble',
			],
			'youtube' => [
				'label' => __( 'YouTube', 'photolab' ),
				'icon'  => 'fa-youtube',
			],
		];
	}
}
