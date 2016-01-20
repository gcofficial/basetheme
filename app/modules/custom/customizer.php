<?php
/**
 * Customizer module file
 *
 * @package photolab
 */

namespace Modules\Custom;

use View;
use Utils;

/**
 * Customize class
 */
class Customizer {

	/**
	 * Customizer class construct
	 */
	public function __construct() {
		add_action( 'customize_preview_init', [ $this, 'preview_init' ] );
		add_action( 'customize_controls_enqueue_scripts', [ $this, 'scripts_and_styles' ] );
		add_action( 'customize_register', [ $this, 'register' ] );
	}

	/**
	 * Add postMessage support for site title and description for the Theme Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function preview_init( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}

	/**
	 * This function enqueues scripts and styles in the Customizer.
	 */
	public function scripts_and_styles() {
		wp_enqueue_script(
			'my-customizer-script',
			Utils::assets_url() . '/js/customizer.js',
			[ 'customize-controls' ]
		);
	}

	/**
	 * Sanitize image input
	 */
	public function sanitize_img( $input ) {
		return esc_url( $input );
	}

	/**
	 * Sanitize select input
	 */
	function sanitize_select( $input ) {
		return esc_attr( $input );
	}

	/**
	 * Sanitize content for allowed HTML tags for post content.
	 *
	 * @param type $input content.
	 * @return string sanitized content.
	 */
	public function sanitize_html( $input ) {
		return wp_kses_post( $input );
	}

	/**
	 * Front End Customizer
	 *
	 * @param  WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @return void
	 */
	public function register( $wp_customize ) {
		$wp_customize->add_setting(
			'photolab_header_slogan',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$wp_customize->add_control(
			'photolab_header_slogan',
			[
				'label'    => __( 'Header slogan text', 'photolab' ),
				'section'  => 'header_image',
				'settings' => 'photolab_header_slogan',
				'type'     => 'text',
				'priority' => 4,
			]
		);

		/* Socials section */
		$wp_customize->add_section(
			'social_settings',
			[
				'title'    => __( 'Socials Settings', 'photolab' ),
				'priority' => 40,
			]
		);

		/* Socials position */
		$wp_customize->add_setting(
			'social_settings[header]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => [ $this, 'sanitize_select' ],
			]
		);
		$wp_customize->add_setting(
			'social_settings[footer]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => [ $this, 'sanitize_select' ],
			]
		);
		$wp_customize->add_control(
			'social_settings_header',
			[
				'label'    => __( 'Show social links in header', 'photolab' ),
				'section'  => 'social_settings',
				'settings' => 'social_settings[header]',
				'type'     => 'checkbox',
			]
		);
		$wp_customize->add_control(
			'social_settings_footer',
			[
				'label'    => __( 'Show social links in footer', 'photolab' ),
				'section'  => 'social_settings',
				'settings' => 'social_settings[footer]',
				'type'     => 'checkbox',
			]
		);

		/* Social links */
		foreach ( \Social_Settings_Model::get_allowed() as $social_id => $social_data ) {
			$name  = $social_id . '_url';
			$label = isset( $social_data['label'] ) ? $social_data['label'] : false;

			$wp_customize->add_setting(
				'social_settings[' . $name . ']',
				[
					'default'           => '',
					'type'              => 'option',
					'sanitize_callback' => 'sanitize_text_field',
				]
			);
			$wp_customize->add_control(
				'photolab_' . $name ,
				[
					'label'    => sprintf( __( '%s url', 'photolab' ), $label ),
					'section'  => 'social_settings',
					'settings' => 'social_settings[' . $name . ']',
					'type'     => 'text',
				]
			);
		}

		$wp_customize->add_section(
			'photolab_message',
			[
				'title'    => __( 'Welcome Message', 'photolab' ),
				'priority' => 50,
			]
		);

		/* welcome label */
		$wp_customize->add_setting(
			'photolab[welcome_label]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'photolab_welcome_label',
			[
				'label'    => __( 'Welcome message label', 'photolab' ),
				'section'  => 'photolab_message',
				'settings' => 'photolab[welcome_label]',
				'type'     => 'text',
				'priority' => 4,
			]
		);

