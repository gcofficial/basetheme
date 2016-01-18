<?php
Use \View\View;
Use \Core\Utils;

add_action('init', 'photolab_init');
function photolab_init()
{
	// ==============================================================
	// Global view variables declaration
	// ==============================================================
	View::addData(Main_Model::main());
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) 
{
	$content_width = 1140; /* pixels */
}

require_once 'src/Core/Autoload.php';
\Core\App::Start();

