<?php
/**
 * Blog setting model
 *
 * @package photolab
 */

/**
 * Blog settings model сlass
 */
class Blog_Settings_Model {
	const LAYOUT_DEFAULT = 'default';
	const LAYOUT_GRID    = 'grid';
	const LAYOUT_MASONRY = 'masonry';

	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		return Utils::array_get( ( array ) get_option( 'bs' ), $key, '' );
	}

	/**
	 * Get blog layout style
	 *
	 * @return string --- blog layout style
	 */
	public static function get_layout_style() {
		$allowed_styles = self::get_allowed_styles();
		$style 			= ( string ) self::get_option( 'layout_style' );
		if ( in_array( $style, $allowed_styles ) ) {
			return $style;
		}
		return $allowed_styles[0];
	}

	/**
	 * Get all allowed footer styles
	 *
	 * @return array --- all allowed footer sytles
	 */
	public static function get_allowed_styles() {
		return array(
			'default',
			'grid',
			'masonry',
		);
	}

	/**
	 * Get layout columns
	 *
	 * @return integer --- layout columns
	 */
	public static function get_columns() {
		$columns = min( 3, self::get_option( 'columns' ) );
		$columns = max( 2, $columns );
		return $columns;
	}

	/**
	 * Get column CSS class
	 *
	 * @return string --- column CSS class
	 */
	public static function getColumnCSSClass() {
		$classes = array(
			2 => 'col-md-6 col-lg-6',
			3 => 'col-md-4 col-lg-4',
		);
		return $classes[ self::get_columns() ];
	}

	/**
	 * Is default layout ?
	 *
	 * @return boolean --- true if succes | false if not
	 */
	public static function is_default_layout() {
		return self::get_layout_style() == self::LAYOUT_DEFAULT;
	}

	/**
	 * Get paginate links
	 *
	 * @return string
	 */
	public static function get_paginate_links() {
		global $wp_query, $wp_rewrite;

		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		return paginate_links(
			array(
				'base'      => $pagenum_link,
				'format'    => $format,
				'total'     => $wp_query->max_num_pages,
				'current'   => $paged,
				'mid_size'  => 1,
				'add_args'  => array_map( 'urlencode', $query_args ),
				'prev_text' => __( '&larr; Previous', 'photolab' ),
				'next_text' => __( 'Next &rarr;', 'photolab' ),
			)
		);
	}

	/**
	 * Get content template name
	 *
	 * @return string content template name
	 */
	public static function get_content_name() {
		$post_format = ( string ) get_post_format();
		return '' == $post_format ? 'content' : $post_format;
	}
}
