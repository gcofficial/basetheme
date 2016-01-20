<?php
/**
 * Main Model fiel
 *
 * @package photolab
 */

/**
 * Main model class
 */
class Main_Model {

	/**
	 * Main data for view
	 *
	 * @return array
	 */
	public static function main() {
		return array(
			'TDU'               => get_template_directory_uri(),
			'search_form'       => View::make( 'blocks/search-form' ),
			'sidebar_side_type' => Sidebar_Settings_Model::get_sidebar_side_type(),
			'wp_query'          => Utils::array_get( $GLOBALS, 'wp_query', null ),
			'post'              => Utils::array_get( $GLOBALS, 'post', null ),
			'blog_layout_style' => Blog_Settings_Model::get_layout_style(),
			'blog_content'      => Misc_Model::get_blog_content(),
			'read_more_button'  => Misc_Model::get_blog_button(),
			'columns_count'     => Blog_Settings_Model::get_columns(),
			'column_css_class'  => Blog_Settings_Model::get_column_css_class(),
			'category_list'     => get_the_category_list( __( ', ', 'photolab' ) ),
			'tag_list'          => get_the_tag_list( '', __( ', ', 'photolab' ) ),
			'archive_list'      => wp_get_archives( array( 'type' => 'monthly', 'echo' => false ) ),
			'wp_register'  		=> wp_register( '<li>', '</li>', false ),
			'wp_loginout'  		=> wp_loginout( '', false ),
			'wp_meta'      		=> Utils::echo_to_var( array( __CLASS__, 'wp_meta' ) ),
			'is_show_title_on_header' => Header_Settings_Model::is_show_title_on_header(),
		);
	}

	/**
	 * It's for php 5.2
	 */
	public static function wp_meta() {
		wp_meta();
	}

	/**
	 * Get header
	 *
	 * @return string HTML code header
	 */
	public static function header() {
		return View::make( 'sections/header', Main_Model::header_data() );
	}

	/**
	 * Header data for header section
	 *
	 * @return array
	 */
	public static function header_data() {
		$header_image = get_header_image();
		$header = array(
			'allowedtags'          => $GLOBALS['allowedtags'],
			'language_attributes'  => get_language_attributes(),
			'body_class'           => implode( ' ', get_body_class() ),
			'charset'              => get_bloginfo( 'charset' ),
			'ping_back_url'        => get_bloginfo( 'pingback_url' ),
			'name'                 => get_bloginfo( 'name' ),
			'home_url'    		   => esc_url( home_url( '/' ) ),
			'description' 		   => get_bloginfo( 'description' ),
			'favicon'              => General_Site_Settings_Model::get_favicon(),
			'touch_icon'           => General_Site_Settings_Model::get_touch_icon(),
			'custom_styles'        => '',
			'is_enabled_preloader' => General_Site_Settings_Model::is_enabled_preloader(),
			'logo'                 => General_Site_Settings_Model::get_logo(),
			'socials'              => View::make(
				'blocks/socials',
				array(
					'socials' => Social_Settings_Model::get_all_socials(),
					'where'   => 'header',
				)
			),
			'socials_show_header'  => Social_Settings_Model::is_show_header(),
			'disclimer'            => Header_Settings_Model::get_disclimer(),
			'search_box'           => Header_Settings_Model::get_search_box(),
			'header_style_layout'  => Header_Settings_Model::get_header_style(),
			'header_layout_view'   => sprintf( 'header-%s', Header_Settings_Model::get_header_style() ),
			'header_image'         => $header_image,
			'header_slogan'        => get_option( 'photolab_header_slogan' ),
			'header_class'         => Header_Settings_Model::get_header_class(),
			'static_class'         => empty( $header_image ) ? 'static' : 'absolute',
			'term_description'     => term_description(),
			'welcome_message'      => get_option( 'photolab' ),
			'main_menu'            => wp_nav_menu(
				array(
					'theme_location'  => 'main',
					'container'       => 'nav',
					'container_class' => 'main-navigation',
					'container_id'    => 'site-navigation',
					'menu_class'      => 'sf-menu',
					'walker'          => new Photolab_Walker(),
					'echo'            => false,
				)
			),
			'top_menu'            => wp_nav_menu(
				array(
					'theme_location'  => 'top',
					'container'       => 'nav',
					'container_class' => 'top-navigation',
					'container_id'    => 'site-navigation',
					'menu_class'      => 'sf-top-menu',
					'walker'          => new Photolab_Walker(),
					'echo'            => false,
				)
			),
		);

		$header['alt_mess'] = Utils::array_get( $header['welcome_message'], 'welcome_title', get_bloginfo( 'name' ) );

		return $header;
	}

