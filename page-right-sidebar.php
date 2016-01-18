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
		'sidebar_right'     => Sidebar_Settings_Model::getModeRight(),
		'breadcrumbs'       => General_SiteSettings_Model::breadcrumbs(),
		'sidebar_side_type' => 'right'
	]
);

