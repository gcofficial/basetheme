<?php
/**
 * Layouts/Sidebar right view
 *
 * @package photolab
 */
?><div id="{{ $sidebar_right }}" class="widget-area col-sm-3" role="complementary">
	@if ( ! dynamic_sidebar( $sidebar_right ) )
		@include('layouts/sidebar-no-active')
	@endif
</div><!-- #secondary -->
