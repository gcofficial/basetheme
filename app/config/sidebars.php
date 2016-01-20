<?php
/**
 * Install all sidebars
 *
 * @package photolab
 */

return array(
	array(
		'name'          => __( 'Sidebar', 'photolab' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Allowed only on static pages', 'photolab' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	),
	array(
		'name'          => __( 'Sidebar second', 'photolab' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Allowed only on static pages', 'photolab' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	),
	array(
		'name'          => __( 'Footer Widget Area', 'photolab' ),
		'id'            => 'footer',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s '.Footer_Settings_Model::getColumnsCSSClass().' col-sm-6">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	),
);
