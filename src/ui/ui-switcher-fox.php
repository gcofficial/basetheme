<?php
/**
 * Description: Fox ui-elements
 * Version: 0.2
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 *
 * @package ui_switcherfox
 *
 * @since 0.1.0
 */

if ( ! class_exists( 'UI_Switcher_Fox' ) ) {

	/**
	 * UI-switcher.
	 */
	class UI_Switcher_Fox {

		/**
		 * Default settings
		 *
		 * @var type array
		 */
		private $default_settings = array(
			'id'        => 'switcher-fox',
			'class'     => '',
			'name'      => 'switcher-fox',
			'values'    => array( 'true' => 'On', 'false' => 'Off' ),
			'default'    => 'true',
		);

		/**
		 * Required settings
		 *
		 * @var type array
		 */
		private $required_settings = array(
			'class'        => 'switcher-fox',
		);

		/**
		 * Settings
		 *
		 * @var type array
		 */
		public $settings;

		/**
		 * Init base settings
		 */
		public function __construct( $attr = null ) {
			if ( empty( $attr ) || ! is_array( $attr ) ) {
				$attr = $this->default_settings;
			} else {
				foreach ( $this->default_settings as $key => $value ) {
					if ( empty( $attr[ $key ] ) ) {
						$attr[ $key ] = $this->default_settings[ $key ];
					}
				}
			}

			$this->settings = $attr;
		}

		/**
		 * Add styles
		 */
		private function assets() {
			$url = get_template_directory_uri() . '/src/ui/ui-switcher/assets/css/switcher.min.css';
			wp_enqueue_style( 'switcher-fox', $url, array(), '0.2.0', 'all' );
		}

		/**
		 * Render html
		 *
		 * @return string
		 */
		public function output() {
			$this->assets();
			foreach ( $this->required_settings as $key => $value ) {
				$this->settings[ $key ] = empty( $this->settings[ $key ] ) ? $value : $this->settings[ $key ] . ' ' . $value;
			}

			$values = $this->settings['values'];
			$value_first = each( $values );
			$value_second = each( $values );
			if ( empty( $this->settings['default'] ) ) {
				$default_array = each( $values );
				$default = $default_array[ $key ];
			} else {
				$default = $this->settings['default'];
			}
			$name = $this->settings['name'];
			unset( $this->settings['values'], $this->settings['name'], $this->settings['default'] );
			$attributes = '';
			foreach ( $this->settings as $key => $value ) {
				$attributes .= ' ' . $key . '="' . $value . '"';
			}

			return View::make(
				__DIR__ . '/ui-switcher/views/switcher.php',
				array(
					'attributes'		=> $attributes,
					'name'				=> $name,
					'value_first'		=> $value_first,
					'value_second'		=> $value_second,
					'default'			=> $default,
				)
			);
		}
	}
}
