<?php
/**
 * Load all assets
 *
 * @package photolab
 */
return [
	'scripts' => [
		[ 'photolab-navigation', \Core\Utils::assets_url() . 'js/navigation.js', [], '20120206', true ],
		[ 'photolab-skip-link-focus-fix', \Core\Utils::assets_url() . 'js/skip-link-focus-fix.js', [], '20130115', true ],
		[ 'photolab-superfish', \Core\Utils::assets_url() . 'js/jquery.superfish.min.js', [ 'jquery' ], '1.4.9', true ],
		[ 'photolab-mobilemenu', \Core\Utils::assets_url() . 'js/jquery.mobilemenu.js', [ 'jquery' ], '1.0', true ],
		[ 'photolab-sfmenutouch', \Core\Utils::assets_url() . 'js/jquery.sfmenutouch.js', [ 'jquery' ], '1.0', true ],
		[ 'photolab-magnific-popup', \Core\Utils::assets_url() . 'js/jquery.magnific-popup.min.js', [ 'jquery' ], '1.0.0', true ],
		[ 'photolab-device', \Core\Utils::assets_url() . 'js/device.min.js', [ 'jquery' ], '1.0.2', true ],
		[ 'photolab-sticky', \Core\Utils::assets_url() . 'js/jquery.stickyheader.js', [ 'jquery' ], '1.0', true ],
		[ 'photolab-custom', \Core\Utils::assets_url() . 'js/custom.js', [ 'jquery' ], '1.0', true ],
		[ 'masonry', 'https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.min.js', [ 'jquery' ] ],
	],
	'styles'  => [
		[ 'photolab-layout', \Core\Utils::assets_url().'css/layout.css', [], '1.1.0' ],
		[ 'photolab-magnific-popup', \Core\Utils::assets_url() . 'css/magnific-popup.css', [], '1.1.0' ],
		[ 'dashicons' ],
		[ 'photolab-fonts', Main_Model::fonts_url(), [], null ],
		[ 'photolab-style', get_stylesheet_uri(), [], '1.1.0' ],
		[ 'photolab-font-awesome', \Core\Utils::assets_url(). 'css/font-awesome-4.5.0/css/font-awesome.min.css', [] ],
		[ 'photolab-layout-ie', \Core\Utils::assets_url() . 'css/layout-ie.css', [], '1.1.0' ],
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
