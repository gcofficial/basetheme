<?php

Use \View\View;
Use \Core\Utils;

class MainModel{

	/**
	 * Main data for view
	 * 
	 * @return array
	 */
	public static function main()
	{
		return [
			'TDU'               => get_template_directory_uri(),
			'search_form'       => View::make('blocks/search_form'),
			'sidebar_side_type' => SidebarSettingsModel::get_sidebar_side_type(),
			'wp_query'          => Utils::array_get($GLOBALS, 'wp_query', null),
			'post'              => Utils::array_get($GLOBALS, 'post', null),
			'blog_layout_style' => BlogSettingsModel::getLayoutStyle(),
			'blog_content'      => MiscModel::getBlogContent(),
			'read_more_button'  => MiscModel::getBlogButton(),
			'columns_count'     => BlogSettingsModel::getColumns(),
			'column_css_class'  => BlogSettingsModel::getColumnCSSClass(),
			'category_list'     => get_the_category_list( __( ', ', 'photolab' ) ),
			'tag_list'          => get_the_tag_list( '', __( ', ', 'photolab' ) ),
			'archive_list'      => wp_get_archives( array( 'type' => 'monthly', 'echo' => false ) ),
			'wp_register'  		=> wp_register('<li>', '</li>', false),
			'wp_loginout'  		=> wp_loginout('', false),
			'wp_meta'      		=> Utils::echoToVar(function(){ wp_meta(); }),
			'is_show_title_on_header' => HeaderSettingsModel::is_show_title_on_header(),
		];
	}

	/**
	 * Get header
	 * @return string HTML code header
	 */
	public static function header()
	{
		return \View\View::make( 'sections/header', MainModel::header_data() );
	}

	/**
	 * Header data for header section
	 * 
	 * @return array
	 */
	public static function header_data()
	{
		$header = [
			'allowedtags'          => $GLOBALS['allowedtags'],
			'language_attributes'  => get_language_attributes(),
			'body_class'           => implode(' ', get_body_class()),
			'charset'              => get_bloginfo( 'charset' ),
			'ping_back_url'        => get_bloginfo( 'pingback_url' ),
			'name'                 => get_bloginfo( 'name' ),
			'home_url'    		   => esc_url( home_url( '/' ) ),
			'description' 		   => get_bloginfo( 'description' ),
			'favicon'              => GeneralSiteSettingsModel::getFavicon(),
			'touch_icon'           => GeneralSiteSettingsModel::getTouchIcon(),
			'custom_styles'        => '',
			'is_enabled_preloader' => GeneralSiteSettingsModel::is_enabled_preloader(),
			'logo'                 => GeneralSiteSettingsModel::getLogo(),
			'socials'              => View::make(
				'blocks/socials', 
				[
					'socials' => SocialSettingsModel::get_all_socials(),
					'where'   => 'header',
				]
			),
			'socials_show_header'  => SocialSettingsModel::is_show_header(),
			'disclimer'            => HeaderSettingsModel::getDisclimer(),
			'search_box'           => HeaderSettingsModel::getSearchBox(),
			'header_style_layout'  => HeaderSettingsModel::getHeaderStyle(),
			'header_layout_view'   => sprintf('header_%s', HeaderSettingsModel::getHeaderStyle()),
			'header_image'         => get_header_image(),
			'header_slogan'        => get_option( 'photolab_header_slogan' ),
			'header_class'         => HeaderSettingsModel::getHeaderClass(),
			'static_class'         => empty( get_header_image() ) ? 'static' : 'absolute',
			'term_description'     => term_description(),
			'welcome_message'      => get_option( 'photolab' ),
			'main_menu'            => wp_nav_menu( 
				[ 
					'theme_location'  => 'main',
					'container'       => 'nav', 
					'container_class' => 'main-navigation', 
					'container_id'    => 'site-navigation',
					'menu_class'      => 'sf-menu', 
					'walker'          => new \Modules\Custom\Photolab_Walker(),
					'echo'            => false,
				] 
			),
			'top_menu'            => wp_nav_menu( 
				[
					'theme_location'  => 'top',
					'container'       => 'nav', 
					'container_class' => 'top-navigation', 
					'container_id'    => 'site-navigation',
					'menu_class'      => 'sf-top-menu', 
					'walker'          => new \Modules\Custom\Photolab_Walker(),
					'echo'            => false,
				] 
			)
		];	

		$header['alt_mess'] = Utils::array_get($header['welcome_message'], 'welcome_title', get_bloginfo( 'name' ));

		return $header;
	}

