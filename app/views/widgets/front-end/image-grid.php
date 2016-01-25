<?php
/**
 * Frontend view
 *
 * @package TM_Image_Grid_Widget
 */
?>
<!-- Widget area -->
{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
<div class="tm-image-grid-widget">
	<!-- Grid area -->
	<div class="grid grid-{{ $cols_count }}">
		@foreach( $posts as $post )
		<a href="{{ get_permalink( $post->ID ) }}" style="
				{{ ! empty ( $post->image ) ? 'background-image: url(' . $post->image . ');' : '' }}
				margin: {{ $padding }}px;
		">
			<h4>
				{{ $post->post_title }}
			</h4>
		</a>
		@if( ++$index % $cols_count )
		<div class="clear"></div>
		@endif
		@endforeach
	</div>
	<!-- End grid area -->
</div>
{{ $after_widget }}
<!-- End widget area -->
