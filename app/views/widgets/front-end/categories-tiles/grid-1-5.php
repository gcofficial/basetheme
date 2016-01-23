<?php
/**
 * Frontend view
 *
 * @package TM_Categories_Tiles_Widget
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
<div class="tm-grid-1-5-widget">
	<div class="grid-wrap">
		@foreach( $categories as $index => $category )
			@if( 5 >= $index )
				@if( $index )
				{{ $size = 'small' }}
				@else
				{{ $size = 'big' }}
				@endif
				<a href="{{ $category['url'] }}">
					<div class="cell-{{ $size }}" 
						@if( ! empty( $category['image'] ) )
						style="background: url({{ $category['image'] }}) no-repeat;"
						@endif
						>
						<div class="title">{{ $category['name'] }}</div>
						@if ( 'true' == $show_count )
						<div class="count">{{ sprintf( __( '%d posts', PHOTOLAB_BASE_TM_ALIAS ), $category['count'] ); }}</div>
						@endif
					</div>
				</a>
			@endif
		@endforeach
	</div>
</div>
{{ $after_widget }}
