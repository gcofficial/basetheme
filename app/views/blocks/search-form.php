<?php
/**
 * Blocks/Search form view
 *
 * @package photolab
 */
?>
<form id="top-bar-search-form" role="search" method="get" class="search-form" action="{{ home_url( '/' ) }}">
	<input type="search" class="search-field" value="{{ get_search_query() }}" name="s" title="{{ esc_attr_x( 'Search for:', 'label', 'photolab' ) }}" />
</form>
