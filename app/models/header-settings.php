<?php
/**
 * Header settings model file
 *
 * @package photolab
 */

/**
 * Header setting model class
 */
class Header_Settings_Model {

	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		return Utils::array_get( (array) get_option( 'header_settings' ), $key, '' );
	}

	/**
	 * Get stickup menu checkbox value
	 *
	 * @return boolean --- true or false
	 */
	public static function get_stickup_menu() {
		return (bool) self::get_option( 'stickup_menu' );
	}

	/**
	 * Get show title on header checkbox value
	 *
	 * @return boolean --- true or false
	 */
	public static function is_show_title_on_header() {
		return (bool) self::get_option( 'show_title_on_header' );
	}

	/**
	 * Get enable/disable flag title attributes
	 *
	 * @return boolean --- enabled or disabled
	 */
	public static function get_title_attributes() {
		return (bool) self::get_option( 'title_attributes' );
	}

	/**
	 * Get enable/disable flag search box
	 *
	 * @return boolean --- enabled or disabled
	 */
	public static function get_search_box() {
		return (bool) self::get_option( 'search_box' );
	}

	/**
	 * Get disclimer text HTML code
	 *
	 * @return string --- disclimer text HTML code
	 */
	public static function get_disclimer() {
		return (string) self::get_option( 'disclimer_text' );
	}

	/**
	 * Get current header style
	 *
	 * @return string --- header style
	 */
	public static function get_header_style() {
		$allowed_header_styles = self::get_allowed_header_styles();
		$header_style = (string) self::get_option( 'header_style' );
		if ( in_array( $header_style, $allowed_header_styles ) ) {
			return $header_style;
		}
		return $allowed_header_styles[0];
	}

	/**
	 * Get all allowed header styles
	 *
	 * @return array --- all allowed header sytles
	 */
	public static function get_allowed_header_styles() {
		return array(
			'default',
			'minimal',
			'centered',
		);
	}

	/**
	 * Get header css classes
	 *
	 * @return string css classes
	 */
	public static function get_header_class() {
		$classes = array(
			'page-header',
			'header-type-' . rand( 1, 8 ),
		);

		if ( ! Header_Settings_Model::is_show_title_on_header() ) {
			array_push( $classes, 'invisibility' );
		}
		if ( has_post_thumbnail() or get_header_image() ) {
			array_push( $classes, 'with-img' );
		}
		return implode( ' ', $classes );
	}

	/**
	 * Add title to content
	 */
	public static function add_title_to_content( $content ) {
		$custom_content = '';
		if ( ! self::is_show_title_on_header() ) {
			$custom_content = renderTitle();
		}
		$custom_content .= $content;
		return $custom_content;
	}
}
