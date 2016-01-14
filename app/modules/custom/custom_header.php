<?php

namespace Modules\Custom;

Use \View\View;
Use \Core\Utis;

class Custom_Header{

	/**
	 * Custom_Header class constructor
	 */
	public function __construct()
	{
		add_action( 'admin_print_styles-appearance_page_custom-header', [$this, 'scripts_and_styles'] );
		add_action( 'admin_head-appearance_page_custom-header', [$this, 'save_header_slogan'], 40 );
		add_action( 'custom_header_options', [$this, 'add_header_options'] );
	}

	/**
	 * Add custom options to admin screen
	 */
	public function add_header_options()
	{
		echo View::make('add_header_options');
	}

	/**
	 * Save header slogan
	 */
	public function save_header_slogan() 
	{
		if ( empty( $_POST ) ) {
			return;
		}
		if ( !isset($_POST['phtotloab_header_slogan']) ) {
			return;
		}

		global $allowedtags;
		$header_slogan = wp_kses( $_POST['phtotloab_header_slogan'], $allowedtags );

		update_option( 'photolab_header_slogan', $header_slogan );
	}

	/**
	 * Add scripts and styles
	 */
	public function scripts_and_styles()
	{
		wp_enqueue_style( 'photolab-fonts', photolab_fonts_url(), array(), null );
	}
	
	/**
	 * Custom header style
	 */
	public static function style()
	{
		echo View::make('custom_header_style');
	}

	public static function image()
	{
		echo View::make(
			'custom_header_image',
			[
				'header_slogan' => get_option( 'photolab_header_slogan' ),
				'allowedtags'   => Utils::array_get($GLOBALS, 'allowedtags'),
			]
		);
	}
}

new Custom_Header;