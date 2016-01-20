<?php
/**
 * Add theme pages
 *
 * @package photolab
 */
return [
	'Upgrade_To_Pro' => [
		__( 'About Photolab', 'photolab' ),
		__( 'About Photolab', 'photolab' ),
		'edit_theme_options',
		'welcome.php',
		function(){
			echo View::make( 'pages/about-photolab' );
		},
	],
];
