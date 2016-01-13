<?php
/**
 * Add theme pages
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
	]
];