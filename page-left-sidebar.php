<?php
/**
 *
 * Template Name: Page with left sidebar
 *
 * @package photolab
 */

echo View::make(
	'pages/page',
	array(
		'sidebar_left'      => Sidebar_Settings_Model::get_mode_left(),
		'breadcrumbs'       => General_Site_Settings_Model::breadcrumbs(),
		'sidebar_side_type' => 'left',
	)
);