		/* welcome image */
		$wp_customize->add_setting(
			'photolab[welcome_img]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => [ $this, 'sanitize_img' ],
			]
		);
		$wp_customize->add_control(
			new \WP_Customize_Image_Control(
				$wp_customize,
				'welcome_img',
				[
					'label'    => __( 'Welcome message image', 'photolab' ),
					'section'  => 'photolab_message',
					'settings' => 'photolab[welcome_img]',
					'priority' => 5,
				]
			)
		);

		/* welcome title */
		$wp_customize->add_setting(
			'photolab[welcome_title]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$wp_customize->add_control(
			'photolab_welcome_title',
			[
				'label'    => __( 'Welcome message title', 'photolab' ),
				'section'  => 'photolab_message',
				'settings' => 'photolab[welcome_title]',
				'type'     => 'text',
				'priority' => 6,
			]
		);

		/* welcome title */
		$wp_customize->add_setting(
			'photolab[welcome_message]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$wp_customize->add_control(
			'photolab_welcome_message',
			[
				'label'    => __( 'Welcome message text', 'photolab' ),
				'section'  => 'photolab_message',
				'settings' => 'photolab[welcome_message]',
				'type'     => 'text',
				'priority' => 7,
			]
		);

		/**
		 * Misc section
		 */
		$wp_customize->add_section(
			'photolab_misc',
			[
				'title'    => __( 'Misc', 'photolab' ),
				'priority' => 200,
			]
		);

		/* featured post label */
		$wp_customize->add_setting(
			'misc[featured_label]',
			[
				'default'           => __( 'Featured', 'photolab' ),
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'photolab_featured_label',
			[
				'label'    => __( 'Featured Post Label', 'photolab' ),
				'section'  => 'photolab_misc',
				'settings' => 'misc[featured_label]',
				'type'     => 'text',
				'priority' => 6,
			]
		);

		/* blog posts label */
		$wp_customize->add_setting(
			'misc[blog_label]',
			[
				'default'           => __( 'My Blog', 'photolab' ),
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$wp_customize->add_control(
			'photolab_blog_label',
			[
				'label'    => __( 'Blog Label', 'photolab' ),
				'section'  => 'photolab_misc',
				'settings' => 'misc[blog_label]',
				'type'     => 'text',
				'priority' => 7,
			]
		);

		/* blog posts label */
		$wp_customize->add_setting(
			'misc[blog_content]',
			[
				'default'           => 'excerpt',
				'type'              => 'option',
				'sanitize_callback' => [ $this, 'sanitize_select' ],
			]
		);
		$wp_customize->add_control(
			'photolab_blog_content',
			[
				'label'    => __( 'Post content on blog page', 'photolab' ),
				'section'  => 'photolab_misc',
				'settings' => 'misc[blog_content]',
				'type'     => 'select',
				'choices'  => [
					'excerpt' => __( 'Only Excerpt', 'photolab' ),
					'full'    => __( 'Full Content', 'photolab' ),
				],
				'priority' => 8,
			]
		);

		/* featured image */
		$wp_customize->add_setting(
			'misc[blog_image]',
			[
				'default'           => 'post-thumbnail',
				'type'              => 'option',
				'sanitize_callback' => [ $this, 'sanitize_select' ],
			]
		);
		$wp_customize->add_control(
			'photolab_blog_image',
			[
				'label'    => __( 'Featured image on blog page', 'photolab' ),
				'section'  => 'photolab_misc',
				'settings' => 'misc[blog_image]',
				'type'     => 'select',
				'choices'  => [
					'post-thumbnail'      => __( 'Small', 'photolab' ),
					'fullwidth-thumbnail' => __( 'Fullwidth', 'photolab' ),
				],
				'priority' => 9,
			]
		);

		/* blog read more button text */
		$wp_customize->add_setting(
			'misc[blog_btn]',
			[
				'default'           => __( 'Read More', 'photolab' ),
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$wp_customize->add_control(
			'photolab_blog_btn',
			[
				'label'    => __( 'Blog "Read More" button text', 'photolab' ),
				'section'  => 'photolab_misc',
				'settings' => 'misc[blog_btn]',
				'type'     => 'select',
				'type'     => 'text',
				'priority' => 10,
			]
		);

		/**
		 * Sidebars
		 */
		$wp_customize->add_section(
			'photolab_sidebars',
			[
				'title'    => __( 'Sidebar Settings', 'photolab' ),
				'priority' => 40,
			]
		);

		$wp_customize->add_setting(
			'sidebar_settings[mode_left]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => [ $this, 'sanitize_select' ],
			]
		);

		$wp_customize->add_control(
			'sidebar_settings_mode_left',
			[
				'label'    => __( 'Show sidebar on left side', 'photolab' ),
				'section'  => 'photolab_sidebars',
				'settings' => 'sidebar_settings[mode_left]',
				'type'     => 'checkbox',
			]
		);

		$wp_customize->add_setting(
			'sidebar_settings[mode_right]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => [ $this, 'sanitize_select' ],
			]
		);

		$wp_customize->add_control(
			'sidebar_settings_mode_right',
			[
				'label'    => __( 'Show sidebar on right side', 'photolab' ),
				'section'  => 'photolab_sidebars',
				'settings' => 'sidebar_settings[mode_right]',
				'type'     => 'checkbox',
			]
		);

		$wp_customize->add_setting(
			'sidebar_settings[sidebars]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			new \Modules\Custom\Sidebar_Creator(
				$wp_customize,
				'sidebar_settings_sidebar',
				[
					'label'    => __( 'Custom sidebars', 'photolab' ),
					'section'  => 'photolab_sidebars',
					'settings' => 'sidebar_settings[sidebars]',
				]
			)
		);

		// ==============================================================
		// Header settings
		// ==============================================================
		$wp_customize->get_section( 'header_image' )->title = __( 'Header Settings', 'photolab' );

		$wp_customize->get_control( 'background_image' )->section = 'header_image';

		$wp_customize->add_setting(
			'header_settings[stickup_menu]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'stickup_menu',
			[
				'label'    => __( 'Enable/Disable stickup menu', 'photolab' ),
				'section'  => 'header_image',
				'settings' => 'header_settings[stickup_menu]',
				'type'     => 'checkbox',
				'std'      => '1',
			]
		);

		$wp_customize->add_setting(
			'header_settings[title_attributes]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'title_attributes',
			[
				'label'    => __( 'Enable/Disable title attributes', 'photolab' ),
				'section'  => 'header_image',
				'settings' => 'header_settings[title_attributes]',
				'type'     => 'checkbox',
				'std'      => '1',
			]
		);

		/* Show titel on header image */
		$wp_customize->add_setting(
			'header_settings[show_title_on_header]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$wp_customize->add_control(
			'show_title_on_header',
			[
				'label'    => __( 'Show title on header image?', 'photolab' ),
				'section'  => 'header_image',
				'settings' => 'header_settings[show_title_on_header]',
				'type'     => 'checkbox',
				'priority' => 4,
				'std'	   => '1',
			]
		);

		$wp_customize->add_setting(
			'header_settings[search_box]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'search_box',
			[
				'label'    => __( 'Enable/Disable search box', 'photolab' ),
				'section'  => 'header_image',
				'settings' => 'header_settings[search_box]',
				'type'     => 'checkbox',
				'std'    => '1',
			]
		);

		$wp_customize->add_setting(
			'header_settings[disclimer_text]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => [ $this, 'sanitize_html' ],
			]
		);

		$wp_customize->add_control(
			'disclimer_text',
			[
				'label'    => __( 'Disclaimer text', 'photolab' ),
				'section'  => 'header_image',
				'settings' => 'header_settings[disclimer_text]',
				'type'     => 'textarea',
			]
		);

		$wp_customize->add_setting(
			'header_settings[header_style]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'header_style',
			[
				'label'    => __( 'Header style', 'photolab' ),
				'section'  => 'header_image',
				'settings' => 'header_settings[header_style]',
				'type'     => 'select',
				'choices'  => [
					'default'  => __( 'Default', 'photolab' ),
					'minimal'  => __( 'Minimal', 'photolab' ),
					'centered' => __( 'Centered', 'photolab' ),
				],
			]
		);

		// ==============================================================
		// General Site Settings
		// ==============================================================
		$wp_customize->add_section(
			'general_site_settings',
			[
				'title'    => __( 'General Site Settings', 'photolab' ),
				'priority' => 10,
			]
		);

		$wp_customize->get_control( 'background_color' )->section = 'general_site_settings';

		$wp_customize->add_setting(
			'gss[color_scheme]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'color_scheme',
				[
					'label'      => __( 'Color Scheme', 'photolab' ),
					'section'    => 'general_site_settings',
					'settings'   => 'gss[color_scheme]',
				]
			)
		);

		$wp_customize->add_control(
			'blogname',
			[
				'label'      => __( 'Site Title', 'photolab' ),
				'section'    => 'general_site_settings',
			]
		);

		$wp_customize->add_control(
			'blogdescription',
			[
				'label'      => __( 'Tagline', 'photolab' ),
				'section'    => 'general_site_settings',
			]
		);

		$wp_customize->add_setting(
			'gss[favicon]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => [ $this, 'sanitize_img' ],
			]
		);

		$wp_customize->add_control(
			new \WP_Customize_Image_Control(
				$wp_customize,
				'favicon',
				[
					'label'      => __( 'Upload a favicon', 'photolab' ),
					'section'    => 'general_site_settings',
					'settings'   => 'gss[favicon]',
				]
			)
		);

		$wp_customize->add_setting(
			'gss[touch_icon]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => [ $this, 'sanitize_img' ],
			]
		);

		$wp_customize->add_control(
			new \WP_Customize_Image_Control(
				$wp_customize,
				'touch_icon',
				[
					'label'      => __( 'Upload a touch icon (57x57)', 'photolab' ),
					'section'    => 'general_site_settings',
					'settings'   => 'gss[touch_icon]',
				]
			)
		);

		$wp_customize->add_setting(
			'gss[logo]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => [ $this, 'sanitize_img' ],
			]
		);

		$wp_customize->add_control(
			new \WP_Customize_Image_Control(
				$wp_customize,
				'logo',
				[
					'label'      => __( 'Upload a logo', 'photolab' ),
					'section'    => 'general_site_settings',
					'settings'   => 'gss[logo]',
				]
			)
		);

		$wp_customize->add_setting(
			'gss[page_preloader]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => [ $this, 'sanitize_select' ],
			]
		);

		$wp_customize->add_control(
			'page_preloader',
			[
				'label'    => __( 'Enable/Disable page preloader', 'photolab' ),
				'section'  => 'general_site_settings',
				'settings' => 'gss[page_preloader]',
				'type'     => 'checkbox',
			]
		);

		$wp_customize->add_setting(
			'gss[retina_optimisation]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => [ $this, 'sanitize_select' ],
			]
		);

		$wp_customize->add_control(
			'retina_optimisation',
			[
				'label'    => __( 'Enable/Disable retina optimisation', 'photolab' ),
				'section'  => 'general_site_settings',
				'settings' => 'gss[retina_optimisation]',
				'type'     => 'checkbox',
			]
		);

		$wp_customize->add_setting(
			'gss[breadcrumbs]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => [ $this, 'sanitize_select' ],
			]
		);

		$wp_customize->add_control(
			'breadcrumbs',
			[
				'label'    => __( 'Enable/Disable Breadcrumbs', 'photolab' ),
				'section'  => 'general_site_settings',
				'settings' => 'gss[breadcrumbs]',
				'type'     => 'checkbox',
			]
		);

		// ==============================================================
		// Footer Settings
		// ==============================================================
		$wp_customize->add_section(
			'footer_settings',
			[
				'title'    => __( 'Footer Settings', 'photolab' ),
				'priority' => 100,
			]
		);

		$wp_customize->add_setting(
			'fs[footer_style]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'footer_style',
			[
				'label'    => __( 'Style', 'photolab' ),
				'section'  => 'footer_settings',
				'settings' => 'fs[footer_style]',
				'type'     => 'select',
				'choices'  => [
					'default'  => __( 'Default', 'photolab' ),
					'minimal'  => __( 'Minimal', 'photolab' ),
					'centered' => __( 'Centered', 'photolab' ),
				],
			]
		);

		$wp_customize->add_setting(
			'fs[copyright]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'copyright',
			[
				'label'    => __( 'Copyright text', 'photolab' ),
				'section'  => 'footer_settings',
				'settings' => 'fs[copyright]',
				'type'     => 'text',
			]
		);

		$wp_customize->add_setting(
			'fs[columns]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'footer_columns',
			[
				'label'       => __( 'Columns number', 'photolab' ),
				'section'     => 'footer_settings',
				'settings'    => 'fs[columns]',
				'type'        => 'select',
				'choices'     => [
					'2' => 2,
					'3' => 3,
					'4' => 4,
				],
			]
		);

		$wp_customize->add_setting(
			'fs[logo]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => [ $this, 'sanitize_img' ],
			]
		);

		$wp_customize->add_control(
			new \WP_Customize_Image_Control(
				$wp_customize,
				'footer_logo',
				[
					'label'      => __( 'Upload a footer logo', 'photolab' ),
					'section'    => 'footer_settings',
					'settings'   => 'fs[logo]',
				]
			)
		);

		// ==============================================================
		// Remove some sections
		// ==============================================================
		$wp_customize->remove_section( 'title_tagline' );
		$wp_customize->remove_section( 'background_image' );
		$wp_customize->remove_section( 'static_front_page' );
		$wp_customize->remove_section( 'colors' );

		// ==============================================================
		// Blog settings
		// ==============================================================
		$wp_customize->add_section(
			'blog_settings',
			[
				'title'    => __( 'Blog Settings', 'photolab' ),
				'priority' => 100,
			]
		);

		$wp_customize->get_control( 'show_on_front' )->section = 'blog_settings';

		$wp_customize->add_setting(
			'bs[layout_style]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'layout_style',
			[
				'label'       => __( 'Layout style', 'photolab' ),
				'section'     => 'blog_settings',
				'settings'    => 'bs[layout_style]',
				'type'        => 'select',
				'description' => __( 'If you select a non-default double sidebar will be disabled', 'photolab' ),
				'choices'     => [
					'default' => __( 'Default', 'photolab' ),
					'grid'    => __( 'Grid', 'photolab' ),
					'masonry' => __( 'Masonry', 'photolab' ),
				],
			]
		);

		$wp_customize->add_setting(
			'bs[columns]',
			[
				'default'           => '2',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			]
		);

		$wp_customize->add_control(
			'columns',
			[
				'label'       => __( 'Columns', 'photolab' ),
				'section'     => 'blog_settings',
				'settings'    => 'bs[columns]',
				'type'        => 'select',
				'choices'     => [
					'2' => __( '2', 'photolab' ),
					'3' => __( '3', 'photolab' ),
				],
			]
		);

		// ==============================================================
		// Typography settings
		// ==============================================================
		$wp_customize->add_setting(
			'typography[color_text]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'text_color',
				[
					'label'      => __( 'Text Color', 'photolab' ),
					'section'    => 'typography_settings',
					'settings'   => 'typography[color_text]',
				]
			)
		);

		$wp_customize->add_setting(
			'typography[color_h1]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'color_h1',
				[
					'label'      => __( 'Color h1', 'photolab' ),
					'section'    => 'typography_settings',
					'settings'   => 'typography[color_h1]',
				]
			)
		);

		$wp_customize->add_setting(
			'typography[color_h2]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'color_h2',
				[
					'label'      => __( 'Color h2', 'photolab' ),
					'section'    => 'typography_settings',
					'settings'   => 'typography[color_h2]',
				]
			)
		);

		$wp_customize->add_setting(
			'typography[color_h3]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'color_h3',
				[
					'label'      => __( 'Color h3', 'photolab' ),
					'section'    => 'typography_settings',
					'settings'   => 'typography[color_h3]',
				]
			)
		);

		$wp_customize->add_setting(
			'typography[color_h4]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'color_h4',
				[
					'label'      => __( 'Color h4', 'photolab' ),
					'section'    => 'typography_settings',
					'settings'   => 'typography[color_h4]',
				]
			)
		);

		$wp_customize->add_setting(
			'typography[color_h5]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'color_h5',
				[
					'label'      => __( 'Color h5', 'photolab' ),
					'section'    => 'typography_settings',
					'settings'   => 'typography[color_h5]',
				]
			)
		);

		$wp_customize->add_setting(
			'typography[color_h6]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'color_h6',
				[
					'label'      => __( 'Color h6', 'photolab' ),
					'section'    => 'typography_settings',
					'settings'   => 'typography[color_h6]',
				]
			)
		);
		$wp_customize->add_section(
			'typography_settings',
			[
				'title'    => __( 'Typography settings', 'photolab' ),
				'priority' => 100,
			]
		);

		$wp_customize->add_setting(
			'typography[base_font_family]',
			[
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'typography_base_font_family',
			[
				'label'       => __( 'Base font family', 'photolab' ),
				'section'     => 'typography_settings',
				'settings'    => 'typography[base_font_family]',
				'type'        => 'select',
				'choices'     => \Typography_Settings_Model::getFontsOption(),
			]
		);
	}
}

new Customizer;
