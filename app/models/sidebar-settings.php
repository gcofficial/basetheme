<?php
/**
 * Sidebar settings model file
 *
 * @package photolab
 */

/**
 * Sidebar settings model class
 */
class Sidebar_Settings_Model {

	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		return Utils::array_get( (array) get_option( 'sidebar_settings' ), $key, '' );
	}

	/**
	 * Get mode left
	 *
	 * @return string --- mode left
	 */
	public static function get_mode_left() {
		return self::get_option( 'mode_left' );
	}

	/**
	 * Get mode right
	 *
	 * @return string --- mode right
	 */
	public static function get_mode_right() {
		return self::get_option( 'mode_right' );
	}

	/**
	 * Get sidebars
	 *
	 * @return string --- json string or empty
	 */
	public static function get_sidebars() {
		return (string) self::get_option( 'sidebars' );
	}

	/**
	 * Get sidebars in array
	 *
	 * @return array --- sidebars array
	 */
	public static function get_sidebars_array() {
		return (array) json_decode( self::get_sidebars() );
	}

	/**
	 * Get sidebars with options
	 *
	 * @return array --- sidebars with options
	 */
	public static function get_sidebars_options() {
		$res = array();
		$arr = self::get_sidebars_array();
		if ( count( $arr ) ) {
			foreach ( $arr as $key => $value ) {
				array_push(
					$res,
					array(
						'name'          => $value,
						'id'            => self::get_sidebar_id( $value ),
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget'  => '</aside>',
						'before_title'  => '<h3 class="widget-title">',
						'after_title'   => '</h3>',
					)
				);
			}
		}
		return $res;
	}

	/**
	 * Get sidebar id from name
	 *
	 * @param type $name sidebar name.
	 * @return string sidebar id.
	 */
	public static function get_sidebar_id( $name ) {
		return str_replace( ' ', '_', strtolower( $name ) );
	}

	/**
	 * Get registered sidebars for select control.
	 *
	 * @return array registered sidebars.
	 */
	public static function get_sidebars_for_select() {
		$result   = array( '' => 'Inherit' );
		$sidebars = (array) $GLOBALS['wp_registered_sidebars'];
		if ( count( $sidebars ) ) {
			foreach ( $sidebars as $sidebar ) {
				$result[ $sidebar['id'] ] = $sidebar['name'];
			}
		}
		return $result;
	}

	/**
	 * Get left sidebar id
	 *
	 * @return string left sidebar id.
	 */
	public static function get_left_sidebar_id() {
		global $post;
		$left = trim( (string) get_post_meta( $post->ID, 'sidebar_left', true ) );
		if ( '' == $left ) {
			$left = 'sidebar-1';
		}

		return $left;
	}

	/**
	 * Get right sidebar id
	 *
	 * @return string --- right sidebar id.
	 */
	public static function get_right_sidebar_id() {
		global $post;
		$right = trim( (string) get_post_meta( $post->ID, 'sidebar_right', true ) );
		if ( '' == $right ) {
			$right = 'sidebar-2';
		}
		return $right;
	}

	/**
	 * Get sidebars type
	 *
	 * @return string sidebars type.
	 */
	public static function get_sidebar_side_type() {
		$key = sprintf(
			'l%sr%s',
			self::get_mode_left(),
			self::get_mode_right()
		);
		$values = array(
			'lr'   => 'hide',
			'l1r'  => 'left',
			'lr1'  => 'right',
			'l1r1' => 'leftright',
		);
		if ( ! Blog_Settings_Model::is_default_layout() ) {
			$values['l1r1'] = 'left';
		}
		return $values[ $key ];
	}
}
