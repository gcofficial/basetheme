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

if(is_404())
{
	$result = \View\View::make(
		'pages/404',
		[
			'breadcrumbs' => GeneralSiteSettingsModel::breadcrumbs()
		]
	);
}
else if (is_search()) 
{
	$result = \View\View::make(
		'pages/search',
		[
			'sidebar_left'  => SidebarSettingsModel::getModeLeft(),
			'sidebar_right' => SidebarSettingsModel::getModeRight(),
			'breadcrumbs'   => GeneralSiteSettingsModel::breadcrumbs(),
		]
	);
}
else if(is_page())
{
	$result = \View\View::make(
		'pages/page',
		[
			'sidebar_left'  => SidebarSettingsModel::getModeLeft(),
			'sidebar_right' => SidebarSettingsModel::getModeRight(),
			'breadcrumbs'   => GeneralSiteSettingsModel::breadcrumbs(),
		]
	);
}
else if(is_single())
{
	$result = \View\View::make(
		'pages/single',
		[
			'social_post_code' => SocialPostTypes::getSocialPostCode($post),
			'sidebar_left'     => SidebarSettingsModel::getModeLeft(),
			'sidebar_right'    => SidebarSettingsModel::getModeRight(),
			'breadcrumbs'      => GeneralSiteSettingsModel::breadcrumbs(),
		]
	);
}
else
{
	$result = \View\View::make(
		'pages/index',
		[
			'paginate_links' => BlogSettingsModel::getPaginateLinks(),
			'posts'          => $GLOBALS['wp_query']->get_posts()
		]
	);
}

echo $result;

