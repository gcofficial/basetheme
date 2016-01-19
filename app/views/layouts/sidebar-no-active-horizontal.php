<?php
/**
 * Layouts/Sidebar No active horizontal view
 *
 * @package photolab
 */
?>
<aside id="search" class="widget widget_search col-md-4">
	{{ $search_form }}
</aside>

<aside id="archives" class="widget col-md-4">
	<h3 class="widget-title">{{ __( 'Archives', 'photolab' ) }}</h3>
	<ul>
		{{ $archive_list }}
	</ul>
</aside>

<aside id="meta" class="widget col-md-4">
	<h3 class="widget-title">{{ __( 'Meta', 'photolab' ) }}</h3>
	<ul>
		{{ $wp_register }}
		<li>{{ $wp_loginout }}</li>
		{{ $wp_meta }}
	</ul>
</aside>