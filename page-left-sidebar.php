<?php
/**
 *
 * Template Name: Page with left sidebar
 *
 * @package photolab
 */

echo \View\View::make(
	'pages/page',
	[
		'sidebar_left'      => SidebarSettingsModel::getModeLeft(),
		'breadcrumbs'       => GeneralSiteSettingsModel::breadcrumbs(),
		'sidebar_side_type' => 'left'
	]
);
