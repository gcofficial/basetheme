<?php
/**
 * Layouts/Sidebar view
 *
 * @package photolab
 */
?><div id="secondary" class="widget-area col-sm-3" role="complementary">
	@if ( ! dynamic_sidebar( 'sidebar-1' ) )
		@include('layouts/sidebar-no-active')
	@endif
</div><!-- #secondary -->
