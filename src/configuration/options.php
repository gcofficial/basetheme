<?php
/**
 * Configuration customizer options engine class file
 *
 * @package photolab
 */

/**
 * Customizer Options class
 */
class Options {

	/**
	 * Options array control
	 */
	const WITHOUT_PANEL = '__WITHOUT_PANEL__';
	const SECTIONS      = '__SECTIONS__';
	const SETTINGS      = '__SETTINGS__';
	const CONTROLS      = '__CONTROLS__';
	const CUSTOM_CLASS  = '__CLASS__';

	/**
	 * All settings
	 *
	 * @var array
	 */
	private $settings = array();

	/**
	 * The image sizes.
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * Images class constructor
	 *
	 * @param array $data engine data.
	 */
	public function __construct( array $data ) {
		$this->data = $data;
		$this->make();
	}

	/**
	 * Add custom image sizes.
	 *
	 * @return \Themosis\Configuration\Images
	 */
	public function make() {
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'scripts_and_styles' ) );
		add_action( 'customize_register', array( $this, 'register' ) );

		return $this;
	}

	/**
	 * This function enqueues scripts and styles in the Customizer.
	 */
	public function scripts_and_styles() {
		wp_enqueue_script(
			'my-customizer-script',
			Utils::assets_url() . '/js/customizer.js',
			array( 'customize-controls' )
		);
	}

	/**
	 * Front End Customizer
	 *
	 * @param  WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @return void
	 */
	public function register( $wp_customize ) {
		$data = Utils::array_remove_right_keys( array( self::WITHOUT_PANEL ), $this->data );
		$only_sections = Utils::array_get( $this->data, self::WITHOUT_PANEL, array() );

		// Add with panels
		if ( is_array( $data ) && count( $data ) ) {
			$this->add_panels( $wp_customize, $data );
		}

		// Add sections withou panels
		if ( is_array( $only_sections ) && count( $only_sections ) ) {
			$this->add_sections( $wp_customize, '', $only_sections );
		}
	}

	/**
	 * Add panels to customizer
	 *
	 * @param [type] $customizer $wp_customize object.
	 * @param [type] $panels     panels list.
	 */
	public function add_panels( $customizer, $panels ) {
		if ( is_array( $panels ) && count( $panels ) ) {
			foreach ( $panels as $panel_key => $parameters ) {
				$this->add_panel( $customizer, $panel_key, $parameters );
				if ( array_key_exists( self::SECTIONS, $parameters ) ) {
					$sections = $parameters[ self::SECTIONS ];
					if ( is_array( $sections ) && count( $sections ) ) {
						$this->add_sections( $customizer, $panel_key, $sections );
					}
				}
			}
		}
	}

	/**
	 * Add panel to customizer
	 *
	 * @param [type] $customizer $wp_customize object.
	 * @param [type] $panel      panel key.
	 * @param [type] $parameters panel parameters.
	 */
	public function add_panel( $customizer, $panel, $parameters ) {
		$parameters = Utils::array_remove_right_keys( array( self::SECTIONS ), $parameters );
		$customizer->add_panel( $panel, $parameters );
	}

	/**
	 * Add sections to customizer
	 *
	 * @param [type] $customizer $wp_customize object.
	 * @param [type] $panel_key  Panel.
	 * @param [type] $sections Panel sections list.
	 */
	public function add_sections( $customizer, $panel_key, $sections ) {
		foreach ( $sections as $section_key => $parameters ) {
			$parameters['panel'] = $panel_key;
			$this->add_section( $customizer, $section_key, $parameters );
			if ( array_key_exists( self::CONTROLS, $parameters ) ) {
				$settings = Utils::array_get( $parameters, self::SETTINGS, array() );
				$controls = $parameters[ self::CONTROLS ];

				if ( is_array( $controls ) && count( $controls ) ) {
					$prefix = sprintf( '%s_%s', $panel_key, $section_key );
					$this->add_settings( $customizer, $settings, $prefix );
					$this->add_controls( $customizer, $controls, $section_key, $prefix );
				}
			}
		}
	}

	/**
	 * Add section to customizer
	 *
	 * @param [type] $customizer  $wp_customize object.
	 * @param [type] $section_key section key.
	 * @param [type] $parameters  section parameters.
	 */
	public function add_section( $customizer, $section_key, $parameters ) {
		$parameters = Utils::array_remove_right_keys(
			array(
				self::SETTINGS,
				self::CONTROLS,
			),
			$parameters
		);
		$customizer->add_section( $section_key, $parameters );
	}

	/**
	 * Add settings to customizer
	 *
	 * @param [type] $customizer     $wp_customize object.
	 * @param [type] $settings       settings list.
	 * @param [type] $prefix         setting prefix.
	 */
	public function add_settings( $customizer, $settings, $prefix = '' ) {
		$settings = (array) $settings;
		if ( ! count( $settings ) ) {
			return false;
		}
		foreach ( $settings as $key => $value ) {
			if ( is_int( $key ) ) {
				$setting_key = $this->get_setting_name( $prefix, $value );
				$this->add_setting( $customizer, $setting_key );
			} else {
				$setting_key = $this->get_setting_name( $prefix, $key );
				$this->add_setting( $customizer, $setting_key, $value );
			}
		}
	}

	/**
	 * Add setting to customizer
	 *
	 * @param [type] $customizer         $wp_cutomize object.
	 * @param [type] $setting_key        setting key.
	 * @param array  $setting_parameters setting parameters.
	 */
	public function add_setting( $customizer, $setting_key, $setting_parameters = array() ) {
		$this->settings[ $setting_key ] = true;
		$defaults = array(
			'default'           => '',
			'type'              => 'option',
			'capability'        => 'manage_options',
			'sanitize_callback' => 'sanitize_text_field',
		);
		$setting_parameters = array_merge( $defaults, $setting_parameters );
		$customizer->add_setting( $setting_key, $setting_parameters );
	}

	/**
	 * Is setting added?
	 *
	 * @param  [type] $setting_key setting key.
	 * @return boolean true if success false if not.
	 */
	private function is_setting_added( $setting_key ) {
		return array_key_exists( $setting_key, $this->settings );
	}

	/**
	 * Get setting name
	 *
	 * @param  [type] $prefix setting prefix.
	 * @param  [type] $setting_name   setting name.
	 * @return setting name like: $prefix[ $setting_name ]
	 */
	public function get_setting_name( $prefix, $setting_name ) {
		$prefix       = trim( $prefix );
		$setting_name = trim( $setting_name );
		$result       = $setting_name;

		if ( '' != $prefix ) {
			$result = sprintf( '%s[%s]', $prefix, $setting_name );
		}
		return $result;
	}

	/**
	 * Add controls to customizer
	 *
	 * @param [type] $customizer $wp_cutomize object.
	 * @param [type] $controls   controls list.
	 * @param [type] $section_name section name.
	 * @param [type] $prefix     controls prefix.
	 */
	public function add_controls( $customizer, $controls, $section_name, $prefix = '' ) {
		foreach ( $controls as $key => $parameters ) {
			$setting  = $this->get_setting_name( $prefix, $key );
			$defaults = array(
				'settings' => $setting,
				'section'  => $section_name,
			);
			$control_key = $prefix.'_'.$key;
			$control_parameters = array_merge( $defaults, $parameters );

			// If setting not added then add setting
			if ( ! $this->is_setting_added( $setting ) ) {
				$this->add_setting( $customizer, $setting );
			}

			if ( array_key_exists( self::CUSTOM_CLASS, $parameters ) ) {
				$custom_class = $parameters[ self::CUSTOM_CLASS ];
				if ( class_exists( $custom_class ) ) {
					$customizer->add_control(
						new $custom_class( $customizer, $control_key, $control_parameters )
					);
				}
			} else {
				$customizer->add_control( $control_key, $control_parameters );
			}
		}
	}
}
