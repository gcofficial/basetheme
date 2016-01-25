<?php
/**
 * Typography settings model file
 *
 * @package photolab
 */

/**
 * Typogtaphy settings model class
 */
class Typography_Settings_Model {

	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		return Utils::array_get( (array) get_option( 'typography' ), $key, '' );
	}

	/**
	 * Get allowed fonts with all options
	 *
	 * @return array all allowed fonts.
	 */
	public static function get_allowed_fonts_with() {
		return array(
			'open_sans' => array(
				'name' => 'Open Sans',
				'url'  => 'https://fonts.googleapis.com/css?family=Open+Sans:400,800italic,800,700italic,700,600italic,600,400italic,300italic,300&subset=latin,greek,cyrillic,greek-ext,vietnamese,cyrillic-ext,latin-ext',
			),
			'pt_sans'   => array(
				'name' => 'PT Sans',
				'url'  => 'https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic&subset=latin,greek,cyrillic,greek-ext,vietnamese,cyrillic-ext,latin-ext',
			),
			'roboto'    => array(
				'name' => 'Roboto',
				'url'  => 'https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic&subset=latin,greek,greek-ext,cyrillic,vietnamese,cyrillic-ext,latin-ext',
			),
			'lato'      => array(
				'name' => 'Lato',
				'url'  => 'https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic&subset=latin,latin-ext',
			),
			'oswald'    => array(
				'name' => 'Oswald',
				'url'  => 'https://fonts.googleapis.com/css?family=Oswald:400,700,300&subset=latin,latin-ext',
			),
			'lora'      => array(
				'name' => 'Lora',
				'url'  => 'https://fonts.googleapis.com/css?family=Lora:400,400italic,700,700italic&subset=latin,latin-ext,cyrillic',
			),
			'raleway'   => array(
				'name' => 'Raleway',
				'url'  => 'https://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900',
			),
		);
	}

	/**
	 * Get font option
	 *
	 * @param type $font font key.
	 * @param type $option option key.
	 * @return font option.
	 */
	public static function get_font_option( $font, $option = 'name' ) {
		$options = self::get_fonts_option( $option );
		if ( array_key_exists( $font, $options ) ) {
			return $options[ $font ];
		}
		return false;
	}

	/**
	 * Get fonts option
	 *
	 * @param type $option option key.
	 * @return string array with font key => option value.
	 */
	public static function get_fonts_option( $option = 'name' ) {
		$result = array();
		$fonts  = self::get_allowed_fonts_with();
		foreach ( $fonts as $key => $font ) {
			$result[ $key ] = $font[ $option ];
		}
		return $result;
	}

	/**
	 * Get text color HEX
	 *
	 * @return string text color HEX.
	 */
	public static function get_text_color() {
		$color = trim( self::get_option( 'color_text' ) );
		if ( '' == $color ) {
			$color = '#000';
		}
		return  $color;
	}

	/**
	 * Get text H1 color HEX
	 *
	 * @param type $num H tag number.
	 * @return string text H1 color HEX.
	 */
	public static function get_h( $num ) {
		$color = trim( self::get_option( 'color_h' . $num ) );
		if ( '' == $color ) {
			$color = '#333';
		}
		return  $color;
	}
}
