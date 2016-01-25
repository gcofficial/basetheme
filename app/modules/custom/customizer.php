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

		// Remove not needed sections
		$not_needed_sections = $this->get_not_needed_sections();
		foreach ( $not_needed_sections as $not_needed_section ) {
			$wp_customize->remove_section( $not_needed_section );
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
			'color_scheme' => array(
				'title'       => __( 'Color scheme', 'photolab' ),
				'description' => '',
			),
			'typography_settings' => array(
				'title'       => __( 'Typography settings', 'photolab' ),
				'description' => '',
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
			'regular' => array(
				'title' => __( 'Regular', 'photolab' ),
				'panel' => 'color_scheme',
			),
			'invert' => array(
				'title' => __( 'Invert', 'photolab' ),
				'panel' => 'color_scheme',
			),
			'body_text' => array(
				'title' => __( 'Body text', 'photolab' ),
				'panel' => 'typography_settings',
			),
			'breadcrumbs_typography' => array(
				'title' => __( 'Breadcrumbs typography', 'photolab' ),
				'panel' => 'typography_settings',
			),
			'h1_heading' => array(
				'title' => __( 'H1 heading', 'photolab' ),
				'panel' => 'typography_settings',
			),
			'h2_heading' => array(
				'title' => __( 'H2 heading', 'photolab' ),
				'panel' => 'typography_settings',
			),
			'h3_heading' => array(
				'title' => __( 'H3 heading', 'photolab' ),
				'panel' => 'typography_settings',
			),
			'h4_heading' => array(
				'title' => __( 'H4 heading', 'photolab' ),
				'panel' => 'typography_settings',
			),
			'h5_heading' => array(
				'title' => __( 'H5 heading', 'photolab' ),
				'panel' => 'typography_settings',
			),
			'h6_heading' => array(
				'title' => __( 'H6 heading', 'photolab' ),
				'panel' => 'typography_settings',
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
	 * Get not needed sections
	 *
	 * @return array not needed sections.
	 */
	public function get_not_needed_sections() {
		return array(
			'title_tagline',
			'background_image',
			'static_front_page',
			'colors',
		);
	}

	/**
	 * Get customize Settings
	 *
	 * @return array settings list.
	 */
	public function get_settings() {
		return array(
			'blogname'                      => array( 'default' => get_option( 'blogname' ) ),
			'blogdescription'               => array( 'default' => get_option( 'blogdescription' ) ),
			'gss_lf[logo]'                  => array(),
			'gss_lf[favicon]'               => array(),
			'gss_lf[enable_retina]'         => array(),
			'gss_lf[show_preloader]'        => array(),
			'gss_b[show_page_title]'        => array(),
			'gss_b[show_breadcrubs]'        => array(),
			'gss_b[full_minifide]'          => array(),
			'gss_sl[show_in_header]'        => array(),
			'gss_sl[show_in_footer]'        => array(),
			'gss_sl[show_in_posts]'         => array(),
			'gss_sl[show_in_post]'          => array(),
			'gss_sl[rss_feed]'              => array(),
			'gss_sl[facebook]'              => array(),
			'gss_sl[twitter]'               => array(),
			'gss_sl[google_plus]'           => array(),
			'gss_sl[instagram]'             => array(),
			'gss_sl[linked_in]'             => array(),
			'gss_sl[dribble]'               => array(),
			'gss_sl[youtube]'               => array(),
			'cs_r[accent]'                  => array(),
			'cs_r[text]'                    => array(),
			'cs_r[link_hover]'              => array(),
			'cs_r[heading]'                 => array(),
			'cs_i[accent]'                  => array(),
			'cs_i[text]'                    => array(),
			'cs_i[link_hover]'              => array(),
			'cs_i[heading]'                 => array(),
			'gss_pls[layout]'               => array(),
			'gss_pls[width]'                => array( 'default' => 1170 ),
			'gss_pls[sidebar_width]'        => array(),
			'ts_bt[font_family]'            => array(),
			'ts_bt[font_style]'             => array(),
			'ts_bt[character_set]'          => array(),
			'ts_bt[font_size]'              => array(),
			'ts_bt[font_weight]'            => array(),
			'ts_bt[line_height]'            => array(),
			'ts_bt[letter_space]'           => array(),
			'ts_bt[text_align]'             => array(),
			'ts_breadcrumbs[font_family]'   => array(),
			'ts_breadcrumbs[font_style]'    => array(),
			'ts_breadcrumbs[character_set]' => array(),
			'ts_breadcrumbs[font_size]'     => array(),
			'ts_breadcrumbs[font_weight]'   => array(),
			'ts_breadcrumbs[line_height]'   => array(),
			'ts_breadcrumbs[letter_space]'  => array(),
			'ts_breadcrumbs[text_align]'    => array(),
			'ts_h1[font_family]'            => array(),
			'ts_h1[font_style]'             => array(),
			'ts_h1[character_set]'          => array(),
			'ts_h1[font_size]'              => array(),
			'ts_h1[font_weight]'            => array(),
			'ts_h1[line_height]'            => array(),
			'ts_h1[letter_space]'           => array(),
			'ts_h1[text_align]'             => array(),
			'ts_h2[font_family]'            => array(),
			'ts_h2[font_style]'             => array(),
			'ts_h2[character_set]'          => array(),
			'ts_h2[font_size]'              => array(),
			'ts_h2[font_weight]'            => array(),
			'ts_h2[line_height]'            => array(),
			'ts_h2[letter_space]'           => array(),
			'ts_h2[text_align]'             => array(),
			'ts_h3[font_family]'            => array(),
			'ts_h3[font_style]'             => array(),
			'ts_h3[character_set]'          => array(),
			'ts_h3[font_size]'              => array(),
			'ts_h3[font_weight]'            => array(),
			'ts_h3[line_height]'            => array(),
			'ts_h3[letter_space]'           => array(),
			'ts_h3[text_align]'             => array(),
			'ts_h4[font_family]'            => array(),
			'ts_h4[font_style]'             => array(),
			'ts_h4[character_set]'          => array(),
			'ts_h4[font_size]'              => array(),
			'ts_h4[font_weight]'            => array(),
			'ts_h4[line_height]'            => array(),
			'ts_h4[letter_space]'           => array(),
			'ts_h4[text_align]'             => array(),
			'ts_h5[font_family]'            => array(),
			'ts_h5[font_style]'             => array(),
			'ts_h5[character_set]'          => array(),
			'ts_h5[font_size]'              => array(),
			'ts_h5[font_weight]'            => array(),
			'ts_h5[line_height]'            => array(),
			'ts_h5[letter_space]'           => array(),
			'ts_h5[text_align]'             => array(),
			'ts_h6[font_family]'            => array(),
			'ts_h6[font_style]'             => array(),
			'ts_h6[character_set]'          => array(),
			'ts_h6[font_size]'              => array(),
			'ts_h6[font_weight]'            => array(),
			'ts_h6[line_height]'            => array(),
			'ts_h6[letter_space]'           => array(),
			'ts_h6[text_align]'             => array(),
			'hs_hs[image_position]'         => array(),
			'hs_hs[image_repeat]'           => array(),
			'hs_hs[background_scroll]'      => array(),
			'hs_hs[background_color]'       => array(),
			'hs_hs[layout]'                 => array(),
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
			'cs_r_accent' => array(
				'label'    => __( 'Accent', 'photolab' ),
				'settings' => 'cs_r[accent]',
				'section'  => 'regular',
				'type'     => 'text',
			),
			'cs_r_text' => array(
				'label'    => __( 'Text', 'photolab' ),
				'settings' => 'cs_r[text]',
				'section'  => 'regular',
				'type'     => 'text',
			),
			'cs_r_link_hover' => array(
				'label'    => __( 'Link hover', 'photolab' ),
				'settings' => 'cs_r[link_hover]',
				'section'  => 'regular',
				'type'     => 'text',
			),
			'cs_r_heading' => array(
				'label'    => __( 'Heading ( H1 - H6 )', 'photolab' ),
				'settings' => 'cs_r[heading]',
				'section'  => 'regular',
				'type'     => 'text',
			),
			'cs_i_accent' => array(
				'label'    => __( 'Accent', 'photolab' ),
				'settings' => 'cs_i[accent]',
				'section'  => 'invert',
				'type'     => 'text',
			),
			'cs_i_text' => array(
				'label'    => __( 'Text', 'photolab' ),
				'settings' => 'cs_i[text]',
				'section'  => 'invert',
				'type'     => 'text',
			),
			'cs_i_link_hover' => array(
				'label'    => __( 'Link hover', 'photolab' ),
				'settings' => 'cs_i[link_hover]',
				'section'  => 'invert',
				'type'     => 'text',
			),
			'cs_i_heading' => array(
				'label'    => __( 'Heading ( H1 - H6 )', 'photolab' ),
				'settings' => 'cs_i[heading]',
				'section'  => 'invert',
				'type'     => 'text',
			),
			'gss_pls_layout'         => array(
				'label'    => __( 'Layout style', 'photolab' ),
				'settings' => 'gss_pls[layout]',
				'section'  => 'page_layout_settings',
				'type'     => 'select',
				'choices'  => array(
					'boxed' => __( 'Boxed', 'photolab' ),
					'full'  => __( 'Full width', 'photolab' ),
				),
			),
			'gss_pls_width'          => array(
				'label'    => __( 'Container width', 'photolab' ),
				'settings' => 'gss_pls[width]',
				'section'  => 'page_layout_settings',
				'type'     => 'text',
			),
			'gss_pls_sidebar_width'  => array(
				'label'    => __( 'Sidebar width', 'photolab' ),
				'settings' => 'gss_pls[sidebar_width]',
				'section'  => 'page_layout_settings',
				'type'     => 'select',
				'choices'  => array(
					'1__3' => '⅓',
					'1__4' => '¼',
				),
			),
			'ts_bt_font_family' => array(
				'label'    => __( 'Font family', 'photolab' ),
				'settings' => 'ts_bt[font_family]',
				'section'  => 'body_text',
				'type'     => 'text',
			),
			'ts_bt_font_style' => array(
				'label'    => __( 'Font style', 'photolab' ),
				'settings' => 'ts_bt[font_style]',
				'section'  => 'body_text',
				'type'     => 'text',
			),
			'ts_bt_character_set' => array(
				'label'    => __( 'Character set', 'photolab' ),
				'settings' => 'ts_bt[character_set]',
				'section'  => 'body_text',
				'type'     => 'text',
			),
			'ts_bt_font_size' => array(
				'label'    => __( 'Font size', 'photolab' ),
				'settings' => 'ts_bt[font_size]',
				'section'  => 'body_text',
				'type'     => 'text',
			),
			'ts_bt_font_weight' => array(
				'label'    => __( 'Font weight', 'photolab' ),
				'settings' => 'ts_bt[font_weight]',
				'section'  => 'body_text',
				'type'     => 'text',
			),
			'ts_bt_line_height' => array(
				'label'    => __( 'Line height', 'photolab' ),
				'settings' => 'ts_bt[line_height]',
				'section'  => 'body_text',
				'type'     => 'text',
			),
			'ts_bt_letter_space' => array(
				'label'    => __( 'Letter space', 'photolab' ),
				'settings' => 'ts_bt[letter_space]',
				'section'  => 'body_text',
				'type'     => 'text',
			),
			'ts_bt_text_align' => array(
				'label'    => __( 'Text align', 'photolab' ),
				'settings' => 'ts_bt[text_align]',
				'section'  => 'body_text',
				'type'     => 'text',
			),
			'ts_breadcrumbs_font_family' => array(
				'label'    => __( 'Font family', 'photolab' ),
				'settings' => 'ts_breadcrumbs[font_family]',
				'section'  => 'breadcrumbs_typography',
				'type'     => 'text',
			),
			'ts_breadcrumbs_font_style' => array(
				'label'    => __( 'Font style', 'photolab' ),
				'settings' => 'ts_breadcrumbs[font_style]',
				'section'  => 'breadcrumbs_typography',
				'type'     => 'text',
			),
			'ts_breadcrumbs_character_set' => array(
				'label'    => __( 'Character set', 'photolab' ),
				'settings' => 'ts_breadcrumbs[character_set]',
				'section'  => 'breadcrumbs_typography',
				'type'     => 'text',
			),
			'ts_breadcrumbs_font_size' => array(
				'label'    => __( 'Font size', 'photolab' ),
				'settings' => 'ts_breadcrumbs[font_size]',
				'section'  => 'breadcrumbs_typography',
				'type'     => 'text',
			),
			'ts_breadcrumbs_font_weight' => array(
				'label'    => __( 'Font weight', 'photolab' ),
				'settings' => 'ts_breadcrumbs[font_weight]',
				'section'  => 'breadcrumbs_typography',
				'type'     => 'text',
			),
			'ts_breadcrumbs_line_height' => array(
				'label'    => __( 'Line height', 'photolab' ),
				'settings' => 'ts_breadcrumbs[line_height]',
				'section'  => 'breadcrumbs_typography',
				'type'     => 'text',
			),
			'ts_breadcrumbs_letter_space' => array(
				'label'    => __( 'Letter space', 'photolab' ),
				'settings' => 'ts_breadcrumbs[letter_space]',
				'section'  => 'breadcrumbs_typography',
				'type'     => 'text',
			),
			'ts_breadcrumbs_text_align' => array(
				'label'    => __( 'Text align', 'photolab' ),
				'settings' => 'ts_breadcrumbs[text_align]',
				'section'  => 'breadcrumbs_typography',
				'type'     => 'text',
			),
			'ts_h1_font_family' => array(
				'label'    => __( 'Font family', 'photolab' ),
				'settings' => 'ts_h1[font_family]',
				'section'  => 'h1_heading',
				'type'     => 'text',
			),
			'ts_h1_font_style' => array(
				'label'    => __( 'Font style', 'photolab' ),
				'settings' => 'ts_h1[font_style]',
				'section'  => 'h1_heading',
				'type'     => 'text',
			),
			'ts_h1_character_set' => array(
				'label'    => __( 'Character set', 'photolab' ),
				'settings' => 'ts_h1[character_set]',
				'section'  => 'h1_heading',
				'type'     => 'text',
			),
			'ts_h1_font_size' => array(
				'label'    => __( 'Font size', 'photolab' ),
				'settings' => 'ts_h1[font_size]',
				'section'  => 'h1_heading',
				'type'     => 'text',
			),
			'ts_h1_font_weight' => array(
				'label'    => __( 'Font weight', 'photolab' ),
				'settings' => 'ts_h1[font_weight]',
				'section'  => 'h1_heading',
				'type'     => 'text',
			),
			'ts_h1_line_height' => array(
				'label'    => __( 'Line height', 'photolab' ),
				'settings' => 'ts_h1[line_height]',
				'section'  => 'h1_heading',
				'type'     => 'text',
			),
			'ts_h1_letter_space' => array(
				'label'    => __( 'Letter space', 'photolab' ),
				'settings' => 'ts_h1[letter_space]',
				'section'  => 'h1_heading',
				'type'     => 'text',
			),
			'ts_h1_text_align' => array(
				'label'    => __( 'Text align', 'photolab' ),
				'settings' => 'ts_h1[text_align]',
				'section'  => 'h1_heading',
				'type'     => 'text',
			),
			'ts_h2_font_family' => array(
				'label'    => __( 'Font family', 'photolab' ),
				'settings' => 'ts_h2[font_family]',
				'section'  => 'h2_heading',
				'type'     => 'text',
			),
			'ts_h2_font_style' => array(
				'label'    => __( 'Font style', 'photolab' ),
				'settings' => 'ts_h2[font_style]',
				'section'  => 'h2_heading',
				'type'     => 'text',
			),
			'ts_h2_character_set' => array(
				'label'    => __( 'Character set', 'photolab' ),
				'settings' => 'ts_h2[character_set]',
				'section'  => 'h2_heading',
				'type'     => 'text',
			),
			'ts_h2_font_size' => array(
				'label'    => __( 'Font size', 'photolab' ),
				'settings' => 'ts_h2[font_size]',
				'section'  => 'h2_heading',
				'type'     => 'text',
			),
			'ts_h2_font_weight' => array(
				'label'    => __( 'Font weight', 'photolab' ),
				'settings' => 'ts_h2[font_weight]',
				'section'  => 'h2_heading',
				'type'     => 'text',
			),
			'ts_h2_line_height' => array(
				'label'    => __( 'Line height', 'photolab' ),
				'settings' => 'ts_h2[line_height]',
				'section'  => 'h2_heading',
				'type'     => 'text',
			),
			'ts_h2_letter_space' => array(
				'label'    => __( 'Letter space', 'photolab' ),
				'settings' => 'ts_h2[letter_space]',
				'section'  => 'h2_heading',
				'type'     => 'text',
			),
			'ts_h2_text_align' => array(
				'label'    => __( 'Text align', 'photolab' ),
				'settings' => 'ts_h2[text_align]',
				'section'  => 'h2_heading',
				'type'     => 'text',
			),
			'ts_h3_font_family' => array(
				'label'    => __( 'Font family', 'photolab' ),
				'settings' => 'ts_h3[font_family]',
				'section'  => 'h3_heading',
				'type'     => 'text',
			),
			'ts_h3_font_style' => array(
				'label'    => __( 'Font style', 'photolab' ),
				'settings' => 'ts_h3[font_style]',
				'section'  => 'h3_heading',
				'type'     => 'text',
			),
			'ts_h3_character_set' => array(
				'label'    => __( 'Character set', 'photolab' ),
				'settings' => 'ts_h3[character_set]',
				'section'  => 'h3_heading',
				'type'     => 'text',
			),
			'ts_h3_font_size' => array(
				'label'    => __( 'Font size', 'photolab' ),
				'settings' => 'ts_h3[font_size]',
				'section'  => 'h3_heading',
				'type'     => 'text',
			),
			'ts_h3_font_weight' => array(
				'label'    => __( 'Font weight', 'photolab' ),
				'settings' => 'ts_h3[font_weight]',
				'section'  => 'h3_heading',
				'type'     => 'text',
			),
			'ts_h3_line_height' => array(
				'label'    => __( 'Line height', 'photolab' ),
				'settings' => 'ts_h3[line_height]',
				'section'  => 'h3_heading',
				'type'     => 'text',
			),
			'ts_h3_letter_space' => array(
				'label'    => __( 'Letter space', 'photolab' ),
				'settings' => 'ts_h3[letter_space]',
				'section'  => 'h3_heading',
				'type'     => 'text',
			),
			'ts_h3_text_align' => array(
				'label'    => __( 'Text align', 'photolab' ),
				'settings' => 'ts_h3[text_align]',
				'section'  => 'h3_heading',
				'type'     => 'text',
			),
			'ts_h4_font_family' => array(
				'label'    => __( 'Font family', 'photolab' ),
				'settings' => 'ts_h4[font_family]',
				'section'  => 'h4_heading',
				'type'     => 'text',
			),
			'ts_h4_font_style' => array(
				'label'    => __( 'Font style', 'photolab' ),
				'settings' => 'ts_h4[font_style]',
				'section'  => 'h4_heading',
				'type'     => 'text',
			),
			'ts_h4_character_set' => array(
				'label'    => __( 'Character set', 'photolab' ),
				'settings' => 'ts_h4[character_set]',
				'section'  => 'h4_heading',
				'type'     => 'text',
			),
			'ts_h4_font_size' => array(
				'label'    => __( 'Font size', 'photolab' ),
				'settings' => 'ts_h4[font_size]',
				'section'  => 'h4_heading',
				'type'     => 'text',
			),
			'ts_h4_font_weight' => array(
				'label'    => __( 'Font weight', 'photolab' ),
				'settings' => 'ts_h4[font_weight]',
				'section'  => 'h4_heading',
				'type'     => 'text',
			),
			'ts_h4_line_height' => array(
				'label'    => __( 'Line height', 'photolab' ),
				'settings' => 'ts_h4[line_height]',
				'section'  => 'h4_heading',
				'type'     => 'text',
			),
			'ts_h4_letter_space' => array(
				'label'    => __( 'Letter space', 'photolab' ),
				'settings' => 'ts_h4[letter_space]',
				'section'  => 'h4_heading',
				'type'     => 'text',
			),
			'ts_h4_text_align' => array(
				'label'    => __( 'Text align', 'photolab' ),
				'settings' => 'ts_h4[text_align]',
				'section'  => 'h4_heading',
				'type'     => 'text',
			),
			'ts_h5_font_family' => array(
				'label'    => __( 'Font family', 'photolab' ),
				'settings' => 'ts_h5[font_family]',
				'section'  => 'h5_heading',
				'type'     => 'text',
			),
			'ts_h5_font_style' => array(
				'label'    => __( 'Font style', 'photolab' ),
				'settings' => 'ts_h5[font_style]',
				'section'  => 'h5_heading',
				'type'     => 'text',
			),
			'ts_h5_character_set' => array(
				'label'    => __( 'Character set', 'photolab' ),
				'settings' => 'ts_h5[character_set]',
				'section'  => 'h5_heading',
				'type'     => 'text',
			),
			'ts_h5_font_size' => array(
				'label'    => __( 'Font size', 'photolab' ),
				'settings' => 'ts_h5[font_size]',
				'section'  => 'h5_heading',
				'type'     => 'text',
			),
			'ts_h5_font_weight' => array(
				'label'    => __( 'Font weight', 'photolab' ),
				'settings' => 'ts_h5[font_weight]',
				'section'  => 'h5_heading',
				'type'     => 'text',
			),
			'ts_h5_line_height' => array(
				'label'    => __( 'Line height', 'photolab' ),
				'settings' => 'ts_h5[line_height]',
				'section'  => 'h5_heading',
				'type'     => 'text',
			),
			'ts_h5_letter_space' => array(
				'label'    => __( 'Letter space', 'photolab' ),
				'settings' => 'ts_h5[letter_space]',
				'section'  => 'h5_heading',
				'type'     => 'text',
			),
			'ts_h5_text_align' => array(
				'label'    => __( 'Text align', 'photolab' ),
				'settings' => 'ts_h5[text_align]',
				'section'  => 'h5_heading',
				'type'     => 'text',
			),
			'ts_h6_font_family' => array(
				'label'    => __( 'Font family', 'photolab' ),
				'settings' => 'ts_h6[font_family]',
				'section'  => 'h6_heading',
				'type'     => 'text',
			),
			'ts_h6_font_style' => array(
				'label'    => __( 'Font style', 'photolab' ),
				'settings' => 'ts_h6[font_style]',
				'section'  => 'h6_heading',
				'type'     => 'text',
			),
			'ts_h6_character_set' => array(
				'label'    => __( 'Character set', 'photolab' ),
				'settings' => 'ts_h6[character_set]',
				'section'  => 'h6_heading',
				'type'     => 'text',
			),
			'ts_h6_font_size' => array(
				'label'    => __( 'Font size', 'photolab' ),
				'settings' => 'ts_h6[font_size]',
				'section'  => 'h6_heading',
				'type'     => 'text',
			),
			'ts_h6_font_weight' => array(
				'label'    => __( 'Font weight', 'photolab' ),
				'settings' => 'ts_h6[font_weight]',
				'section'  => 'h6_heading',
				'type'     => 'text',
			),
			'ts_h6_line_height' => array(
				'label'    => __( 'Line height', 'photolab' ),
				'settings' => 'ts_h6[line_height]',
				'section'  => 'h6_heading',
				'type'     => 'text',
			),
			'ts_h6_letter_space' => array(
				'label'    => __( 'Letter space', 'photolab' ),
				'settings' => 'ts_h6[letter_space]',
				'section'  => 'h6_heading',
				'type'     => 'text',
			),
			'ts_h6_text_align' => array(
				'label'    => __( 'Text align', 'photolab' ),
				'settings' => 'ts_h6[text_align]',
				'section'  => 'h6_heading',
				'type'     => 'text',
			),
		);
	}
}

new Customizer;
