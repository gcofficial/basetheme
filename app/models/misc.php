<?php

class Misc_Model extends Options_Model{

	/**
	 * Get all options
	 * 
	 * @return array --- all options
	 */
	public static function getAll()
	{
		return (array) get_option('misc');
	}

	/**
	 * Get featured label
	 * 
	 * @return string
	 */
	public static function getFeaturedLabel()
	{
		return (string) self::getOption('featured_label');
	}

	/**
	 * Get blog label
	 * 
	 * @return string
	 */
	public static function getBlogLabel()
	{
		return (string) self::getOption('blog_label');
	}

	/**
	 * Get blog content
	 * 
	 * @return string
	 */
	public static function getBlogContent()
	{
		$allowed = array('excerpt', 'full');
		$content = (string) self::getOption('blog_content');
		if(in_array($content, $allowed))
			return $content;
		return $allowed[0];
	}

	/**
	 * Get blog image
	 * 
	 * @return string
	 */
	public static function getBlogImage()
	{
		$blog_image = (string) self::getOption('blog_image');
		return $blog_image != '' ? $blog_image : 'post-thumbnail';
	}

	/**
	 * Get blog button
	 * 
	 * @return string
	 */
	public static function getBlogButton()
	{
		$blog_btn = (string) self::getOption('blog_btn');
		if($blog_btn == '')
		{
			$blog_btn = __( "Read More", "photolab" );	
		}
		return $blog_btn;
	}
	
}