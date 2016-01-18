<?php

namespace Configuration;

class Widgets{

	/**
     * The image sizes.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Widgets class constructor
     * 
     * @param array $data 
     */
	public function __construct(array $data)
	{
		$this->data = $data;
		add_action('widgets_init', [$this, 'load']);
	}

	/**
	 * Load classes
	 */
	public function load()
	{
		foreach ($this->data as $class) 
		{
			$class_name = 'Modules\\Widgets\\'.$class;
			$path = $this->path($class);
			
			if(file_exists($path))
			{
				require_once($path);
				
				if(class_exists($class_name))
				{
					register_widget( $class_name );
				}
			}
		}
	}

	/**
	 * Get class path
	 * 
	 * @param type $class class name
	 * @return string widget path
	 */
	public function path($class)
	{
		return sprintf(
			'%s%s.php',
			\Core\Utils::widgets_path(),
			strtolower($class)
		);
	}
}