<?php
/**
 * Load all assets
 *
 * @package photolab
 */
return array(
	'scripts' => array(
		array( 'photolab-navigation', Utils::assets_url() . 'js/navigation.js', array(), '20120206', true ),
		array( 'photolab-skip-link-focus-fix', Utils::assets_url() . 'js/skip-link-focus-fix.js', array(), '20130115', true ),
		array( 'photolab-superfish', Utils::assets_url() . 'js/jquery.superfish.min.js', array( 'jquery' ), '1.4.9', true ),
		array( 'photolab-mobilemenu', Utils::assets_url() . 'js/jquery.mobilemenu.js', array( 'jquery' ), '1.0', true ),
		array( 'photolab-sfmenutouch', Utils::assets_url() . 'js/jquery.sfmenutouch.js', array( 'jquery' ), '1.0', true ),
		array( 'photolab-magnific-popup', Utils::assets_url() . 'js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.0.0', true ),
		array( 'photolab-device', Utils::assets_url() . 'js/device.min.js', array( 'jquery' ), '1.0.2', true ),
		array( 'photolab-sticky', Utils::assets_url() . 'js/jquery.stickyheader.js', array( 'jquery' ), '1.0', true ),
		array( 'photolab-custom', Utils::assets_url() . 'js/custom.js', array( 'jquery' ), '1.0', true ),
		array( 'masonry', 'https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.min.js', array( 'jquery' ) ),
	),
	'styles'  => array(
		array( 'photolab-layout', Utils::assets_url().'css/layout.css', array(), '1.1.0' ),
		array( 'photolab-magnific-popup', Utils::assets_url() . 'css/magnific-popup.css', array(), '1.1.0' ),
		array( 'dashicons' ),
		array( 'photolab-fonts', Main_Model::fonts_url(), array(), null ),
		array( 'photolab-style', get_stylesheet_uri(), array(), '1.1.0' ),
		array( 'photolab-font-awesome', Utils::assets_url(). 'css/font-awesome-4.5.0/css/font-awesome.min.css', array() ),
		array( 'photolab-layout-ie', Utils::assets_url() . 'css/layout-ie.css', array(), '1.1.0' ),
	),
	'localize' => array(
		array(
			'photolab-custom',
			'photolab_custom',
			array( 'stickup_menu' => Header_Settings_Model::getStickupMenu() ),
		),
		array(
			'photolab-layout-ie',
			'conditional',
			'lte IE 8',
		),
	),
	'custom' => array(),
);
