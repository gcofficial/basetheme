<?php
namespace View;

class View {

	//                          __              __      
	//   _________  ____  _____/ /_____ _____  / /______
	//  / ___/ __ \/ __ \/ ___/ __/ __ `/ __ \/ __/ ___/
	// / /__/ /_/ / / / (__  ) /_/ /_/ / / / / /_(__  ) 
	// \___/\____/_/ /_/____/\__/\__,_/_/ /_/\__/____/  

	const STORAGE_FOLDER = 'storage';
	const VIEWS_FOLDER   = 'views';

	//                    _       __    __         
	//  _   ______ ______(_)___ _/ /_  / /__  _____
	// | | / / __ `/ ___/ / __ `/ __ \/ / _ \/ ___/
	// | |/ / /_/ / /  / / /_/ / /_/ / /  __(__  ) 
	// |___/\__,_/_/  /_/\__,_/_.___/_/\___/____/  
	
	/**
	 * All global data to insert in view
	 * 
	 * @var array
	 */
	protected static $data = array();

	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	
	/**
	 * Add $key => $value to global data
	 * 
	 * @param array $data 
	 */
	public static function addData($data = null)
	{
		if(is_null($data)) 
		{
			return false;	
		}
		
		if(is_array($data)) 
		{
			static::$data = array_merge(static::$data, $data);
		}
		return count(static::$data);
	}

	/**
	 * Get storage path
	 * 
	 * @return string storage folder path
	 */
	public static function get_storage_folder_path()
	{
		return sprintf(
			'%2$s%1$sapp%1$s%3$s%1$s', 
			DIRECTORY_SEPARATOR, 
			get_template_directory(), 
			self::STORAGE_FOLDER
		);
	}

	/**
	 * Get views path
	 * 
	 * @return string views folder path
	 */
	public static function get_view_folder_path()
	{
		return sprintf(
			'%2$s%1$sapp%1$s%3$s%1$s', 
			DIRECTORY_SEPARATOR, 
			get_template_directory(), 
			self::VIEWS_FOLDER
		);
	}

	/**
	 * Get view path
	 * 		
	 * @param type $filename file name
	 * @return string view path
	 */
	public static function get_view_path($filename)
	{
		return sprintf(
			'%s%s.php',
			self::get_view_folder_path(),
			$filename
		);
	}

	/**
	 * Build a view instance. This is the 1st method called
     * when defining a View.
     * 
	 * @param type $view The view name.
	 * @param  array $datas Passed data to the view.
	 * @return string Compiled view
	 */
	public static function make($view, $__data = array())
	{
		$__data = array_merge(static::$data, $__data);
		$__path = self::get_view_path($view);
		$scout_compiler = new Scout_Compiler(self::get_storage_folder_path());
		if($scout_compiler->isExpired($__path))
		{
			$scout_compiler->compile($__path);
		}
		$storage_view_path = $scout_compiler->getCompiledPath($__path);

		return self::render_view($storage_view_path, (array) $__data);
	}

	/**
	 * Check view exists
	 * @return boolean true if exists | false if not
	 */
	public static function exists($view = '')
	{
		$view_path = self::get_view_path($view);
		return file_exists($view_path);
	}

	/**
	 * Render view
	 * 	
	 * @param type $view_path storage view path
	 * @param  array $data include data
	 * @return rendered html
	 */
	public static function render_view($__path, $__data)
	{
		ob_start();

        // Extract view datas.
        extract($__data);

        // Compile the view.
        try
        {
            // Include the view.
            include($__path);

        } 
        catch (\Exception $e)
        {
            echo $e;
            die();
        }

        // Return the compiled view and terminate the output buffer.
        return ltrim(ob_get_clean());
	}
}