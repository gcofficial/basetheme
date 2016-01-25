<?php
/**
 *
 * Template Name: Page with right sidebar
 *
 * @package photolab
 */

echo View::make(
	'pages/page',
	array(
		'sidebar_right'     => Sidebar_Settings_Model::get_mode_right(),
		'breadcrumbs'       => General_Site_Settings_Model::breadcrumbs(),
		'sidebar_side_type' => 'right',
	)
);

