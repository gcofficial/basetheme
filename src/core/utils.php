<?php
/**
 * Core Utils class file
 *
 * @package photolab
 */

/**
 * Utils class
 */
class Utils {

	/**
	 * Print and die a value - Used for debugging.
	 *
	 * @param mixed $value Any PHP value.
	 * @return void
	 */
	public static function pd( $value ) {
		echo '<pre>';
		print_r( $value );
		echo '</pre>';
		wp_die();
	}

	/**
	 * Print a value.
	 *
	 * @param mixed $value Any PHP value.
	 * @return void
	 */
	public static function p( $value ) {
		echo '<pre>';
		print_r( $value );
		echo '</pre>';
	}

	/**
	 * Try get value by key from array
	 *
	 * @param  array $array values list.
	 * @param  type  $key value key.
	 * @param  type  $default default value.
	 * @return mixed value by key
	 */
	public static function array_get( $array, $key, $default = '' ) {
		$array = (array) $array;
		if ( is_null( $key ) ) {
			return $array;
		}
		if ( array_key_exists( $key, $array ) ) {
			return $array[ $key ];
		}
		return $default;
	}

	/**
	 * Join array to string
	 *
	 * @param  array $arr --- array like 'key' => 'value'.
	 * @return string --- joined string
	 */
	public static function array_join( $arr = array() ) {
		$arr    = self::array_remove_empty( $arr );
		$result = array();
		foreach ( $arr as $key => $value ) {
			$result[] = sprintf( '%s="%s"', $key, $value );
		}
		return implode( ' ', $result );
	}

	/**
	 * Get all of the given array except for a specified array of items.
	 *
	 * @param array $array to except.
	 * @param array $keys keys.
	 * @return array
	 */
	public static function array_except( $array, $keys ) {
		return array_diff_key( $array, array_flip( (array) $keys ) );
	}

	/**
	 * Remove empty elements
	 *
	 * @param  array $arr --- array with empty elements.
	 * @return array --- array without empty elements
	 */
	public static function array_remove_empty( $arr ) {
		return array_filter( $arr, array( __CLASS__, 'array_remove_empty_check' ) );
	}

	/**
	 * Check if empty.
	 * It's need for PHP 5.2.4 version
	 *
	 * @param  [type] $var variable.
	 * @return boolean
	 */
	public static function array_remove_empty_check( $var ) {
		return '' != $var;
	}

	/**
	 * Lave just right keys in array
	 *
	 * @param  array $right_keys right keys to leave.
	 * @param  array $array list.
	 * @return array
	 */
	public static function array_leave_right_keys( $right_keys, $array ) {
		$right_keys = (array) $right_keys;
		$array      = (array) $array;

		if ( count( $array ) ) {
			foreach ( $array as $key => $value ) {
				if ( ! in_array( $key, $right_keys ) ) {
					unset( $array[ $key ] );
				}
			}
		}
		return $array;
	}

	/**
	 * Remove some keys form array
	 *
	 * @param  [type] $right_keys keys to remove.
	 * @param  [type] $array      where we want remove this keys.
	 * @return array without keys
	 */
	public static function array_remove_right_keys( $right_keys, $array ) {
		$right_keys = (array) $right_keys;
		$array      = (array) $array;

		if ( count( $right_keys ) ) {
			foreach ( $right_keys as $key ) {
				if ( array_key_exists( $key, $array ) ) {
					unset( $array[ $key ] );
				}
			}
		}
		return $array;
	}

	/**
	 * Push some values in to end of the array
	 *
	 * @param  [type] $array list where we want push.
	 * @param  [type] $values values to push
	 * @return array with new values
	 */
	public static function array_push_values( &$array, $values ) {
		$array  = (array) $array;
		$values = (array) $values;

		if ( count( $values ) ) {
			foreach ($values as $value) {
				$array[] = $value;
			}
		}
		return $array;
	}

	/**
	 * Determine if a given string starts with a given substring.
	 *
	 * @param type       $haystack haystack.
	 * @param type|array $needles some needles.
	 * @return bool
	 */
	public static function starts_with( $haystack, $needles ) {
		foreach ( (array) $needles as $needle ) {
			if ( '' != $needle && 0 === strpos( $haystack, $needle ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get string from echo buffer and return in variable
	 *
	 * @param  mixed $func function name.
	 * @return string
	 */
	public static function echo_to_var( $func ) {
		$result = '';
		if ( is_callable( $func ) ) {
			ob_start();
			$func();
			$result = ob_get_clean();
		}
		return $result;
	}

	/**
	 * Models path
	 *
	 * @return  string
	 */
	public static function models_path() {
		return sprintf(
			'%s/app/models/',
			get_template_directory()
		);
	}

	/**
	 * Widgets path
	 *
	 * @return string
	 */
	public static function widgets_path() {
		return sprintf(
			'%s/app/modules/widgets/',
			get_template_directory()
		);
	}

	/**
	 * Pages path
	 *
	 * @return string
	 */
	public static function pages_path() {
		return sprintf(
			'%s/app/modules/pages/',
			get_template_directory()
		);
	}

	/**
	 * Assets URL
	 *
	 * @return string
	 */
	public static function assets_url() {
		return sprintf(
			'%s/app/assets/',
			get_template_directory_uri()
		);
	}

	/**
	 * Core URL
	 *
	 * @return string
	 */
	public static function core_url() {
		return sprintf(
			'%s/src/',
			get_template_directory_uri()
		);
	}

	/**
	 * Instead $GLOBALS['wp_filesystem']->get_contents( $file )
	 *
	 * @param type $url host url.
	 * @return string requres data
	 */
	public static function get_contents( $url ) {
		$wp_filesystem = sefl::get_wp_filesystem();
		$wp_filesystem->get_contents( $url );

		return $data;
	}

	/**
	 * Get wp_filesystem
	 *
	 * @return Object
	 */
	public static function get_wp_filesystem() {
		global $wp_filesystem;

		if ( ! defined( 'FS_CHMOD_FILE' ) ) {
			define( 'FS_CHMOD_FILE', ( fileperms( ABSPATH . 'index.php' ) & 0777 | 0644 ) );
		}

		if ( empty( $wp_filesystem ) ) {
			include_once( ABSPATH . '/wp-admin/includes/class-wp-filesystem-base.php' );
			include_once( ABSPATH . '/wp-admin/includes/class-wp-filesystem-direct.php' );
		}

		return new WP_Filesystem_Direct( null );
	}
}
