<?php
/**
 * Load all assets
 *
 * @package photolab
 */
return [
	'scripts' => [
		[ 'photolab-navigation', Utils::assets_url() . 'js/navigation.js', [], '20120206', true ],
		[ 'photolab-skip-link-focus-fix', Utils::assets_url() . 'js/skip-link-focus-fix.js', [], '20130115', true ],
		[ 'photolab-superfish', Utils::assets_url() . 'js/jquery.superfish.min.js', [ 'jquery' ], '1.4.9', true ],
		[ 'photolab-mobilemenu', Utils::assets_url() . 'js/jquery.mobilemenu.js', [ 'jquery' ], '1.0', true ],
		[ 'photolab-sfmenutouch', Utils::assets_url() . 'js/jquery.sfmenutouch.js', [ 'jquery' ], '1.0', true ],
		[ 'photolab-magnific-popup', Utils::assets_url() . 'js/jquery.magnific-popup.min.js', [ 'jquery' ], '1.0.0', true ],
		[ 'photolab-device', Utils::assets_url() . 'js/device.min.js', [ 'jquery' ], '1.0.2', true ],
		[ 'photolab-sticky', Utils::assets_url() . 'js/jquery.stickyheader.js', [ 'jquery' ], '1.0', true ],
		[ 'photolab-custom', Utils::assets_url() . 'js/custom.js', [ 'jquery' ], '1.0', true ],
		[ 'masonry', 'https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.min.js', [ 'jquery' ] ],
	],
	'styles'  => [
		[ 'photolab-layout', Utils::assets_url().'css/layout.css', [], '1.1.0' ],
		[ 'photolab-magnific-popup', Utils::assets_url() . 'css/magnific-popup.css', [], '1.1.0' ],
		[ 'dashicons' ],
		[ 'photolab-fonts', Main_Model::fonts_url(), [], null ],
		[ 'photolab-style', get_stylesheet_uri(), [], '1.1.0' ],
		[ 'photolab-font-awesome', Utils::assets_url(). 'css/font-awesome-4.5.0/css/font-awesome.min.css', [] ],
		[ 'photolab-layout-ie', Utils::assets_url() . 'css/layout-ie.css', [], '1.1.0' ],
	],
	'localize' => [
		[
			'photolab-custom',
			'photolab_custom',
			[ 'stickup_menu' => Header_Settings_Model::getStickupMenu() ],
		],
		[
			'photolab-layout-ie',
			'conditional',
			'lte IE 8',
		],
	],
	'custom' => [],
];
