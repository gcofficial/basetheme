<?php
/**
 * Add theme pages
 *
 * @package photolab
 */
function conf_get_about_photolab()
{
	echo View::make( 'pages/about-photolab' );
}
return array(
	'Upgrade_To_Pro' => array(
		__( 'About Photolab', 'photolab' ),
		__( 'About Photolab', 'photolab' ),
		'edit_theme_options',
		'welcome.php',
		'conf_get_about_photolab',
	),
);
