<?php
/**
 * Layouts/Sidebar second view
 *
 * @package photolab
 */
?><div id="secondary" class="widget-area col-sm-3" role="complementary">
	@if ( ! dynamic_sidebar( 'sidebar-2' ) )
		@include('layouts/sidebar-no-active')
	@endif
</div><!-- #secondary -->

