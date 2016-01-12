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
			'favicon'              => GeneralSiteSettingsModel::getFavicon(),
			'touch_icon'           => GeneralSiteSettingsModel::getTouchIcon(),
			'custom_styles'        => '',
			'preloader'            => GeneralSiteSettingsModel::getPreloader(),
			'logo'                 => GeneralSiteSettingsModel::getLogo(),
			'socials'              => photolab_social_list( 'header', false ),
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
					'fallback_cb'     => 'photolab_page_menu',
					'walker'          => new PhotolabWalker(),
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
					'fallback_cb'     => 'photolab_page_menu',
					'walker'          => new PhotolabWalker(),
					'echo'            => false,
				] 
			)
		];	

		$header['alt_mess'] = Utils::array_get($header['welcome_message'], 'welcome_title', get_bloginfo( 'name' ));

		return $header;
	}

	/**
	 * Get footer
	 * @return string HTML code footer
	 */
	public static function footer()
	{
		return \View\View::make( 'sections/footer', MainModel::footer_data()	);
	}

	/**
	 * Footer data for footer section
	 * 
	 * @return array
	 */
	public static function footer_data()
	{
		return [
			'footer_style' => FooterSettingsModel::getStyle(),
			'footer'       => FooterSettingsModel::getFooter(),
			'widgets' 	   => FooterSettingsModel::getAllFooterWidgetsHTML(),
			'columns' 	   => FooterSettingsModel::getColumns(),
			'css'     	   => FooterSettingsModel::getColumnsCSSClass(),
		];
	}
}