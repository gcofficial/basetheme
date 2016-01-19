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
	$result = \View\View::make(
		'pages/404',
		[
			'breadcrumbs' => General_Site_Settings_Model::breadcrumbs(),
		]
	);
} else if ( is_search() ) {
	$result = \View\View::make(
		'pages/search',
		[
			'sidebar_left'   => Sidebar_Settings_Model::getModeLeft(),
			'sidebar_right'  => Sidebar_Settings_Model::getModeRight(),
			'breadcrumbs'    => General_Site_Settings_Model::breadcrumbs(),
			'paginate_links' => Blog_Settings_Model::getPaginateLinks(),
		]
	);
} else if ( is_page() ) {
	$result = \View\View::make(
		'pages/page',
		[
			'sidebar_left'  => Sidebar_Settings_Model::getModeLeft(),
			'sidebar_right' => Sidebar_Settings_Model::getModeRight(),
			'breadcrumbs'   => General_Site_Settings_Model::breadcrumbs(),
		]
	);
} else if ( is_single() ) {
	$result = \View\View::make(
		'pages/single',
		[
			'social_post_code' => \Modules\Custom\Social_Post_Types::getSocialPostCode( $post ),
			'sidebar_left'     => Sidebar_Settings_Model::getModeLeft(),
			'sidebar_right'    => Sidebar_Settings_Model::getModeRight(),
			'breadcrumbs'      => General_Site_Settings_Model::breadcrumbs(),
		]
	);
} else {
	$result = \View\View::make(
		'pages/index',
		[
			'paginate_links' => Blog_Settings_Model::getPaginateLinks(),
			'posts'          => $GLOBALS['wp_query']->get_posts(),
		]
	);
}

echo $result;