	/**
	 * Get footer
	 *
	 * @return string HTML code footer
	 */
	public static function footer() {
		return View::make( 'sections/footer', Main_Model::footer_data() );
	}

	/**
	 * Footer data for footer section
	 *
	 * @return array
	 */
	public static function footer_data() {
		return array(
			'copyright'    => Footer_Settings_Model::get_copyright(),
			'logo'         => Footer_Settings_Model::get_logo(),
			'menu'         => wp_nav_menu(
				array(
					'theme_location'  => 'footer',
					'container'       => '',
					'container_class' => 'footer-navigation',
					'container_id'    => 'site-navigation',
					'menu_class'      => 'sf-footer-menu',
					'echo'            => false,
				)
			),
			'socials'              => View::make(
				'blocks/socials',
				array(
					'socials' => Social_Settings_Model::get_all_socials(),
					'where'   => 'footer',
				)
			),
			'socials_show_footer'  => Social_Settings_Model::is_show_footer(),
			'footer_style' => Footer_Settings_Model::get_style(),
			'widgets' 	   => Footer_Settings_Model::get_all_footer_widgets_html(),
			'columns' 	   => Footer_Settings_Model::get_columns(),
			'css'     	   => Footer_Settings_Model::get_columns_css_class(),
		);
	}

	/**
	 * Include Google fonts
	 */
	public static function fonts_url() {
		$fonts_url = '';

		$locale = get_locale();

		$cyrillic_locales = array( 'ru_RU', 'mk_MK', 'ky_KY', 'bg_BG', 'sr_RS', 'uk', 'bel' );

		/**
		* Translators: If there are characters in your language that are not
		* supported by Lora, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$libre = _x( 'on', 'Libre Baskerville font: on or off', 'photolab' );

		/**
		* Translators: If there are characters in your language that are not
		* supported by Open Sans, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$open_sans = _x( 'on', 'Open Sans font: on or off', 'photolab' );

		if ( 'off' !== $libre || 'off' !== $open_sans ) {
			$font_families = array();

			if ( 'off' !== $libre ) {
				$font_families[] = 'Libre Baskerville:400,700,400italic';
			}

			if ( 'off' !== $open_sans ) {
				$font_families[] = 'Open Sans:300,400,700,400italic,700italic';
			}

			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);

			if ( in_array( $locale, $cyrillic_locales ) ) {
				$query_args['subset'] = urlencode( 'latin,latin-ext,cyrillic' );
			}

			$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}

	/**
	 * Get image for image post format
	 */
	public static function image_post() {
		if ( has_post_thumbnail() ) {
			$thumb_id      = get_post_thumbnail_id();
			$fullsize_img  = wp_get_attachment_url( $thumb_id );
			$cropped_image = wp_get_attachment_image( $thumb_id , 'fullwidth-thumbnail' );
		} else {
			$attachments = get_children(
				array(
					'post_parent'    => get_the_id(),
					'posts_per_page' => 1,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
				)
			);
			if ( $attachments && is_array( $attachments ) ) {
				$img_id        = $attachments[0]->ID;
				$fullsize_img  = wp_get_attachment_url( $img_id );
				$cropped_image = wp_get_attachment_image( $img_id , 'fullwidth-thumbnail' );
			}
		}
		echo View::make(
			'blocks/image-post',
			array(
				'fullsize_img'  => $fullsize_img,
				'cropped_image' => $cropped_image,
			)
		);
	}
}
