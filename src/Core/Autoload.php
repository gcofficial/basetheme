<?php
namespace Core;

class Autoload{

	/**
	 * Framework class constructor
	 */
	public function __construct()
	{
		spl_autoload_register(array(&$this, 'autoloader'));
	}

	/**
	 * Autoload my classes
	 * 
	 * @return void
	 */
	public function autoloader($class)
	{
		$class_path = self::getClassPath($class);
		if(file_exists($class_path))
		{
			require_once $class_path;
		}
	}

	/**
	 * Get class path from class called name
	 * @param  string $class --- class called name
	 * @return string        --- class path
	 */
	public static function getClassPath($class)
	{
		$class_path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
		return sprintf('%s/src/%s.php', get_template_directory(), $class_path);
	}
}

new Autoload;