<?php

namespace Configuration;

class Customs{

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
		$this->load();
	}

	/**
	 * Load classes
	 */
	public function load()
	{
		foreach ($this->data as $class)
		{
			$class_name = 'Modules\\Custom\\'.$class;
			$path = $this->path( str_replace( '_', '-', $class ) );
			
			if(file_exists($path))
			{
				require_once($path);
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
			'%s/app/modules/custom/%s.php',
			get_template_directory(),
			strtolower($class)
		);
	}
}