	/**
	 * Get footer
	 * 
	 * @return string HTML code footer
	 */
	public static function footer()
	{
		return \View\View::make( 'sections/footer', MainModel::footer_data() );
	}

	/**
	 * Footer data for footer section
	 * 
	 * @return array
	 */
	public static function footer_data()
	{
		return [
			'copyright'    => FooterSettingsModel::getCopyright(),
			'logo'         => FooterSettingsModel::getLogo(),
			'menu'         => wp_nav_menu( 
				array( 
					'theme_location'  => 'footer',
					'container'       => '', 
					'container_class' => 'footer-navigation', 
					'container_id'    => 'site-navigation',
					'menu_class'      => 'sf-footer-menu',
					'echo'            => false
				) 
			),
			'socials'              => View::make(
				'blocks/socials', 
				[
					'socials' => SocialSettingsModel::get_all_socials(),
					'where'   => 'footer',
				]
			),
			'socials_show_footer'  => SocialSettingsModel::is_show_footer(),
			'footer_style' => FooterSettingsModel::getStyle(),
			'widgets' 	   => FooterSettingsModel::getAllFooterWidgetsHTML(),
			'columns' 	   => FooterSettingsModel::getColumns(),
			'css'     	   => FooterSettingsModel::getColumnsCSSClass(),
		];
	}

	/**
	 * Include Google fonts
	 */
	public static function fonts_url()
	{
		$fonts_url = '';

		$locale = get_locale();

		$cyrillic_locales = array( 'ru_RU', 'mk_MK', 'ky_KY', 'bg_BG', 'sr_RS', 'uk', 'bel' );

		/* Translators: If there are characters in your language that are not
		* supported by Lora, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$libre = _x( 'on', 'Libre Baskerville font: on or off', 'photolab' );

		/* Translators: If there are characters in your language that are not
		* supported by Open Sans, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$open_sans = _x( 'on', 'Open Sans font: on or off', 'photolab' );

		if ( 'off' !== $libre || 'off' !== $open_sans ) 
		{
			$font_families = array();

			if ( 'off' !== $libre ) 
			{
				$font_families[] = 'Libre Baskerville:400,700,400italic';
			}

			if ( 'off' !== $open_sans ) 
			{
				$font_families[] = 'Open Sans:300,400,700,400italic,700italic';
			}

			$query_args = [
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			];

			if ( in_array($locale, $cyrillic_locales) ) 
			{
				$query_args['subset'] = urlencode( 'latin,latin-ext,cyrillic' );
			}

			$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}

	/**
	 * Get image for image post format
	 */
	public static function image_post() 
	{
		if ( has_post_thumbnail() ) 
		{
			$thumb_id      = get_post_thumbnail_id();
			$fullsize_img  = wp_get_attachment_url( $thumb_id );
			$cropped_image = wp_get_attachment_image( $thumb_id , 'fullwidth-thumbnail' );
		} 
		else 
		{
			$attachments = get_children( 
				[
					'post_parent'    => get_the_id(),
					'posts_per_page' => 1,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
				] 
			);
			if ( $attachments && is_array( $attachments ) ) 
			{
				$img_id        = $attachments[0]->ID;
				$fullsize_img  = wp_get_attachment_url( $img_id );
				$cropped_image = wp_get_attachment_image( $img_id , 'fullwidth-thumbnail' );
			}
		}
		echo View::make(
			'blocks/image_post',
			[
				'fullsize_img'  => $fullsize_img,
				'cropped_image' => $cropped_image,

			]
		);
	}
}