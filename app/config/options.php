<?php
/**
 * Customizer options config file
 * List structure:
 * PANEL -> SECTION -> CONROLS
 *
 * @package photolab
 */
return array(
	'general_site_settings' => array(
		'title'       => __( 'General site settings', 'photolab' ),
		'description' => __( 'This is general site settings.', 'photolab' ),
		'__SECTIONS__'    => array(

			// Site title & Tagline SECTION
			'site_title_and_tageline' => array(
				'title'       => __( 'Site title & Tagline', 'photolab' ),
				'description' => __( 'This is a Site Title & Tagline section.', 'photolab' ),
				'__SETTINGS__'    => array(
					'blogname' => array( 'default' => get_option( 'blogname' ) ),
					'blogdescription' => array( 'default' => get_option( 'blogdescription' ) ),
				),
				'__CONTROLS__'    => array(
					'blogname' => array( 'label' => __( 'Site Title' ) ),
					'blogdescription' => array( 'label' => __( 'Tagline' ) ),
				),
			),

			// Logo & Favicon SECTION
			'logo_and_favicon' => array(
				'title' => __( 'Logo & Favicon', 'photolab' ),
				'__CONTROLS__' => array(
					'logo' => array(
						'label'     => __( 'Upload a logo', 'photolab' ),
						'__CLASS__' => 'WP_Customize_Image_Control',
					),
					'favicon' => array(
						'label'     => __( 'Upload a favicon', 'photolab' ),
						'__CLASS__' => 'WP_Customize_Image_Control',
					),
					'enable_retina' => array(
						'label' => __( 'Enable / Disable retina optimisation', 'photolab' ),
						'type'  => 'checkbox',
					),
					'show_preloader' => array(
						'label' => __( 'Enable / Disable page preloader', 'photolab' ),
						'type'  => 'checkbox',
					),
				),
			),

			// Breadcrumbs SECTION
			'breadcrumbs' => array(
				'title' => __( 'Breadcrumbs', 'photolab' ),
				'__CONTROLS__' => array(
					'show_page_title' => array(
						'label'    => __( 'Enable / Disable page title in breadcrumbs area', 'photolab' ),
						'type'     => 'checkbox',
					),
					'show_breadcrubs' => array(
						'label'    => __( 'Enable / Disable breadcrumbs', 'photolab' ),
						'type'     => 'checkbox',
					),
					'full_minifide' => array(
						'label'    => __( 'Show full / Minified breadcrumbs path', 'photolab' ),
						'type'     => 'checkbox',
					),
				),
			),

			// Social links SECTION
			'social_links' => array(
				'title' => __( 'Social links', 'photolab' ),
				'__CONTROLS__' => array(
					'show_in_header' => array(
						'label' => __( 'Show social links in header', 'photolab' ),
						'type'  => 'checkbox',
					),
					'show_in_footer' => array(
						'label' => __( 'Show social links in footer', 'photolab' ),
						'type'  => 'checkbox',
					),
					'show_in_posts' => array(
						'label' => __( 'Add social sharing to blog posts', 'photolab' ),
						'type'  => 'checkbox',
					),
					'show_in_post' => array(
						'label' => __( 'Add social sharing to single blog post', 'photolab' ),
						'type'  => 'checkbox',
					),
					'rss_feed' => array( 'label' => __( 'RSS Feed link', 'photolab' ) ),
					'facebook' => array( 'label' => __( 'Facebook URL', 'photolab' ) ),
					'twitter' => array( 'label' => __( 'Twitter URL', 'photolab' ) ),
					'google_plus' => array( 'label' => __( 'Google+ URL', 'photolab' ) ),
					'instagram' => array( 'label' => __( 'Instagram URL', 'photolab' ) ),
					'linked_in' => array( 'label' => __( 'LinkedIn URL', 'photolab' ) ),
					'dribble' => array( 'label' => __( 'Dribble URL', 'photolab' ) ),
					'youtube' => array( 'label' => __( 'Youtube URL', 'photolab' ) ),
				),
			),

			// Page layout settings SECTION
			'page_layout_settings' => array(
				'title' => __( 'Page layout settings', 'photolab' ),
				'__CONTROLS__' => array(
					'layout' => array(
						'label'    => __( 'Layout style', 'photolab' ),
						'type'     => 'select',
						'choices'  => array(
							'boxed' => __( 'Boxed', 'photolab' ),
							'full'  => __( 'Full width', 'photolab' ),
						),
					),
					'width' => array( 'label' => __( 'Container width', 'photolab' ) ),
					'sidebar_width'  => array(
						'label'    => __( 'Sidebar width', 'photolab' ),
						'type'     => 'select',
						'choices'  => array(
							'1__3' => '⅓',
							'1__4' => '¼',
						),
					),
				),
			),
		),
	),
	'color_scheme' => array(
		'title'       => __( 'Color scheme', 'photolab' ),
		'description' => '',
		'__SECTIONS__'    => array(

			// Regular SECTION
			'regular' => array(
				'title' => __( 'Regular', 'photolab' ),
				'__CONTROLS__' => array(
					'accent'     => array( 'label' => __( 'Accent', 'photolab' ) ),
					'text'       => array( 'label' => __( 'Text', 'photolab' ) ),
					'link_hover' => array( 'label' => __( 'Link hover', 'photolab' ) ),
					'heading'    => array( 'label' => __( 'Heading ( H1 - H6 )', 'photolab' ) ),
				),
			),

			// Invert SECTION
			'invert' => array(
				'title' => __( 'Invert', 'photolab' ),
				'__CONTROLS__' => array(
					'accent'     => array( 'label' => __( 'Accent', 'photolab' ) ),
					'text'       => array( 'label' => __( 'Text', 'photolab' ) ),
					'link_hover' => array( 'label' => __( 'Link hover', 'photolab' ) ),
					'heading'    => array( 'label' => __( 'Heading ( H1 - H6 )', 'photolab' ) ),
				),
			),
		),
	),
	'typography_settings' => array(
		'title'       => __( 'Typography settings', 'photolab' ),
		'description' => '',
		'__SECTIONS__'    => array(
			'body_text' => array(
				'title' => __( 'Body text', 'photolab' ),
				'__CONTROLS__' => array(
					'font_family'   => array( 'label' => __( 'Font family', 'photolab' ) ),
					'font_style'    => array( 'label' => __( 'Font style', 'photolab' ) ),
					'character_set' => array( 'label' => __( 'Character set', 'photolab' ) ),
					'font_size'     => array( 'label' => __( 'Font size', 'photolab' ) ),
					'font_weight'   => array( 'label' => __( 'Font weight', 'photolab' ) ),
					'line_height'   => array( 'label' => __( 'Line height', 'photolab' ) ),
					'letter_space'  => array( 'label' => __( 'Letter space', 'photolab' ) ),
					'text_align'    => array( 'label' => __( 'Text align', 'photolab' ) ),
				),
			),
			'breadcrumbs_typography' => array(
				'title' => __( 'Breadcrumbs typography', 'photolab' ),
				'__CONTROLS__' => array(
					'font_family'   => array( 'label' => __( 'Font family', 'photolab' ) ),
					'font_style'    => array( 'label' => __( 'Font style', 'photolab' ) ),
					'character_set' => array( 'label' => __( 'Character set', 'photolab' ) ),
					'font_size'     => array( 'label' => __( 'Font size', 'photolab' ) ),
					'font_weight'   => array( 'label' => __( 'Font weight', 'photolab' ) ),
					'line_height'   => array( 'label' => __( 'Line height', 'photolab' ) ),
					'letter_space'  => array( 'label' => __( 'Letter space', 'photolab' ) ),
					'text_align'    => array( 'label' => __( 'Text align', 'photolab' ) ),
				),
			),
			'h1_heading' => array(
				'title' => __( 'H1 heading', 'photolab' ),
				'__CONTROLS__' => array(
					'font_family'   => array( 'label' => __( 'Font family', 'photolab' ) ),
					'font_style'    => array( 'label' => __( 'Font style', 'photolab' ) ),
					'character_set' => array( 'label' => __( 'Character set', 'photolab' ) ),
					'font_size'     => array( 'label' => __( 'Font size', 'photolab' ) ),
					'font_weight'   => array( 'label' => __( 'Font weight', 'photolab' ) ),
					'line_height'   => array( 'label' => __( 'Line height', 'photolab' ) ),
					'letter_space'  => array( 'label' => __( 'Letter space', 'photolab' ) ),
					'text_align'    => array( 'label' => __( 'Text align', 'photolab' ) ),
				),
			),
			'h2_heading' => array(
				'title' => __( 'H2 heading', 'photolab' ),
				'__CONTROLS__' => array(
					'font_family'   => array( 'label' => __( 'Font family', 'photolab' ) ),
					'font_style'    => array( 'label' => __( 'Font style', 'photolab' ) ),
					'character_set' => array( 'label' => __( 'Character set', 'photolab' ) ),
					'font_size'     => array( 'label' => __( 'Font size', 'photolab' ) ),
					'font_weight'   => array( 'label' => __( 'Font weight', 'photolab' ) ),
					'line_height'   => array( 'label' => __( 'Line height', 'photolab' ) ),
					'letter_space'  => array( 'label' => __( 'Letter space', 'photolab' ) ),
					'text_align'    => array( 'label' => __( 'Text align', 'photolab' ) ),
				),
			),
			'h3_heading' => array(
				'title' => __( 'H3 heading', 'photolab' ),
				'__CONTROLS__' => array(
					'font_family'   => array( 'label' => __( 'Font family', 'photolab' ) ),
					'font_style'    => array( 'label' => __( 'Font style', 'photolab' ) ),
					'character_set' => array( 'label' => __( 'Character set', 'photolab' ) ),
					'font_size'     => array( 'label' => __( 'Font size', 'photolab' ) ),
					'font_weight'   => array( 'label' => __( 'Font weight', 'photolab' ) ),
					'line_height'   => array( 'label' => __( 'Line height', 'photolab' ) ),
					'letter_space'  => array( 'label' => __( 'Letter space', 'photolab' ) ),
					'text_align'    => array( 'label' => __( 'Text align', 'photolab' ) ),
				),
			),
			'h4_heading' => array(
				'title' => __( 'H4 heading', 'photolab' ),
				'__CONTROLS__' => array(
					'font_family'   => array( 'label' => __( 'Font family', 'photolab' ) ),
					'font_style'    => array( 'label' => __( 'Font style', 'photolab' ) ),
					'character_set' => array( 'label' => __( 'Character set', 'photolab' ) ),
					'font_size'     => array( 'label' => __( 'Font size', 'photolab' ) ),
					'font_weight'   => array( 'label' => __( 'Font weight', 'photolab' ) ),
					'line_height'   => array( 'label' => __( 'Line height', 'photolab' ) ),
					'letter_space'  => array( 'label' => __( 'Letter space', 'photolab' ) ),
					'text_align'    => array( 'label' => __( 'Text align', 'photolab' ) ),
				),
			),
			'h5_heading' => array(
				'title' => __( 'H5 heading', 'photolab' ),
				'__CONTROLS__' => array(
					'font_family'   => array( 'label' => __( 'Font family', 'photolab' ) ),
					'font_style'    => array( 'label' => __( 'Font style', 'photolab' ) ),
					'character_set' => array( 'label' => __( 'Character set', 'photolab' ) ),
					'font_size'     => array( 'label' => __( 'Font size', 'photolab' ) ),
					'font_weight'   => array( 'label' => __( 'Font weight', 'photolab' ) ),
					'line_height'   => array( 'label' => __( 'Line height', 'photolab' ) ),
					'letter_space'  => array( 'label' => __( 'Letter space', 'photolab' ) ),
					'text_align'    => array( 'label' => __( 'Text align', 'photolab' ) ),
				),
			),
			'h6_heading' => array(
				'title' => __( 'H6 heading', 'photolab' ),
				'__CONTROLS__' => array(
					'font_family'   => array( 'label' => __( 'Font family', 'photolab' ) ),
					'font_style'    => array( 'label' => __( 'Font style', 'photolab' ) ),
					'character_set' => array( 'label' => __( 'Character set', 'photolab' ) ),
					'font_size'     => array( 'label' => __( 'Font size', 'photolab' ) ),
					'font_weight'   => array( 'label' => __( 'Font weight', 'photolab' ) ),
					'line_height'   => array( 'label' => __( 'Line height', 'photolab' ) ),
					'letter_space'  => array( 'label' => __( 'Letter space', 'photolab' ) ),
					'text_align'    => array( 'label' => __( 'Text align', 'photolab' ) ),
				),
			),
		),
	),
	'header_settings' => array(
		'title'       => __( 'Header settings', 'photolab' ),
		'description' => __( 'This is header settings panel.', 'photolab' ),
		'__SECTIONS__'    => array(
			'header_styles' => array(
				'title' => __( 'Header styles', 'photolab' ),
				'__CONTROLS__' => array(
					'image_position' => array( 'label' => __( 'Image position', 'photolab' ) ),
					'image_repeat' => array( 'label' => __( 'Image repeat', 'photolab' ) ),
					'background_scroll' => array( 'label' => __( 'Background scroll', 'photolab' ) ),
					'background_color' => array( 'label' => __( 'Background color', 'photolab' ) ),
					'header_layout' => array(
						'label' => __( 'Header layout', 'photolab' ),
						'type'  => 'select',
						'choices' => array(
							'Default',
							'Minimal',
							'Centered',
						),
					),
				),
			),
			'top_panel_settings' => array(
				'title' => __( 'Top panel settings', 'photolab' ),
				'__CONTROLS__' => array(
					'background_color' => array( 'label' => __( 'Background color', 'photolab' ) ),
					'disclaimer_text' => array(
						'label' => __( 'Disclaimer text', 'photolab' ),
						'type'  => 'textarea',
					),
					'show_search' => array(
						'label' => __( 'Show search block', 'photolab' ),
						'type'  => 'checkbox',
					),
				),
			),
			'main_menu_settings' => array(
				'title' => __( 'Main menu settings', 'photolab' ),
				'__CONTROLS__' => array(
					'on_off_sticky_menu' => array(
						'label' => __( 'Enable / Disable sticky menu', 'photolab' ),
						'type'  => 'checkbox',
					),
					'on_off_title_attribute' => array(
						'label' => __( 'Enable / Disable title attributes', 'photolab' ),
						'type'  => 'checkbox',
					),
				),
			),
		),
	),
	'__WITHOUT_PANEL__' => array(
		'sidebar_settings' => array(
			'title' => __( 'Sidebar settings', 'photolab' ),
			'__CONTROLS__' => array(
				'add_widget_area' => array(
					'label' => __( 'Add widget area', 'photolab' ),
					'__CLASS__' => 'Sidebar_Creator',
				),
				'show_left' => array(
					'label' => __( 'Show / Hide on left side', 'photolab' ),
					'type'  => 'checkbox',
				),
				'show_right' => array(
					'label' => __( 'Show / Hide on right side', 'photolab' ),
					'type'  => 'checkbox',
				),
			),
		),
		'footer_settings' => array(
			'title' => __( 'Footer settings', 'photolab' ),
			'__CONTROLS__' => array(
				'logo' => array(
					'label'     => __( 'Upload a footer logo', 'photolab' ),
					'__CLASS__' => 'WP_Customize_Image_Control',
				),
				'copyright_text' => array(
					'label' => __( 'Copyright text', 'photolab' ),
					'type'  => 'textarea',
				),
				'widget_area_columns' => array(
					'label' => __( 'Widget area columns', 'photolab' ),
					'type'  => 'select',
					'choices' => array(
						'2',
						'3',
						'4',
					),
				),
				'layout' => array(
					'label' => __( 'Layout', 'photolab' ),
					'type'  => 'select',
					'choices' => array(
						'central' => 'Central',
						'minimal' => 'Minimal',
						'default' => 'Default',
					),
				),
				'widget_area_bg_color' => array( 'label' => __( 'Widget area BG color', 'photolab' ) ),
				'bg_color' => array( 'label' => __( 'BG color', 'photolab' ) ),
			),
		),
		'blog_settings' => array(
			'title' => __( 'Blog settings', 'photolab' ),
			'__CONTROLS__' => array(
				'layout' => array(
					'label' => __( 'Layout', 'photolab' ),
					'type'  => 'select',
					'choices' => array(
						'default' => 'Default',
						'grid'    => 'Grid',
						'masonry' => 'Masonry',
					),
				),
				'exclude_categories_from_blog' => array( 'label' => __( 'Exclude categories from blog', 'photolab' ) ),
				'blog_label' => array( 'label' => __( 'Blog label', 'photolab' ) ),
				'read_more_button_text' => array( 'label' => __( 'Read more button text', 'photolab' ) ),
				'hide_additional_info_in_single' => array(
					'label' => __( 'Hide additional info ( post author, publish date, category, tags) in single post', 'photolab' ),
					'type' => 'checkbox',
				),
				'hide_additional_info_in_loop' => array(
					'label' => __( 'Hide additional info ( post author, publish date, category, tags) in loop posts', 'photolab' ),
					'type' => 'checkbox',
				),
				'on_off_author_block' => array(
					'label' => __( 'Enable / Disable the author block after each post', 'photolab' ),
					'type' => 'checkbox',
				),
			),
		),
		'misc' => array(
			'title' => __( 'Misc', 'photolab' ),
			'__CONTROLS__' => array(
				'featured_post_label' => array( 'label' => __( 'Featured post label', 'photolab' ) ),
				'post_content_on_blog_page' => array(
					'label' => __( 'Post content on blog page', 'photolab' ),
					'type'  => 'select',
					'choices' => array(
						'only_excerpt' => 'Only excerpt',
						'full_content' => 'Full content',
					),
				),
				'featured_image_on_blog_page' => array(
					'label' => __( 'Featured image on blog page', 'photolab' ),
					'type'  => 'select',
					'choices' => array(
						'only_excerpt' => 'Small',
						'full_width' => 'Full width',
					),
				),
				'export' => array(
					'label' => __( 'Featured post label', 'photolab' ),
					'typ'   => 'button',
				),
			),
		),
	),
);
