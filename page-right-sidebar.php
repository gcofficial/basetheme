<?php
/**
 *
 * Template Name: Page with right sidebar
 *
 * @package photolab
 */

echo \View\View::make(
	'pages/page',
	[
		'sidebar_right'     => SidebarSettingsModel::getModeRight(),
		'breadcrumbs'       => GeneralSiteSettingsModel::getBreadcrumbs(),
		'sidebar_side_type' => 'right'
	]
);

