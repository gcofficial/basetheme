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
		'sidebar_left'      => Sidebar_Settings_Model::getModeLeft(),
		'breadcrumbs'       => General_SiteSettings_Model::breadcrumbs(),
		'sidebar_side_type' => 'left'
	]
);
