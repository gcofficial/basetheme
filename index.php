<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package photolab
 */

if ( is_404() ) {
	$result = View::make(
		'pages/404',
		array(
			'breadcrumbs' => General_Site_Settings_Model::breadcrumbs(),
		)
	);
} else if ( is_search() ) {
	$result = View::make(
		'pages/search',
		array(
			'sidebar_left'   => Sidebar_Settings_Model::get_mode_left(),
			'sidebar_right'  => Sidebar_Settings_Model::get_mode_right(),
			'breadcrumbs'    => General_Site_Settings_Model::breadcrumbs(),
			'paginate_links' => Blog_Settings_Model::get_paginate_links(),
		)
	);
} else if ( is_page() ) {
	$result = View::make(
		'pages/page',
		array(
			'sidebar_left'  => Sidebar_Settings_Model::get_mode_left(),
			'sidebar_right' => Sidebar_Settings_Model::get_mode_right(),
			'breadcrumbs'   => General_Site_Settings_Model::breadcrumbs(),
		)
	);
} else if ( is_single() ) {
	$result = View::make(
		'pages/single',
		array(
			'social_post_code' => Social_Post_Types::get_social_post_code( $post ),
			'sidebar_left'     => Sidebar_Settings_Model::get_mode_left(),
			'sidebar_right'    => Sidebar_Settings_Model::get_mode_right(),
			'breadcrumbs'      => General_Site_Settings_Model::breadcrumbs(),
		)
	);
} else {
	$result = View::make(
		'pages/index',
		array(
			'paginate_links' => Blog_Settings_Model::get_paginate_links(),
			'posts'          => $GLOBALS['wp_query']->get_posts(),
		)
	);
}

echo $result;
