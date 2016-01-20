<?php
/**
 * Add theme pages
 *
 * @package photolab
 */
return array(
	'Upgrade_To_Pro' => array(
		__( 'About Photolab', 'photolab' ),
		__( 'About Photolab', 'photolab' ),
		'edit_theme_options',
		'welcome.php',
		function(){
			echo View::make( 'pages/about-photolab' );
		},
	),
);
