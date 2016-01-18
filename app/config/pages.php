<?php
/**
 * Add theme pages
 *
 * @package photolab
 */
return [
	'Upgrade_To_Pro' => [
		__('About Photolab', 'photolab'), 
		__('About Photolab', 'photolab'), 
		'edit_theme_options', 
		'welcome.php', 
		function(){
			echo \View\View::make('pages/about_photolab');
		}
	],
	'Fuck_the_planet' => [
		__('Example', 'photolab'), 
		__('Example', 'photolab'), 
		'edit_theme_options', 
		'fuck_the_planet.php', 
		function(){
			echo \View\View::make('pages/fuck_the_planet', ['fuck_variable' => 'Fuck the planet']);
		}
	]
];
