<?php

namespace Modules\Custom;

Use \View\View;
Use \Core\Utis;

class Custom_Header{
	
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
		)
	}
}

new Custom_Header;