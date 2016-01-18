<?php
/**
 * Misc model file
 *
 * @package photolab
 */

/**
 * Mis model class
 */
class Misc_Model extends Options_Model{

	/**
	 * Get all options
	 *
	 * @return array --- all options
	 */
	public static function get_all() {
		return (array) get_option( 'misc' );
	}

	/**
	 * Get featured label
	 *
	 * @return string
	 */
	public static function getFeaturedLabel() {
		return (string) self::get_option( 'featured_label' );
	}

	/**
	 * Get blog label
	 *
	 * @return string
	 */
	public static function getBlogLabel() {
		return (string) self::get_option( 'blog_label' );
	}

	/**
	 * Get blog content
	 *
	 * @return string
	 */
	public static function getBlogContent() {
		$allowed = [ 'excerpt', 'full' ];
		$content = (string) self::get_option( 'blog_content' );
		if ( in_array( $content, $allowed ) ) {
			return $content;
		}
		return $allowed[0];
	}

	/**
	 * Get blog image
	 *
	 * @return string
	 */
	public static function getBlogImage() {
		$blog_image = (string) self::get_option( 'blog_image' );
		return '' != $blog_image ? $blog_image : 'post-thumbnail';
	}

	/**
	 * Get blog button
	 *
	 * @return string
	 */
	public static function getBlogButton() {
		$blog_btn = (string) self::get_option( 'blog_btn' );
		if ( '' == $blog_btn ) {
			$blog_btn = __( 'Read More', 'photolab' );
		}
		return $blog_btn;
	}
}
