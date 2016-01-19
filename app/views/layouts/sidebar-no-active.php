<?php
/**
 * Layouts/Sidebar No active view
 *
 * @package photolab
 */
?>
<aside id="search" class="widget widget_search">
	{{ $search_form }}
</aside>

<aside id="archives" class="widget">
	<h3 class="widget-title">{{ __( 'Archives', 'photolab' ) }}</h3>
	<ul>
		{{ $archive_list }}
	</ul>
</aside>

<aside id="meta" class="widget">
	<h3 class="widget-title">{{ __( 'Meta', 'photolab' ) }}</h3>
	<ul>
		{{ $wp_register }}
		<li>{{ $wp_loginout }}</li>
		{{ $wp_meta }}
	</ul>
</aside>