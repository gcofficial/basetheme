<?php
/**
 * Customizer module file
 *
 * @package photolab
 */

/**
 * Customize class
 */
class Customizer {

	/**
	 * Customizer class construct
	 */
	public function __construct() {
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'scripts_and_styles' ) );
		add_action( 'customize_register', array( $this, 'register' ) );
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
		// Add panels
		$panels = $this->get_panels();
		foreach ( $panels as $panel_key => $panel_parameters ) {
			$wp_customize->add_panel( $panel_key, $panel_parameters );
		}

		// Add sections
		$sections = $this->get_sections();
		foreach ( $sections as $section_key => $section_parameters ) {
			$wp_customize->add_section( $section_key, $section_parameters );
		}

		// Add settings
		$settings = $this->get_settings();
		foreach ( $settings as $setting_key => $setting_parameters ) {
			/**
			 * Add defaults
			 *
			 * @var array
			 */
			$setting_parameters = array_merge(
				array(
					'default'           => '',
					'type'              => 'option',
					'capability'        => 'manage_options',
					'sanitize_callback' => 'sanitize_text_field',
				),
				(array) $setting_parameters
			);

			$wp_customize->add_setting( $setting_key, $setting_parameters );
		}

		// Add controls
		$controls = $this->get_controls( $wp_customize );
		foreach ( $controls as $control_key => $control_parameters ) {
			if ( $control_parameters instanceof WP_Customize_Control ) {
				$wp_customize->add_control( $control_parameters );
			} else {
				$wp_customize->add_control( $control_key, $control_parameters );
			}
		}
	}

	/**
	 * Get customize panels
	 *
	 * @return array panel list.
	 */
	public function get_panels() {
		return array(
			'general_site_settings' => array(
				'title'       => __( 'General site settings', 'photolab' ),
				'description' => __( 'This is general site settings.', 'photolab' ),
			),
			'header_settings' => array(
				'title'       => __( 'Header settings', 'photolab' ),
				'description' => __( 'This is header settings panel.', 'photolab' ),
			),
		);
	}

	/**
	 * Get customize sections
	 *
	 * @return array panel list.
	 */
	public function get_sections() {
		return array(
			'site_title_and_tageline' => array(
				'title'       => __( 'Site title & tagline', 'photolab' ),
				'description' => __( 'This is a Site Title & Tagline section.', 'photolab' ),
				'panel'       => 'general_site_settings',
			),
			'logo_and_favicon' => array(
				'title' => __( 'Logo & favicon', 'photolab' ),
				'panel' => 'general_site_settings',
			),
			'breadcrumbs' => array(
				'title' => __( 'Breadcrumbs', 'photolab' ),
				'panel' => 'general_site_settings',
			),
			'color_scheme' => array(
				'title' => __( 'Color scheme', 'photolab' ),
				'panel' => 'general_site_settings',
			),
			'typography_settings' => array(
				'title' => __( 'Typography settings', 'photolab' ),
				'panel' => 'general_site_settings',
			),
			'social_links' => array(
				'title' => __( 'Social links', 'photolab' ),
				'panel' => 'general_site_settings',
			),
			'page_layout_settings' => array(
				'title' => __( 'Page layout settings', 'photolab' ),
				'panel' => 'general_site_settings',
			),
			'header_styles' => array(
				'title' => __( 'Header styles', 'photolab' ),
				'panel' => 'header_settings',
			),
			'top_panel_settings' => array(
				'title' => __( 'Top panel settings', 'photolab' ),
				'panel' => 'header_settings',
			),
			'main_menu_settings' => array(
				'title' => __( 'Main menu settings', 'photolab' ),
				'panel' => 'header_settings',
			),
			'menu_settings' => array(
				'title' => __( 'Menu settings', 'photolab' ),
			),
			'sidebar_settings' => array(
				'title' => __( 'Sidebar settings', 'photolab' ),
			),
			'footer_settings' => array(
				'title' => __( 'Footer settings', 'photolab' ),
			),
			'blog_settings' => array(
				'title' => __( 'Blog settings', 'photolab' ),
			),
			'static_front_page' => array(
				'title' => __( 'Static front page', 'photolab' ),
			),
			'misc' => array(
				'title' => __( 'Misc', 'photolab' ),
			),
		);
	}

	/**
	 * Get customize Settings
	 *
	 * @return array settings list.
	 */
	public function get_settings() {
		return array(
			'blogname'                => array( 'default' => get_option( 'blogname' ) ),
			'blogdescription'         => array( 'default' => get_option( 'blogdescription' ) ),
			'gss_lf[logo]'            => array(),
			'gss_lf[favicon]'         => array(),
			'gss_lf[enable_retina]'   => array(),
			'gss_lf[show_preloader]'  => array(),
			'gss_b[show_page_title]'  => array(),
			'gss_b[show_breadcrubs]'  => array(),
			'gss_b[full_minifide]'    => array(),
			'gss_sl[show_in_header]'  => array(),
			'gss_sl[show_in_footer]'  => array(),
			'gss_sl[show_in_posts]'   => array(),
			'gss_sl[show_in_post]'    => array(),
			'gss_sl[rss_feed]'        => array(),
			'gss_sl[facebook]'        => array(),
			'gss_sl[twitter]'         => array(),
			'gss_sl[google_plus]'     => array(),
			'gss_sl[instagram]'       => array(),
			'gss_sl[linked_in]'       => array(),
			'gss_sl[dribble]'         => array(),
			'gss_sl[youtube]'         => array(),
		);
	}

	/**
	 * Get customize controls
	 *
	 * @return array controls list.
	 */
	public function get_controls( $wp_customize = null ) {
		return array(
			'blogname' => array(
				'label'      => __( 'Site Title' ),
				'section'    => 'site_title_and_tageline',
			),
			'blogdescription' => array(
				'label'      => __( 'Tagline' ),
				'section'    => 'site_title_and_tageline',
			),
			new WP_Customize_Image_Control(
				$wp_customize,
				'gss_lf_logo',
				array(
					'label'      => __( 'Upload a logo', 'photolab' ),
					'section'    => 'logo_and_favicon',
					'settings'   => 'gss_lf[logo]',
				)
			),
			new WP_Customize_Image_Control(
				$wp_customize,
				'gss_lf_favicon',
				array(
					'label'      => __( 'Upload a favicon', 'photolab' ),
					'section'    => 'logo_and_favicon',
					'settings'   => 'gss_lf[favicon]',
				)
			),
			'gss_lf_enable_retina' => array(
				'label'    => __( 'Enable / Disable retina optimisation', 'photolab' ),
				'section'  => 'logo_and_favicon',
				'settings' => 'gss_lf[enable_retina]',
				'type'     => 'checkbox',
			),
			'gss_lf_show_preloader' => array(
				'label'    => __( 'Enable / Disable page preloader', 'photolab' ),
				'section'  => 'logo_and_favicon',
				'settings' => 'gss_lf[show_preloader]',
				'type'     => 'checkbox',
			),
			'gss_b_show_page_title' => array(
				'label'    => __( 'Enable / Disable page title in breadcrumbs area', 'photolab' ),
				'section'  => 'breadcrumbs',
				'settings' => 'gss_b[show_page_title]',
				'type'     => 'checkbox',
			),
			'gss_b_show_breadcrubs' => array(
				'label'    => __( 'Enable / Disable breadcrumbs', 'photolab' ),
				'section'  => 'breadcrumbs',
				'settings' => 'gss_b[show_breadcrubs]',
				'type'     => 'checkbox',
			),
			'gss_b_full_minifide' => array(
				'label'    => __( 'Show full / Minified breadcrumbs path', 'photolab' ),
				'section'  => 'breadcrumbs',
				'settings' => 'gss_b[full_minifide]',
				'type'     => 'checkbox',
			),
			'gss_sl_show_in_header' => array(
				'label'    => __( 'Show social links in header', 'photolab' ),
				'section'  => 'social_links',
				'settings' => 'gss_sl[show_in_header]',
				'type'     => 'checkbox',
			),
			'gss_sl_show_in_footer' => array(
				'label'    => __( 'Show social links in footer', 'photolab' ),
				'section'  => 'social_links',
				'settings' => 'gss_sl[show_in_footer]',
				'type'     => 'checkbox',
			),
			'gss_sl_show_in_posts' => array(
				'label'    => __( 'Add social sharing to blog posts', 'photolab' ),
				'section'  => 'social_links',
				'settings' => 'gss_sl[show_in_posts]',
				'type'     => 'checkbox',
			),
			'gss_sl_show_in_post' => array(
				'label'    => __( 'Add social sharing to single blog post', 'photolab' ),
				'section'  => 'social_links',
				'settings' => 'gss_sl[show_in_post]',
				'type'     => 'checkbox',
			),
			'gss_sl_rss_feed' => array(
				'label'    => __( 'RSS Feed link', 'photolab' ),
				'section'  => 'social_links',
				'settings' => 'gss_sl[rss_feed]',
				'type'     => 'text',
			),
			'gss_sl_facebook' => array(
				'label'    => __( 'Facebook URL', 'photolab' ),
				'section'  => 'social_links',
				'settings' => 'gss_sl[facebook]',
				'type'     => 'text',
			),
			'gss_sl_twitter' => array(
				'label'    => __( 'Twitter URL', 'photolab' ),
				'section'  => 'social_links',
				'settings' => 'gss_sl[twitter]',
				'type'     => 'text',
			),
			'gss_sl_google_plus' => array(
				'label'    => __( 'Google+ URL', 'photolab' ),
				'section'  => 'social_links',
				'settings' => 'gss_sl[google_plus]',
				'type'     => 'text',
			),
			'gss_sl_instagram' => array(
				'label'    => __( 'Instagram URL', 'photolab' ),
				'section'  => 'social_links',
				'settings' => 'gss_sl[instagram]',
				'type'     => 'text',
			),
			'gss_sl_linked_in' => array(
				'label'    => __( 'LinkedIn URL', 'photolab' ),
				'section'  => 'social_links',
				'settings' => 'gss_sl[linked_in]',
				'type'     => 'text',
			),
			'gss_sl_dribble' => array(
				'label'    => __( 'Dribble URL', 'photolab' ),
				'section'  => 'social_links',
				'settings' => 'gss_sl[dribble]',
				'type'     => 'text',
			),
			'gss_sl_youtube' => array(
				'label'    => __( 'Youtube URL', 'photolab' ),
				'section'  => 'social_links',
				'settings' => 'gss_sl[youtube]',
				'type'     => 'text',
			),
		);
	}
}

new Customizer;
