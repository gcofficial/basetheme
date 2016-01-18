<?php

namespace Modules\Custom;

Use \View\View;
Use \Core\Utils;

class Extras{

	/**
	 * Extras class constructor
	 */
	public function __construct()
	{
		// ==============================================================
		// Actions
		// ==============================================================
		add_filter( 'wp_page_menu_args', [$this, 'page_menu_args'] );
		add_filter( 'body_class', [$this, 'body_classes'] );
		add_filter( 'wp_title', [$this, 'wp_title'], 10, 2 );
		add_filter( 'excerpt_length', [$this, 'excerpt_length'], 99 );
		add_filter( 'wp_generate_tag_cloud', [$this, 'tag_class'], 10 );
		add_filter( 'nav_menu_css_class', [$this, 'nav_class'] );
		add_filter( 'upload_mimes', [$this, 'add_some_mime_types'], 1, 1);
		add_filter( 'comment_form_default_fields', [$this, 'comment_form_fields'] );

		// ==============================================================
		// Filters
		// ==============================================================
		add_action( 'wp', [$this, 'setup_author'] );
		add_action( 'photolab_before_post', [$this, 'blog_labels'] );
		add_action( 'after_setup_theme', [$this, 'setup'] );
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	public function setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on photolab, use a find and replace
		 * to change 'photolab' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'photolab', get_template_directory() . '/languages' );

		// Add editor styling
		add_editor_style( 'editor-style.css' );
	}

	/**
	 * Modify comment form default fields
	 */
	public function comment_form_fields( $fields ) {

		$req       = get_option( 'require_name_email' );
		$html5     = 'html5';
		$commenter = wp_get_current_commenter();
		$aria_req  = ( $req ? " aria-required='true'" : '' );

		$fields = [
			'author' => View::make(
				'blocks/comment_form_fields/author',
				[
					'placeholder' => __( 'Name', 'photolab' ) . ( $req ? '*' : '' ),
					'value'       => esc_attr( $commenter['comment_author'] ),
					'aria_req'    => $aria_req,
				]
			),
			'email'  => View::make(
				'blocks/comment_form_fields/email',
				[
					'type' 		  => ( $html5 ? 'type="email"' : 'type="text"' ),
					'placeholder' => __( 'Email', 'photolab' ) . ( $req ? '*' : '' ),
					'value'       => esc_attr(  $commenter['comment_author_email'] ),
					'aria_req'    => $aria_req,
				]
			),
			'url'    => View::make(
				'blocks/comment_form_fields/author',
				[
					'type' => ( $html5 ? 'type="url"' : 'type="text"' ),
					'placeholder' => __( 'Website', 'photolab' ),
					'value'       => esc_attr( $commenter['comment_author_url'] ),
				]
			),
		];

		return $fields;
	}

	/**
	 * Add some mime types
	 * @param array $mime_types --- mime types
	 */
	public function add_some_mime_types($mime_types)
	{
	    $mime_types['svg'] = 'image/svg+xml';
	    return $mime_types;
	}

	/**
	 * Add random class to nav items in primary menu (for hover effect)
	 */
	public function nav_class( $classes ) 
	{
		$classes[] = 'item-type-' . rand(1, 8);
		return $classes;
	}

	/**
	 * Add random class to tag cloud links (for hover effect)
	 */
	public function tag_class( $return ) 
	{
		return preg_replace_callback(
			'|(tag-link-)|', 
			[$this, 'gener_random_class'], 
			$return
		);
	}

	/**
	 * Generate random css class
	 * @param  array $matches preg matches
	 * @return string
	 */
	public function gener_random_class($matches) 
	{
		return 'term-type-' . rand(1, 8) . ' ' . $matches[0];
	}

	/**
	 * Add featured label and label before blog
	 */
	public function blog_labels() 
	{
		global $photolab_first_sticky, $photolab_first_post, $wp_query;
		if ( is_sticky() && $photolab_first_sticky ) 
		{
			return;
		} 
		elseif ( !is_sticky() && $photolab_first_post ) 
		{
			return;
		} 
		elseif ( is_sticky() ) 
		{
			$photolab_first_sticky = get_the_id();
			$label = \Misc_Model::getFeaturedLabel();
			if ( $wp_query->is_home() && $wp_query->is_main_query() ) 
			{
				if ( $wp_query->is_paged && $wp_query->query['paged'] > 1 ) 
				{
					return;
				}
				if ( $label ) 
				{
					echo View::make('blocks/blog_labels', ['label' => $label]);
				}
			}
		} 
		else 
		{
			$photolab_first_post = get_the_id();
			$label = \Misc_Model::getBlogLabel();
			if ( $wp_query->is_home() && $wp_query->is_main_query() ) 
			{
				if ( $wp_query->is_paged && $wp_query->query['paged'] > 1 ) 
				{
					return;
				}
				if ( $label ) 
				{
					echo View::make('blocks/blog_labels', ['label' => $label]);
				}
			}
		}
	}

	/**
	 * Increase default excerpt length
	 */
	public function excerpt_length( $length ) 
	{
		return 100;
	}

	/**
	 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
	 *
	 * @param array $args Configuration arguments.
	 * @return array
	 */
	public function page_menu_args( $args ) 
	{
		$args['show_home'] = true;
		return $args;
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	public function body_classes( $classes ) 
	{
		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) 
		{
			$classes[] = 'group-blog';
		}

		return $classes;
	}

	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	public function wp_title( $title, $sep ) 
	{
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) 
		{
			$title .= " $sep " . sprintf( __( 'Page %s', 'photolab' ), max( $paged, $page ) );
		}

		return $title;
	}

	/**
	 * Sets the authordata global when viewing an author archive.
	 *
	 * This provides backwards compatibility with
	 * http://core.trac.wordpress.org/changeset/25574
	 *
	 * It removes the need to call the_post() and rewind_posts() in an author
	 * template to print information about the author.
	 *
	 * @global WP_Query $wp_query WordPress Query object.
	 * @return void
	 */
	public function setup_author() 
	{
		global $wp_query;

		if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
			$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
		}
	}
}

new Extras;