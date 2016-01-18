<?php

class Sidebar_Settings_Model extends Options_Model{

	/**
	 * Get all options
	 * @return array --- all options
	 */
	public static function get_all()
	{
		return (array) get_option('sidebar_settings');
	}

	/**
	 * Get mode left
	 * @return string --- mode left
	 */
	public static function getModeLeft()
	{
		return self::get_option('mode_left');
	}

	/**
	 * Get mode right
	 * @return string --- mode right
	 */
	public static function getModeRight()
	{
		return self::get_option('mode_right');
	}

	/**
	 * Get sidebars
	 * @return string --- json string or empty
	 */
	public static function getSidebars()
	{
		return (string) self::get_option('sidebars');
	}

	/**
	 * Get sidebars in array
	 * @return array --- sidebars array
	 */
	public static function getSidebarsArray()
	{
		return (array) json_decode(self::getSidebars());
	}

	/**
	 * Get sidebars with options
	 * @return array --- sidebars with options
	 */
	public static function getSidebarsOptions()
	{
		$res = array();
		$arr = self::getSidebarsArray();
		if(count($arr))
		{
			foreach ($arr as $key => $value) 
			{
				array_push(
					$res, 
					array(
						'name'          => $value,
						'id'            => self::getSidebarID($value),
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget'  => '</aside>',
						'before_title'  => '<h3 class="widget-title">',
						'after_title'   => '</h3>',
					) 
				);
			}
		}
		return $res;
	}

	/**
	 * Get sidebar id from name
	 * @param  string $name --- sidebar name
	 * @return string       --- sidebar id
	 */
	public static function getSidebarID($name)
	{
		return str_replace(' ', '_', strtolower($name));
	}

	/**
	 * Get registered sidebars for select control
	 * @return array --- registered sidebars
	 */
	public static function getSidebarsForSelect()
	{
		$result   = array( '' => 'Inherit' );
		$sidebars = (array) $GLOBALS['wp_registered_sidebars'];
		if(count($sidebars))
		{
			foreach ($sidebars as $sidebar) 
			{
				$result[$sidebar['id']] = $sidebar['name'];
			}
		}
		return $result;
	}

	/**
	 * Get left sidebar id
	 * @return string --- left sidebar id
	 */
	public static function getLeftSidebarID()
	{
		global $post;
		$left = trim((string) get_post_meta( $post->ID, 'sidebar_left', true ));
		if($left == '') $left = 'sidebar-1';
		return $left;
	}

	/**
	 * Get right sidebar id
	 * @return string --- right sidebar id
	 */
	public static function getRightSidebarID()
	{
		global $post;
		$right = trim((string) get_post_meta( $post->ID, 'sidebar_right', true ));
		if($right == '') $right = 'sidebar-2';
		return $right;
	}

	/**
	 * Get sidebars type
	 * 
	 * @return string --- sidebars type
	 */
	public static function get_sidebar_side_type()
	{
		$key = sprintf(
			'l%sr%s', 
			self::getModeLeft(),
			self::getModeRight()
		);
		$values = array(
			'lr'   => 'hide',
			'l1r'  => 'left',
			'lr1'  => 'right',
			'l1r1' => 'leftright',
		);	
		if(!Blog_Settings_Model::isDefaultLayout())
		{
			$values['l1r1'] = 'left';
		}
		return $values[$key];
	}
}