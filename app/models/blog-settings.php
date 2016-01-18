<?php
/**
 * Blog setting model
 *
 * @package photolab
 */

/**
 * Blog settings model сlass
 */
class Blog_Settings_Model extends Options_Model{
	const LAYOUT_DEFAULT = 'default';
	const LAYOUT_GRID    = 'grid';
	const LAYOUT_MASONRY = 'masonry';

	/**
	 * Get all options
	 * 
	 * @return array --- all options
	 */
	public static function get_all() {
		return ( array ) get_option( 'bs' );
	}

	/**
	 * Get blog layout style
	 * 
	 * @return string --- blog layout style
	 */
	public static function getLayoutStyle() {
		$allowed_styles = self::getAllowedStyles();
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
	public static function getAllowedStyles() {
		return [
			'default',
			'grid',
			'masonry',
		];
	}

	/**
	 * Get layout columns
	 * 
	 * @return integer --- layout columns
	 */
	public static function getColumns() {
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
		$classes = [
			2 => 'col-md-6 col-lg-6',
			3 => 'col-md-4 col-lg-4',
		];
		return $classes[ self::getColumns() ];
	}

	/**
	 * Get brick percent width
	 * 
	 * @return float --- percent width
	 */
	public static function getBrickWidth() {
		$widths = [
			2 => 50,
			3 => 33.333333,
		];
		return $widths[ self::getColumns() ];
	}

	/**
	 * Is default layout ?
	 * 
	 * @return boolean --- true if succes | false if not
	 */
	public static function isDefaultLayout() {
		return self::getLayoutStyle() == self::LAYOUT_DEFAULT;
	}

	/**
	 * Is grid layout ?
	 * 
	 * @return boolean --- true if succes | false if not
	 */
	public static function isGridLayout() {
		return self::getLayoutStyle() == self::LAYOUT_GRID;
	}

	/**
	 * Is masonry layout ?
	 * 
	 * @return boolean --- true if succes | false if not
	 */
	public static function isMasonryLayout() {
		return self::getLayoutStyle() == self::LAYOUT_MASONRY;
	}

	/**
	 * Get paginate links
	 *
	 * @return string
	 */
	public static function getPaginateLinks() {
		global $wp_query, $wp_rewrite;

		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = [];
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
			[
				'base'      => $pagenum_link,
				'format'    => $format,
				'total'     => $wp_query->max_num_pages,
				'current'   => $paged,
				'mid_size'  => 1,
				'add_args'  => array_map( 'urlencode', $query_args ),
				'prev_text' => __( '&larr; Previous', 'photolab' ),
				'next_text' => __( 'Next &rarr;', 'photolab' ),
			]
		);
	}

	/**
	 * Get content template name
	 *
	 * @return string content template name
	 */
	public static function getContentName() {
		$post_format = ( string ) get_post_format();
		return '' == $post_format ? 'content' : $post_format;
	}
}
