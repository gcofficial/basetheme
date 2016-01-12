<div id="{{ $sidebar_left }}" class="widget-area col-sm-3" role="complementary">
	@if ( ! dynamic_sidebar( $sidebar_left ) )
		@include('layouts/sidebar-no-active')
	@endif
</div><!-- #secondary -->