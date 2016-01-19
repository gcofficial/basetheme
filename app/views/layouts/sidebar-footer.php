<?php
/**
 * Layouts/Sidebar footer view
 *
 * @package photolab
 */
?><div class="footer-widgets">
	<div class="container">
		<div class="row">
		@if(is_active_sidebar('footer' ))
			@include('layouts/widgets-footer')
		@else
			@include('layouts/sidebar-no-active-horizontal')
		@endif
		</div>
	</div>
</div>