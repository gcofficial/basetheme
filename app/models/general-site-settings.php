<?php

Use \View\View;

class General_SiteSettings_Model extends Options_Model{

	/**
	 * Get all options
	 * @return array --- all options
	 */
	public static function getAll()
	{
		return (array) get_option('gss');
	}

	/**
	 * Get favicon HTML code
	 * @return string --- favicon HTML code
	 */
	public static function getFavicon()
	{
		$result  = '';
		$favicon = trim(self::getOption('favicon'));
		if($favicon != '')
			$result = sprintf('<link rel="icon" type="image/png" href="%s" />', $favicon);
		return $result;
	}

	/**
	 * Get touch icon HTML code
	 * @return string --- touch icon HTML code
	 */
	public static function getTouchIcon()
	{
		$result = '';
		$touch_icon = trim(self::getOption('touch_icon'));
		if($touch_icon != '')
			$result = sprintf('<link rel="apple-touch-icon" href="%s"/>', $touch_icon);
		return $result;
	}

	/**
	 * Get site logo HTML code
	 * @return string --- site logo HTML code
	 */
	public static function getLogo()
	{
		return (string) trim(self::getOption('logo'));
	}

	/**
	 * Is enabled breadcrumbs
	 * 
	 * @return boolean 
	 */
	public static function is_enabled_breadcrumbs()
	{
		return self::getOption('breadcrumbs') == '1';
	}

	/**
	 * Breadcrumbs data 
	 * 
	 * @return array
	 */
	public static function breadcrumbs_data()
	{
		global $post, $author;
		$qo = get_queried_object();
		$data = [
			'separator'         => '&gt;',
			'breadcrums_id'     => 'breadcrumbs',
			'breadcrums_class'  => 'breadcrumbs',
			'home_title'        => 'Homepage',
			'custom_taxonomy'   => 'product_cat',
			'post_type'         => get_post_type(),
			'post_type_object'  => get_post_type_object(get_post_type()),
			'post_type_archive' => get_post_type_archive_link(get_post_type()),
			'category'          => get_the_category(),
			'post'              => $post,
		];
		if($qo != null)
		{
			$data['custom_tax_name'] = $qo->name;
		}

		if(!empty($data['category']))
		{
			$values = array_values($data['category']);
			$data['last_category']   = end($values);
            $data['get_cat_parents'] = rtrim(get_category_parents($data['last_category']->term_id, true, ','), ',');
            $data['cat_parents']     = explode(',', $data['get_cat_parents']);
		}

		$data['taxonomy_exists'] = taxonomy_exists($data['custom_taxonomy']);
        if(empty($data['last_category']) && !empty($data['custom_taxonomy']) && $data['taxonomy_exists']) 
        {
            $data['taxonomy_terms'] = get_the_terms( $post->ID, $data['custom_taxonomy'] );
            $data['cat_id']         = $data['taxonomy_terms'][0]->term_id;
            $data['cat_nicename']   = $data['taxonomy_terms'][0]->slug;
            $data['cat_link']       = get_term_link($data['taxonomy_terms'][0]->term_id, $data['custom_taxonomy']);
            $data['cat_name']       = $data['taxonomy_terms'][0]->name;
        }
        if($post != null)
        {
        	if($post->post_parent)
        	{
        		$data['anc'] = get_post_ancestors( $post->ID );
        	    $data['anc'] = array_reverse($data['anc']);
        	}	
        }
        if(is_tag())
        {
        	$data['term_id']        = get_query_var('tag_id');
        	$data['taxonomy']       = 'post_tag';
        	$data['args']           = 'include=' . $term_id;
        	$data['terms']          = get_terms( $taxonomy, $args );
        	$data['get_term_id']    = $data['terms'][0]->term_id;
        	$data['get_term_slug']  = $data['terms'][0]->slug;
        	$data['get_term_name']  = $data['terms'][0]->name;
        }
        if(is_author())
        {
        	$data['userdata'] = get_userdata( $author );
        }

		return $data;
	}

	/**
	 * Breadcrumbs HTLM block
	 * 
	 * @return string
	 */
	public static function breadcrumbs()
	{
		if(!self::is_enabled_breadcrumbs()) 
		{
			return '';
		}
		return View::make('blocks/breadcrumbs', self::breadcrumbs_data());
	}

	/**
	 * Is enabled preloader
	 * 
	 * @return boolean 
	 */
	public static function is_enabled_preloader()
	{
		return self::getOption('page_preloader') == '1';
	}

	/**
	 * Get color scheme HEX
	 * 
	 * @return string --- color scheme HEX
	 */
	public static function getColorScheme()
	{
		$color = trim(self::getOption('color_scheme'));
		if($color == '') $color = '#222';
		return  $color;
	}
}