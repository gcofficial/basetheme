<?php

abstract class OptionsModel{

	/**
	 * Get single option by key
	 * @param  string $key --- option key
	 * @return mixed --- option type
	 */
	public static function getOption($key)
	{
		return \Core\Utils::array_get(static::getAll(), $key, '');
	}

	/**
	 * Get all options
	 * @return array --- all options
	 */
	public static function getAll()
	{
		die('It must be ovverided!');
	}
}