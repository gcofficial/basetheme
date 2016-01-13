<?php

namespace Configuration;

class Configuration{

	/**
	 * Load all configurations
	 */
	public static function load()
	{
		$allowed_classes = self::get_allowed_config_classes();
		foreach ($allowed_classes as $class_name) 
		{
			$path  = self::get_class_path($class_name);
			$class = sprintf('\\Configuration\\%s', $class_name);
			if(file_exists($path))
			{
				new $class(include($path));
			}
		}
	}

	/**
	 * Get all allowed config classes
	 * 
	 * @return array all allowed config classes
	 */
	public static function get_allowed_config_classes()
	{
		return array(
			'Models',
			'Images',
			'Menus',
			'Sidebars',
			'Supports',
			'Widgets',
			'Pages',
			'Customs',
			'Assets',
		);
	}

	/**
	 * Make class path from class name
	 * 
	 * @param  string $class_name 
	 * @return string class path
	 */
	public static function get_class_path($class_name)
	{
		return sprintf(
			'%s/app/config/%s.php', 
			get_template_directory(),
			strtolower($class_name)
		);
	}
}